<?php
use yii\helpers\Url;
?>
<nav class="navbar">
    <div class="navbar_header"></i>优选运营服务商平台</div>
    <div class="navbar_collapse">
        <ul class="navbar_nav navbar--right">
            <li><a href="javascript:;"><i class="icon-user h4"></i> <?php echo Yii::$app -> session -> get('name'); ?></a></li>
            <li><a href="<?php echo Url::to(['/login/login-out']) ?>"><i class="icon-loginout h4"></i>退出</a></li>
        </ul>
    </div>
</nav>