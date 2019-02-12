<?php
use yii\helpers\Url;
?>
<div class="register-compenent">
    <header>
        <a href="<?php echo Url::to(['login/login']); ?>"><img src="<?php echo Yii::getAlias('@web/img/login/logo.png'); ?>" class="logo"></a>
    </header>
    <main>
        <form action="<?php echo Url::to(['send-email']) ?>" id="form" method="post">
            <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
            <div class="item-container">
                <div class="title">忘记密码重置</div>
                <div class="form-wrapper">
                    <div class="input">
                        <input type="text" class="form-text" name="account" maxlength="100" placeholder="邮箱账号">
                    </div>
                </div>
            </div>
            <div class="item-container">
                <button type="button" class="btn btn-primary w150" id="button">下一步</button>
            </div>
        </form>
    </main>
</div>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/login/forgetFirstForm.js'); ?>"></script>