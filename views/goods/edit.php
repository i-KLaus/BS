<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
?>
<?php echo IndexTitleWidget::widget(); ?>
<form action="<?php echo Url::to(['edit']); ?>" method="get" id="form">
    <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
    <input type="hidden" name="goods_id" value="<?php echo $_GET['id'] ?>">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <div class="m-content" id="first">
        <div class="qgj-title">
            <div class="qgj-title_main">
                <a href="<?php echo Url::to(['list']); ?>"><span class="back"><i class="layui-icon">&#xe603;</i>返回</span></a>
                服务商品
            </div>
        </div>
        <?php if($goods['status']==BE_REJECT){ ?>
            <div class="qgj-reject">
                <span><?php echo $goods['create_time']; ?></span>
                <span>运营方驳回</span>
                <div><span>驳回原因:</span><span><?php echo $goods['reject_reason']; ?></span></div>
            </div>
        <?php }?>
        <div class="qgj-step">
            <ul class="btn-group">
                <li class="col-xs-6 btn active"><a href="javascript:;">编辑基本信息</a></li>
                <li class="col-xs-6 btn"><a href="javascript:;">编辑服务详情</a></li>
            </ul>
        </div>
        <div class="form-horizontal form-add">
            <div class="form-head"><span>基础信息</span></div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 服务分类</label>
                <div class="control-input">

                    <select class="form-control inline-block wper20 valid" name="category_p_id" aria-invalid="false">
                        <?php if(!empty($category)){ ?>
                            <?php foreach ($category as $v){ ?>
                                <option value="<?php echo $v['id'] ?>"<?php if($v['id']==$goods['pre_category_id']){echo "selected";} ?>><?php echo $v['name'] ?></option>
                            <?php } ?>
                        <?php }?>
                    </select>
                    <select class="form-control inline-block wper20 valid" name="category_id" aria-required="true"
                            aria-invalid="false">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商品名称</label>
                <div class="control-input">
                    <input type="text" value="<?php echo $goods['name'] ?>" name="name" id="name" class="form-control wper40 inline-block valid"
                           placeholder="" aria-required="true" aria-invalid="false">
                    <label id="name-error" class="text-danger" for="name" style="display: none;"></label></div>
            </div>

            <div class="form-group ">
                <label class="control-label"><em class="text-danger">*</em> 商品图</label>
                <div class="control-input">
                    <div class="pic-list ui-sortable">
                        <ul class="image-list js-pic-list">
                            <?php $img_arr = json_decode($goods['goods_img'], true); ?>

                            <?php foreach ($img_arr as $key => $val) { ?>
                                <li class="sort">
                                    <img src="<?php echo UPLOAD_IMG_SERVER_GOODS_SOURCE . $val; ?>" alt="" data-name="<?php echo $val; ?>">
                                    <a href="javascript:;" class="js-delete-pic close close-bg">×</a>
                                </li>
                            <?php } ?>
                            <li class="image-list--add">
                                <a href="javascript:;" class="add-pic js-add-pic" id="upload"><span>加图</span></a>
                                <div class="text">选择图片</div>
                            </li>
                        </ul>
                        <input type="hidden" name="goods_img" id="goods_img" value="">
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="form-horizontal form-add" id="goodsSetForm">-->
<!--            <div class="form-head"><span>规格-价格</span></div>-->
<!--            <div class="form-group">-->
<!--                <label class="control-label">商品规格</label>-->
<!--                <div class="control-input">-->
<!--                    <div class="sku-group">-->
<!--                        <div class="js-sku-list-container" id="category-list">-->
<!--                        </div>-->
<!--                        <div class="js-add-sku-group add-sku-group">-->
<!--                            <button type="button" class="btn btn-default addCategory">添加规格项目</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-group table-class">-->
<!---->
<!--            </div>-->
<!--        </div>-->
        <div class="form-horizontal form-add" id="goodsSetForm">
            <div class="form-head"><span>规格-价格</span></div>
            <div class="form-group">
                <label class="control-label">商品价格</label>
                <div class="control-input">
                    <table class="normal-table">
                        <tbody>

                        <tr>
                            <td>套餐</td>
                            <td>价格(元)</td>
                        </tr>
                        <?php foreach ($attr as $v) {?>
                            <?php if(count($v)==4) {?>
                                <tr class="goodsData">
                                    <td><?php echo $v[1]['attr'].' - '.$v[2]['attr'] ?></td>
                                    <td><input type="text" maxlength="7" name="price" value="<?php echo \app\common\util\dataHelp::convertYuan($v[3]);?>" class="table-input w100 epric"></td>
                                    <input type="hidden" name="goods_sku_id" value="<?php echo $v[0] ?>">
                                </tr>
                            <?php }?>
                            <?php if(count($v)==3) {?>
                                <tr class="goodsData">
                                    <td><?php echo $v[1]['attr']?></td>
                                    <td><input type="text" maxlength="7" name="price" value="<?php echo \app\common\util\dataHelp::convertYuan($v[2]);?>" class="table-input w100 epric"></td>
                                    <input type="hidden" name="goods_sku_id" value="<?php echo $v[0] ?>">
                                </tr>
                            <?php }?>
                        <?php } ?>
                        </tbody>
                        <input type="hidden" value="" name="goods_sku" id="goods_sku">
                    </table>
                </div>
            </div>
        </div>


        <input type="hidden" name="goods_data" id="goods_data" value="">

        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150" id="button" onclick="second()">下一步</button>
        </div>
    </div>

    <div class="m-content" style="display: none;" id="second">
        <div class="qgj-title">
            <div class="qgj-title_main">商户营销-编辑</div>
        </div>

        <div class="qgj-step">
            <ul class="btn-group">
                <li class="col-xs-6 btn"><a href="javascript:;">编辑基本信息</a></li>
                <li class="col-xs-6 btn active"><a href="javascript:;">编辑服务详情</a></li>
            </ul>
        </div>

        <div class="qgj-rich-text">
            <!--富文本-->
            <textarea name="content" id="container"><?php echo $goods['content'] ?></textarea>
        </div>

        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150 mr5" onclick="first()">上一步</button>
            <button type="submit" class="btn btn-primary w150 ml5">保存</button>
        </div>

    </div>
</form>
<!--规则选择弹出框-->
<div class="popover">
    <select class="js-example-basic-multiple form-control" name="propertyData" multiple="multiple">
    </select>
    <a href="javascript:;" class="btn btn-primary btn-popover-sure">确定</a>
    <a href="javascript:;" class="btn btn-default btn-popover-cancel">取消</a>
</div>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/goods.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/goodsForm.js'); ?>"></script>


<script>
    var category_id = '<?php echo isset($goods['category_id'])?$goods['category_id']:'' ?>'

    buildImg()



    $(function () {
        getSubCategory();
    });



    upload_img(
        'upload',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_IMG_TYPE; ?>',
        '<?php echo UPLOAD_IMG_SERVER_GOODS_FOLDER; ?>',
        '',
        function (filename) {
            var img = '<?php echo UPLOAD_IMG_SERVER_GOODS_SOURCE; ?>' + filename;
            var html = '';
            html += '<li class="sort">';
            html +=     '<img src="'+img+'" alt="" data-name="'+filename+'">';
            html +=     '<a href="javascript:;" class="js-delete-pic close close-bg">×</a>';
            html += '</li>';
            $('.js-pic-list').prepend(html);

            buildImg();
        }
    );

</script>