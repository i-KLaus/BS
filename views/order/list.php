<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
use app\common\util\page;
use app\common\util\dataHelp;
?>
<?php echo IndexTitleWidget::widget(); ?>
<div class="m-content">
    <div class="qgj-title">
        <div class="qgj-title_main">全部订单</div>
    </div>
    <form action="<?php echo Url::to(['list']); ?>" method="get" id="searchForm">
    <div class="form-horizontal qgj-form-search">
        <div class="row">
            <div class="form-group form-group-long col-md-3">
                <label class="control-label">服务分类</label>
                <div class="control-input">
                    <select class="form-control" name="category_p_id">
                        <option value="" <?php echo empty($category_p_id) ? 'selected' : ''; ?>>全部分类</option>
                        <?php if (!empty($category)) { ?>
                            <?php foreach ($category as $key => $val) { ?>
                                <option value="<?php echo $val -> id; ?>" <?php echo $val -> id == $category_p_id ? 'selected' : ''; ?>><?php echo $val -> name; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">二级分类</label>
                <div class="control-input">
                    <select class="form-control" name="category_id">
                        <option value="">全部类别</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="control-input">
                    <div class="input-group w150">
                        <input type="text" class="form-control bg-gray-lighter" placeholder="搜索" name="keyword" <?php if(isset($_GET['keyword'])){echo $_GET['keyword'];} ?>>
                        <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="icon-search"></i></button>
                                    </span>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="status" value="<?php echo $status; ?>">
        <div class="qgj-nav mt10">
            <div class="btn-group">
                <a href="javascript:;" class="btn btn-default <?php echo empty($status) ? 'active' : ''; ?>" onclick="statusSearch('')">全部</a>
                <a href="javascript:;" class="btn btn-default <?php echo $status == 1 ? 'active' : ''; ?>" onclick="statusSearch('1')">待确认</a>
                <a href="javascript:;" class="btn btn-default <?php echo $status == 2 ? 'active' : ''; ?>" onclick="statusSearch('2')">进行中</a>
                <a href="javascript:;" class="btn btn-default <?php echo $status == 3 ? 'active' : ''; ?>" onclick="statusSearch('3')">已完成</a>
                <a href="javascript:;" class="btn btn-default <?php echo $status == 4 ? 'active' : ''; ?>" onclick="statusSearch('4')">已结束</a>

            </div>
        </div>
    </div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>服务内容</th>
                <th>服务明细</th>
                <th></th>
                <th>操作</th>
            </tr>
            </thead>
            <?php if(!empty($list)){ ?>
                <?php foreach ($list as $v){ ?>
                <tbody class="tb">
            <tr class="tr-head">
                <td colspan="3">
                    <div class="tr-head_left">
                        <span class="text-gray-light mr30"><?php echo $v['create_time'] ?></span>
                        <span class="mr30">订单号：<?php echo $v['order_no'] ?></span>
                        <a href="javaScript:;" class="btn btn-outlined btn-sm btn-primary">
                            <?php
                            switch ($v['status']){
                                case ORDER_STATUS_OPERATION_AUDIT:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_OPERATION_AUDIT];
                                    break;
                                case ORDER_STATUS_ACTUALIZE:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_ACTUALIZE];
                                    break;
                                case ORDER_STATUS_UNPAID:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_UNPAID];
                                    break;
                                case ORDER_STATUS_PAID_CONFIRM:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_PAID_CONFIRM];
                                    break;
                                case ORDER_STATUS_COMPLETED:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_COMPLETED];
                                    break;
                                case ORDER_STATUS_CANCEL:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_CANCEL];
                                    break;
                                case ORDER_STATUS_DEMANDER_AUDIT:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_DEMANDER_AUDIT];
                                    break;
                                case ORDER_STATUS_MERCHANT_AUDIT:
                                    echo $GLOBALS['__ORDER_STATUS_LIST_SHOW'][ORDER_STATUS_MERCHANT_AUDIT];
                                    break;
                            }
                            ?>
                        </a>
                    </div>
                </td>
                <td>
                    <a href="<?php echo Url::to(['detail','id'=>$v['id']]) ?>" class="text-blue">详情</a>
                </td>
            </tr>
            <?php if(!empty($v['order_sku'])){ ?>
                <?php foreach ($v['order_sku'] as $val){ ?>
            <tr class="border-b">
                <td>
                    <div class="media">
                        <div class="media-left">
                            <?php $img =  json_decode($val['goods_img']); ?>
                            <img src="<?php echo UPLOAD_IMG_SERVER_GOODS_SOURCE .$img[0]; ?>">
                        </div>
                        <div class="media-body">
                            <div class="media-body">
                                <?php if(!empty($val['goods_name'] ) && empty($val['merchant_alias'])) {?>
                                    <div class="mb5"><?php echo $val['goods_name'] ?></div>
                                <?php }?>
                                <?php if(!empty($val['merchant_alias'])){ ?>
                                <h5 class="mb5"><?php echo $val['merchant_alias'] ?></h5>
                                <?php }?>
                                <?php if(!empty($val['merchant_type'])){ ?>
                                    <div class="text-gray-light"><?php if($val['merchant_type']==MERCHANT_TYPE_PP){echo $GLOBALS['MERCHANT_TYPE'][MERCHANT_TYPE_PP];}elseif($val['merchant_type']==MERCHANT_TYPE_SQ){echo $GLOBALS['MERCHANT_TYPE'][MERCHANT_TYPE_SQ];} ?></div>
                                <?php }?>
                                <?php if(!empty($val['store_sq'])){ ?>
                                    <div class="text-gray-light"><?php echo $val['store_sq']?></div>
                                <?php }?>

                                <div class="text-gray-light"><?php echo $val['pre_category_name'].' - '.$val['category_name'] ?></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <?php if(!empty($val['merchant_standard_json'])){?>
                    <div class="text-left">
                        <span class="text-gray-light">标准服务：</span>

                        <span><?php echo !empty($val['implement_money'])?dataHelp::convertYuan($val['implement_money']).'*':'实际执行金额*' ?><?php echo $val['merchant_standard_json'][0]['rate'] ?>%，保底费用<?php echo $val['merchant_standard_json'][0]['minimum_guarantee'] ?>元</span>
                    </div>
                    <?php }?>
                    <?php if(!empty($val['merchant_optional_json'])){ ?>
                        <?php foreach ($val['merchant_optional_json'] as $valu){ ?>
                            <?php if($valu['type']==FWS_TYPE_TEST){ ?>
                                <div class="text-left">
                                    <span class="text-gray-light">测试服务：</span>
                                    <span><?php echo $valu['unit_price'] ?>元/门店，共<?php echo $valu['store_num']?>家门店。测试比例<?php echo $valu['exercise_ratio'] ?>%</span>
                                </div>
                            <?php }?>
                            <?php if($valu['type']==FWS_TYPE_SATISFY){ ?>
                                        <div class="text-left">
                                    <span class="text-gray-light">客户满意度回访：</span>
                                    <span><?php echo $valu['unit_price'] ?>元/门店，共<?php echo $valu['store_num']?>家门店。回访比例<?php echo $valu['exercise_ratio'] ?>%</span>
                                </div>
                            <?php }?>
                        <?php }?>
                    <?php }?>
                    <?php if(!empty($val['platform_standard_json'])) {?>
                    <div class="text-left">
                        <span class="text-gray-light">平台服务费：</span>
                        <span><?php echo ($val['implement_money']!=0)?(sprintf("%01.2f",$val['implement_money']/100)).'*':'实际执行金额*' ?><?php echo $val['platform_standard_json'][0]['rate'].'%+'.(!empty($val['platform_standard_json'][0]['point_tax'])?(($val['implement_money']!=0)?sprintf("%01.2f",$val['implement_money']/100):"实际执行金额").'*'.$val['platform_standard_json'][0]['point_tax']."%":(($val['implement_money']!=0)?sprintf("%01.2f",$val['implement_money']/100):"实际执行金额").'*承担税点') ?></span>
                    </div>
                    <?php }?>
                    <?php if(!empty($val['platform_optional_json'])){ ?>
                    <div class="text-left">
                        <span class="text-gray-light">抽检服务：</span>
                        <span><?php echo $val['platform_optional_json'][0]['unit_price'] ?>元/门店，共<?php echo $val['platform_optional_json'][0]['store_num']?>家门店。回访比例<?php echo $val['platform_optional_json'][0]['exercise_ratio'] ?>%</span>
                    </div>
                    <?php }?>
                    <?php if(!empty($val['goods_attr'])){ ?>
                        <div class="text-left">
                            <span class="mb5"><?php echo $val['goods_attr'] .' x ' .$val['num']?></span>
                        </div>
                    <?php }?>
                </td>


                <td class="text-left">
                    <?php if(!empty($val['merchant_standard_json'])){ ?>
                    <div>
                        <?php if(!empty($val['merchant_standard_json']) && $val['implement_money']==0){ ?>
                        <p>实际执行金额*<?php echo  $val['merchant_standard_json'][0]['rate'] ?>%</p>
                        <?php }?>
                        <?php if(!empty($val['merchant_standard_json']) && $val['implement_money']!=0){ ?>
                            <p class="st_price">￥<?php echo  (($val['merchant_standard_json'][0]['rate']*$val['implement_money']/10000)>$val['merchant_standard_json'][0]['minimum_guarantee'])?sprintf("%01.2f",$val['merchant_standard_json'][0]['rate']*$val['implement_money']/10000):sprintf("%01.2f",$val['merchant_standard_json'][0]['minimum_guarantee'])?></p>
                        <?php }?>

                        <?php if(!empty($val['merchant_optional_json'])){ ?>
                        <?php foreach ($val['merchant_optional_json'] as $valu){ ?>
                            <?php if($valu['type']==FWS_TYPE_TEST){ ?>
                            <p class="test_price">￥<?php echo sprintf("%01.2f",floatval(dataHelp::convertYuan($valu['unit_price']*$valu['store_num']*$valu['exercise_ratio']))) ?></p>
                            <?php }?>
                            <?php if($valu['type']==FWS_TYPE_SATISFY){ ?>
                            <p class="satisfy_price">￥<?php echo sprintf("%01.2f",floatval(dataHelp::convertYuan($valu['unit_price']*$valu['store_num']*$valu['exercise_ratio']))) ?></p>
                            <?php }?>
                        <?php }?>
                        <?php }?>

                        <?php if(!empty($val['platform_standard_json']) && $val['implement_money']==0){ ?>
                            <span><?php echo ($val['implement_money']!=0)?(sprintf("%01.2f",$val['implement_money']/100)).'*':'实际执行金额*' ?><?php echo $val['platform_standard_json'][0]['rate'].'%+'.(!empty($val['platform_standard_json'][0]['point_tax'])?(($val['implement_money']!=0)?sprintf("%01.2f",$val['implement_money']/100):"实际执行金额").'*'.$val['platform_standard_json'][0]['point_tax']."%":(($val['implement_money']!=0)?sprintf("%01.2f",$val['implement_money']/100):"实际执行金额").'*承担税点') ?></span>
                        <?php }?>
                        <?php if(!empty($val['platform_standard_json']) && $val['implement_money']!=0){ ?>
                            <p class="plat_st_price">￥<?php echo !empty($val['platform_standard_json'][0]['point_tax'])?($val['platform_standard_json'][0]['rate']+$val['platform_standard_json'][0]['point_tax'])*$val['implement_money']/10000:'(承担税点+'.$val['platform_standard_json'][0]['rate'].'%)*'.sprintf("%01.2f",$val['implement_money']/100)?></p>
                        <?php }?>

                        <?php if(!empty($val['platform_optional_json'])){ ?>
                        <p class="plat_op_price">￥<?php echo sprintf("%01.2f",floatval(dataHelp::convertYuan($val['platform_optional_json'][0]['unit_price']*$val['platform_optional_json'][0]['store_num']*$val['platform_optional_json'][0]['exercise_ratio']))) ?></p>
                        <?php }?>
                    </div>
                    <?php }?>
                    <?php if(empty($val['merchant_standard_json'])){ ?>
                        <div>
                            <p class="goods_price">￥<?php echo sprintf("%01.2f",$val['price']*$val['num']) ?></p>
                        </div>
                    <?php }?>
                </td>
                <td></td>
            </tr>
                <?php }?>
            <?php }?>

            <tr class="tr-head border-b">
                <td colspan="4" class="text-right">
                    合计：<?php if($v['implement_status']==0) {?>实际活动费用+<?php }?><?php echo sprintf("%01.2f",$v['order_money'])  ?>
                </td>
            </tr>
            <tr class="tr-head">
                <td colspan="4">
                    <div class="tr-head_right">
                        <?php if (!in_array($v['status'], [ORDER_STATUS_COMPLETED, ORDER_STATUS_CANCEL])) { ?>
                            <a href="#modal" data-toggle="modal" class="btn ml10 btn-outlined btn-default" data-id="<?php echo $v['id']; ?>">上传资料</a>
                        <?php } ?>
                        <?php if ($v['status'] == ORDER_STATUS_MERCHANT_AUDIT) { ?>
                            <a href="javascript:;" class="btn ml10 btn-primary"
                               onclick="operateConfirm('确定确认订单？', '<?php echo Url::to(['determine-order', 'order_no' => $v['order_no'], 'goUrl' => Yii::$app -> request -> url]); ?>', '确认订单')">确认订单</a>
                        <?php } ?>

                    </div>
                </td>
            </tr>
            </tbody>
                <?php }?>
            <?php }?>

        </table>

        <?php if (empty($list)) { ?>
            <div class="text-center h5 ptb15 bg-white">暂时无数据</div>
        <?php } ?>

        <?php if ($count > PAGE_PARAMS) {
            $page = new page($count, PAGE_PARAMS, $page, Url::to(['list']) . '?page={page}', 2, $_GET);
            echo $page -> myde_write();
        } ?>
    </div>

</div>

<!--弹出框内容-->
<div class="modal fade" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">上传资料</h4>
            </div>
            <form action="<?php echo Url::to(['upload-data']); ?>" method="post" id="modalForm">
                <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
                <input type="hidden" name="order_id" value="">
                <input type="hidden" name="goUrl" value="<?php echo Yii::$app -> request -> url; ?>">
                <div class="modal-body form-horizontal">
                    <dl class="dl-horizontal">
                        <dt>图片上传</dt>
                        <dd>
                            <ul class="image-upload-list">
                                <li class="image-list--add">
                                    <a href="javascript:;" class="add-pic" id="upload">加图</a>
                                    <div class="text">选择图片</div>
                                </li>
                            </ul>
                            <input type="hidden" name="data" value="">
                        </dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modalBtn" data-dismiss="modal">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/order/list.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/common/page.js'); ?>"></script>
<script>
    var category_id = '<?php echo $category_id; ?>';




    upload_img(
        'upload',
        '<?php echo UPLOAD_TO_PATH; ?>',
        '<?php echo UPLOAD_DATA_TYPE; ?>',
        '<?php echo UPLOAD_ORDER_DATA_FOLDER; ?>',
        '',
        function (filename) {
            var arr = filename.split('.');
            if (arr[1] == 'jpg' || arr[1] == 'png' || arr[1] == 'jpeg') {
                var img = '<?php echo UPLOAD_ORDER_DATA_SOURCE; ?>' + filename;
            } else {
                var img = '<?php echo Yii::getAlias('@web/img/upload-data.png'); ?>';
            }
            var html = '';
            html += '<li class="sort">';
            html +=     '<img src="'+img+'" alt="" data-name="'+filename+'">';
            html +=     '<a href="javascript:;" class="js-delete-pic close close-bg">×</a>';
            html += '</li>';
            $('.image-upload-list').prepend(html);

            buildImg();
        }
    );
</script>