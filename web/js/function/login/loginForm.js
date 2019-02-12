$(function () {
    //表单提交
    $("#button").click(function () {
        var form = validate.form();

        if (form) {
            $('#form').submit();
        }
    });
});

var validate = $("#form").validate({
    debug: false, //调试模式取消submit的默认提交功能
    rules:{
        username:{
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 6,
            maxlength: 16
        }
    },
    messages:{
        username:{
            required: '请输入您的帐号',
            email: '请输入正确的邮箱'
        },
        password: {
            required: '请输入您的密码',
            minlength: '密码最小{0}位数',
            maxlength: '密码最大{0}位数'
        }
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
    errorClass: "text-danger",
    ignore: ''
});