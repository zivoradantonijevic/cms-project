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
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $config
 * @property integer $status
 * @property string $directory
 * @property integer $backend_bootstrap
 * @property integer $frontend_bootstrap
 * @property string $date
 * @property string $modified
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.2.0
 */
class Module extends ActiveRecord
{
    // Constant for module activation.
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;
    // Constant for module backend bootstrapping .
    const BACKEND_BOOTSTRAP = 1;
    const NOT_BACKEND_BOOTSTRAP = 0;
    // Constant for module backend bootstrapping .
    const FRONTEND_BOOTSTRAP = 1;
    const NOT_FRONTEND_BOOTSTRAP = 0;

    /**
     * @var \yii\web\UploadedFile
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'config', 'directory'], 'required'],
            [['title', 'description', 'config'], 'string'],
            ['name', 'string', 'max' => 64],
            ['directory', 'string', 'max' => 128],
            [['name', 'directory'], 'unique'],
            [['date', 'modified'], 'safe'],
            [['status', 'backend_bootstrap', 'frontend_bootstrap'], 'integer'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_NOT_ACTIVE]],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['backend_bootstrap', 'in', 'range' => [self::BACKEND_BOOTSTRAP, self::NOT_BACKEND_BOOTSTRAP]],
            ['backend_bootstrap', 'default', 'value' => self::NOT_BACKEND_BOOTSTRAP],
            ['frontend_bootstrap', 'in', 'range' => [self::FRONTEND_BOOTSTRAP, self::NOT_BACKEND_BOOTSTRAP]],
            ['frontend_bootstrap', 'default', 'value' => self::NOT_FRONTEND_BOOTSTRAP],
            ['file', 'required', 'on' => 'create'],
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
            'name' => Yii::t('cms', 'Name'),
            'title' => Yii::t('cms', 'Title'),
            'description' => Yii::t('cms', 'Description'),
            'config' => Yii::t('cms', 'Config'),
            'status' => Yii::t('cms', 'Active'),
            'directory' => Yii::t('cms', 'Directory'),
            'frontend_bootstrap' => Yii::t('cms', 'Is Frontend Bootstrap'),
            'backend_bootstrap' => Yii::t('cms', 'Is Backend Bootstrap'),
            'date' => Yii::t('cms', 'Installed'),
            'modified' => Yii::t('cms', 'Updated'),
            'file' => Yii::t('cms', 'Module (ZIP)'),
        ];
    }

    /**
     * Get module status as array
     */
    public function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('cms', 'Yes'),
            self::STATUS_NOT_ACTIVE => Yii::t('cms', 'No'),
        ];
    }

    /**
     * Get array
     */
    public function getBackendBootstraps()
    {
        return [
            self::BACKEND_BOOTSTRAP => Yii::t('cms', 'Yes'),
            self::NOT_BACKEND_BOOTSTRAP => Yii::t('cms', 'No'),
        ];
    }

    /**
     * Get array
     */
    public function getFrontendBootstraps()
    {
        return [
            self::FRONTEND_BOOTSTRAP => Yii::t('cms', 'Yes'),
            self::NOT_FRONTEND_BOOTSTRAP => Yii::t('cms', 'No'),
        ];
    }


    /**
     * Get active modules.
     *
     * @return array|Module[]
     */
    public static function getActiveModules()
    {
        return static::find()->where(['status' => self::STATUS_ACTIVE])->all();
    }

    /**
     * Get config as array.
     *
     * @return mixed
     */
    public function getConfig()
    {
        return Json::decode($this->config);
    }

    /**
     * Get module backend config.
     *
     * @return array
     */
    public function getBackendConfig()
    {
        return ArrayHelper::getValue($this->getConfig(), 'backend', []);
    }

    /**
     * Get module frontend config.
     *
     * @return array
     */
    public function getFrontendConfig()
    {
        return ArrayHelper::getValue($this->getConfig(), 'frontend', []);
    }

    /**
     * Get module param path.
     *
     * @return string.
     */
    public function getParamPath()
    {
        return Yii::getAlias('@modules/' . $this->directory . '/config/params.php');
    }

    /**
     * Get module config path.
     *
     * @return string.
     */
    public function getConfigPath()
    {
        return Yii::getAlias('@modules/' . $this->directory . '/config/config.php');
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
