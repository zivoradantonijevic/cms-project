<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace cms\models;

use common\components\Json;
use core\user\models\User;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer            $id
 * @property integer            $author
 * @property integer            $type
 * @property string             $title
 * @property string             $excerpt
 * @property string             $content
 * @property string             $date
 * @property string             $modified
 * @property string             $status
 * @property string             $password
 * @property string             $slug
 * @property string             $comment_status
 * @property integer            $comment_count
 * @property integer            $views_count
 * @property integer            $featured
 * @property string             $url
 * @property string             thumbnail
 *
 * @property Media[]            $media
 * @property PostType           $postType
 * @property User               $postAuthor
 * @property PostComment[]      $postComments
 * @property PostMeta[]         $postMeta
 * @property TermRelationship[] $termRelationships
 * @property Term[]             $terms
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
class Post extends ActiveRecord
{
    public $username;

    const COMMENT_STATUS_OPEN = 'open';
    const COMMENT_STATUS_CLOSE = 'close';
    const STATUS_PUBLISH = 'publish';
    const STATUS_PRIVATE = 'private';
    const STATUS_DRAFT = 'draft';
    const STATUS_TRASH = 'trash';
    const STATUS_REVIEW = 'review';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'attributes' => [ActiveRecord::EVENT_BEFORE_INSERT => ['slug']],
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            [['author', 'type', 'comment_count', 'views_count', 'featured'], 'integer'],
            [['title', 'excerpt', 'content'], 'string'],
            [['date', 'modified', 'author'], 'safe'],
            [['status', 'comment_status'], 'string', 'max' => 20],
            [['password', 'slug', 'thumbnail'], 'string', 'max' => 255],
            ['comment_status', 'in', 'range' => [self::COMMENT_STATUS_OPEN, self::COMMENT_STATUS_CLOSE]],
            ['comment_status', 'default', 'value' => self::COMMENT_STATUS_CLOSE],
            ['comment_count', 'default', 'value' => 0],
            ['views_count', 'default', 'value' => 0],
            ['featured', 'default', 'value' => 0],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_PUBLISH,
                    self::STATUS_DRAFT,
                    self::STATUS_PRIVATE,
                    self::STATUS_REVIEW,
                    self::STATUS_TRASH,
                ],
            ],
            ['status', 'default', 'value' => self::STATUS_PUBLISH],
            [['title', 'slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'author' => Yii::t('cms', 'Author'),
            'type' => Yii::t('cms', 'Type'),
            'title' => Yii::t('cms', 'Title'),
            'excerpt' => Yii::t('cms', 'Excerpt'),
            'content' => Yii::t('cms', 'Content'),
            'date' => Yii::t('cms', 'Date'),
            'modified' => Yii::t('cms', 'Modified'),
            'status' => Yii::t('cms', 'Status'),
            'password' => Yii::t('cms', 'Password'),
            'slug' => Yii::t('cms', 'Slug'),
            'comment_status' => Yii::t('cms', 'Comment Status'),
            'comment_count' => Yii::t('cms', 'Comment Count'),
            'username' => Yii::t('cms', 'Author'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostType()
    {
        return $this->hasOne(PostType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(PostComment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMeta()
    {
        return $this->hasMany(PostMeta::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTermRelationships()
    {
        return $this->hasMany(TermRelationship::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this
            ->hasMany(Term::className(), ['id' => 'term_id'])
            ->viaTable('{{%term_relationship}}', ['post_id' => 'id']);
    }

    /**
     * Get post status as array.
     *
     * @return array
     */
    public function getPostStatuses()
    {
        return [
            self::STATUS_PUBLISH => Yii::t('cms', 'Publish'),
            self::STATUS_DRAFT => Yii::t('cms', 'Draft'),
            self::STATUS_PRIVATE => Yii::t('cms', 'Private'),
            self::STATUS_TRASH => Yii::t('cms', 'Trash'),
            self::STATUS_REVIEW => Yii::t('cms', 'Review'),
        ];
    }

    /**
     * Get comment status as array
     */
    public function getCommentStatuses()
    {
        return [
            self::COMMENT_STATUS_OPEN => Yii::t('cms', 'Open'),
            self::COMMENT_STATUS_CLOSE => Yii::t('cms', 'Close'),
        ];
    }

    /**
     * Get comment status as array
     */
    public function getBooleanStatuses()
    {
        return [
            0 => 'No',
            1 => 'Yes',
        ];
    }

    /**
     * Get permalink of current post.
     *
     * @return string
     */
    public function getUrl()
    {
        return Yii::$app->urlManagerFront->createAbsoluteUrl([
            '/post/view',
            'id' => $this->id,
            'slug' => $this->slug,
            'type' => $this->type
        ]);
    }

    /**
     * Get meta for current post.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public function getMeta($name)
    {
        /* @var $model \cms\models\PostMeta */
        $model = PostMeta::findOne(['name' => $name, 'post_id' => $this->id]);

        if ($model) {
            if (Json::isJson($model->value)) {
                return Json::decode($model->value);
            }

            return $model->value;
        }

        return null;
    }

    /**
     * Add new meta data for current post.
     *
     * @param string       $name
     * @param string|array $value
     *
     * @return bool
     */
    public function setMeta($name, $value)
    {
        if (is_array($value) || is_object($value)) {
            $value = Json::encode($value);
        }

        if ($this->getMeta($name) !== null) {
            return $this->upMeta($name, $value);
        }

        $model = new PostMeta([
            'post_id' => $this->id,
            'name' => $name,
            'value' => $value,
        ]);

        return $model->save();
    }

    /**
     * Update meta data for current post.
     *
     * @param string       $name
     * @param string|array $value
     *
     * @return bool
     */
    public function upMeta($name, $value)
    {
        /* @var $model \cms\models\PostMeta */
        $model = PostMeta::findOne(['name' => $name, 'post_id' => $this->id]);

        if (is_array($value) || is_object($value)) {
            $value = Json::encode($value);
        }

        $model->value = $value;

        return $model->save();
    }

    /**
     * @param bool $sameType
     * @param bool $sameTerm
     *
     * @return array|null|Post
     */
    public function getNextPost($sameType = true, $sameTerm = false)
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = static::find()
            ->from(['post' => $this->tableName()])
            ->andWhere(['>', 'post.id', $this->id])
            ->andWhere(['status' => 'publish'])
            ->orderBy(['post.id' => SORT_ASC]);

        if ($sameType) {
            $query->andWhere(['type' => $this->type]);
        }

        if ($sameTerm) {
            $query->innerJoinWith([
                'terms' => function ($query) {
                    /* @var $query \yii\db\ActiveQuery */
                    $query->from(['term' => Term::tableName()])->andWhere([
                        'IN',
                        'term.id',
                        implode(',', ArrayHelper::getColumn($this->terms, 'id')),
                    ]);
                },
            ]);
        }

        return $query->one();
    }

    /**
     * @param bool   $sameType
     * @param bool   $sameTerm
     * @param string $title
     * @param array  $options
     *
     * @return string
     */
    public function getNextPostLink($title = '{title}', $sameType = true, $sameTerm = false, $options = [])
    {
        if ($nextPost = $this->getNextPost($sameType, $sameTerm)) {
            $title = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($nextPost) {
                $attribute = $matches[1];

                return $nextPost->{$attribute};
            }, $title);

            return Html::a($title, $nextPost->url, $options);
        }

        return '';
    }

    /**
     * @param bool $sameType
     * @param bool $sameTerm
     *
     * @return array|null|Post
     */
    public function getPrevPost($sameType = true, $sameTerm = false)
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = static::find()
            ->from(['post' => $this->tableName()])
            ->andWhere(['<', 'post.id', $this->id])
            ->andWhere(['status' => 'publish'])
            ->orderBy(['post.id' => SORT_DESC]);

        if ($sameType) {
            $query->andWhere(['type' => $this->type]);
        }

        if ($sameTerm) {
            $query->innerJoinWith([
                'terms' => function ($query) {
                    /* @var $query \yii\db\ActiveQuery */
                    $query->from(['term' => Term::tableName()])->andWhere([
                        'IN',
                        'term.id',
                        implode(',', ArrayHelper::getColumn($this->terms, 'id')),
                    ]);
                },
            ]);
        }

        return $query->one();
    }

    /**
     * @param bool   $sameType
     * @param bool   $sameTerm
     * @param string $title
     * @param array  $options
     *
     * @return string
     */
    public function getPrevPostLink($title = '{title}', $sameType = true, $sameTerm = false, $options = [])
    {
        if ($prevPost = $this->getPrevPost($sameType, $sameTerm)) {
            $title = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($prevPost) {
                $attribute = $matches[1];

                return $prevPost->{$attribute};
            }, $title);

            return Html::a($title, $prevPost->url, $options);
        }

        return '';
    }

    /**
     * Generate excerpt of post model.
     *
     * @param int $limit
     *
     * @return string
     */
    public function getExcerpt($limit = 55)
    {
        $excerpt = preg_replace('/\s{3,}/', ' ', strip_tags($this->content));
        $words = preg_split("/[\n\r\t ]+/", $excerpt, $limit + 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE);

        if (count($words) > $limit) {
            end($words);
            $lastWord = prev($words);

            $excerpt = substr($excerpt, 0, $lastWord[1] + strlen($lastWord[0]));
        }

        return $excerpt;
    }


    /**
     * Get permission to access model by current user.
     *
     * @return bool
     */
    public function getPermission()
    {
        if (!$this->postType
            || !Yii::$app->user->can($this->postType->permission)
            || (!Yii::$app->user->can('editor') && Yii::$app->user->id !== $this->author)
            || (!Yii::$app->user->can('author') && $this->status === self::STATUS_REVIEW)
        ) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->author = Yii::$app->user->id;
            }
            $this->modified = date('Y-m-d H:i:s');
            $this->excerpt = $this->getExcerpt();

            return true;
        }

        return false;
    }

    public function getThumbnailUrl($version = 'thumbnail')
    {
        $thumbnail = $this->thumbnail;
        if ($thumbnail) {
            $media_id
                = \Yii::$app->db->createCommand("SELECT media_id FROM {{%media_meta}} WHERE value LIKE '%\"url\":\"$thumbnail\"%'")
                ->queryScalar();
            if ($media_id) {
                $media = Media::findOne($media_id);
                if ($media) {
                    return $media->getThumbnailUrl($version);
                }
            }
        }

        /** @var Media $media */
        $media = $this->getMedia()->where(['like', 'mime_type', 'image/'])->one();
        if ($media) {
            return $media->getThumbnailUrl($version);
        }
        return null;
    }

    public function getCategory()
    {
        $category = $this->getTerms()
            ->innerJoinWith([
                'taxonomy' => function ($query) {
                    /* @var $query \yii\db\ActiveQuery */
                    $query->from(['taxonomy' => Taxonomy::tableName()]);
                },
            ])
            ->andWhere(['taxonomy.name' => 'category'])
            ->one();
        if (!$category) {
            $category = Term::find()->orderBy(['id' => SORT_ASC])->one();
        }
        return $category;
    }
}
