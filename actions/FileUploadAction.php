<?php
namespace wadeshuler\ckeditor\actions;

class FileUploadAction extends \yii\base\Action
{

    public function run()
    {
        $this->controller->layout = null;
        if (class_exists('yii\debug\Module')) {
            $this->controller->view->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
        }

        $CKEditor = \Yii::$app->getRequest()->getQueryParam('CKEditor');
        $CKEditorFuncNum = \Yii::$app->getRequest()->getQueryParam('CKEditorFuncNum');
        $langCode = \Yii::$app->getRequest()->getQueryParam('langCode');

        if ( $file = \yii\web\UploadedFile::getInstanceByName('upload') )
        {

            if ( in_array($file->extension, \Yii::$app->controller->module->allowedFileExtensions) )
            {
                $path = \Yii::$app->controller->module->getFileDir();
                $filename = $this->generateUniqueFilename($path, $file->extension);

                if ($filename)
                {
                    if ( $file->saveAs( $path . '/' . $filename) )
                    {

                        echo '<p><strong>Success:</strong> File uploaded!</p>';

                        $url = \Yii::$app->controller->module->getFileDirUrl() . '/' . $filename;
                        $message = 'Success: File uploaded!';

                        echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message');</script>";

                    } else {
                        echo '<p><strong>Error:</strong> Could not save file!</p>';
                    }

                } else {
                    echo '<p><strong>Error:</strong> Could not generate unique file name!</p>';
                }

            } else {

                echo '<p><strong>Error:</strong> Invalid file extension!</p>';

            }

        }

        return $this->controller->render('file-upload', ['message' => $message]);

    }

    private function generateUniqueFilename($path, $extension)
    {
        $name = null;
        $retryVal = 5;

        for ($i = 1; $i <= $retryVal; $i++)
        {
            $name = substr(uniqid(md5(rand()), true), 0, 16) . '.' . $extension;

            if ( ! file_exists($path . '/' . $name) ) {
                return $name;
                break;
            }
        }

        return false;
    }

}
