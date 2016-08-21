<?php
namespace wadeshuler\ckeditor\actions;

class FileBrowseAction extends \yii\base\Action
{

    public function run()
    {
        $CKEditor = \Yii::$app->getRequest()->getQueryParam('CKEditor');
        $CKEditorFuncNum = \Yii::$app->getRequest()->getQueryParam('CKEditorFuncNum');
        $langCode = \Yii::$app->getRequest()->getQueryParam('langCode');

        $onlyExtensions = array_map(function ($ext) {
            return '*.' . $ext;
        }, \Yii::$app->controller->module->allowedFileExtensions);

        $filesPath = \yii\helpers\FileHelper::findFiles(\Yii::$app->controller->module->getFileDir(), [
            'recursive' => true,
            'only' => $onlyExtensions
        ]);

        $files = [];
        if (is_array($filesPath) && count($filesPath))
        {
            foreach ($filesPath as $filePath)
            {
                $pathInfo = pathinfo($filePath);

                $pathDirname =   $pathInfo['dirname'];      // /www/htdocs/files
                $pathBasename =  $pathInfo['basename'];     // file.pdf
                $pathExtension = $pathInfo['extension'];    // pdf
                $pathFilename  = $pathInfo['filename'];     // file

                $fileUrl = \Yii::$app->controller->module->getFileDirUrl() . '/' . $pathBasename;
                $fileSize = \Yii::$app->formatter->asShortSize(filesize($filePath));

                $files[] = [
                                'file' => $fileUrl,
                                'name' => $pathFilename,
                                'size' => $fileSize,
                                'extension' => $pathExtension
                ];
            }

            $jsHook = "function returnFileUrl(url) {
                window.opener.CKEDITOR.tools.callFunction( " . $CKEditorFuncNum . ", url );
                window.close();
            }";

            $this->controller->view->registerJs($jsHook, \yii\web\View::POS_END, 'ckeditor-browse-hook');
        }

        $filesProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $files,
            'sort' => [
                'attributes' => ['name', 'file', 'size', 'extension'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->controller->render('file-browse', ['files' => $filesProvider]);
    }

}
