$(function () {
    //表单提交
    $("#button").click(function () {
        var form = validate.form();

        if (form) {
            $('#form').submit();
        }
    });
});

$.validator.addMethod("checkPwd",function(value,element,params){
    var checkTelephone = /^(?!\d+$)(?![a-zA-Z]+$)[\dA-Za-z]{6,16}$/;
    return this.optional(element)||(checkTelephone.test(value));
},"密码必须保证含有数字、字母、字符其中两种, 并且长度保证在6-16位");

$.validator.addMethod("checkPhone",function(value,element,params){
    var checkTelephone = /^1\d{10}$/;
    return this.optional(element)||(checkTelephone.test(value));
},"手机号码格式不正确");

var validate = $("#form").validate({
    debug: false, //调试模式取消submit的默认提交功能
    rules:{
        account:{
            required: true,
            email: true,
            remote: {
                url: 'check-account.html',
                type: 'get',
                data: {
                    id: function() {
                        return $('input[name="id"]').val();
                    },
                    account: function() {
                        return $('input[name="account"]').val();
                    }
                },
                dataFilter: function (data) {
                    if (data == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        },
        pwd: {
            required: true,
            checkPwd: true
        },
        pwdConfirm:{
            required: true,
            equalTo: '#pwd'
        },
        name: {
            required: true,
            maxlength: 20
        },
        address: {
            required: true,
            maxlength: 40
        },
        operating_address: {
            required: true,
            maxlength: 40
        },
        business_license: {
            required: true
        },
        legal_person_name: {
            required: true,
            maxlength: 6
        },
        legal_person_phone: {
            required: true,
            checkPhone: true
        },
        legal_person_id_card_zm: {
            required: true
        },
        legal_person_id_card_fm: {
            required: true
        },
        contact_name: {
            required: true,
            maxlength: 6,
        },
        contact_phone: {
            required: true,
            checkPhone: true
        },
        contact_id_card_zm: {
            required: true
        },
        contact_id_card_fm: {
            required: true
        },
        account_name: {
            required: true,
            maxlength: 20
        },
        settlement_account: {
            required: true,
            maxlength: 30
        },
        bank_info: {
            required: true,
            maxlength: 40
        },
        account_opening_permit: {
            required: true
        }
    },
    messages:{
        account:{
            required: '请输入邮箱帐号',
            email: '请输入正确的邮箱',
            remote: '该邮箱账号已存在'
        },
        pwd: {
            required: '请输入密码'
        },
        pwdConfirm:{
            required: '请确认密码',
            equalTo: '两次密码输入不一致'
        },
        name: {
            required: '请输入运营服务商名称',
            maxlength: '运营服务商名称最多{0}个字'
        },
        address: {
            required: '请输入运营服务商注册地址',
            maxlength: '运营服务商注册地址最多{0}个字'
        },
        operating_address: {
            required: '请输入运营服务商经营地址',
            maxlength: '运营服务商经营地址最多{0}个字'
        },
        business_license: {
            required: '请上传营业执照'
        },
        legal_person_name: {
            required: '请输入法人代表名称',
            maxlength: '法人代表名称最多{0}个字'
        },
        legal_person_phone: {
            required: '请输入法人代表手机号'
        },
        legal_person_id_card_zm: {
            required: '请上传法人代表身份证正面'
        },
        legal_person_id_card_fm: {
            required: '请上传法人代表身份证反面'
        },
        contact_name: {
            required: '请输入联系人姓名',
            maxlength: '联系人姓名最多{0}个字',
        },
        contact_phone: {
            required: '请输入联系人手机号'
        },
        contact_id_card_zm: {
            required: '请上传身份证正面'
        },
        contact_id_card_fm: {
            required: '请上传身份证反面'
        },
        account_name: {
            required: '请输入账户名称',
            maxlength: '账户名称最多{0}个字'
        },
        settlement_account: {
            required: '请输入结算账户',
            maxlength: '结算账户最多{0}个字'
        },
        bank_info: {
            required: '请输入开户行信息',
            maxlength: '开户行信息最多{0}个字'
        },
        account_opening_permit: {
            required: '请上传基本户开户许可证'
        }
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent().parent());
    },
    errorClass: "text-danger",
    ignore: ''
});