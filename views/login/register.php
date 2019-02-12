<?php
use yii\helpers\Url;
?>
<style>
    .ipt {
        display: flex;
        justify-content: space-between;
    }

    .ipt input {
        border: none;
        width: 250px;
    }

    .input {
        width: 100%;
        padding-top: 18px;
        line-height: 38px;
        border: none;
        border-bottom: 1px solid #E6E8EB;
    }
</style>
<div class="register-compenent">
    <header>
        <a href="<?php echo Url::to(['login/login']); ?>"><img src="<?php echo Yii::getAlias('@web/img/login/logo.png'); ?>" class="logo"></a>
    </header>
    <main>
        <form action="<?php echo Url::to(['register']); ?>" method="post" id="form">
            <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
            <input type="hidden" name="id" value="<?php echo $model -> id ?>">
            <div class="item-container">
                <div class="title">账户信息</div>
                <div class="form-wrapper">
                    <div class="input">
                        <label class="ipt">邮箱信息
                            <input type="text" name="account" placeholder="" value="<?php echo $model -> account ?>" maxlength="32">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">密码
                            <input type="password" name="pwd" id="pwd" placeholder="" value="">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">确认密码
                            <input type="password" name="pwdConfirm" placeholder="">
                        </label>
                    </div>
                </div>
            </div>
            <div class="item-container">
                <div class="title">服务商信息</div>
                <div class="form-wrapper">
                    <div class="input">
                        <label class="ipt">服务商名称
                            <input type="text" name="name" placeholder="" value="<?php echo $model -> name ?>">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">服务商注册地址
                            <input type="text" name="address" placeholder="" value="<?php echo $model -> address ?>">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">服务商经营地址
                            <input type="text" name="operating_address" placeholder="" value="<?php echo $model -> operating_address ?>">
                        </label>
                    </div>
                    <div class="upload-img">
                        <div class="upload-title">营业执照</div>
                        <div class="img-wrapper show">
                            <ul class="image-list">
                                <li style="<?php echo !empty($model -> business_license) ? '' : 'display:none;'; ?>">
                                    <img src="<?php echo !empty($model -> business_license) ? UPLOAD_IMG_SERVER_BUSINESS_LICENSE_SOURCE . $model -> business_license : ''; ?>" id="business_license_img" class="w200">
                                </li>
                                <li class="image-list--add">
                                    <input type="file" value="营业执照" id="businessLicense">
                                </li>
                            </ul>
                            <input type="hidden" name="business_license" value="<?php echo $model -> business_license ?>" >
                        </div>
                    </div>
                    <div class="input">
                        <label class="ipt">法人代表姓名
                            <input type="text" name="legal_person_name" placeholder="" value="<?php echo $model -> legal_person_name ?>">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">法人代表手机号
                            <input type="text" name="legal_person_phone" placeholder="" value="<?php echo $model -> legal_person_phone ?>">
                        </label>
                    </div>
                    <div class="upload-img">
                        <div class="upload-title">法人代表身份证正面</div>
                        <div class="img-wrapper show">
                            <ul class="image-list">
                                <li style="<?php echo !empty($model -> legal_person_id_card_zm) ? '' : 'display:none;'; ?>">
                                    <img src="<?php echo !empty($model -> legal_person_id_card_zm) ? UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_ZM_SOURCE . $model -> legal_person_id_card_zm : ''; ?>" id="legal_person_id_card_zm_img" class="w200">
                                </li>
                                <li class="image-list--add">
                                    <input type="file" value="正面照片" id="legalPersonIdCardZm">
                                </li>
                            </ul>
                            <input type="hidden" name="legal_person_id_card_zm" value="<?php echo $model -> legal_person_id_card_zm ?>">
                        </div>
                    </div>
                    <div class="upload-img">
                        <div class="upload-title">法人代表身份证反面</div>
                        <div class="img-wrapper show">
                            <ul class="image-list">
                                <li style="<?php echo !empty($model -> legal_person_id_card_fm) ? '' : 'display:none;'; ?>">
                                    <img src="<?php echo !empty($model -> legal_person_id_card_fm) ? UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_FM_SOURCE . $model -> legal_person_id_card_fm : ''; ?>" id="legal_person_id_card_fm_img" class="w200">
                                </li>
                                <li class="image-list--add">
                                    <input type="file" value="反面照片" id="legalPersonIdCardFm">
                                </li>
                            </ul>
                            </div>
                            <input type="hidden" name="legal_person_id_card_fm" value="<?php echo $model -> legal_person_id_card_fm ?>">
                        </div>
                    </div>
                </div>
            <div class="item-container">
                <div class="title">联系人信息</div>
                <div class="form-wrapper" id="linkmanMsg">
                    <div class="input">
                        <label class="ipt">联系人姓名
                            <input type="text" name="contact_name" placeholder="" value="<?php echo $model -> contact_name ?>">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">联系人手机号
                            <input type="text" name="contact_phone" placeholder="" value="<?php echo $model -> contact_phone ?>">
                        </label>
                    </div>
                    <div class="upload-img">
                        <div class="upload-title">身份证正面</div>
                        <div class="img-wrapper show">
                            <ul class="image-list">
                                <li style="<?php echo !empty($model -> contact_id_card_zm) ? '' : 'display:none;'; ?>">
                                    <img src="<?php echo !empty($model -> contact_id_card_zm) ? UPLOAD_IMG_SERVER_CONTACT_ID_CARD_ZM_SOURCE . $model -> contact_id_card_zm : ''; ?>" id="contact_id_card_zm_img" class="w200">
                                </li>
                                <li class="image-list--add">
                                    <input type="file" value="正面照片" id="contactIdCardZm">
                                </li>
                            </ul>
                            <input type="hidden" name="contact_id_card_zm" value="<?php echo $model -> contact_id_card_zm ?>">
                        </div>
                    </div>
                    <div class="upload-img">
                        <div class="upload-title">身份证反面</div>
                        <div class="img-wrapper show">
                            <ul class="image-list">
                                <li style="<?php echo !empty($model -> contact_id_card_fm) ? '' : 'display:none;'; ?>">
                                    <img src="<?php echo !empty($model -> contact_id_card_fm) ? UPLOAD_IMG_SERVER_CONTACT_ID_CARD_FM_SOURCE . $model -> contact_id_card_fm : ''; ?>" id="contact_id_card_fm_img" class="w200">
                                </li>
                                <li class="image-list--add">
                                    <input type="file" value="反面照片" id="contactIdCardFm">
                                </li>
                            </ul>
                            <input type="hidden" name="contact_id_card_fm" value="<?php echo $model -> contact_id_card_fm ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-container">
                <div class="title">结算账户</div>
                <div class="form-wrapper">
                    <div class="input">
                        <label class="ipt">账户名称
                            <input type="text" name="account_name" placeholder="" value="<?php echo $model -> account_name ?>">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">结算账户
                            <input type="text" name="settlement_account" placeholder="" value="<?php echo $model -> settlement_account ?>">
                        </label>
                    </div>
                    <div class="input">
                        <label class="ipt">开户行信息
                            <input type="text" name="bank_info" placeholder="" value="<?php echo $model -> bank_info ?>">
                        </label>
                    </div>
                    <div class="upload-img">
                        <div class="upload-title">基本户开户许可证</div>
                        <div class="img-wrapper show">
                            <ul class="image-list">
                                <li style="<?php echo !empty($model -> account_opening_permit) ? '' : 'display:none;'; ?>">
                                    <img src="<?php echo !empty($model -> account_opening_permit) ? UPLOAD_IMG_SERVER_ACCOUNT_OPENING_PERMIT_SOURCE . $model -> account_opening_permit : ''; ?>" id="account_opening_permit_img" class="w200">
                                </li>
                                <li class="image-list--add">
                                    <input type="file" value="选择图片" id="accountOpeningPermit">
                                </li>
                            </ul>
                            <input type="hidden" name="account_opening_permit" value="<?php echo $model -> account_opening_permit ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-container">
                <button type="button" class="btn btn-primary w150" id="button">提交审核</button>
            </div>
        </form>
    </main>
</div>

<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/login/register.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/login/registerForm.js'); ?>"></script>
<script>
    upload_img(
        'businessLicense',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_IMG_TYPE; ?>',
        '<?php echo UPLOAD_IMG_SERVER_BUSINESS_LICENSE_FOLDER; ?>',
        '',
        function (filename) {
            $('input[name="business_license"]').val(filename);
            $('#business_license_img').attr('src', '<?php echo UPLOAD_IMG_SERVER_BUSINESS_LICENSE_SOURCE; ?>' + filename).parent('li').show();
        }
    );

    upload_img(
        'legalPersonIdCardZm',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_IMG_TYPE; ?>',
        '<?php echo UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_ZM_FOLDER; ?>',
        '',
        function (filename) {
            $('input[name="legal_person_id_card_zm"]').val(filename);
            $('#legal_person_id_card_zm_img').attr('src', '<?php echo UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_ZM_SOURCE; ?>' + filename).parent('li').show();
        }
    );

    upload_img(
        'legalPersonIdCardFm',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_IMG_TYPE; ?>',
        '<?php echo UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_FM_FOLDER; ?>',
        '',
        function (filename) {
            $('input[name="legal_person_id_card_fm"]').val(filename);
            $('#legal_person_id_card_fm_img').attr('src', '<?php echo UPLOAD_IMG_SERVER_LEGAL_PERSON_ID_CARD_FM_SOURCE; ?>' + filename).parent('li').show();
        }
    );

    upload_img(
        'contactIdCardZm',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_IMG_TYPE; ?>',
        '<?php echo UPLOAD_IMG_SERVER_CONTACT_ID_CARD_ZM_FOLDER; ?>',
        '',
        function (filename) {
            $('input[name="contact_id_card_zm"]').val(filename);
            $('#contact_id_card_zm_img').attr('src', '<?php echo UPLOAD_IMG_SERVER_CONTACT_ID_CARD_ZM_SOURCE; ?>' + filename).parent('li').show();
        }
    );

    upload_img(
        'contactIdCardFm',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_IMG_TYPE; ?>',
        '<?php echo UPLOAD_IMG_SERVER_CONTACT_ID_CARD_FM_FOLDER; ?>',
        '',
        function (filename) {
            $('input[name="contact_id_card_fm"]').val(filename);
            $('#contact_id_card_fm_img').attr('src', '<?php echo UPLOAD_IMG_SERVER_CONTACT_ID_CARD_FM_SOURCE; ?>' + filename).parent('li').show();
        }
    );

    upload_img(
        'accountOpeningPermit',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_IMG_TYPE; ?>',
        '<?php echo UPLOAD_IMG_SERVER_ACCOUNT_OPENING_PERMIT_FOLDER; ?>',
        '',
        function (filename) {
            $('input[name="account_opening_permit"]').val(filename);
            $('#account_opening_permit_img').attr('src', '<?php echo UPLOAD_IMG_SERVER_ACCOUNT_OPENING_PERMIT_SOURCE; ?>' + filename).parent('li').show();
        }
    );
</script>