<?php
use yii\helpers\Url;
?>
<div class="register-compenent">
    <header>
        <a href="<?php echo Url::to(['login/login']); ?>"><img src="<?php echo Yii::getAlias('@web/img/login/logo.png'); ?>" class="logo"></a>
    </header>
    <main>
        <form action="">
            <div class="item-container">
                <div class="form-wrapper">
                    <div class="ptb50 text-center">
                        <h3>密码重置成功</h3>
                        <p><em class="text-danger" id="time">5</em> 秒后自动跳转</p>
                    </div>
                </div>
            </div>
            <div class="item-container">
                <a href="<?php echo Url::to(['login/login']); ?>" class="btn btn-primary w150">确定</a>
            </div>
        </form>
    </main>
</div>
<script>
    var i = 5;
    intervalid = setInterval("fun()", 1000);
    function fun() {
        if (i == 0) {
            window.location.href='<?php echo Url::to(['login/login']) ?>';
            clearInterval(intervalid);
        }
        $('#time').html(i);
        i--;
    }
</script>