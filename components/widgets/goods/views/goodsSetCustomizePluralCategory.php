<div class="form-head"><span>规格-价格</span></div>
<div class="form-group left-move">
    <label class="control-label">添加规则</label>
    <div class="control-input">
        <div class="sku-group">
            <div class="js-sku-list-container">
                <div class="sku-sub-group js-sku-sub-group">
                    <div class="sku-title">
                        <div class="js-sku-name">
                            <select class="js-example-basic-single form-control w200 goodsCategory1" data-index="1" <?php if (!empty($data)) { ?>disabled="disabled"<?php } ?>>
                                <?php if (!empty($category)) { ?>
                                    <?php foreach ($category as $key => $val) { ?>
                                        <?php if (!empty($data['p_category_id'])) { ?>
                                            <option value="<?php echo $val['id']; ?>" <?php echo $val['id'] == $data['p_category_id'] ? 'selected' : ''; ?>><?php echo $val['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $val['id']; ?>" <?php echo $key == 0 ? 'selected' : ''; ?>><?php echo $val['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="sku-bd">
                        <div class="sku-bd-list js-sku-bd-list1">
                            <?php if (!empty($data['p_category'])) { ?>
                                <?php foreach ($data['p_category'] as $key => $val) { ?>
                                    <div class="sku-item"><span><?php echo $val; ?></span><input name="categorys_property[]" value="<?php echo $key; ?>" type="hidden"></div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php if (empty($data['p_category'])) { ?>
                            <a href="javascript:;" class="add-sku js-add-sku1" data-value="0">添加</a>
                        <?php } ?>
                    </div>
                </div>

                <!--规格-->
                <div class="sku-sub-group js-sku-sub-group" <?php if (empty($data['category'])) { ?>style="display: none"<?php } ?>>
                    <div class="sku-title">
                        <div class="js-sku-name">
                            <select class="js-example-basic-single form-control w200 goodsCategory2" data-index="2" <?php if (!empty($data)) { ?>disabled="disabled"<?php } ?>>
                                <?php if (!empty($category)) { ?>
                                    <?php foreach ($category as $key => $val) { ?>
                                        <?php if (!empty($data['category_id'])) { ?>
                                            <option value="<?php echo $val['id']; ?>" <?php echo $val['id'] == $data['category_id'] ? 'selected' : ''; ?>><?php echo $val['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $val['id']; ?>" <?php echo $key == 0 ? 'selected' : ''; ?>><?php echo $val['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="sku-bd">
                        <div class="sku-bd-list js-sku-bd-list2">
                            <?php if (!empty($data['category'])) { ?>
                                <?php foreach ($data['category'] as $key => $val) { ?>
                                    <div class="sku-item"><span><?php echo $val; ?></span><input name="categorys_property[]" value="<?php echo $key; ?>" type="hidden"></div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php if (empty($data)) { ?>
                            <a href="javascript:;" class="add-sku js-add-sku2" data-value="1">添加</a>
                        <?php } ?>
                    </div>
                </div>
                <?php if (empty($data)) { ?>
                    <div class="add-sku-group js-add-sku-group" style="display: none">
                        <a href="javascript:;" class="btn btn-default">添加规格</a>
                    </div>
                <?php } ?>
            </div>

        </div>

    </div>
</div>
<div class="form-group left-move">
    <label class="control-label">商品价格</label>
    <div class="control-input">
        <table class="normal-table small-table">
            <thead class="goodsSetThead">
            <tr>
                <?php if (empty($data['category'])) { ?>
                    <td class="categoryName"></td>
                    <td>价格(元)</td>
                <?php } else { ?>
                    <td class="categoryName"></td>
                    <td class="subCategoryName"></td>
                    <td>价格(元)</td>
                <?php } ?>
            </tr>
            </thead>
            <tbody class="goodsSetTbody">
            <?php echo $last_p_id = ''; ?>
            <?php if (!empty($data['goods'])) { ?>
                <?php foreach ($data['goods'] as $key => $val) { ?>
                    <?php if (empty($data['category'])) { ?>
                        <tr class="goodsData">
                            <td><input type="hidden" name="id" value="<?php echo $val['p_category_id']; ?>"><?php echo $val['p_category_name']; ?></td>
                            <td><input type="text" maxlength="7" name="price" value="<?php echo $val['price']; ?>" class="table-input"></td>
                        </tr>
                    <?php } else { ?>
                        <tr class="goodsData">
                            <?php if ($last_p_id != $val['p_category_id']) { ?>
                                <td rowspan="<?php echo count($data['category']); ?>">
                                    <?php echo $val['p_category_name']; ?>
                                </td>
                            <?php } ?>
                            <td><input type="hidden" name="id" value="<?php echo $val['p_category_id'] . ',' . $val['category_id']; ?>"><?php echo $val['category_name']; ?></td>
                            <td><input type="text" maxlength="7" name="price" value="<?php echo $val['price']; ?>" class="table-input"></td>
                        </tr>
                        <?php $last_p_id = $val['p_category_id']; ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!--规则选择弹出框-->
<div class="popover js-popover1">
    <select class="js-example-basic-multiple1 form-control subGoodsCategory" multiple="multiple" data-index="1">
    </select>
    <a href="javascript:;" class="btn btn-primary btn-popover-sure1">确定</a>
    <a href="javascript:;" class="btn btn-default btn-popover-cancel">取消</a>
</div>
<!--规格选择弹出框-->
<div class="popover js-popover2">
    <select class="js-example-basic-multiple2 form-control subGoodsCategory" multiple="multiple" data-index="2">
    </select>
    <a href="javascript:;" class="btn btn-primary btn-popover-sure2">确定</a>
    <a href="javascript:;" class="btn btn-default btn-popover-cancel">取消</a>
</div>

<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/addPluralCategory.js'); ?>"></script>
<script>
    $(function () {
        //添加规格 初始化
        var se = new specification({
            skuGroupPlace: '.js-sku-list-container', //放置sku组的位置
            addSkuGroup: '.js-add-sku-group',   //添加sku组 对象
            deleteSkuGroup: '.js-delete-sku-group', //删除sku组 对象
            addSkuItem: '.add-sku',  //添加sku组里的单个项
            deleteSkuItem: '.js-delete-sku-item',  //添加sku组里的单个项,
            shopStock: '.jd-shopStock' //商品库存表格项
        });

        getSubGoodsCategory(1);

        <?php if (!empty($data['category'])) { ?>
        $('.subCategoryName').text($('.goodsCategory2').find('option:selected').text());
        <?php } ?>
    });

    function checkGoodsData() {
        var flag = 'success';
        var reg = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;

        if ($('.js-sku-bd-list1 .sku-item').length <= 0) {
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
            json.category_id = ',' + $(this).find('input[name="id"]').val() + ',';
            json.price = $(this).find('input[name="price"]').val();
            data.push(json);
        });

        $('input[name="goods_data"]').val(JSON.stringify(data));
    }

    function getSubGoodsCategory(index) {
        var id = $('.goodsCategory' + index).find('option:selected').val();
        $.ajax({
            'url': 'get-sub-goods-category.html',
            'type': 'get',
            'async': false,
            'data': {'id': id},
            'dataType': 'json',
            'success': function success(result) {
                var html = '';
                for (var i = 0; i < result.length; i++) {
                    var obj = result[i];
                    html += '<option value="'+obj.id+'">'+obj.name+'</option>';
                }
                $('.js-popover' + index).find('select').html(html);
                $('.categoryName').text($('.goodsCategory1').find('option:selected').text());
            }
        });
    }
</script>

