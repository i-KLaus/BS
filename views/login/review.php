<?php
use yii\helpers\Url;
?>
<div class="register-compenent">
    <header>
        <div class="header_left">
            <a href="<?php echo Url::to(['login/login']); ?>"><img src="<?php echo Yii::getAlias('@web/img/login/logo.png'); ?>" class="logo"></a>
        </div>
    </header>
    <main>
        <div class="item-container">
            <img src="<?php echo Yii::getAlias('@web/img/review.png') ?>" alt="">
            <div class="prompt"><?php echo $GLOBALS['__FWS_STATUS'][$model -> status]; ?></div>
            <div class="review-result">
                <?php echo in_array($model -> status, [FWS_STATUS_OPERATION_AUDIT, FWS_STATUS_UNIONPAY_AUDIT]) ? '您的资料已提交，请耐心等待' : '驳回原因：' . $model -> reject_reason; ?>
            </div>
            <a href="<?php echo in_array($model -> status, [FWS_STATUS_OPERATION_AUDIT, FWS_STATUS_UNIONPAY_AUDIT]) ? Url::to(['view', 'id' => $model -> id]) : Url::to(['register', 'id' => $model -> id]); ?>" class="view-review">
                <?php echo in_array($model -> status, [FWS_STATUS_OPERATION_AUDIT, FWS_STATUS_UNIONPAY_AUDIT]) ? '查看审核资料' : '重新提交'; ?>
            </a>
        </div>
    </main>
</div>