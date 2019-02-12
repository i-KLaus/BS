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
        account:{
            required: true,
            email: true
        }
    },
    messages:{
        account:{
            required: '请输入邮箱帐号',
            email: '请输入正确的邮箱'
        }
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
    errorClass: "text-danger",
    ignore: ''
});