<div class="form-head"><span>规格-价格</span></div>
<div class="form-group left-move">
    <label class="control-label">添加规则</label>
    <div class="control-input">
        <div class="sku-group">
            <div class="js-sku-list-container">
                <div class="sku-sub-group js-sku-sub-group">
                    <div class="sku-title">
                        <div class="js-sku-name">
                            <select class="js-example-basic-single form-control w200 goodsCategory" <?php if (!empty($goods)) { ?>disabled="disabled"<?php } ?>>
                                <?php if (!empty($category)) { ?>
                                    <?php foreach ($category as $key => $val) { ?>
                                        <?php if (!empty($goods)) { ?>
                                            <option value="<?php echo $val['id']; ?>" <?php echo $val['id'] == $category_pid ? 'selected' : ''; ?>><?php echo $val['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $val['id']; ?>" <?php echo $key == 0 ? 'selected' : ''; ?>><?php echo $val['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="sku-bd">
                        <div class="sku-bd-list js-sku-bd-list">
                            <?php if (!empty($goods)) { ?>
                                <?php foreach ($goods as $key => $val) { ?>
                                    <div class="sku-item"><span><?php echo $val['category_name']; ?></span><input name="categorys_property[]" value="<?php echo $val['category_id']; ?>" type="hidden"></div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php if (empty($goods)) { ?>
                            <a href="javascript:;" class="add-sku js-add-sku" data-value="0">添加</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group left-move">
    <label class="control-label">商品价格</label>
    <div class="control-input">
        <table class="normal-table small-table">
            <tbody class="goodsSetTbody">
            <tr>
                <td class="categoryName"></td>
                <td>价格(元)</td>
            </tr>
            <?php if (!empty($goods)) { ?>
                <?php foreach ($goods as $key => $val) { ?>
                    <tr class="goodsData" data-id="<?php echo $val['category_id']; ?>">
                        <td><?php echo $val['category_name']; ?></td>
                        <td><input type="text" maxlength="7" name="price" value="<?php echo $val['price']; ?>" class="table-input"></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!--规则选择弹出框-->
<div class="popover">
    <select class="js-example-basic-multiple js-states form-control subGoodsCategory" multiple="multiple">
    </select>
    <a href="javascript:;" class="btn btn-primary btn-popover-sure">确定</a>
    <a href="javascript:;" class="btn btn-default btn-popover-cancel">取消</a>
</div>

<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/addSingleCategory.js'); ?>"></script>
<script>
    $(function () {
        //添加规格 初始化
        var se = new specification({
            skuGroupPlace: '.js-sku-list-container', //放置sku组的位置
            addSkuItem: '.add-sku', //添加sku组里的单个项
            deleteSkuItem: '.js-delete-sku-item', //添加sku组里的单个项,
            shopStock: '.jd-shopStock' //商品库存表格项
        });

        getSubGoodsCategory();
    });

    function checkGoodsData() {
        var flag = 'success';
        var reg = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;

        if ($('.sku-item').length <= 0) {
            layer.msg('请选择规格');
            flag = 'error';
            return flag;
        }

        $('.goodsData').each(function () {
            var price = $(this).find('input[name="price"]').val();
            if (price == '') {
                return false;
            }
            if (reg.exec(price) == null) {
                layer.msg('价格必须为数字，最多为小数点后2位');
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
            json.category_id = ',' + $(this).attr('data-id') + ',';
            json.price = $(this).find('input[name="price"]').val();
            data.push(json);
        });

        $('input[name="goods_data"]').val(JSON.stringify(data));
    }

    function getSubGoodsCategory() {
        $.ajax({
            'url': 'get-sub-goods-category.html',
            'type': 'get',
            'async': false,
            'data': {'id': $('.goodsCategory').find('option:selected').val()},
            'dataType': 'json',
            'success': function success(result) {
                var html = '';
                for (var i = 0; i < result.length; i++) {
                    var obj = result[i];
                    html += '<option value="'+obj.id+'">'+obj.name+'</option>';
                }
                $('.subGoodsCategory').html(html);
                $('.categoryName').text($('.goodsCategory').find('option:selected').text());
            }
        });
    }
</script>

