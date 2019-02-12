$(function () {
    //表单提交

    $("#button").click(function () {
        var form = validate.form();

        var flag = checkData();
        if (flag == 'error') {
            return ;
        }


        if (form) {
            second();
        }
    });

});

function checkData() {
    var flag = 'success';
    var reg = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;
    var numberReg = /^\d+$/;
    $('.merchantNumber').each(function () {
        var number = $(this).val();
        if (number == '') {
            layer.msg('请填写商户编号');
            flag = 'error';
            return false;
        }
    });
    if (flag == 'error') {
        return flag;
    }
    $('.goodsStore').each(function () {
        var store_num = $(this).find('input[name="store_num"]').val();
        if (store_num == '') {
            layer.msg('请填写门店数量');
            flag = 'error';
            return false;
        }
        if (numberReg.exec(store_num) == null) {
            layer.msg('门店数量必须为整数');
            flag = 'error';
            return false;
        }
    });
    if (flag == 'error') {
        return flag;
    }
    $('.goodsData').each(function () {
        var price = $(this).find('input[name="price"]').val();
        var bill_rate = $(this).find('input[name="bill_rate"]').val();

        if (price == '') {
            layer.msg('请填写签约单价');
            flag = 'error';
            return false;
        }
        if (reg.exec(price) == null) {
            layer.msg('价格必须为数字，并且最多两位数');
            flag = 'error';
            return false;
        }
        if (parseFloat(price) > 1000000) {
            layer.msg('价格不能超过1000000');
            flag = 'error';
            return false;
        }
        if (reg.exec(bill_rate) == null && bill_rate != '') {
            layer.msg('对账收票必须为数字，并且最多两位数');
            flag = 'error';
            return false;
        }
    });
    return flag;
}

function buildGoodsData() {
    var data = [];
    $('.goodsData').each(function () {
        var json = {};
        json.store_num = $('.goodsStore').find('div[data-id="'+$(this).attr('data-id')+'"]').find('input[name="store_num"]').val();
        json.category_id = ',' + $(this).attr('data-id') + ',';
        json.price = $(this).find('input[name="price"]').val();
        json.bill_rate = $(this).find('input[name="bill_rate"]').val();
        data.push(json);
    });

    $('input[name="goods_data"]').val(JSON.stringify(data));
}

function buildNumberData() {
    var data = [];
    $('.merchantNumber').each(function () {
        var json = {};
        json.id = $(this).attr('data-id');
        json.number = $(this).val();
        data.push(json);
    });

    $('input[name="number_data"]').val(JSON.stringify(data));
}

//自定义validate验证输入的数字小数点位数不能大于两位
jQuery.validator.addMethod("minNumber",function(value, element){
    var returnVal = true;
    var inputZ=value;
    var ArrMen= inputZ.split(".");    //截取字符串
    if(ArrMen.length==2){
        if(ArrMen[1].length>2){    //判断小数点后面的字符串长度
            returnVal = false;
            return false;
        }
    }
    return returnVal;
},"小数点后最多为2位");

//最低价格不能低于0元
jQuery.validator.addMethod("minPrice",function(value, element){
    var returnVal = true;
    if(value<=0){
        return false
    }
    return returnVal;
},"价格不能低于等于0元");
//测试服务
jQuery.validator.addMethod("testOption",function(value, element){
    var returnVal = true;
    if($('#optional_test').is(':checked')) {
        if(value==''){
            return false
        }
    }
    return returnVal;
},"请填写价格");
//测试服务最低价
jQuery.validator.addMethod("testMinprice",function(value, element){
    var returnVal = true;
    if($('#optional_test').is(':checked')) {
        if(value<=0){
            return false
        }
    }
    return returnVal;
},"价格不能低于等于0元");
//测试服务最高价
jQuery.validator.addMethod("testMaxprice",function(value, element){
    var returnVal = true;
    if($('#optional_test').is(':checked')) {
        if(value>9999999){
            return false
        }
    }
    return returnVal;
},"最高价不能大于9999999");
//测试服务价格小数点位数
jQuery.validator.addMethod("testPricenum",function(value, element){
    var returnVal = true;
    if($('#optional_test').is(':checked')) {
        return this.optional(element) || /^\d+(\.\d{1,2})?$/.test(value);
    }
    return returnVal;
},"小数点后最多2位");

//商户满意度回访
jQuery.validator.addMethod("satOption",function(value, element){
    var returnVal = true;
    if($('#option_satify').is(':checked')) {
        if(value==''){
            return false
        }
    }
    return returnVal;
},"请填写价格");
//商户满意度回访最低价
jQuery.validator.addMethod("satMinprice",function(value, element){
    var returnVal = true;
    if($('#option_satify').is(':checked')) {
        if(value<=0){
            return false
        }
    }
    return returnVal;
},"价格不能低于等于0元");
//商户满意度回访最高价
jQuery.validator.addMethod("satMaxprice",function(value, element){
    var returnVal = true;
    if($('#option_satify').is(':checked')) {
        if(value>9999999){
            return false
        }
    }
    return returnVal;
},"最高价不能大于9999999");
//商户满意度回访价格小数点位数
jQuery.validator.addMethod("satPricenum",function(value, element){
    var returnVal = true;
    if($('#option_satify').is(':checked')) {
        return this.optional(element) || /^\d+(\.\d{1,2})?$/.test(value);
    }
    return returnVal;
},"小数点后最多2位");

//电话号码
jQuery.validator.addMethod("tellCk",function(value, element){
    return this.optional(element) || /^1[34578]\d{9}$/.test(value);
},"请输入正确的手机号码");

//普通发票信息
jQuery.validator.addMethod("ticketCk2",function(value, element){
    var returnVal = true;
    if($('#pt_ticket').is(':checked')) {
        if(value==''){
            return false
        }
    }
    return returnVal;
},"请填写信息");
//专用发票信息
jQuery.validator.addMethod("ticketCk",function(value, element){
    var returnVal = true;
    if($('#zy_ticket').is(':checked')) {
        if(value==''){
            return false
        }
    }
    return returnVal;
},"请填写信息");
//银联产品类型二维码
jQuery.validator.addMethod("ylCkewm",function(value, element){
    var returnVal = true;
    if($('#ewm').is(':checked')) {
        if($('#typefirst').val()==''){
            return false
        }
    }
    return returnVal;
},"请选择通道类型");
//银联产品类型闪付
jQuery.validator.addMethod("ylCksf",function(value, element){
    var returnVal = true;
    if($('#ylsf').is(':checked')) {
        if($('#typesecond').val()==''){
            return false
        }
    }
    return returnVal;
},"请选择通道类型");
//银联产品类型刷卡
jQuery.validator.addMethod("ylCksk",function(value, element){
    var returnVal = true;
    if($('#ylsk').is(':checked')) {
        if($('#typethird').val()==''){
            return false
        }
    }
    return returnVal;
},"请选择通道类型");

//商圈门店地址
jQuery.validator.addMethod("sqAddress",function(value, element){
    var returnVal = true;
    if($('#sqtype').is(':checked')) {
        if($('#full_address').val()==''){
            return false
        }
    }
    return returnVal;
},"请填写门店地址");
//商圈省市区选择
jQuery.validator.addMethod("sqPcr",function(value, element){
    var returnVal = true;
    if($('#sqtype').is(':checked')) {
        if($('#check_city').val()==''){
            return false
        }
    }
    return returnVal;
},"请选择省市区");



var validate = $("#form").validate({
    debug: false, //调试模式取消submit的默认提交功能
    rules:{
        category_id:{
            required: true
        },
        industry_id:{
            required: true
        },
        name: {
            required: true,
            maxlength: 40
        },
        goods_img: {
            required: true
        },
        alias: {
            required: true,
            maxlength: 20
        },
        typee: {
            required: true
        },
        merchant_name: {
            required: true,
            maxlength: 20
        },
        standard_rate:{
            required:true,
            min:0.01,
            max:100,
            minNumber:true
        },
        standard_minmun_guarantee:{
            required:true,
            minPrice:true,
            max:9999999,
            minNumber:true
        },
        optional_test_price:{
            testOption:true,
            testMinprice:true,
            testMaxprice:true,
            testPricenum:true
        },
        option_satify_price:{
            satOption:true,
            satMinprice:true,
            satMaxprice:true,
            satPricenum:true
        },
        finance_contact: {
            required: true,
            maxlength: 40
        },
        finance_contact_info:{
            required: true,
            tellCk:true
        },
        ticket_type_id:{
            required:true
        },
        ticket_invoice_title:{
            ticketCk:true
        },
        ticket_address:{
            ticketCk:true
        },
        ticket_code:{
            ticketCk:true
        },
        ticket_tel:{
            ticketCk:true
        },
        ticket_bank:{
            ticketCk:true
        },
        ticket_branch_bank:{
            ticketCk:true
        },
        ticket_bank_code:{
            ticketCk:true
        },
        yl_production:{
            required:true
        },
        typefirst:{
            ylCkewm:true
        },
        typesecond:{
            ylCksf:true
        },
        typethird:{
            ylCksk:true
        },
        full_address:{
            sqAddress:true
        },
        check_city:{
            sqPcr:true
        },
        ticket_invoice_title1:{
            ticketCk2:true
        },
        ticket_code1:{
            ticketCk2:true
        }
    },
    messages:{
        category_id:{
            required: '请选择服务分类'
        },
        industry_id:{
            required: '请选择服务分类'
        },
        name: {
            required: '请输入商品名称',
            maxlength: '商品名称最多{0}个字'
        },
        goods_img: {
            required: '请上传商品图片'
        },
        alias: {
            required: '请输入商户简称',
            maxlength: '商品名称最多{0}个字'
        },
        typee: {
            required: '请选择商户类别'
        },
        merchant_name: {
            required: '请输入商户名称',
            maxlength: '商品名称最多{0}个字'
        },
        standard_rate:{
            required:'请输入实际执行金额比例',
            min:'最大值不能小于{0}',
            max:'最大值不能超过{0}',
            minNumber:true
        },
        standard_minmun_guarantee:{
            required:'请输入保底金额',
            max:'保底价不能超过9999999',
        },
        finance_contact: {
            required: '请输入财务联系人',
            maxlength: '联系人名称最多{0}个字'
        },
        finance_contact_info:{
            required: '请输入手机号码'
        },
        ticket_type_id:{
            required:'请选择发票类型'
        },
        yl_production:{
            required:'请选择银联产品类型'
        }

    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent());
    },
    errorClass: "text-danger",
    ignore: ''
});