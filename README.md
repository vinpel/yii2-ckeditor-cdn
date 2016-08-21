# yii2-ckeditor-cdn
CKEditor Module for Yii2. Easily add the CKEditor CDN to your Yii2 application. 

I have tried Redactor, TinyMCE, and CKEditor. If you only need basic features, like bold/italic then Redactor is great. I needed 
images, font size, font color, center, bullet lists, and many other features. I tried the 2Amigos CKEditor, but found the documentation 
lacking and was difficult to use.

I wanted it to use a CDN, to easily add plugins, change the skin, to upload images and files, and to be able to build my 
own config and use it straight from the [CKEditor Toolbar Configurator](http://cdn.ckeditor.com/4.5.10/full-all/samples/toolbarconfigurator/index.html).

This uses the original [CKeditor CDN](https://cdn.ckeditor.com), but you can easily use any CDN you wish (CloudFlare, Amazon S3, etc).

By default, the editor will use the `basic` preset. What's the difference? View the [CDN's directory listing](http://cdn.ckeditor.com/4.5.10/), and you will 
see each preset. From there, you can see what plugins and skins are available for the presets. It will also use the `config.js` 
in that preset, but that can easily be overridden too.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

    composer require wadeshuler/yii2-ckeditor-cdn:~1.0

or add

    "wadeshuler/yii2-ckeditor-cdn": "~1.0"

to the require section of your application's `composer.json` file.

## Basic Usage

Add to your app's config:

    'modules' => [
        'ckeditor' => [
            'class' => 'wadeshuler\ckeditor\Module',
        ],
    ],

Add to your view:

    use wadeshuler\ckeditor\widgets\CKEditor;
    
    <?= $form->field($model, 'text')->widget(CKEditor::className()) ?>

## Advanced Configuration

You can add plugins, change the preset, override the controller to set up your own `filebrowserBrowseUrl`, use your own `config.js`. You should
be able to do anything you need to with my extension! If something is missing or broken, please create a new issue and let me know.

Here is an **EXAMPLE CONFIG** showing *most* of the options. I have a lot of them commented out, so take what you need :)

    'modules' => [
        'ckeditor' => [
            'class' => 'wadeshuler\ckeditor\Module',    // required and dont change!!!
            
            //'controllerNamespace' => 'wadeshuler\ckeditor\controllers\default',    // to override my controller
            //'preset' => 'basic',    // default: basic - options: basic, standard, standard-all, full, full-all
            //'customCdn' => '//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.10/ckeditor.js',    // must point to ckeditor.js

            //'uploadDir' => '@app/web/uploads',    // must be file path (required when using filebrowser*BrowseUrl below)
            //'uploadUrl' => '@web/uploads',        // must be valid URL (required when using filebrowser*BrowseUrl below)
            
            // how to add external plugins (must also list them in `widgetClientOptions` `extraPlugins` below)
            //'widgetExternalPlugins' => [
            //    ['name' => 'pluginname', 'path' => '/path/to/', 'file' => 'plugin.js'],
            //    ['name' => 'pluginname2', 'path' => '/path/to2/', 'file' => 'plugin.js'],
            //],
            
            // passes html options to the text area tag itself. Mostly useless as CKEditor hides the <textarea> and uses it's own div
            //'widgetOptions' => [
            //    'rows' => '10',
            //],
            
            // These are basically passed to the `CKEDITOR.replace()`
            'widgetClientOptions' => [
                //'skin' => 'moono',    // must be in skins directory
                //'skin' => 'kama,http://cdn.ckeditor.com/4.5.10/standard-all/skins/kama/'    // skin from somehwere else - http://docs.ckeditor.com/#!/api/CKEDITOR.config-cfg-skin
                //'extraPlugins' => 'abbr,inserthtml',     // list of externalPlugins (loaded from `widgetExternalPlugins` above)
                //'customConfig' => '@web/js/myconfig.js',
                //'filebrowserBrowseUrl' => '/ckeditor/default/file-browse',
                //'filebrowserUploadUrl' => '/ckeditor/default/file-upload',
                //'filebrowserImageBrowseUrl' => '/ckeditor/default/image-browse',
                //'filebrowserImageUploadUrl' => '/ckeditor/default/image-upload',
            ]
        ],

    ],

An important thing to know, is how we merge the options. The config are your global options. They will be passed to every 
instance of the input widget. If you declare any of the options in the input widget directly, it will override what you have
in the config. The options are merged, and the input widget's options take precedence.

I strongly recommend making your own custom `config.js` with all of your options. If you have multiple editors with different 
options, you can make multiple config files and call them in the widget directly. For example, a config for admins with upload 
features, and a separate one for frontend users with most features removed for security.

**CDN** - This uses the original CKEditor CDN by default, but you can change it! In my example config above, I have `//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.10/ckeditor.js` 
as the `customCdn`. You must point to the `ckeditor.js` file, and it will be able to find the plugins and skins from there! 
You could download the CKEditor library directly from their site, manually add any extra plugins or skins you want, and create 
your own `config.js`. Then upload it to your own CDN, like Amazon S3. The benefit, is that you wouldn't have to load and 
externally link to plugins or skins that aren't in the library by default.

## More Configuration
Please, review the [CKEditor Documentation](http://docs.ckeditor.com/#!/guide/dev_configuration) for more configuration options.

**Note:** Anything that goes in the `CKEDITOR.replace()` goes in `widgetClientOptions` (config) or the input widget's `clientOptions` directly.

## Credits
[2amigos yii2-ckeditor-widget](https://github.com/2amigos/yii2-ckeditor-widget)

[CKEditor](http://ckeditor.com)

[yii2-redactor](https://github.com/yiidoc/yii2-redactor)
