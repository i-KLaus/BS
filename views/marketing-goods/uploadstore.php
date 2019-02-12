<?php
use yii\helpers\Url;
?>
<?php if($data!='error' &&$data!='error-area'){ ?>
<?php foreach ($data as $key=>$val) {?>
    <div class="table_row store_list">
        <div class="table_cell stlist">
            <input type="text" class="form-control stname w100 inline-block" name="stname" value="<?php echo $val[1] ?>">
        </div>
        <div class="table_cell stlist">
            <input type="text" class="form-control stbusiness w100 inline-block" name="stbusiness" value="<?php echo $val[2] ?>">
        </div>
        <div class="table_cell stlist">
            <select class="form-control w100 inline-block pr" name="stprovince<?php echo $key; ?>">
                <option value="" name="stprovince">请选择</option>
                <?php if(!empty($province)){ ?>
                    <?php foreach ($province as $k=>$v) {?>
                        <option name="stprovince" class="store_province_option" value="<?php echo $k ?>" <?php if($k==$val[7]){echo "selected";} ?>><?php echo $v?></option>
                    <?php }?>
                <?php }?>
            </select>
        </div>
        <div class="table_cell stlist">
            <select class="form-control w100 inline-block ci" name="stcity<?php echo $key; ?>">
                <option value="" name="store_city_option<?php echo $key; ?>" class="store_city_option">请选择</option>
            </select>
        </div>
        <div class="table_cell stlist">
            <select class="form-control w100 inline-block ar" name="stblock<?php echo $key; ?>"">
            <option value="" name="store_area_option<?php echo $key; ?>" class="store_area_option">请选择</option>
            </select>
        </div>
        <div class="table_cell stlist">
            <input type="text"  class="form-control staddress w100 inline-block" name="staddress"  value="<?php echo $val[6] ?>" >
        </div>
        <div class="table_cell stlist">
            <a href="javascript:;" class="text-primary store-delete">删除</a>
        </div>
    </div>
<?php }?>
<?php }?>
<?php if($data=='error'){
    echo "<script>layer.msg('文件类型错误，请上传指定格式excel')</script>";
}?>
<?php if($data=='error-area'){
    echo "<script>layer.msg('区域信息填写错误，请核对后重新提交')</script>";
}?>
<script>
    //门店列表数据
    var store_data_num = '<?php echo count($data) ?>' ;
    var store_json = '<?php echo $store_json ?>'
    var store_json_arr= eval("(" + store_json + ")")
    var start_num = '<?php echo $num ?>'




    function get_store_data(i) {
        if(i>Number(store_data_num)+Number(start_num)-1){
            return;
        }
        console.log(Number(store_data_num)+Number(start_num)-1)
        $.ajax({
            'type': 'get',
            'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
            'data': {'pid': $('[name="stprovince'+i+'"]').find("option:selected").val()},
            'success': function (data) {
                data = eval("(" + data + ")")
                console.log(data)
                $('[name="store_city_option'+i+'"]').remove();
                $('[name="stcity'+i+'"]').append('<option name="store_city_option' + i +'" class="store_city_option"  value="">请选择</option>');
                if (data['errCode']==0) {
                    for(let key in data['data']){
                        var id = key;
                        var city_name = data['data'][key];

                        if(key==store_json_arr[i][8]){
                            $('[name="stcity'+i+'"]').append('<option name="store_city_option'+ i+ '"  class="store_city_option" selected  value="'+ id +'"  >' + city_name + '</option>')
                        }else{
                            $('[name="stcity'+i+'"]').append('<option name="store_city_option'+ i+ '"  class="store_city_option"  value="'+ id +'"  >' + city_name + '</option>');
                        }
                    }
                }
                $.ajax({
                    'type': 'get',
                    'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                    'data': {'pid': $('[name="stcity'+i+'"]').find("option:selected").val()},
                    'success': function (data) {
                        data = eval("(" + data + ")")
                        $('[name="store_area_option'+i+'"]').remove()
                        $('[name="stblock'+i+'"]').append('<option name="store_area_option'+ i +'" value="" class="store_area_option">请选择</option>');
                        if (data['errCode']==0) {
                            for(let key in data['data']){
                                var id = key;
                                var city_name = data['data'][key];
                                if(key==store_json_arr[i][9]){
                                    $('[name="stblock'+i+'"]').append('<option name="store_area_option' + i + '" class="store_area_option" selected value="' + id + '">'+ city_name + '</option>')
                                }else{
                                    $('[name="stblock'+i+'"]').append('<option name="store_area_option' + i + '" class="store_area_option"  value="' + id + '">'+ city_name + '</option>');
                                }

                            }
                        }
                        i=i+1;
                        get_store_data(i)
                    }
                })

            }
        })
    }
    get_store_data(Number(start_num));



    //编辑
    for(var i=Number(start_num);i<=Number(store_data_num)+Number(start_num)-1;i++){
        $('[name="stprovince'+i+'"]').change(function () {
            var str = $(this).prop('name')
            var x = str.substr(str.length-1,str.length)
            $('[name="store_area_option'+x+'"]').remove()
            $('[name="stblock'+x+'"]').append('<option name="store_area_option'+ x +'" value="" class="store_area_option">请选择</option>');
            console.log(x)
            $.ajax({
                'type': 'get',
                'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                'data': {'pid': $('[name="'+str+'"]').find("option:selected").val()},
                'success': function (data) {
                    data = eval("(" + data + ")")
                    console.log(data)
                    $('[name="store_city_option'+x+'"]').remove()
                    $('[name="stcity'+x+'"]').append('<option name="store_city_option' + x +'" class="store_city_option"  value="">请选择</option>');
                    if (data['errCode']==0) {
                        for(let key in data['data']){
                            var id = key;
                            var city_name = data['data'][key];
                            $('[name="stcity'+x+'"]').append('<option name="store_city_option'+ x+ '"  class="store_city_option"  value="'+ id +'"  >' + city_name + '</option>');
                        }
                    }
                }
            })
        })
        $('[name="stcity'+i+'"]').change(function () {
            var strc = $(this).prop('name')
            var y = strc.substr(strc.length-1,strc.length)
            $.ajax({
                'type': 'get',
                'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                'data': {'pid': $('[name="stcity'+y+'"]').find("option:selected").val()},
                'success': function (data) {
                    data = eval("(" + data + ")")
                    $('[name="store_area_option'+y+'"]').remove()
                    $('[name="stblock'+y+'"]').append('<option name="store_area_option'+ y +'" value="" class="store_area_option">请选择</option>');
                    if (data['errCode']==0) {
                        for(let key in data['data']){
                            var id = key;
                            var city_name = data['data'][key];
                            $('[name="stblock'+y+'"]').append('<option name="store_area_option' + y + '" class="store_area_option"  value="' + id + '">'+ city_name + '</option>');
                        }
                    }
                }
            })

        })
    }
</script>



