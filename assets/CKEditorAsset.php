<?php
namespace wadeshuler\ckeditor\assets;

use Yii;
use yii\base\InvalidConfigException;

Class CKEditorAsset extends \yii\web\AssetBundle
{
    private $moduleId = 'ckeditor';

    public $js = [];

    public $css = [];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        $this->js[] = isset($this->module->customCdn) ? $this->getCustomCdn() : $this->getDefaultCdn();
        parent::init();
    }

    public function getDefaultCdn()
    {
        return $this->module->cdnPath . '/' . $this->module->version . '/' . $this->module->preset . '/ckeditor.js';
    }

    public function getCustomCdn()
    {
        if ( ! isset($this->module->customCdn) ) {
            throw new InvalidConfigException(self::className() . ': Error retrieving Custom CDN');
        }

        return $this->module->customCdn;
    }

    /**
     * Getter for '$this->module'
     * @return Module
     * @throws InvalidConfigException
     */
    public function getModule()
    {
        if (is_null(Yii::$app->getModule($this->moduleId))) {
            throw new InvalidConfigException(self::className() . ': Invalid config with "$moduleId"');
        }
        return Yii::$app->getModule($this->moduleId);
    }

}
