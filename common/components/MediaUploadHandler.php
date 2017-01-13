<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace common\components;

use cms\models\Media;
use cms\models\Post;
use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Upload handler for Media model.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class MediaUploadHandler
{
    const PRINT_RESPONSE = true;
    const NOT_PRINT_RESPONSE = false;

    /**
     * @var array Options for upload handler, can be overridden over class constructs.
     */
    protected $options = [];
    /**
     * @var array Used to generate response.
     */
    protected $response = [];
    /**
     * @var array Grouping files based on its extension.
     */
    protected $fileTypes = [
        'image' => [
            'extensions' => '/\.(gif|jpg|jpeg|png)$/i',
        ],
        'audio' => [
            'extensions' => '/\.(m4a|mp3|wav|wma|oga)$/i',
            'mime_icon' => 'img/mime/audio.png',
        ],
        'video' => [
            'extensions' => '/\.(3gp|mkv|flv|og?(a|g)|avi|mov|wmv|mp4|m4p|mp?(g|2|eg|e|v))$/i',
            'mime_icon' => 'img/mime/video.png',
        ],
        'pdf' => [
            'extensions' => '/\.(pdf|xps)$/i',
            'mime_icon' => 'img/mime/pdf.png',
        ],
        'spreadsheet' => [
            'extensions' => '/\.(xls|xlsx|ods|csv|xml)$/i',
            'mime_icon' => 'img/mime/spreadsheet.png',
        ],
        'document' => [
            'extensions' => '/\.(doc?(m|x)|odt)$/i',
            'mime_icon' => 'img/mime/document.png',
        ],
        'archive' => [
            'extensions' => '/\.(rar|zip|tar|7zip)$/i',
            'mime_icon' => 'img/mime/archive.png',
        ],
        'code' => [
            'extensions' => '/\.(php|c?pp|java|vb?s|html|js|css)$/i',
            'mime_icon' => 'img/mime/audio.png',
        ],
        'interactive' => [
            'extensions' => '/\.(ppt|pptx|odp)$/i',
            'icon' => 'img/mime/interactive.png',
        ],
        'text' => [
            'extensions' => '/\.(txt|md|bat)$/i',
            'mime_icon' => 'img/mime/text.png',
        ],
    ];

    /**
     * @var Media
     */
    private $_media;
    /**
     * @var array Used to create Media Meta.
     */
    private $_meta;

    /**
     * Create object of MediaUploadHandler.
     *
     * @param array|null $options
     * @param bool $initialize
     */
    public function __construct($options = null, $initialize = true)
    {
        // Set response format to RAW.
        Yii::$app->response->format = Response::FORMAT_RAW;
        // Set options of MediaUploadHandler.
        $this->setOptions($options);

        if ($initialize) {
            $this->initialize();
        }
    }

    /**
     * Initialize the action of MediaUploadHandler based on request method if set true.
     */
    protected function initialize()
    {
        switch (Yii::$app->request->method) {
            case 'OPTIONS':
            case 'HEAD':
                $this->head();
                break;
            case 'PATCH':
            case 'PUT':
            case 'POST':
                $this->post($this->getOption('print_response'));
                break;
            case 'GET':
                $this->get($this->getOption('print_response'));
                break;
            case 'DELETE':
                $this->delete($this->getOption('print_response'));
                break;
            default:
                $this->setHeader('HTTP/1.1 405 Method Not Allowed');
        }
    }

    /**
     * Get server var based on id. Return null when it's not exist.
     *
     * @param $id
     * @return mixed
     */
    protected function getServerVar($id)
    {
        if (isset($_SERVER[$id])) {
            return $_SERVER[$id];
        }

        return null;
    }

    /**
     * Get singular param name.
     *
     * @return string
     */
    protected function getSingularParamName()
    {
        return substr($this->options['param_name'], 0, -1);
    }

    /**
     * Adds a new header.
     * If there is already a header with the same name, it will be replaced.
     *
     * @param string $name The name of the header.
     * @param string $value The value of the header.
     */
    protected function setHeader($name, $value = '')
    {
        Yii::$app->response->headers->set($name, $value);
    }

    /**
     * Set header content-type.
     */
    protected function sendContentTypeHeader()
    {
        $this->setHeader('Vary', 'Accept');

        if (strpos($this->getServerVar('HTTP_ACCEPT'), 'application/json') !== false) {
            $this->setHeader('Content-type', 'application/json');
        } else {
            $this->setHeader('Content-type', 'text/plain');
        }
    }

    /**
     * Set header Access-Control-*.
     */
    protected function sendAccessControlHeaders()
    {
        $this->setHeader('Access-Control-Allow-Origin', $this->options['access_control_allow_origin']);
        $this->setHeader('Access-Control-Allow-Credentials', $this->options['access_control_allow_credentials']
            ? 'true'
            : 'false'
        );
        $this->setHeader('Access-Control-Allow-Methods', implode(', ', $this->options['access_control_allow_methods']));
        $this->setHeader('Access-Control-Allow-Headers', implode(', ', $this->options['access_control_allow_headers']));
    }

    /**
     * Finds the Media model based on its primary key value.
     * If the model is not found it will return null.
     *
     * @param integer $id
     * @return Media|array
     */
    protected function findMedia($id)
    {
        if (($model = Media::findOne($id)) !== null) {
            return $model;
        }

        return null;
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found it will return null.
     *
     * @param integer $id
     * @return Post|null
     */
    protected function findPost($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        return null;
    }

    /**
     * Get user path of login user. It can be disabled by override config, set user_dirs to false.
     *
     * @return string The username of login user.
     */
    protected function getUserPath()
    {
        if ($this->options['user_dirs'] && !Yii::$app->user->isGuest) {
            return Yii::$app->user->identity->username . '/';
        }

        return '';
    }

    /**
     * Year-month path generated by date function can be disable by set year_month_path to false.
     *
     * @return string date(/Y/m).
     */
    protected function getYearMonthPath()
    {
        if ($this->options['year_month_dirs']) {
            return date('Y/m/');
        }

        return '';
    }

    /**
     * Get upload path based on current config, generate upload_dir/user_path/y/m/filename.ext.
     *
     * @param null $fileName Filename and extension (filename.ext).
     * @return string
     */
    protected function getUploadPath($fileName = null)
    {
        return $this->getOption('upload_dir') . $this->getUserPath() . $this->getYearMonthPath() . $fileName;
    }

    /**
     * Get file-path of the filename.
     *
     * @param string|null $fileName
     * @return string
     */
    protected function getFilePath($fileName = null)
    {
        return $this->getOption('upload_dir') . $fileName;
    }

    /**
     * Generate slug for uploaded file.
     * Replace all space to - and transform all character to lowercase.
     *
     * @param string $fileName
     * @param array $replace The replace_pairs parameter may be used as a substitute for to and from in which case.
     * it's an array in the form array('from' => 'to', ...).
     * @param string $delimiter
     * @see strtr
     * @return string Clean name
     */
    protected function generateSlug($fileName, $replace = [], $delimiter = '-')
    {
        setlocale(LC_ALL, 'en_US.UTF8');
        $fileName = trim($fileName);

        if (!empty($replace)) {
            $fileName = strtr($fileName, $replace);
        }

        $cleanName = iconv('UTF-8', 'ASCII//TRANSLIT', $fileName);
        $cleanName = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $cleanName);
        $cleanName = strtolower(trim($cleanName, '-'));
        $cleanName = preg_replace("/[\/_|+ -]+/", $delimiter, $cleanName);

        return $cleanName;
    }

    /**
     * Callback function of upCountName.
     *
     * @param array $matches
     * @return string
     */
    protected function upCountNameCallback($matches)
    {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';

        return '-' . $index . $ext;
    }

    /**
     * The number before fileName extension is replaced by upCountNameCallback.
     *
     * @param string $fileName
     * @return mixed
     * @see upCountNameCallback
     */
    protected function upCountName($fileName)
    {
        return preg_replace_callback('/(?:(?:\-([\d]+))?(\.[^.]+))?$/', [$this, 'upCountNameCallback'], $fileName, 1);
    }

    /**
     * Get filename of uploaded file.
     * If the filename is already exist in the upload directory
     * then the number between - and before the extension plus 1.
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function getFileName($file)
    {
        $index = 0;
        $fileName = $this->generateSlug($file->baseName);
        $fileName .= '.' . $file->extension;
        $fileName = trim(basename(stripslashes($fileName)), ".\x00..\x20");

        if (!$fileName) {
            $fileName = str_replace('.', '-', microtime(true));
        }

        while (is_file($this->getUploadPath($fileName))) {
            $fileName = $this->upCountName($fileName);
            $index++;
        }

        if ($index !== 0) {
            // Replace media title
            $this->_media->title = $file->baseName . ' ' . $index;
        }

        return $fileName;
    }

    /**
     * @param \imagine\image\ImageInterface $image
     * @param string $filePath
     * @return bool
     */
    protected function correctExifRotation($image, $filePath)
    {
        if (!function_exists('exif_read_data')) {
            return false;
        }

        $exif = @exif_read_data($filePath);

        if ($exif === false) {
            return false;
        }

        $orientation = (int)@$exif['Orientation'];

        if ($orientation < 2 || $orientation > 8) {
            return false;
        }

        switch ($orientation) {
            case 8:
                $image->rotate(-90);
                break;
            case 3:
                $image->rotate(180);
                break;
            case 6:
                $image->rotate(90);
                break;
        }

        return true;
    }

    /**
     * @param $fileName
     * @param $version
     * @param $options
     * @return bool|\imagine\Image\ManipulatorInterface
     */
    protected function createScaledImage($fileName, $version, $options)
    {
        $success = false;
        $filePath = $this->getFilePath($fileName);
        $image = Image::getImagine()->open($filePath);

        if ($this->getOption('correct_exif_rotation')) {
            $this->correctExifRotation($image, $filePath);
        }

        $maxWidth = $imageWidth = $image->getSize()->getWidth();
        $maxHeight = $imageHeight = $image->getSize()->getHeight();

        if (!empty($options['max_width'])) {
            $maxWidth = $options['max_width'];
        }

        if (!empty($options['max_height'])) {
            $maxHeight = $options['max_height'];
        }

        $scale = min($maxWidth / $imageWidth, $maxHeight / $imageHeight);

        if ($scale > 0 && $scale <= 1) {
            if (empty($options['crop'])) {
                $newWidth = round($imageWidth * $scale);
                $newHeight = round($imageHeight * $scale);
                $newFileName = substr($fileName, 0, -(strlen($this->_media->file->extension) + 1)) .
                    '-' . $newWidth .
                    'x' . $newHeight .
                    '.' . $this->_media->file->extension;
                $newFilePath = $this->getFilePath($newFileName);
                $success = $image->thumbnail(new Box($newWidth, $newHeight))
                    ->save($newFilePath);
                if ($success) {
                    $this->_meta['versions'][$version] = [
                        'url' => $newFileName,
                        'width' => $newWidth,
                        'height' => $newHeight,
                    ];
                }
            } else {
                if (($imageWidth / $imageHeight) >= ($maxWidth / $maxHeight)) {
                    $newWidth = round($imageWidth / ($imageHeight / $maxHeight));
                    $newHeight = $maxHeight;
                } else {
                    $newWidth = $maxWidth;
                    $newHeight = round($imageHeight / ($imageWidth / $maxWidth));
                }
                $pointX = abs(round(($newWidth - $maxWidth) / 2));
                $pointY = abs(round(($newHeight - $maxHeight) / 2));
                $newFileName = substr($fileName, 0, -(strlen($this->_media->file->extension) + 1)) .
                    '-' . $maxWidth .
                    'x' . $maxHeight .
                    '.' . $this->_media->file->extension;
                $newFilePath = $this->getFilePath($newFileName);
                $success = $image->thumbnail(new Box($newWidth, $newHeight), ManipulatorInterface::THUMBNAIL_OUTBOUND)
                    ->crop(new Point($pointX, $pointY), new Box($maxWidth, $maxHeight))
                    ->save($newFilePath);
                if ($success) {
                    $this->_meta['versions'][$version] = [
                        'url' => $newFileName,
                        'width' => $maxWidth,
                        'height' => $maxWidth,
                    ];
                }
            }
        }

        return $success;
    }

    /**
     * Handle image file.
     *
     * @param string $fileName
     */
    protected function handleImageFile($fileName)
    {
        if ($versions = $this->getOption('versions')) {
            foreach ($versions as $version => $options) {
                $this->createScaledImage($fileName, $version, $options);
            }
        }
    }

    /**
     * Set icon url.
     *
     * @param string $fileName
     * @return string
     */
    protected function setIconUrl($fileName)
    {
        foreach ($this->fileTypes as $name => $type) {
            if (preg_match($type['extensions'], $fileName)) {
                if ($name === 'image') {
                    return $this->_meta['versions']['thumbnail']['url'];
                }

                return $type['mime_icon'];
            }
        }

        return 'img/mime/default.png';
    }

    /**
     * Handle uploaded file. If the uploaded file is valid image type, the file will be resize or crop
     * based on versions in options.
     *
     * @param UploadedFile $file
     */
    protected function handleFileUpload($file)
    {
        $this->_meta['filename'] = $this->getFileName($file);
        $this->_meta['file_size'] = $file->size;
        $uploadDir = $this->getUploadPath();
        $uploadPath = $this->getUploadPath($this->_meta['filename']);

        if (!is_dir($uploadDir)) {
            FileHelper::createDirectory($uploadDir, $this->getOption('mkdir_mode'));
        }

        if ($file->saveAs($uploadPath)) {
            $this->_meta['versions']['full']['url'] = $this->getUserPath()
                . $this->getYearMonthPath()
                . $this->_meta['filename'];

            if (preg_match($this->fileTypes['image']['extensions'], $this->_meta['filename'])) {
                $image = Image::getImagine()->open($this->getFilePath($this->_meta['versions']['full']['url']));
                $this->handleImageFile($this->_meta['versions']['full']['url']);
                $this->_meta['versions']['full']['width'] = $image->getSize()->getWidth();
                $this->_meta['versions']['full']['height'] = $image->getSize()->getHeight();
            }

            $this->_meta['icon_url'] = $this->setIconUrl($this->_meta['filename']);
        }
    }

    /**
     * @return \yii\data\Pagination
     */
    protected function getPages()
    {
        $query = Media::find()->orderBy(['id' => SORT_DESC]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => $this->getOption('files_per_page'),
        ]);

        return $pages;
    }

    /**
     * @param $pages Pagination
     * @return array
     */
    protected function getPaging($pages)
    {
        $currentPage = $pages->getPage();
        $perPage = $pages->getPageSize();
        $result = [
            'next_url' => '',
            'current_page' => $currentPage,
            'per_page' => $perPage,
        ];
        $pageCount = $pages->getPageCount();

        if ($currentPage + 1 < $pageCount) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }

            return [
                'next_url' => Url::to(['get-json', 'page' => $page + 1, 'per-page' => $pages->getPageSize()]),
                'current_page' => $page,
                'per_page' => $perPage,
            ];
        }

        return $result;
    }

    /**
     * Set options of upload Handler.
     *
     * @param array $options
     */
    public function setOptions($options = [])
    {
        $this->options = [
            'script_url' => Yii::$app->request->absoluteUrl,
            'upload_dir' => Yii::getAlias('@public/uploads/'),
            'upload_url' => Media::getUploadUrl(),
            'user_dirs' => true,
            'year_month_dirs' => true,
            'mkdir_mode' => 0755,
            'param_name' => 'files',
            'access_control_allow_origin' => '*',
            'access_control_allow_credentials' => false,
            'correct_exif_rotation' => true,
            'pagination_route' => '/media/get-json',
            'access_control_allow_methods' => [
                'OPTIONS',
                'HEAD',
                'GET',
                'POST',
                'PUT',
                'PATCH',
                'DELETE',
            ],
            'access_control_allow_headers' => [
                'Content-Type',
                'Content-Range',
                'Content-Disposition',
            ],
            'versions' => [
                'large' => [
                    'max_width' => 1024,
                    'max_height' => 1024,
                ],
                'medium' => [
                    'max_width' => 300,
                    'max_height' => 300,
                ],
                'thumbnail' => [
                    'max_width' => 150,
                    'max_height' => 150,
                    'crop' => 1,
                ],
            ],
            'files_per_page' => 100,
            'print_response' => true,
        ];

        if ($options) {
            $this->options = ArrayHelper::merge($this->options, $options);
        }
    }

    /**
     * Get all of MediaUploadHandler Options.
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get single option of MediaUploadHandler.
     * Return string or array if option exist, or return null if not exist.
     *
     * @param string $id
     * @return string|array|null
     */
    public function getOption($id)
    {
        if (isset($this->options[$id])) {
            return $this->options[$id];
        }

        return null;
    }

    /**
     * Generate response based on Media primary key.
     *
     * @param Media $media
     * @return array
     */
    public function generateResponse($media)
    {
        $metadata = $media->getMeta('metadata');
        $response = ArrayHelper::merge(ArrayHelper::toArray($media), $metadata);
        $response['date_formatted'] = Yii::$app->formatter->asDatetime($media->date);
        $response['readable_size'] = Yii::$app->formatter->asShortSize($metadata['file_size']);
        $response['delete_url'] = Url::to(['/media/ajax-delete', 'id' => $media->id, 'delete' => '1']);
        $response['update_url'] = Url::to(['/media/update', 'id' => $media->id]);
        $response['view_url'] = $media->getUrl();

        if (preg_match('/^image\//', $media->mime_type)) {
            $response['type'] = 'image';
            $response['icon_url'] = $this->getOption('upload_url') . $metadata['icon_url'];
        } else {
            $response['icon_url'] = Yii::getAlias('@web') . '/' . $metadata['icon_url'];
            if (preg_match('/^video\//', $media->mime_type)) {
                $response['type'] = 'video';
            } elseif (preg_match('/^audio\//', $media->mime_type)) {
                $response['type'] = 'audio';
            } else {
                $response['type'] = 'file';
            }
        }

        return $response;
    }

    /**
     * Set response.
     *
     * @param array $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }


    /**
     * Generate response in the form of a string of json.
     *
     * @param bool $printResponse
     * @return array
     */
    public function getResponse($printResponse = self::PRINT_RESPONSE)
    {
        if ($printResponse) {
            $this->head();
            $content = Json::encode($this->response);
            $redirect = stripslashes(Yii::$app->request->getQueryParam('redirect'));
            if ($redirect) {
                $this->setHeader('Location', sprintf($redirect, rawurlencode($content)));

                return null;
            }
            echo $content;
        }

        return $this->response;
    }

    /**
     * Set response header.
     */
    public function head()
    {
        $this->setHeader('Pragma', 'no-cache');
        $this->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->setHeader('Content-Disposition', 'inline; filename="files.json"');
        // Prevent Internet Explorer from MIME-sniffing the content-type:
        $this->setHeader('X-Content-Type-Options', 'nosniff');
        if ($this->options['access_control_allow_origin']) {
            $this->sendAccessControlHeaders();
        }
        $this->sendContentTypeHeader();
    }

    /**
     * Get media files.
     *
     * @param int $id
     * @param bool $printResponse
     * @return array
     */
    public function get($id = null, $printResponse = self::PRINT_RESPONSE)
    {
        $content = [];

        if ($id && $media = $this->findMedia($id)) {
            $response = [
                $this->getSingularParamName() => $this->generateResponse($media),
            ];
        } else {
            $query = Media::find()->orderBy(['id' => SORT_DESC]);
            $pages = $this->getPages();

            $query->andFilterWhere(['like', 'post_id', Yii::$app->request->get('post')])
                ->andFilterWhere(['like', 'mime_type', Yii::$app->request->get('type')])
                ->andFilterWhere(['like', 'title', Yii::$app->request->get('keyword')])
                ->orFilterWhere(['like', 'content', Yii::$app->request->get('keyword')]);

            if ($models = $query->offset($pages->offset)->limit($pages->limit)->all()) {
                foreach ($models as $media) {
                    /* @var $media Media */
                    $content[] = $this->generateResponse($media);
                }
            }
            $response = [
                $this->getOption('param_name') => $content,
                'paging' => $this->getPaging($pages),
            ];
        }

        $this->setResponse($response);

        return $this->getResponse($printResponse);
    }

    /**
     * Upload file to server.
     *
     * @param bool $printResponse
     * @return array
     */
    public function post($printResponse = self::PRINT_RESPONSE)
    {
        if (Yii::$app->request->get('delete') && $id = Yii::$app->request->get('id')) {
            return $this->delete($id, $printResponse);
        }

        $response = [];
        $this->_media = new Media();
        $this->_media->file = UploadedFile::getInstance($this->_media, 'file');

        if ($this->_media->file !== null && $this->_media->validate(['file'])) {
            if ($postId = Yii::$app->request->get('post')) {
                $post = $this->findPost($postId);
                $this->_media->post_id = $post->id;
            }

            $this->_media->title = $this->_media->file->baseName;
            $this->_media->mime_type = $this->_media->file->type;
            $this->handleFileUpload($this->_media->file);

            if ($this->_media->save(false)) {
                if ($this->_media->setMeta('metadata', $this->_meta)) {
                    $response = $this->generateResponse($this->_media);
                }
            }
        } else {
            $response = [
                'error' => $this->_media->getFirstError('file'),
                'filename' => isset($this->_media->file->name) ? $this->_media->file->name : null,
                'file_size' => isset($this->_media->file->size) ? $this->_media->file->size : null,
            ];
        }

        $this->setResponse([
            $this->getOption('param_name') => [$response],
        ]);

        return $this->getResponse($printResponse);
    }

    /**
     * Delete files based on media primary key
     *
     * @param int $id Primary key of Media
     * @param bool $printResponse
     * @return array
     * @throws \Exception
     */
    public function delete($id, $printResponse = self::PRINT_RESPONSE)
    {
        $success = true;
        $response = [];
        $media = $this->findMedia($id);
        $metadata = $media->getMeta('metadata');

        if ($media->delete()) {
            foreach ($metadata['versions'] as $version) {
                $filePath = $this->getFilePath($version['url']);
                $success = is_file($filePath) && unlink($filePath);
            }
            $response[$metadata['filename']] = $success;
        }

        $this->setResponse($response);

        return $this->getResponse($printResponse);
    }
}
