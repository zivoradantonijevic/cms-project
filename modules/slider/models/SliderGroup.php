<?php

namespace modules\slider\models;

/**
 * This is the model class for table "{{%slider_group}}".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $width
 * @property integer $height
 */
class SliderGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'width', 'height'], 'required'],
            [['width', 'height'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'width' => 'Width',
            'height' => 'Height',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliders()
    {
        return $this->hasMany(Slider::className(), ['group_id' => 'id']);
    }
}
