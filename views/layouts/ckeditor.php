<?php
use wadeshuler\ckeditor\assets\CKAdminAsset;
CKAdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
