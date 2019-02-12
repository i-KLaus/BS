<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?php echo Yii::$app->language ?>">

<head>
    <meta charset="utf-8">
    <title>优选服务商平台</title>
    <link rel="icon" href="<?php echo Yii::getAlias('@web/img/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/css/yx.css'); ?>">
    <script src="<?php echo Yii::getAlias('@web/js/lib/lib.min.js'); ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/common/util.js'); ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/lib/select2.min.js'); ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/common/common.js'); ?>"></script>

    <script src="<?php echo Yii::getAlias('@web/js/common/upload.js');?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/lib/webuploader/webuploader.js');?>"></script>

    <script src="<?php echo Yii::getAlias('@web/js/lib/layer/layer.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/js/lib/layer/css/layui.css') ?>">
    <script src="<?php echo Yii::getAlias('@web/js/lib/layer/layui.js') ?>"></script>

    <?php echo Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body>
    <?php echo $content;?>

    <?php if (Yii::$app -> session -> hasFlash('error_msg')) { ?>
        <script>
            $(function () {
                layer.msg('<?php print_r(Yii::$app -> session -> getFlash('error_msg')); ?>');
            });
        </script>
    <?php } ?>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>