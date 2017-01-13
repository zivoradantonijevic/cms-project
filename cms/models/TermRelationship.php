<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace cms\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%term_relationship}}".
 *
 * @property integer $post_id
 * @property integer $term_id
 *
 * @property Post $post
 * @property Term $term
 *
 * @author  Agiel K. Saputra <13nightevil@gmail.com>
 * @since   0.1.0
 */
class TermRelationship extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%term_relationship}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'term_id'], 'required'],
            [['post_id', 'term_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('cms', 'Post ID'),
            'term_id' => Yii::t('cms', 'Term ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(Term::className(), ['id' => 'term_id']);
    }
}
