<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $this->beginPage() ?>

<!doctype html>
<html>

<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <title>优选服务商平台</title>
    <link rel="icon" href="<?php echo Yii::getAlias('@web/img/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/css/yx.css'); ?>">
    <script src="<?php echo Yii::getAlias('@web/js/lib/lib.min.js'); ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/common/util.js'); ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/lib/echarts.min.js'); ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/lib/select2.min.js'); ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/common/common.js'); ?>"></script>

    <script src="<?php echo Yii::getAlias('@web/js/common/upload.js');?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/lib/webuploader/webuploader.js');?>"></script>

    <script src="<?php echo Yii::getAlias('@web/js/lib/layer/layer.js') ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/lib/moment.js');?>"></script>
    <link rel="stylesheet" href="<?php echo Yii::getAlias('@web/js/lib/layer/css/layui.css') ?>">
    <script src="<?php echo Yii::getAlias('@web/js/lib/layer/layui.js') ?>"></script>
    <script src="<?php echo Yii::getAlias('@web/js/common/layer.js'); ?>"></script>

    <!--富文本-->
    <script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/lib/ueditor/ueditor.config.js');?>"></script>
    <script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/lib/ueditor/ueditor.all.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/lib/ueditor/lang/zh-cn/zh-cn.js');?>"></script>
</head>
<?php $this->beginBody() ?>
<body>
<?php
$type = \Yii::$app->session->get('admin_type'.Yii::$app->user->id);
$right = \Yii::$app->session->get('admin_right'.Yii::$app->user->id);
?>

<div class="siderbar" id="siderbar">
    <div class="logo"><a href="<?php echo Url::to(['goods/list']); ?>"><img src="<?php echo Yii::getAlias('@web/img/logo.png'); ?>"></a> </div>
    <ul class="list-group list-group-black">
        <?php $controller = Yii::$app -> controller -> id; ?>
        <li><a href="<?php echo Url::to(['index/index']); ?>" style="display: <?php echo (rightvalidate(RIGHT_INDEX)==true)? 'block':'none'?>" class="list-group-item list-group-item-arrow <?php if(in_array($controller,['index'])){ echo "active";} ?>" ><i class="icon-index h5"></i>首页</a></li>
        <li>
            <a style="display: <?php echo (rightvalidate(RIGHT_MARKETING_GOODS)==true)||(rightvalidate(RIGHT_GOODS)==true)? 'block':'none'?>" href="javascript:;" class="list-group-item list-group-item-arrow <?php if (in_array($controller, ['goods', 'marketing-goods'])) { ?>active<?php } ?>"><i class="icon-server"></i>服务管理</a>

            <ul>
                <li><a style="display: <?php echo (rightvalidate(RIGHT_MARKETING_GOODS)==true) ? 'block':'none'?>" href="<?php echo Url::to(['marketing-goods/list']); ?>">商户服务</a></li>
                <li><a style="display: <?php echo (rightvalidate(RIGHT_GOODS)==true) ? 'block':'none'?>" href="<?php echo Url::to(['goods/list']); ?>">服务商品</a></li>

            </ul>
        </li>
        <li>
            <a style="display: <?php echo (rightvalidate(RIGHT_ORDER)==true) ? 'block':'none'?>" href="javascript:;" class="list-group-item list-group-item-arrow <?php if (in_array($controller, ['order'])) { ?>active<?php } ?>"><i class="icon-order"></i>订单管理</a>
            <ul>
                <li><a href="<?php echo Url::to(['order/list']); ?>">全部订单</a></li>
            </ul>
        </li>
        <li>
            <a style="display: <?php echo (rightvalidate(RIGHT_SERVICE_DETAIL)==true)||(rightvalidate(RIGHT_ACCOUNT)==true)? 'block':'none'?>" href="javascript:;" class="list-group-item list-group-item-arrow <?php if (in_array($controller, ['service', 'account'])) { ?>active<?php } ?>"><i class="icon-order"></i>系统设置</a>
            <ul>
                <li><a style="display: <?php echo (rightvalidate(RIGHT_SERVICE_DETAIL)==true) ? 'block':'none'?>" href="<?php echo Url::to(['service/detail']); ?>">服务商信息</a></li>
                <li><a style="display: <?php echo (rightvalidate(RIGHT_ACCOUNT)==true) ? 'block':'none'?>" href="<?php echo Url::to(['account/list']); ?>">账号管理</a></li>
            </ul>
        </li>
    </ul>
</div>

<div class="main-con">
    <div class="main-content" id="mainContent">
        <?php echo $content; ?>
    </div>
</div>

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
