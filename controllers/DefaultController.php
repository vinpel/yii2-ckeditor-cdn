<?php
namespace wadeshuler\ckeditor\controllers;

/**
 * Default controller for the `ckeditor` module
 */
class DefaultController extends \yii\web\Controller
{
    public $layout = 'ckeditor';

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'file-upload' => 'wadeshuler\ckeditor\actions\FileUploadAction',
            'file-browse' => 'wadeshuler\ckeditor\actions\FileBrowseAction',
            'image-upload' => 'wadeshuler\ckeditor\actions\ImageUploadAction',
            'image-browse' => 'wadeshuler\ckeditor\actions\ImageBrowseAction',
        ];
    }

}
