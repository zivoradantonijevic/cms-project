<?php

namespace modules\slider\models;

use common\components\UploadImageTrait;
use core\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%slider}}".
 *
 * @property integer     $id
 * @property integer     $name
 * @property integer     $group_id
 * @property integer     $author
 * @property string      $code
 * @property string      $image
 * @property string      $url
 * @property string      $title_en
 * @property string      $title_tr
 * @property string      $subtitle_en
 * @property string      $subtitle_tr
 * @property integer     $sortorder
 * @property integer     $is_publiched
 * @property SliderGroup $group
 * @property User        $owner
 * @property integer     $impressions
 * @property integer     $clicks
 */
class Slider extends \yii\db\ActiveRecord
{
    use UploadImageTrait;

    public $folder = 'slider';
    public $uploadedFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'group_id'], 'required'],
            [['group_id', 'author', 'sortorder', 'is_published'], 'integer'],
            [['code'], 'string'],
            [['name', 'url', 'title_en', 'title_tr', 'subtitle_en', 'subtitle_tr'], 'string', 'max' => 255],
            [
                ['group_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => SliderGroup::className(),
                'targetAttribute' => ['group_id' => 'id']
            ],
            [
                ['author'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['author' => 'id']
            ],
            //[['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ['image', 'safe']
        ];
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


            return true;
        }

        return false;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'group_id' => 'Group ID',
            'author' => 'Author',
            'code' => 'Code',
            'image' => 'Image',
            'url' => 'Url',
            'sortorder' => 'Sortorder',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(SliderGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
}
