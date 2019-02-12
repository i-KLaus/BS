$(function () {
    //文本编辑器初始化
    var ue = UE.getEditor('container',{
        initialFrameWidth: 1451,
        toolbars: [
            ['bold', 'source', 'fontsize','paragraph','rowspacingtop','rowspacingbottom','lineheight', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','edittable','edittd', 'link', 'insertimage']
        ]
    });

    ue.ready(function() {//编辑器初始化完成再赋值
        ue.setContent($(".js-regions").html(),false);  //赋值给UEditor
    });
    //当编辑器里的内容改变时执行方法
    ue.addListener("contentChange",function(){
        var $regions = $(".js-regions");
        $regions.html(ue.getContent());
    });
});

$('.addNumber').click(function () {
    var html = '<div class="mb10">\n' +
        '                        <input type="text" class="form-control form-control-inline wper30 merchantNumber" placeholder="" data-id="" maxlength="30">\n' +
        '                        <a href="javascript:;" class="text-primary ml10 deleteNumber">删除</a>\n' +
        '                    </div>';
    $('.numberSet').append(html);
});

$(document).on('click', '.deleteNumber', function () {
    $(this).parent().remove();
});

$(document).on('click', '.js-delete-pic', function () {
    $(this).parent('li').remove();
    buildImg();
});
//检测门店列表数据
var if_error_store = true;
function Checksotrelist(){
    var count_error = 0
    $('.store_list').each(function (inde,item) {
        $(item).find('input[name="stname"]').parent().find('label').remove()
        if($(item).find('input[name="stname"]').val()==''){
            count_error = count_error+1
            $(item).find('input[name="stname"]').parent().append("<label style='color: red'>必填</label>")
            $(item).find('input[name="stname"]').on("change",function() {
                $(item).find('input[name="stname"]').parent().find('label').remove()
            })
        }

        $(item).find('input[name="stbusiness"]').parent().find('label').remove()
        if($(item).find('input[name="stbusiness"]').val()==''){
            count_error = count_error+1
            $(item).find('input[name="stbusiness"]').parent().append("<label style='color: red'>必填</label>")
            $(item).find('input[name="stbusiness"]').on("change",function() {
                $(item).find('input[name="stbusiness"]').parent().find('label').remove()
            })
        }
        $(item).find('input[name="staddress"]').parent().find('label').remove()
        if($(item).find('input[name="staddress"]').val()==''){
            count_error = count_error+1
            $(item).find('input[name="staddress"]').parent().append("<label style='color: red'>必填</label>")
            $(item).find('input[name="staddress"]').on("change",function() {
                $(item).find('input[name="staddress"]').parent().find('label').remove()
            })
        }
        $(item).find('.pr').parent().find('label').remove()
       if($(item).find('.pr option:selected').text()=='请选择'){
           count_error = count_error+1
           $(item).find('.pr').parent().append("<label style='color: red'>必选</label>")
           $(item).find('.pr').change(function () {
               $(item).find('.pr').parent().find('label').remove()
           })
       }

        $(item).find('.ci').parent().find('label').remove()
        if($(item).find('.ci option:selected').text()=='请选择'){
            count_error = count_error+1
            $(item).find('.ci').parent().append("<label style='color: red'>必选</label>")
            $(item).find('.ci').change(function () {
                $(item).find('.ci').parent().find('label').remove()
            })
        }
        $(item).find('.ar').parent().find('label').remove()
        if($(item).find('.ar option:selected').text()=='请选择'){
            count_error = count_error+1
            $(item).find('.ar').parent().append("<label style='color: red'>必选</label>")
            $(item).find('.ar').change(function () {
                $(item).find('.ar').parent().find('label').remove()
            })
        }


        if(count_error!=0){
            if_error_store = false
        }
        if(count_error==0){
            if_error_store = true
        }


    })
}

$('#industry').change(function () {
    if($('#industry option:selected').val()!=''){
        $('#industry_id-error').remove()
    }
})



$('#pptype,#sqtype').click(function () {
    $('#typee-error').remove()

})
$('#zy_ticket,#pt_ticket,#no_ticket').click(function () {
    $('#ticket_type_id-error').remove()
})
$('#ewm,#ewmjl,#ylsf,#ylsk').click(function () {
    if($('#ewm').is(':checked')||$('#ylsf').is(':checked')||$('#ylsk').is(':checked')){
        $('#yl_production-error').remove()
    }
})
$('#ewmzl,#ewmjl').click(function () {
    $('#typefirst-error').remove()
    $('#yl_production-error').remove()
})
$('#ylsfzl,#ylsfjl').click(function () {
    $('#typesecond-error').remove()
    $('#yl_production-error').remove()
})
$('#ylskzl,#ylskjl').click(function () {
    $('#typethird-error').remove()
    $('#yl_production-error').remove()
})
$('#ar').change(function () {
    if($('#ar option:selected').val()!=''){
        $('#check_city-error').remove()
        $('#yl_production-error').remove()
    }
})




function buildImg() {
    var data = [];
    $('.pic-list .sort').each(function () {
        data.push($(this).find('img').attr('data-name'));
    });
    $('input[name="goods_img"]').val(JSON.stringify(data))
    $('#goods_img').trigger('change')

}

function first() {

    $('#first').show();
    $('#second').hide();
    $('.btn-group li').eq(0).addClass('active');
    $('.btn-group li').eq(1).removeClass('active');
}

function second() {
    Checksotrelist();
    if($('#ewm').is(':checked')) {
        if($('#ewmzl').is(':checked')==false){

        }
    }
    $img = $('#goods_img').val();

    if($img=='[]'){
        $('#goods_img').val('')
    }
//门店列表json拼装
    var store_json_list ='';
    var store_count_number = 0;
    $('.js-store-table').find('.store_list').each(function (iidnex,vvalue) {
        store_count_number = store_count_number+1
        var store_json = '';

        // $('.store_list').each(function (idx,item) {
        //     var pro = $(this).find('.pr').find('option:selected').text()
        //     var city = $(this).find('.ci').find('option:selected').text()
        //     var area = $(this).find('.ar').find('option:selected').text()
        //     console.log(pro,city,area,'---------------------')
        //
        // })

        $(vvalue).find('input,option:selected').each(function (ind,val) {
            var str = $(val).parent().prop('class').substr(31)

            var param = $(val).val()
            if($(val).prop('name')=="stname"){
                store_json = store_json  +'{"name":"' +param+ '",'
            }
            if($(val).prop('name')=="stbusiness"){
                store_json = store_json  +'"business_license_name":"' +param+ '",'
            }
            if($(val).prop('class').substr(0,14)=="store_province"||$(val).parent().prop('class').substr(31)=='pr'){
                var str = $(val).text();
                store_json = store_json  +'"province":"' +str+ '",'+'"province_code":"'+param+'",'
            }
            if($(val).prop('class').substr(0,10)=="store_city"||$(val).parent().prop('class').substr(31)=='ci'){
                var str = $(val).text();
                store_json = store_json  +'"city":"' +str+ '",'+'"city_code":"'+param+'",'
            }
            if($(val).prop('class').substr(0,10)=="store_area"||$(val).parent().prop('class').substr(31)=='ar'){
                var str = $(val).text();
                store_json = store_json  +'"area":"' +str+ '",'+'"area_code":"'+param+'",'
            }
            if($(val).prop('name')=="staddress"){
                store_json = store_json  +'"address":"' +param+ '"}'
            }

        })
        store_json_list = store_json_list + store_json+','
    })
    if(store_json_list!=''){
        store_json_list = store_json_list.substr(0,store_json_list.length-1)
        store_json_list = '['+store_json_list+']'

    }
    $('#store_data').val(store_json_list)

    $('#store_num').val(store_count_number)

    var if_store_exist = true
    //选择品牌商户 不选门店验证
    if($('#pptype').is(':checked')) {
        if($(".store_list").length==0){
            if_store_exist = false
            layer.msg("请为品牌商户添加门店")
        }

    }

    $(document).on('change','#goods_img',function () {
       $('#goods_img-error').remove()
    })

    var province = $('#pr option:selected').text()
    $('#province').val(province)
    var city = $('#ci').find('option:selected').text()
    $('#city').val(city)
    var area = $('#ar').find('option:selected').text();
    $('#area').val(area)




    var form = validate.form();
    if(form && if_error_store && if_store_exist){
        $('#first').hide();
        $('#second').show();
        $('.btn-group li').eq(0).removeClass('active');
        $('.btn-group li').eq(1).addClass('active');
    }
}