<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
    .error{
        color:red;
    }
</style>
<div class="login-compenent">
    <header>
        <div class="header-r">
            <span></span>
        </div>
        <div class="header-l">
            <a href="<?php echo Url::to(['login/login']); ?>"><img src="<?php echo Yii::getAlias('@web/img/login/logo.png'); ?>" class="logo"></a>
        </div>
    </header>
        <main>
            <div class="main-l">
                <img src="<?php echo Yii::getAlias('@web/img/login/pic.png'); ?>" alt="">
            </div>
            <div class="main-r">
                <h3>登录优选运营服务商平台</h3>
                <form action="<?php echo Url::to(['login']); ?>" class="login-form" id="form" method="post">
                    <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
                    <div class="form-group">
                        <i class="icon-user"></i>
                        <input type="text" class="form-txt" name="username" placeholder="请输入用户名" value="<?php echo $model -> username; ?>" maxlength="32">
                    </div>
                    <?php echo Html::error($model, 'username', ['class' => 'error']); ?>
                    <div class="form-group">
                        <i class="icon-password"></i>
                        <input type="password" class="form-txt" name="password" placeholder="请输入密码" value="<?php echo $model -> password; ?>" maxlength="16">
                    </div>
                    <?php echo Html::error($model, 'password', ['class' => 'error']); ?>
                    <div class="btn-wrap">
                        <input type="button" value="登录" class="btn-login" id="button">
                    </div>
                </form>
                <div class="forget">
                    <a href="<?php echo Url::to(['forget-first']); ?>" class="text-gray-light">忘记密码？</a>
                    <a href="<?php echo Url::to(['register']); ?>" class="text-gray-light">免费注册</a>
                </div>
            </div>
        </main>
    <div class="spaceh"></div>
</div>
<div class="login-footer">
    <p>Copyright@2017优选版权所有 浙ICP备18047439号-1</p>
</div>

<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/login/loginForm.js'); ?>"></script>