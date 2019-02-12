<div class="form-head"><span>规格-价格</span></div>
<div class="form-group left-move">
    <label class="control-label">商品价格</label>
    <div class="control-input">
        <table class="normal-table">
            <tbody>
            <tr>
                <td>时间段</td>
                <td>区域</td>
                <td>价格(人/天)</td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['工作日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['市区']; ?>">
                <td rowspan="4">工作日</td>
                <td>市区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['工作日'].','.$data['市区'].',']['price']) ? $goods[','.$data['工作日'].','.$data['市区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['工作日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['鄞州']; ?>">
                <td>鄞州</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['工作日'].','.$data['鄞州'].',']['price']) ? $goods[','.$data['工作日'].','.$data['鄞州'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['工作日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['北仑镇海高新区']; ?>">
                <td>北仑镇海高新区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['工作日'].','.$data['北仑镇海高新区'].',']['price']) ? $goods[','.$data['工作日'].','.$data['北仑镇海高新区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['工作日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['其他地区']; ?>">
                <td>其他地区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['工作日'].','.$data['其他地区'].',']['price']) ? $goods[','.$data['工作日'].','.$data['其他地区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['周末']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['市区']; ?>">
                <td rowspan="4">周末</td>
                <td>市区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['周末'].','.$data['市区'].',']['price']) ? $goods[','.$data['周末'].','.$data['市区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['周末']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['鄞州']; ?>">
                <td>鄞州</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['周末'].','.$data['鄞州'].',']['price']) ? $goods[','.$data['周末'].','.$data['鄞州'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['周末']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['北仑镇海高新区']; ?>">
                <td>北仑镇海高新区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['周末'].','.$data['北仑镇海高新区'].',']['price']) ? $goods[','.$data['周末'].','.$data['北仑镇海高新区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['周末']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['其他地区']; ?>">
                <td>其他地区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['周末'].','.$data['其他地区'].',']['price']) ? $goods[','.$data['周末'].','.$data['其他地区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['特殊节假日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['市区']; ?>">
                <td rowspan="4">特殊节假日</td>
                <td>市区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['特殊节假日'].','.$data['市区'].',']['price']) ? $goods[','.$data['特殊节假日'].','.$data['市区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['特殊节假日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['鄞州']; ?>">
                <td>鄞州</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['特殊节假日'].','.$data['鄞州'].',']['price']) ? $goods[','.$data['特殊节假日'].','.$data['鄞州'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['特殊节假日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['北仑镇海高新区']; ?>">
                <td>北仑镇海高新区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['特殊节假日'].','.$data['北仑镇海高新区'].',']['price']) ? $goods[','.$data['特殊节假日'].','.$data['北仑镇海高新区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            <tr class="goodsData">
                <input type="hidden" name="pid" value="<?php echo $data['特殊节假日']; ?>">
                <input type="hidden" name="id" value="<?php echo $data['其他地区']; ?>">
                <td>其他地区</td>
                <td><input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['特殊节假日'].','.$data['其他地区'].',']['price']) ? $goods[','.$data['特殊节假日'].','.$data['其他地区'].',']['price'] : ''; ?>" class="table-input"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    function checkGoodsData() {
        var flag = 'success';
        var reg = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;
        var priceNum = 0;
        $('.goodsData').each(function () {
            var price = $(this).find('input[name="price"]').val();
            if (price == '') {
                priceNum++;
                if(priceNum == document.getElementsByName('price').length){
                    layer.msg('至少填写一个价格');
                    flag = 'error';
                    return false;
                }
                return true;
            }
            if (reg.exec(price) == null) {
                layer.msg('价格必须为数字，最多为小数点后2位');
                flag = 'error';
                return false;
            }
            if (parseFloat(price) > 1000000) {
                layer.msg('价格不能超过1000000');
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
            var price = $(this).find('input[name="price"]').val();
            if(price == 0){
                return true;
            }
            json.category_id = ',' + $(this).find('input[name="pid"]').val() + ',' + $(this).find('input[name="id"]').val() + ',';
            json.price =$(this).find('input[name="price"]').val();
            data.push(json);
        });

        $('input[name="goods_data"]').val(JSON.stringify(data));
    }
</script>