<?php
/**
 * Project: writesdown
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 27.9.16.
 */

namespace common\components;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


trait UploadImageTrait
{

    /**
     * Upload file
     *
     * @param        $filePath
     *
     * @param string $field
     *
     * @return mixed the uploaded image instance
     */
    public function uploadImage($filePath, $field = 'avatar')
    {
        /** @var Model $this */
        $file = UploadedFile::getInstance($this, $field);

        // if no file was uploaded abort the upload
        if (empty($file)) {
            return false;
        } else {

            // file extension
            $fileExt = $file->extension;
            // purge filename
            $fileName = Yii::$app->security->generateRandomString();
            // update file->name
            $file->name = $fileName . ".{$fileExt}";
            // update avatar field
            $this->$field = $fileName . ".{$fileExt}";
            // save images to imagePath
            $file->saveAs($filePath . $fileName . ".{$fileExt}");

            // the uploaded file instance
            return $file;
        }
    }

    /**
     * fetch stored image file name with complete path
     *
     * @param string $field
     *
     * @return string
     */
    public function getImagePath($field = 'avatar')
    {
        return $this->$field ? Yii::getAlias('@public/uploads/' . ($this->folder ? $this->folder . '/' : ''))
            . $this->$field : null;
    }

    /**
     * fetch stored image url
     *
     * @param string $field
     *
     * @return string
     */
    public function getImageUrl($field = 'avatar')
    {
        $avatar = $this->$field ? $this->$field : 'default.png';
        $imageURL = Yii::getAlias('@web/uploads/' . ($this->folder ? $this->folder . '/' : '')) . $avatar;

        if (strpos($imageURL, '/admin/') !== false) {
            $imageURL = str_replace('admin/', '', $imageURL);
        }
        return $imageURL;
    }

    /**
     * Process deletion of image
     *
     * @param string $avatarOld
     * @param string $field
     *
     * @return bool the status of deletion
     */
    public function deleteImage($avatarOld, $field = 'avatar')
    {
        $avatarURL = Yii::getAlias('@public/uploads/' . ($this->folder ? $this->folder . '/' : '')) . $avatarOld;

        // check if file exists on server
        if (empty($avatarURL) || !file_exists($avatarURL)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($avatarURL)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->$field = null;

        return true;
    }
}