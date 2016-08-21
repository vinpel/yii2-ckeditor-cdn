<?php
namespace wadeshuler\ckeditor\assets;

use Yii;
use yii\base\InvalidConfigException;

Class CKAdminAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
