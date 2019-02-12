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

var validate = $("#form").validate({
    debug: false, //调试模式取消submit的默认提交功能
    rules:{
        pwd: {
            required: true,
            checkPwd: true
        },
        pwdConfirm:{
            required: true,
            equalTo: '#pwd'
        }
    },
    messages:{
        pwd: {
            required: '请输入密码'
        },
        pwdConfirm:{
            required: '请确认密码',
            equalTo: '两次密码输入不一致'
        }
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
    errorClass: "text-danger",
    ignore: ''
});