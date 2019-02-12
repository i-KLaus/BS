<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
?>
<?php echo IndexTitleWidget::widget(); ?>
<form action="<?php echo Url::to(['add']); ?>" method="get" id="form">
    <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
    <div class="m-content" id="first">
        <div class="qgj-title">
            <div class="qgj-title_main">
                <a href="<?php echo Url::to(['list']); ?>"><span class="back"><i class="layui-icon">&#xe603;</i>返回</span></a>
                服务商品
            </div>
        </div>
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
                            <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
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
                    <input type="text" value="" name="name" id="name" class="form-control wper40 inline-block valid"
                           placeholder="" aria-required="true" aria-invalid="false">
                    <label id="name-error" class="text-danger" for="name" style="display: none;"></label></div>
            </div>

            <div class="form-group ">
                <label class="control-label"><em class="text-danger">*</em> 商品图</label>
                <div class="control-input">
                    <div class="pic-list ui-sortable">
                        <ul class="image-list js-pic-list">
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
        <div class="form-horizontal form-add" id="goodsSetForm">
            <div class="form-head"><span>规格-价格</span></div>
            <div class="form-group">
                <label class="control-label">商品规格</label>
                <div class="control-input">
                    <div class="sku-group">
                        <div class="js-sku-list-container" id="category-list">
                        </div>
                        <div class="js-add-sku-group add-sku-group">
                            <button type="button" class="btn btn-default addCategory">添加规格项目</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group table-class">

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
            <textarea name="content" id="container"></textarea>
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

<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/goodsForm.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/goods.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/goods/add.js'); ?>"></script>
<script>


    category_id = '';

$('.addCategory').click(function () {
    var count_num = 0;
    $('.js-sku-sub-group').each(function (index,item) {
        count_num = count_num+1;
    })
    if(count_num>=1){
        $('.add-sku-group').hide()
    }
})


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


    $('.goodsData').find('.table-input').each(function (ind,v) {
        console.log($(v).val())
    })

</script>