<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace frontend\widgets\comment;

use cms\models\MediaComment as Comment;
use yii\data\Pagination;

/**
 * Class MediaComment
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class MediaComment extends BaseComment
{
    /**
     * Set comment and pagination.
     * Select all comments from database and create pagination.
     * Get child of current comment.
     */
    protected function setComments()
    {
        /* @var $models \common\models\BaseComment */
        $comments = [];
        $query = Comment::find()
            ->select(['id', 'author', 'email', 'url', 'date', 'content'])
            ->andWhere(['parent' => 0, 'media_id' => $this->model->id, 'status' => 'approved'])
            ->andWhere(['<=', 'date', date('Y-m-d H:i:s')])
            ->orderBy(['date' => $this->commentOrder]);

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $this->pageSize,
        ]);

        $this->pages = $pages;

        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        /* @var $model \cms\models\PostComment */
        foreach ($models as $model) {
            $comments[$model->id] = $model;
            $comments[$model->id]['child'] = $this->getChildren($model->id);
        }

        $this->comments = $comments;
    }


    /**
     * Get comment children based on comment ID.
     *
     * @param int $id
     * @return array|null
     */
    protected function getChildren($id)
    {
        $comments = [];

        $models = Comment::find()
            ->select(['id', 'author', 'email', 'url', 'date', 'content'])
            ->andWhere(['parent' => $id, 'media_id' => $this->model->id, 'status' => 'approved'])
            ->andWhere(['<=', 'date', date('Y-m-d H:i:s')])
            ->orderBy(['date' => $this->commentOrder])
            ->all();

        if (empty($models)) {
            $comments = null;
        } else {
            /* @var $model \cms\models\PostComment */
            foreach ($models as $model) {
                $comments[$model->id] = $model;
                $comments[$model->id]['child'] = $this->getChildren($model->id);
            }
        }

        return $comments;
    }
}
