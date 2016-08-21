<?php
namespace wadeshuler\ckeditor;

/**
 * ckeditor module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'wadeshuler\ckeditor\controllers';

    public $version = '4.5.10';
    public $cdnPath = '//cdn.ckeditor.com';
    public $preset = 'full-all';       // basic, standard, standard-all, full, full-all, custom

    public $customCdn = null;

    public $widgetOptions = [];
    public $widgetClientOptions = [];

    /*
    [
        ['name' => 'pluginname', 'path' => '/path/to/', 'file' => 'plugin.js'],
        ['name' => 'pluginname', 'path' => '/path/to/', 'file' => 'plugin.js'],
    ]
    */
    public $widgetExternalPlugins = [];

    public $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    public $allowedFileExtensions = ['txt', 'rtf', 'doc', 'docx', 'xls', 'csv', 'pdf', 'mp4', 'mkv', 'wmv', 'mov', 'avi', 'flv', 'swf'];

    public $uploadDir = '@app/web/uploads';

    public $uploadUrl = '@web/uploads';

    public $imageFolder = 'images';

    public $fileFolder = 'files';

    private $_presetWhitelist = ['basic', 'standard', 'standard-all', 'full', 'full-all'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->checkConfig();
    }

    public function checkConfig()
    {
        if ( ! in_array($this->preset, $this->_presetWhitelist) ) {
            throw new \yii\base\InvalidConfigException(self::className() . ': Invalid preset! Options are: ' . explode(', ', $this->_presetWhitelist) . '.');
        }

        if ( isset($this->widgetClientOptions['customConfig']) ) {
            $this->widgetClientOptions['customConfig'] = \Yii::getAlias($this->widgetClientOptions['customConfig']);
        }

        if ( isset($this->widgetClientOptions['filebrowserImageBrowseUrl']) ) {
            $this->widgetClientOptions['filebrowserImageBrowseUrl'] = \yii\helpers\Url::toRoute([$this->widgetClientOptions['filebrowserImageBrowseUrl']]);
        }

        if ( isset($this->widgetClientOptions['filebrowserImageUploadUrl']) ) {
            $this->widgetClientOptions['filebrowserImageUploadUrl'] = \Yii::$app->urlManager->createUrl([$this->widgetClientOptions['filebrowserImageUploadUrl']]);
        }

        if ( isset($this->widgetClientOptions['filebrowserBrowseUrl']) ) {
            $this->widgetClientOptions['filebrowserBrowseUrl'] = \yii\helpers\Url::toRoute([$this->widgetClientOptions['filebrowserBrowseUrl']]);
        }

        if ( isset($this->widgetClientOptions['filebrowserUploadUrl']) ) {
            $this->widgetClientOptions['filebrowserUploadUrl'] = \Yii::$app->urlManager->createUrl([$this->widgetClientOptions['filebrowserUploadUrl']]);
        }
    }

    public function getUploadDir()
    {
        return \Yii::getAlias($this->uploadDir);
    }

    public function getUploadDirUrl()
    {
        return \Yii::getAlias($this->uploadUrl);
    }

    public function getImageDir()
    {
        return $this->getUploadDir() . '/' . $this->imageFolder;
    }

    public function getImageDirUrl()
    {
        return $this->getUploadDirUrl() . '/' . $this->imageFolder;
    }

    public function getFileDir()
    {
        return $this->getUploadDir() . '/' . $this->fileFolder;
    }

    public function getFileDirUrl()
    {
        return $this->getUploadDirUrl() . '/' . $this->fileFolder;
    }

}
