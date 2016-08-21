<?php
namespace wadeshuler\ckeditor\actions;

class ImageBrowseAction extends \yii\base\Action
{

    public function run()
    {
        $CKEditor = \Yii::$app->getRequest()->getQueryParam('CKEditor');
        $CKEditorFuncNum = \Yii::$app->getRequest()->getQueryParam('CKEditorFuncNum');
        $langCode = \Yii::$app->getRequest()->getQueryParam('langCode');

        $onlyExtensions = array_map(function ($ext) {
            return '*.' . $ext;
        }, \Yii::$app->controller->module->allowedImageExtensions);

        $filesPath = \yii\helpers\FileHelper::findFiles(\Yii::$app->controller->module->getImageDir(), [
            'recursive' => true,
            'only' => $onlyExtensions
        ]);

        $images = [];
        if (is_array($filesPath) && count($filesPath))
        {
            foreach ($filesPath as $filePath)
            {
                $pathInfo = pathinfo($filePath);

                $pathDirname =   $pathInfo['dirname'];      // /www/htdocs/images
                $pathBasename =  $pathInfo['basename'];     // image.png
                $pathExtension = $pathInfo['extension'];    // png
                $pathFilename  = $pathInfo['filename'];     // image

                $imageUrl = \Yii::$app->controller->module->getImageDirUrl() . '/' . $pathBasename;
                $imageSize = \Yii::$app->formatter->asShortSize(filesize($filePath));

                $images[] = [
                                'thumb' => $imageUrl,
                                'image' => $imageUrl,
                                'title' => $pathFilename,
                                'size' => $imageSize,
                                'extension' => $pathExtension
                ];
            }

            $jsHook = "function returnFileUrl(url) {
                window.opener.CKEDITOR.tools.callFunction( " . $CKEditorFuncNum . ", url );
                window.close();
            }";

            $this->controller->view->registerJs($jsHook, \yii\web\View::POS_END, 'ckeditor-browse-hook');
        }

        return $this->controller->render('image-browse', ['images' => $images]);
    }

}
