<?php
namespace wadeshuler\ckeditor\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\View;

use wadeshuler\ckeditor\assets\CKEditorAsset;

class CKEditor extends \yii\widgets\InputWidget
{
    /**
     * @var string Module Id already configured for Application Module
     */
    public $moduleId = 'ckeditor';

    /**
     * @var array HTML attributes for textarea tag
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array The options underlying for setting up CKEditor plugin.
     * @see http://docs.ckeditor.com/#!/guide/dev_configuration
     */
    public $clientOptions = [];

    public $externalPlugins = [];

    private $_assetBundle;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->defaultOptions();
        $this->registerAssetBundle();
        $this->registerPlugins();
        $this->registerScript();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
    }

    /**
     * Sets default options
     */
    protected function defaultOptions()
    {
        $this->options = ArrayHelper::merge($this->options, $this->module->widgetOptions);
        $this->clientOptions = ArrayHelper::merge($this->clientOptions, $this->module->widgetClientOptions);
        $this->externalPlugins = ArrayHelper::merge($this->externalPlugins, $this->module->widgetExternalPlugins);

        if (!isset($this->options['id']))
        {
            if ($this->hasModel()) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            } else {
                $this->options['id'] = $this->getId();
            }
        }
    }

    /**
     * Register assetBundle
     */
    protected function registerAssetBundle()
    {
        $this->_assetBundle = CKEditorAsset::register($this->getView());
    }

    /**
     * Register plugins for CKEditor
     */
    protected function registerPlugins()
    {
        if ( count($this->externalPlugins) )
        {
            foreach ( $this->externalPlugins as $plugin ) {
                $this->getView()->registerJs("CKEDITOR.plugins.addExternal( '" . $plugin['name'] . "', '" . $plugin['path'] . "', '" . $plugin['file'] . "' );", View::POS_END);
            }
        }
    }

    /**
     * Register clients script to View
     */
    protected function registerScript()
    {
        $id = $this->options['id'];
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '{}';

        $this->getView()->registerJs("CKEDITOR.replace('$id', $clientOptions);", View::POS_END);
    }



    /* ------ */



    /**
     * @return AssetBundle
     */
    public function getAssetBundle()
    {
        if (!($this->_assetBundle instanceof AssetBundle)) {
            $this->registerAssetBundle();
        }
        return $this->_assetBundle;
    }

    /**
     * @return bool|string The path of assetBundle
     */
    public function getSourcePath()
    {
        return Yii::getAlias($this->getAssetBundle()->sourcePath);
    }

    /**
     * Getter for '$this->module'
     * @return Module
     * @throws InvalidConfigException
     */
    public function getModule()
    {
        if (is_null(Yii::$app->getModule($this->moduleId))) {
            throw new InvalidConfigException('CKEditor: Invalid config with "$moduleId"');
        }
        return Yii::$app->getModule($this->moduleId);
    }

    /**
     * @param $key
     * @param mixed $defaultValue
     */
    protected function setOptionsKey($key, $defaultValue = null)
    {
        $this->clientOptions[$key] = Url::to(ArrayHelper::getValue($this->clientOptions, $key, $defaultValue));
    }

}
