<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11
 * Time: 19:53
 *
 */
use yii\helpers\Url;
?>


<div class="table_row store_list">
    <div class="table_cell stlist">
        <input type="text" class="form-control stname w100 inline-block" name="stname">
    </div>
    <div class="table_cell stlist">
        <input type="text" class="form-control stbusiness w100 inline-block" name="stbusiness">
    </div>
    <div class="table_cell stlist">
        <select class="form-control w100 inline-block pr" name="stprovince<?php echo $num; ?>">
            <option value="" name="stprovince">请选择</option>
            <?php if(!empty($province)){ ?>
                <?php foreach ($province as $k=>$v) {?>
                    <option name="stprovince" class="store_province_option" value="<?php echo $k ?>"><?php echo $v?></option>
                <?php }?>
            <?php }?>
        </select>
    </div>
    <div class="table_cell stlist">
        <select class="form-control w100 inline-block ci" name="stcity<?php echo $num; ?>">
            <option value="" name="store_city_option<?php echo $num; ?>" class="store_city_option">请选择</option>
        </select>
    </div>
    <div class="table_cell stlist">
        <select class="form-control w100 inline-block ar" name="stblock<?php echo $num; ?>"">
            <option value="" name="store_area_option<?php echo $num; ?>" class="store_area_option">请选择</option>
        </select>
    </div>
    <div class="table_cell stlist">
        <input type="text"  class="form-control staddress w100 inline-block" name="staddress">
    </div>
    <div class="table_cell stlist">
        <a href="javascript:;" class="text-primary store-delete">删除</a>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    var num = "<?php echo $num ?>"
    //省市区下拉框


    function getdata(i) {
        $('[name="stprovince'+i+'"]').change(function () {
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
                            $('[name="stcity'+i+'"]').append('<option name="store_city_option'+ i+ '"  class="store_city_option"  value="'+ id +'"  >' + city_name + '</option>');
                        }
                    }
                }
            })
        })
        $('[name="stcity'+i+'"]').change(function () {
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
                            $('[name="stblock'+i+'"]').append('<option name="store_area_option' + i + '" class="store_area_option"  value="' + id + '">'+ city_name + '</option>');
                        }
                    }
                }
            })

        })


    }
    getdata(num);

</script>

