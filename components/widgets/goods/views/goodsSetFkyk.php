<div class="form-head"><span>规格-价格</span></div>
<div class="form-group left-move">
    <label class="control-label">商品价格</label>
    <div class="control-input">
        <div class="table_css table_css_auto">
            <div class="table_row">
                <div class="table_cell">时间段</div>
                <div class="table_cell">价格(元/张)</div>
                <div class="table_cell">获客上限(张)</div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一周内完成']; ?>">
                <div class="table_cell">一周内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一周内完成'].',']['price']) ? $goods[','.$data['一周内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="limit_num" value="<?php echo !empty($goods[','.$data['一周内完成'].',']['limit_num']) ? $goods[','.$data['一周内完成'].',']['limit_num'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一月内完成']; ?>">
                <div class="table_cell">一月内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一月内完成'].',']['price']) ? $goods[','.$data['一月内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="limit_num" value="<?php echo !empty($goods[','.$data['一月内完成'].',']['limit_num']) ? $goods[','.$data['一月内完成'].',']['limit_num'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一个季度内完成']; ?>">
                <div class="table_cell">一个季度内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一个季度内完成'].',']['price']) ? $goods[','.$data['一个季度内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="limit_num" value="<?php echo !empty($goods[','.$data['一个季度内完成'].',']['limit_num']) ? $goods[','.$data['一个季度内完成'].',']['limit_num'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['半年内完成']; ?>">
                <div class="table_cell">半年内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['半年内完成'].',']['price']) ? $goods[','.$data['半年内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="limit_num" value="<?php echo !empty($goods[','.$data['半年内完成'].',']['limit_num']) ? $goods[','.$data['半年内完成'].',']['limit_num'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一个年内完成']; ?>">
                <div class="table_cell">一个年内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一个年内完成'].',']['price']) ? $goods[','.$data['一个年内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="limit_num" value="<?php echo !empty($goods[','.$data['一个年内完成'].',']['limit_num']) ? $goods[','.$data['一个年内完成'].',']['limit_num'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function checkGoodsData() {
        var flag = 'success';
        var reg = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;
        var numberReg = /^\d+$/;
        var priceNum = 0;
        $('.goodsData').each(function () {
            var price = $(this).find('input[name="price"]').val();
            var limit_num = $(this).find('input[name="limit_num"]').val();
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

            if (limit_num == '') {
                layer.msg('请填写开发上限');
                flag = 'error';
                return false;
            }
            if (numberReg.exec(limit_num) == null) {
                layer.msg('开发上限必须为整数');
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
            if(price ==''){
                return true;
            }
            json.category_id = ',' + $(this).find('input[name="id"]').val() + ',';
            json.price =$(this).find('input[name="price"]').val();
            json.limit_num = $(this).find('input[name="limit_num"]').val();
            data.push(json);
        });

        $('input[name="goods_data"]').val(JSON.stringify(data));
    }
</script>