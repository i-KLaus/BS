$(function () {
    //文本编辑器初始化
    var ue = UE.getEditor('container',{
        initialFrameWidth: 1451,
        toolbars: [
            ['bold', 'source', 'fontsize','paragraph','rowspacingtop','rowspacingbottom','lineheight', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','edittable','edittd', 'link', 'insertimage']
        ]
    });

    ue.ready(function() {//编辑器初始化完成再赋值
        ue.setContent($(".js-regions").html());  //赋值给UEditor
    });
    //当编辑器里的内容改变时执行方法
    ue.addListener("contentChange",function(){
        var $regions = $(".js-regions");
        $regions.html(ue.getContent());
    });
});

$('select[name="category_p_id"]').change(function () {
    getSubCategory();
});

function getSubCategory() {
    var pid = $('select[name="category_p_id"]').find('option:selected').val();
    $.ajax({
        'type': 'get',
        'url': 'get-sub-category.html',
        'data': {'p_id': pid},
        'dataType': 'json',
        'success': function (result) {
            console.log(category_id)
            var html = '';
            for (var i = 0; i < result.length; i++) {
                var obj = result[i];
                if(category_id!=""&& category_id==obj.id){
                    html += '<option value="'+obj.id+'" selected>'+obj.name+'</option>';
                }
                else {
                    html += '<option value="'+obj.id+'">'+obj.name+'</option>';
                }
            }
            $('select[name="category_id"]').html(html);
        }
    });
}







$('select[name="category_id"]').change(function () {

});

$(document).on('click', '.js-delete-pic', function () {
    $(this).parent('li').remove();
    buildImg();
});

function buildImg() {
    var data = [];
    $('.pic-list .sort').each(function () {
        data.push($(this).find('img').attr('data-name'));
    });
    $('input[name="goods_img"]').val(JSON.stringify(data));
}


var check_eprice =true;
function checkEprice() {
    var err_num = 0;
    $('.goodsData').find("input[name='price']").each(function (ind,v) {
        $(this).next('label').remove()
        var reg1 = /^[0-9]+([.]{1}[0-9]{1,2})?$/;
        if($(v).val()!=''){
            if($(v).val()>9999999 || !reg1.test($(v).val()) || $(v).val()==0){
                err_num = err_num+1;
                $(this).after('<label style="color: red">价格小于等于9999999,保留2位小数</label>')
            }
        }

        if($(v).val()==''){
            err_num = err_num+1;
            $(this).after('<label style="color: red">请输入价格</label>')
        }
    })
    if(err_num!=0){
        check_eprice = false;
    }else {
        check_eprice =true
    }
}

var check_price = true;
function checkPrice(){
    var err_num = 0;
    $('.goodsData').find('.table-input').each(function (ind,v) {
        $(this).next('label').remove()
        var reg1 = /^[0-9]+([.]{1}[0-9]{1,2})?$/;
        if($(v).val()!=''){
            if($(v).val()>9999999 || !reg1.test($(v).val()) || $(v).val()==0){
                err_num = err_num+1;
                $(this).after('<label style="color: red">价格小于等于9999999,保留2位小数</label>')
            }
        }

       if($(v).val()==''){
           err_num = err_num+1;
           $(this).after('<label style="color: red">请输入价格</label>')
       }
    })

    if(err_num!=0){
        check_price = false;
    }else {
        check_price = true
    }

}


$(document).on('change','.pr',function () {
    checkPrice();
})
$(document).on('change','.epric',function () {
    checkEprice();
})

function first() {
    $('#first').show();
    $('#second').hide();
    $('.btn-group li').eq(0).addClass('active');
    $('.btn-group li').eq(1).removeClass('active');
}

function second() {
    $img = $('#goods_img').val();
    if($img=='[]'){
        $('#goods_img').val('')
    }

    var goods_data = '';
    $('.tb').find('.goodsData').each(function (i,item) {
        var goods_list = '';
        $(item).find('input').each(function (x,v) {
                var attr = $(v).val()
            if($(v).prop('name')=='pri'){
                goods_list = goods_list +'{"price":'+attr+','
            }else{
                goods_list = goods_list + '"category_id":",'+attr+',"},'
            }
        })
        goods_data = goods_data + goods_list
    })
    goods_data = goods_data.substr(0,goods_data.length-1)
    goods_data = '['+goods_data+']'
    $('#goods_data').val(goods_data)


    var goods_sku = '';

    $('.goodsData').each(function (inde,val) {
        var sku_price = $(val).find("input[name='price']").val()
        var sku_id = $(val).find("input[name='goods_sku_id']").val()
        goods_sku =goods_sku + '{"price":"' +sku_price+ '",'+'"sku_id":"' +sku_id+ '"},'

    })

    goods_sku = goods_sku.substr(0,goods_sku.length-1)
    goods_sku = '['+goods_sku+']'

    $('#goods_sku').val(goods_sku)

    var attr_count= 0;
    var if_attr = true;

    // if($('.addCategory').length)

    $('.js-sku-sub-group').each(function (index,item) {
        attr_count = attr_count+1;
    })


    if($('.addCategory').length>0){
        $('.js-sku-sub-group').each(function (index,item) {
            attr_count = attr_count+1;
        })
        if(attr_count == 0){
            if_attr = false
            layer.msg('请选择规格')
        }
        if($('.normal-table').length==0){
            if_attr = false
            layer.msg('请选择规格')
        }
    }else {
        if_attr = true;
    }



    checkPrice();
    checkEprice();




    var form = validate.form();
    if(form && check_price && check_eprice && if_attr) {
        $('#first').hide();
        $('#second').show();
        $('.btn-group li').eq(0).removeClass('active');
        $('.btn-group li').eq(1).addClass('active');
    }
}