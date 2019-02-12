<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
?>
<?php echo IndexTitleWidget::widget(); ?>
<form action="<?php echo Url::to(['add']); ?>" method="post" id="form">
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
                <li class="col-xs-6 btn active"><a href="javascript:;">基本信息</a></li>
                <li class="col-xs-6 btn"><a href="javascript:;">服务详情</a></li>
            </ul>
        </div>
        <div class="form-horizontal form-add">
            <div class="form-head"><span>基础信息</span></div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 服务分类</label>
                <div class="control-input">

                    <select class="form-control inline-block wper20 valid" name="category_p_id" aria-invalid="false">

                                <option value="<?php echo $goods['preCategory']['id'] ?>"><?php echo $goods['preCategory']['name'] ?></option>

                    </select>
                    <select class="form-control inline-block wper20 valid" name="category_id" aria-required="true"
                            aria-invalid="false">
                        <option value="<?php echo $goods['category']['id'] ?>"><?php echo $goods['category']['name'] ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商品名称</label>
                <div class="control-input">
                    <input type="text" value="<?php echo $goods['name'] ?>" name="name" class="form-control wper40 inline-block valid"
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
                        <input type="hidden" name="goods_img" value="">
                    </div>
                </div>
            </div>
        </div>
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
                            <td><input type="text" maxlength="7" name="price" value="<?php echo \app\common\util\dataHelp::convertYuan($v[3]);?>" class="table-input"></td>
                        </tr>
                            <?php }?>
                            <?php if(count($v)==3) {?>
                                <tr class="goodsData">
                                    <td><?php echo $v[1]['attr']?></td>
                                    <td><input type="text" maxlength="7" name="price" value="<?php echo \app\common\util\dataHelp::convertYuan($v[2]);?>" class="table-input"></td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <input type="hidden" name="goods_data" value="">

        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150" id="button" onclick="second()">下一步</button>
        </div>
    </div>

    <div class="m-content" style="display: none;" id="second">
        <div class="qgj-title">
            <div class="qgj-title_main">服务商品</div>
        </div>

        <div class="qgj-step">
            <ul class="btn-group">
                <li class="col-xs-6 btn"><a href="javascript:;">基本信息</a></li>
                <li class="col-xs-6 btn active"><a href="javascript:;">服务详情</a></li>
            </ul>
        </div>

        <div class="qgj-rich-text">
            <!--富文本-->
            <textarea name="content" id="container"></textarea>
        </div>

        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150 mr5" onclick="first()">上一步</button>
        </div>

    </div>
</form>



<script>
    $(function () {
        //文本编辑器初始化
        var ue = UE.getEditor('container',{
            initialFrameWidth: 1451,
            toolbars: [
                ['bold', 'source', 'fontsize','paragraph','rowspacingtop','rowspacingbottom','lineheight', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc','edittable','edittd', 'link', 'insertimage']
            ]
        });

        ue.ready(function() {//编辑器初始化完成再赋值
            ue.setContent($(".js-regions").html());  //赋值给UEditor
        });
        //当编辑器里的内容改变时执行方法
        ue.addListener("contentChange",function(){
            var $regions = $(".js-regions");
            $regions.html(ue.getContent());
        });
    });

    $('select[name="category_p_id"]').change(function () {
        getSubCategory();
    });


    function first() {
        $('#first').show();
        $('#second').hide();
        $('.btn-group li').eq(0).addClass('active');
        $('.btn-group li').eq(1).removeClass('active');
    }
    function second() {
        $('#first').hide();
        $('#second').show();
        $('.btn-group li').eq(0).removeClass('active');
        $('.btn-group li').eq(1).addClass('active');
    }
</script>
