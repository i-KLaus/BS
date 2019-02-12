<?php
use yii\helpers\Url;
?>
<style>
    .form_title {
        width: 170px;
        display: inline-block;
    }

    .upload-title{
        width: 170px;
        display: inline-block;
    }

    .image {
        width: 80px;
    }

    .bottom-border {
        border-bottom: 1px solid #E6E8EB;
    }

    .image-list .image-text {
        line-height: 30px;
    }

    .image-list li{
        float: left;
        margin: 10px 10px 0 10px;
        border: 1px solid #E6E8EB;
        background-color: #fff;
        vertical-align: middle;
        width: 80px;
        height: 80px;
        line-height: 78px;
        cursor: pointer;
    }

    .image-list li img {
        max-width: 100%;
        max-height: 100%;
    }

    .upload-img{
        display: flex;
        flex-direction: row;
    }
</style>
<div class="register-compenent">
    <header>
        <a href="<?php echo Url::to(['login/login']); ?>"><img src="<?php echo Yii::getAlias('@web/img/login/logo.png'); ?>" class="logo"></a>
    </header>
    <main>


            <div class="item-container">
                <div class="title">账户信息</div>
                <div class="form-wrapper">
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">邮箱信息</span>
                            <span id="demandName"><?php echo $model -> account ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-container">
                <div class="title">服务商信息</div>
                <div class="form-wrapper">
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">服务商名称</span>
                            <span><?php echo $model -> name ?></span>
                        </div>
                    </div>
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">服务商注册地址</span>
                            <span><?php echo $model -> address ?></span>
                        </div>
                    </div>
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">服务商经营地址</span>
                            <span><?php echo $model -> operating_address ?></span>
                        </div>
                    </div>
                    <div class="upload-img bottom-border">
                        <div class="upload-title">营业执照</div>
                        <div class="img-wrapper">
                            <ul class="image-list">
                                <li>
                                <img src="<?php echo !empty($model -> business_license) ? UPLOAD_IMG_SERVER_BUSINESS_LICENSE_SOURCE . $model -> business_license : ''; ?>" id="business_license_img" class="w200">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">法人代表姓名</span>
                            <span><?php echo $model -> legal_person_name ?></span>
                        </div>
                    </div>
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">法人代表手机号</span>
                            <span><?php echo $model -> legal_person_phone ?></span>
                        </div>
                    </div>
                    <div class="upload-img bottom-border">
                        <div class="upload-title">法人代表身份证正面</div>
                        <div class="img-wrapper">
                            <ul class="image-list">
                                <li>
                                <img src="<?php echo !empty($model -> legal_person_id_card_zm) ? UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_ZM_SOURCE . $model -> legal_person_id_card_zm : ''; ?>" id="legal_person_id_card_zm_img" class="w200">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="upload-img bottom-border">
                        <div class="upload-title">法人代表身份证反面</div>
                        <div class="img-wrapper">
                            <ul class="image-list">
                                <li>
                                <img src="<?php echo !empty($model -> legal_person_id_card_fm) ? UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_FM_SOURCE . $model -> legal_person_id_card_fm : ''; ?>" id="legal_person_id_card_fm_img" class="w200">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-container">
                <div class="title">联系人信息</div>
                <div class="form-wrapper" action="" id="linkmanMsg">
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">联系人姓名</span>
                            <span><?php echo $model -> contact_name ?></span>
                        </div>
                    </div>
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">联系人手机号</span>
                            <span><?php echo $model -> contact_phone ?></span>
                        </div>
                    </div>
                    <div class="upload-img bottom-border">
                        <div class="upload-title">身份证正面/反面</div>
                        <div class="img-wrapper">
                            <ul class="image-list">
                                <li>
                                <img src="<?php echo !empty($model -> contact_id_card_zm) ? UPLOAD_IMG_SERVER_CONTACT_ID_CARD_ZM_SOURCE . $model -> contact_id_card_zm : ''; ?>" id="contact_id_card_zm_img" class="w200">
                                </li>
                            </ul>
                        </div>
                        <div class="img-wrapper">
                            <ul class="image-list">
                                <li>
                                <img src="<?php echo !empty($model -> contact_id_card_fm) ? UPLOAD_IMG_SERVER_CONTACT_ID_CARD_FM_SOURCE . $model -> contact_id_card_fm : ''; ?>" id="contact_id_card_fm_img" class="w200">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-container">
                <div class="title">结算账户</div>
                <div class="form-wrapper">
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">账户名称</span>
                            <span><?php echo $model -> account_name ?></span>
                        </div>
                    </div>
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">结算账户</span>
                            <span><?php echo $model -> settlement_account ?></span>
                        </div>
                    </div>
                    <div class="input">
                        <div class="form-text">
                            <span class="form_title">开户行信息</span>
                            <span><?php echo $model -> bank_info ?></span>
                        </div>
                    </div>
                    <div class="upload-img bottom-border">
                        <div class="upload-title">基本户开户许可证</div>
                        <div class="img-wrapper">
                            <ul class="image-list">
                                <li>
                                <img src="<?php echo !empty($model -> account_opening_permit) ? UPLOAD_IMG_SERVER_ACCOUNT_OPENING_PERMIT_SOURCE . $model -> account_opening_permit : ''; ?>" id="account_opening_permit_img" class="w200">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <div class="item-container">
            <a href="<?php echo Url::to(['review', 'id' => $model -> id]); ?>" class="btn btn-primary w150">返回</a>
        </div>
    </main>
</div>