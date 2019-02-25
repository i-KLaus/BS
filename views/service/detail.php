<?php
use app\components\widgets\common\IndexTitleWidget;
?>
<?php echo IndexTitleWidget::widget(); ?>
<div class="m-content">
    <div class="form-horizontal form-add form-md-200">
        <h5 class="border-b pb10 mb15"><strong>账户信息</strong></h5>
        <div class="form-group">
            <label class="control-label text-dark">邮箱账号</label>
            <div class="control-input"><?php echo $model -> account; ?></div>
        </div>

        <h5 class="border-b pb10 mb15"><strong>服务商信息</strong></h5>
        <div class="form-group">
            <label class="control-label text-dark">运营服务商名称</label>
            <div class="control-input"><?php echo $model -> name ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">运营服务商经营地址</label>
            <div class="control-input"><?php echo $model -> operating_address ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">营业执照</label>
            <div class="control-input">
                <img src="<?php echo UPLOAD_IMG_SERVER_BUSINESS_LICENSE_SOURCE . $model -> business_license; ?>" alt="" class="w192">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">法人代表姓名</label>
            <div class="control-input"><?php echo $model -> legal_person_name ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">法人代表手机号</label>
            <div class="control-input"><?php echo $model -> legal_person_phone ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">法人代表身份证正面</label>
            <div class="control-input"><img src="<?php echo UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_ZM_SOURCE . $model -> legal_person_id_card_zm; ?>" alt="" class="w192"></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">法人代表身份证反面</label>
            <div class="control-input"><img src="<?php echo UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_FM_SOURCE . $model -> legal_person_id_card_fm; ?>" alt="" class="w192"></div>
        </div>

        <h5 class="border-b pb10 mb15"><strong>联系人信息</strong></h5>
        <div class="form-group">
            <label class="control-label text-dark">联系人姓名</label>
            <div class="control-input"><?php echo $model -> contact_name ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">联系人手机号</label>
            <div class="control-input"><?php echo $model -> contact_phone ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">身份证正面</label>
            <div class="control-input"><img src="<?php echo UPLOAD_IMG_SERVER_CONTACT_ID_CARD_ZM_SOURCE . $model -> contact_id_card_zm; ?>" alt="" class="w192"></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">身份证反面</label>
            <div class="control-input"><img src="<?php echo UPLOAD_IMG_SERVER_CONTACT_ID_CARD_FM_SOURCE . $model -> contact_id_card_fm; ?>" alt="" class="w192"></div>
        </div>

        <h5 class="border-b pb10 mb15"><strong>结算账户</strong></h5>
        <div class="form-group">
            <label class="control-label text-dark">账户名称</label>
            <div class="control-input"><?php echo $model -> account_name ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">结算账户</label>
            <div class="control-input"><?php echo $model -> settlement_account ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">开户行信息</label>
            <div class="control-input"><?php echo $model -> bank_info ?></div>
        </div>
        <div class="form-group">
            <label class="control-label text-dark">基本户开户许可证</label>
            <div class="control-input"><img src="<?php echo UPLOAD_IMG_SERVER_ACCOUNT_OPENING_PERMIT_SOURCE . $model -> account_opening_permit; ?>" alt="" class="w192"></div>
        </div>
    </div>
</div>