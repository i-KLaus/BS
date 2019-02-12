<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?php echo Yii::$app->language ?>">

    <head>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <title>首页</title>
        <!--    <link rel="shortcut icon" href="images/favicon.ico">-->
        <?php echo Html::csrfMetaTags() ?>

        <link type="text/css" rel="stylesheet" href="<?php echo Yii::getAlias('@web/css/mgr/basic.css');?>" />
        <script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/jquery1.6.2.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/webCommonShow.js');?>"></script>
        <script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/artDialog/jquery.artDialog.js?skin=default"');?>"></script>
        <script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/artDialog/plugins/iframeTools.js');?>"></script>
        <?php $this->head() ?>
    </head>

    <?php $this->beginBody() ?>
    <body>
        <?php echo $content;?>
    </body>
    <?php $this->endBody() ?>
    </html>
<?php $this->endPage() ?>