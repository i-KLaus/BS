$(function () {
    //表单提交
    $("#button").click(function () {
        var form = validate.form();
        console.log(form)



        if (form) {
            second();
        }
    });
});



var validate = $("#form").validate({
    debug: false, //调试模式取消submit的默认提交功能
    rules:{
        category_id:{
            required: true
        },
        name: {
            required: true,
            maxlength: 40
        },
        goods_img: {
            required: true
        }
    },
    messages:{
        category_id:{
            required: '请选择服务分类'
        },
        name: {
            required: '请输入商品名称',
            maxlength: '商品名称最多{0}个字'
        },
        goods_img: {
            required: '请上传商品图片'
        }
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
    errorClass: "text-danger",
    ignore: ''
});