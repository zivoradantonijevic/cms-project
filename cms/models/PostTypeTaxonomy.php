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
 * This is the model class for table "{{%post_type_taxonomy}}".
 *
 * @property integer $post_type_id
 * @property integer $taxonomy_id
 *
 * @property PostType $postType
 * @property Taxonomy $taxonomy
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class PostTypeTaxonomy extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_type_taxonomy}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_type_id', 'taxonomy_id'], 'required'],
            [['post_type_id', 'taxonomy_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_type_id' => Yii::t('cms', 'Post Type ID'),
            'taxonomy_id' => Yii::t('cms', 'Taxonomy ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostType()
    {
        return $this->hasOne(PostType::className(), ['id' => 'post_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxonomy()
    {
        return $this->hasOne(Taxonomy::className(), ['id' => 'taxonomy_id']);
    }
}
