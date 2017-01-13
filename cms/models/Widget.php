<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace cms\models;

use common\components\Json;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%widget}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $config
 * @property string $location
 * @property integer $order
 * @property string $directory
 * @property string $date
 * @property string $modified
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.2.0
 */
class Widget extends ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'location', 'directory'], 'required'],
            ['config', 'required', 'on' => 'create'],
            ['config', 'string'],
            ['order', 'integer'],
            [['date', 'modified'], 'safe'],
            ['title', 'string', 'max' => 255],
            [['location', 'directory'], 'string', 'max' => 128],
            ['file', 'required', 'on' => 'upload'],
            ['file', 'file', 'extensions' => 'zip'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'title' => Yii::t('cms', 'Title'),
            'config' => Yii::t('cms', 'Config'),
            'location' => Yii::t('cms', 'Location'),
            'order' => Yii::t('cms', 'Order'),
            'directory' => Yii::t('cms', 'Directory'),
            'date' => Yii::t('cms', 'Assigned'),
            'modified' => Yii::t('cms', 'Updated'),
            'file' => Yii::t('cms', 'Widget (ZIP)'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['upload'] = ['file'];
        $scenarios['activate'] = $scenarios['default'];

        return $scenarios;
    }

    /**
     * Get widget configuration as array
     *
     * @return mixed
     */
    public function getConfig()
    {
        return Json::decode($this->config);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->date = new Expression('NOW()');
            }
            $this->modified = new Expression('NOW()');

            return true;
        }

        return false;
    }
}
