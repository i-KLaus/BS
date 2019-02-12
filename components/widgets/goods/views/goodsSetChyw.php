<div class="form-head"><span>规格-价格</span></div>
<div class="form-group left-move">
    <label class="control-label">商品价格</label>
    <div class="control-input">
        <div class="table_css table_css_auto">
            <div class="table_row">
                <div class="table_cell">时间段</div>
                <div class="table_cell">存贷扣点(%)</div>
                <div class="table_cell">存贷上限(元)</div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一周内完成']; ?>">
                <div class="table_cell">一周内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="6" name="bill_rate" value="<?php echo !empty($goods[','.$data['一周内完成'].',']['bill_rate']) ? $goods[','.$data['一周内完成'].',']['bill_rate'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一周内完成'].',']['price']) ? $goods[','.$data['一周内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一月内完成']; ?>">
                <div class="table_cell">一月内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="6" name="bill_rate" value="<?php echo !empty($goods[','.$data['一月内完成'].',']['bill_rate']) ? $goods[','.$data['一月内完成'].',']['bill_rate'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一月内完成'].',']['price']) ? $goods[','.$data['一月内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一个季度内完成']; ?>">
                <div class="table_cell">一个季度内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="6" name="bill_rate" value="<?php echo !empty($goods[','.$data['一个季度内完成'].',']['bill_rate']) ? $goods[','.$data['一个季度内完成'].',']['bill_rate'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一个季度内完成'].',']['price']) ? $goods[','.$data['一个季度内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['半年内完成']; ?>">
                <div class="table_cell">半年内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="6" name="bill_rate" value="<?php echo !empty($goods[','.$data['半年内完成'].',']['bill_rate']) ? $goods[','.$data['半年内完成'].',']['bill_rate'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['半年内完成'].',']['price']) ? $goods[','.$data['半年内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
                </div>
            </div>
            <div class="table_row goodsData">
                <input type="hidden" name="id" value="<?php echo $data['一个年内完成']; ?>">
                <div class="table_cell">一个年内完成</div>
                <div class="table_cell">
                    <input type="text" maxlength="6" name="bill_rate" value="<?php echo !empty($goods[','.$data['一个年内完成'].',']['bill_rate']) ? $goods[','.$data['一个年内完成'].',']['bill_rate'] : ''; ?>" class="form-control text-center bg_input">
                </div>
                <div class="table_cell">
                    <input type="text" maxlength="7" name="price" value="<?php echo !empty($goods[','.$data['一个年内完成'].',']['price']) ? $goods[','.$data['一个年内完成'].',']['price'] : ''; ?>" class="form-control text-center bg_input">
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
            var bill_rate = $(this).find('input[name="bill_rate"]').val();
            if (price == '') {
                priceNum++;
                if(priceNum == document.getElementsByName('price').length){
                    layer.msg('至少填写一个存货上限');
                    flag = 'error';
                    return false;
                }
                return true;
            }
            if (numberReg.exec(price) == null) {
                layer.msg('必须为整数');
                flag = 'error';
                return false;
            }

            if (bill_rate == '') {
                layer.msg('请填写存货扣点');
                flag = 'error';
                return false;
            }
            if (reg.exec(bill_rate) == null) {
                layer.msg('存货扣点必须为数字，并且最多两位数');
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
            if(price == ''){
                return true;
            }
            json.category_id = ',' + $(this).find('input[name="id"]').val() + ',';
            json.price =$(this).find('input[name="price"]').val();
            json.bill_rate = $(this).find('input[name="bill_rate"]').val();
            data.push(json);
        });

        $('input[name="goods_data"]').val(JSON.stringify(data));
    }
</script>