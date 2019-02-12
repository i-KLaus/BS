<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
use app\common\util\dataHelp;
?>
<?php echo IndexTitleWidget::widget(); ?>
<div class="m-content">
    <div class="qgj-title">
        <div class="qgj-title_main">
            <a href="<?php echo Url::to(['list']); ?>"><span class="back"><i class="layui-icon">&#xe603;</i>返回</span></a>
            订单管理详情
        </div>
    </div>
    <div class="circle-progress-container">
        <!-- completed：已完成  processing:进行中 -->
        <?php
        $order_status = $data['status'];
        $before_cancel_status = $order_status == ORDER_STATUS_CANCEL?$data['before_cancel_status']:0;
        $flag = 1;
        $class='';
        $flag_status = ORDER_STATUS_OPERATION_AUDIT;
        $show_status = true;
        ?>
        <ul class="circle-progress">
            <li class="circle-progress-item  completed">
                <div class="icon-wrapper">
                    <div class="icon">
                        <i class="layui-icon">&#xe605;</i>
                    </div>
                    <div class="text">提交订单</div>
                </div>
            </li>
            <?php if ($show_status){?>
                <li class="circle-progress-item <?php if ($order_status == ORDER_STATUS_OPERATION_AUDIT){
                    $class = 'processing';
                }else{
                    $class = 'completed';
                }echo $class;$flag++;$flag_status = ORDER_STATUS_OPERATION_AUDIT;?>">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <?php if ($class == 'completed'){?>
                                <i class="layui-icon">&#xe605;</i>
                            <?php }else{echo $flag;}?>
                        </div>
                        <div class="text">运营方确认订单</div>
                    </div>
                </li>
                <?php if ($before_cancel_status == $flag_status){?>
                    <li class="circle-progress-item circle-progress-item-last completed">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <i class="layui-icon">&#xe605;</i>
                            </div>
                            <div class="text">已关闭</div>
                        </div>
                    </li>
                    <?php $show_status = false;}?>
            <?php }?>
            <?php if ($show_status){?>
                <?php if ($order_status == ORDER_STATUS_DEMANDER_AUDIT ||$before_cancel_status == ORDER_STATUS_DEMANDER_AUDIT){?>
                    <li class="circle-progress-item <?php if ($order_status == ORDER_STATUS_DEMANDER_AUDIT){
                        $class = 'processing';
                    }else{
                        if (in_array($order_status,array(ORDER_STATUS_ACTUALIZE,ORDER_STATUS_UNPAID,ORDER_STATUS_PAID_CONFIRM,ORDER_STATUS_COMPLETED,ORDER_STATUS_CANCEL))){
                            $class = 'completed';
                        }else{
                            $class = '';
                        }
                    }echo $class;$flag++;$flag_status = ORDER_STATUS_DEMANDER_AUDIT?>">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <?php if ($class == 'completed'){?>
                                    <i class="layui-icon">&#xe605;</i>
                                <?php }else{echo $flag;}?>
                            </div>
                            <div class="text">需求方确认订单</div>
                        </div>
                    </li>
                <?php }?>
                <?php if ($before_cancel_status == $flag_status){?>
                    <li class="circle-progress-item circle-progress-item-last completed">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <i class="layui-icon">&#xe605;</i>
                            </div>
                            <div class="text">已关闭</div>
                        </div>
                    </li>
                    <?php $show_status = false;}?>
            <?php }?>
            <?php if ($show_status){?>
                <li class="circle-progress-item <?php if ($order_status == ORDER_STATUS_MERCHANT_AUDIT){
                    $class = 'processing';
                }else{
                    if (in_array($order_status,array(ORDER_STATUS_ACTUALIZE,ORDER_STATUS_UNPAID,ORDER_STATUS_PAID_CONFIRM,ORDER_STATUS_COMPLETED,ORDER_STATUS_CANCEL))){
                        $class = 'completed';
                    }else{
                        $class = '';
                    }
                }echo $class;$flag++;$flag_status = ORDER_STATUS_MERCHANT_AUDIT?>">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <?php if ($class == 'completed'){?>
                                <i class="layui-icon">&#xe605;</i>
                            <?php }else{echo $flag;}?>
                        </div>
                        <div class="text">服务方确认订单</div>
                    </div>
                </li>
                <?php if ($before_cancel_status == $flag_status){?>
                    <li class="circle-progress-item circle-progress-item-last completed">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <i class="layui-icon">&#xe605;</i>
                            </div>
                            <div class="text">已关闭</div>
                        </div>
                    </li>
                    <?php $show_status = false;}?>
            <?php }?>
            <?php if ($show_status){?>
                <li class="circle-progress-item <?php if ($order_status == ORDER_STATUS_ACTUALIZE){
                    $class = 'processing';
                }else{
                    if (in_array($order_status,array(ORDER_STATUS_UNPAID,ORDER_STATUS_PAID_CONFIRM,ORDER_STATUS_COMPLETED,ORDER_STATUS_CANCEL))){
                        $class = 'completed';
                    }else{
                        $class = '';
                    }
                }echo $class;$flag++;$flag_status = ORDER_STATUS_ACTUALIZE?>">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <?php if ($class == 'completed'){?>
                                <i class="layui-icon">&#xe605;</i>
                            <?php }else{echo $flag;}?>
                        </div>
                        <div class="text">进行中</div>
                    </div>
                </li>
                <?php if ($before_cancel_status == $flag_status){?>
                    <li class="circle-progress-item circle-progress-item-last completed">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <i class="layui-icon">&#xe605;</i>
                            </div>
                            <div class="text">已关闭</div>
                        </div>
                    </li>
                    <?php $show_status = false;}?>
            <?php }?>
            <?php if ($show_status){?>
                <li class="circle-progress-item <?php if ($order_status == ORDER_STATUS_UNPAID){
                    $class = 'processing';
                }else{
                    if (in_array($order_status,array(ORDER_STATUS_PAID_CONFIRM,ORDER_STATUS_COMPLETED,ORDER_STATUS_CANCEL))){
                        $class = 'completed';
                    }else{
                        $class = '';
                    }
                }echo $class;$flag++;$flag_status = ORDER_STATUS_UNPAID?>">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <?php if ($class == 'completed'){?>
                                <i class="layui-icon">&#xe605;</i>
                            <?php }else{echo $flag;}?>
                        </div>
                        <div class="text">待付款</div>
                    </div>
                </li>
                <?php if ($before_cancel_status == $flag_status){?>
                    <li class="circle-progress-item circle-progress-item-last completed">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <i class="layui-icon">&#xe605;</i>
                            </div>
                            <div class="text">已关闭</div>
                        </div>
                    </li>
                    <?php $show_status = false;}?>
            <?php }?>
            <?php if ($show_status){?>
                <li class="circle-progress-item <?php if ($order_status == ORDER_STATUS_PAID_CONFIRM){
                    $class = 'processing';
                }else{
                    if (in_array($order_status,array(ORDER_STATUS_COMPLETED,ORDER_STATUS_CANCEL))){
                        $class = 'completed';
                    }else{
                        $class = '';
                    }
                }echo $class;$flag++;$flag_status = ORDER_STATUS_PAID_CONFIRM?>">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <?php if ($class == 'completed'){?>
                                <i class="layui-icon">&#xe605;</i>
                            <?php }else{echo $flag;}?>
                        </div>
                        <div class="text">支付待确认</div>
                    </div>
                </li>
                <?php if ($before_cancel_status == $flag_status){?>
                    <li class="circle-progress-item circle-progress-item-last completed">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <i class="layui-icon">&#xe605;</i>
                            </div>
                            <div class="text">已关闭</div>
                        </div>
                    </li>
                    <?php $show_status = false;}?>
            <?php }?>
            <?php if ($show_status){?>
                <li class="circle-progress-item circle-progress-item-last <?php if ($order_status == ORDER_STATUS_COMPLETED){
                    $class = 'completed';
                }else{
                    $class = '';
                }echo $class;$flag++;$flag_status = ORDER_STATUS_COMPLETED?>">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <?php if ($class == 'completed'){?>
                                <i class="layui-icon">&#xe605;</i>
                            <?php }else{echo $flag;}?>
                        </div>
                        <div class="text">已完成</div>
                    </div>
                </li>
            <?php }?>
        </ul>
    </div>
    <div id="print_area">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                <?php if(!empty($data)){?>
                    <tr class="tr-head">
                        <td colspan="5">
                            <div class="tr-head_left">
                                <span class="text-gray-light mr30"><?php echo $data['create_time'] ?></span>
                                <span class="mr30">订单号：<?php echo $data['order_no'] ?></span>
                                <a href="javaScript:;" class="btn btn-outlined btn-sm btn-primary">
                                    <?php
                                    switch ($data['status']){
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
                    </tr>
                <?php foreach ($data['order_sku'] as $val){ ?>
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
                                <span><?php echo $val['implement_money']!=0?dataHelp::convertYuan($val['implement_money']).'*':'实际执行金额*' ?><?php echo $val['merchant_standard_json'][0]['rate'] ?>%，保底费用<?php echo $val['merchant_standard_json'][0]['minimum_guarantee'] ?>元</span>
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
                                    <p>实际执行金额*<?php echo $val['merchant_standard_json'][0]['rate'] ?>%</p>
                                <?php }?>
                                <?php if(!empty($val['merchant_standard_json']) && $val['implement_money']!=0){ ?>
                                        <p class="st_price">￥<?php echo  (($val['merchant_standard_json'][0]['rate']*$val['implement_money']/100)>$val['merchant_standard_json'][0]['minimum_guarantee'])?$val['merchant_standard_json'][0]['rate']*$val['implement_money']:$val['merchant_standard_json'][0]['minimum_guarantee'] ?></p>
                                <?php }?>

                                <?php if(!empty($val['merchant_optional_json'])){ ?>
                                    <?php foreach ($val['merchant_optional_json'] as $valu){ ?>
                                        <?php if($valu['type']==FWS_TYPE_TEST){ ?>
                                            <p class="test_price">￥<?php echo sprintf("%01.2f",$valu['unit_price']*$valu['store_num']*$valu['exercise_ratio']/100) ?></p>
                                        <?php }?>
                                        <?php if($valu['type']==FWS_TYPE_SATISFY){ ?>
                                            <p class="satisfy_price">￥<?php echo sprintf("%01.2f",$valu['unit_price']*$valu['store_num']*$valu['exercise_ratio']/100) ?></p>
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
                                    <p class="plat_op_price">￥<?php echo sprintf("%01.2f",$val['platform_optional_json'][0]['unit_price']*$val['platform_optional_json'][0]['store_num']*$val['platform_optional_json'][0]['exercise_ratio']/100) ?></p>
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
                    <td></td>
                </tr>
                <?php }?>
                    <tr class="text-left">
                        <td colspan="5" class="text-right">
                            <div>
                                <p class="goods_price_total">合计：<?php if($data['implement_status']==0) {?>实际活动费用+<?php }?><?php echo sprintf("%01.2f",$data['order_money']) ?></p>
                            </div>

                        </td>
                    </tr>
                    <tr class="tr-head">
                        <td colspan="5">
                            <div class="tr-head_right no-print" >
                                <?php if (!in_array($data['status'], [ORDER_STATUS_COMPLETED, ORDER_STATUS_CANCEL])) { ?>
                                    <a href="#modal" data-toggle="modal" class="btn ml10 btn-outlined btn-default" data-id="<?php echo $data['id']; ?>">上传资料</a>
                                <?php } ?>
                                <?php if ($data['status'] == ORDER_STATUS_MERCHANT_AUDIT) { ?>
                                    <a href="javascript:;" class="btn ml10 btn-primary"
                                       onclick="operateConfirm('确定确认订单？', '<?php echo Url::to(['determine-order', 'order_no' => $data['order_no'], 'goUrl' => Yii::$app -> request -> url]); ?>', '确认订单')">确认订单</a>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
        <div class="activity-information panel panel-default" <?php if (empty($data['activity_start_time'])){?>style="display: none" <?php }?>>
            <div class="panel-heading">活动信息</div>
            <div class="m-content">
                <div class="left-line">活动时间</div>
                <div class="vice-main"><?php echo date('Y年m月d日',strtotime($data['activity_start_time']))?> - <?php echo date('Y年m月d日',strtotime($data['activity_end_time']))?></div>
                <?php $activity_name_arr = json_decode($data['activity_name_json'],true);?>
                <?php if (!empty($activity_name_arr)){?>
                <div class="left-line">活动产品类型</div>
                <?php foreach ($activity_name_arr as $k => $v){?>
                <div class="btn margin-b btn-outlined btn-sm btn-primary"><?php echo $GLOBALS['__ACTIVITY_TYPE'][$v['type']].':'.$v['name']?></div>
                <?php }?>
                <?php }?>
                <?php $activity_rule_arr = json_decode($data['activity_rule_json'],true);?>
                <?php if (!empty($activity_rule_arr)){?>
                <div class="left-line">活动规则类型</div>
                <?php foreach ($activity_rule_arr as $k => $v){?>
                <div class="vice-main"><?php echo $GLOBALS['__ACTIVITY_RULE_TYPE'][$v['type']]?>，<?php echo $v['rule']?></div>
                <?php }?>
                <?php }?>
                <?php if (!empty($data['activity_remark'])){?>
                <div class="left-line">备注</div>
                <div class="vice-main"><?php echo $data['activity_remark']?></div>
                <?php }?>
                <?php $activity_file_arr = json_decode($data['activity_file'],true);
                $file_img_bg_url = Yii::getAlias('@web/img/upload-data.png');?>
                <?php if (!empty($activity_file_arr)){?>
                <div class="left-line">资料上传</div>
                <ul class="image-upload-list">
                    <?php foreach ($activity_file_arr as $k => $v){?>
                        <?php $file_name_arr = explode('.',$v);?>
                        <li>
                            <a href="<?php echo UPLOAD_ORDER_DATA_SOURCE.$v?>" download="file" target="_blank">
                                <img src="<?php echo ($file_name_arr[1] == 'jpg' || $file_name_arr[1] == 'png' || $file_name_arr[1] == 'jpeg')?(UPLOAD_ORDER_DATA_SOURCE.$v):$file_img_bg_url;?>" alt="">
                            </a>
                        </li>
                    <?php }?>
                </ul>
                <?php }?>
            </div>
        </div>

        <?php if (!empty($orderRecord)) { ?>
            <div class="panel panel-default" style="">
                <div class="panel-heading">订单跟踪</div>
                <div class="panel-body">
                    <div class="vertical-progress-container">
                        <div class="vertical-progress">
                            <ul class="layui-timeline">
                                <?php foreach ($orderRecord as $key => $val) { ?>
                                    <li class="layui-timeline-item">
                                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                        <div class="layui-timeline-content layui-text">
                                           <h3 class="layui-timeline-title"><?php echo $val -> create_time; ?> <?php echo $GLOBALS['_ORDER_OPERATION_ROLE'][$val -> role]; ?><?php echo $GLOBALS['__ORDER_OPERATION_TYPE'][$val -> operation_type]; ?></h3>
                                            <?php if (in_array($val -> operation_type, [ORDER_OPERATION_TYPE_FINALPAYMENT_INFO, ORDER_OPERATION_TYPE_UPLOAD, ORDER_OPERATION_TYPE_ADVANCEPAYMENT_INFO])) { ?>
                                                <div>
                                                    <div class="upload-file">
                                                        <?php $data_arr = json_decode($val -> data_file, true); ?>
                                                        <?php if (!empty($data_arr)){?>
                                                        <?php foreach ($data_arr as $k => $v) { ?>
                                                            <?php $format = explode('.', $v)[1]; ?>
                                                            <?php if (in_array($format, ['jpg', 'png', 'jpeg'])) { ?>
                                                                <a href="<?php echo Url::to(['download', 'src' => UPLOAD_ORDER_DATA_SOURCE . $v, 'format' => $format]); ?>" target="_blank"><img src="<?php echo UPLOAD_ORDER_DATA_SOURCE . $v; ?>" alt="" class="w80"></a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo Url::to(['download', 'src' => UPLOAD_ORDER_DATA_SOURCE . $v, 'format' => $format]); ?>" target="_blank"><img src="<?php echo Yii::getAlias('@web/img/upload-data.png');; ?>" alt=""></a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php }?>
                                                        <?php if (!empty($val -> content)) { ?>
                                                            <div class="left-line">备注</div>
                                                            <div class="vice-main"><?php echo $val -> content; ?></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
        <div class="btn-wrap text-center ptb30">
            <input type="button" id="save" value="打印" class="submit btn btn-md btn-primary w200" onclick="print()">
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
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/common/jquery.jqprint-0.3.js'); ?>"></script>
<script>
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
    function print() {
        $(".no-print").hide();
        $("#print_area").jqprint({
            debug: false,
            importCSS: true,
            printContainer: true,
            operaSupport: false
        });
        $(".no-print").show();
    }
</script>