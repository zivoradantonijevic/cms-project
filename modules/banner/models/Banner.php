<?php

namespace modules\banner\models;

use common\components\UploadImageTrait;
use core\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property integer     $id
 * @property integer     $group_id
 * @property integer     $author
 * @property string      $code
 * @property string      $image
 * @property string      $url
 * @property integer     $start_time
 * @property integer     $end_time
 * @property integer     $sortorder
 * @property BannerGroup $group
 * @property User        $owner
 * @property integer     $impressions
 * @property integer     $clicks
 */
class Banner extends \yii\db\ActiveRecord
{
    use UploadImageTrait;

    public $folder = 'banner';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'group_id'], 'required'],
            [['group_id', 'author', 'sortorder', 'clicks', 'impressions'], 'integer'],
            [['code'], 'string'],
            [['start_time', 'end_time',], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
            [
                ['group_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => BannerGroup::className(),
                'targetAttribute' => ['group_id' => 'id']
            ],
            [
                ['author'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['author' => 'id']
            ],
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
            if ($this->start_time) {
                $this->start_time = date('Y-m-d H:i:s', strtotime($this->start_time));
            }
            if ($this->end_time) {
                $this->end_time = date('Y-m-d H:i:s', strtotime($this->end_time));
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
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'sortorder' => 'Sortorder',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(BannerGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
}
