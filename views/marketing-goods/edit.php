<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
?>
<?php echo IndexTitleWidget::widget(); ?>
<form action="<?php echo Url::to(['edit']); ?>" method="get" id="form">
    <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <div class="m-content" id="first">
        <div class="qgj-title">
            <div class="qgj-title_main">
                <a href="<?php echo Url::to(['list']); ?>"><span class="back"><i class="layui-icon">&#xe603;</i>返回</span></a>
                商户服务
            </div>
        </div>
        <?php if($detail['status']==BE_REJECT){ ?>
            <div class="qgj-reject">
                <span><?php echo $detail['reject_time'] ?></span>
                <span>运营方驳回</span>
                <div><span>驳回原因:</span><span><?php echo $detail['reject_reason'] ?></span></div>
            </div>
        <?php }?>

        <div class="qgj-step">
            <ul class="btn-group">
                <li class="col-xs-6 btn active"><a href="javascript:;">编辑基本信息</a></li>
                <li class="col-xs-6 btn"><a href="javascript:;">编辑服务详情</a></li>
            </ul>
        </div>


        <div class="form-horizontal form-add">
            <div class="form-head"><span>商户基本信息</span></div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商户简称</label>
                <div class="control-input">
                    <input type="text" class="form-control wper30" placeholder="" id="alias" name="alias" value="<?php echo $detail['merchant']['alias'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商户名称</label>
                <div class="control-input">
                    <input type="text" class="form-control wper30" placeholder="" id="name" name="name" value="<?php echo $detail['merchant']['name'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商户类别</label>
                <div class="control-input">
                    <select class="form-control wper30" name="industry" id="industry">
                        <option value="">全部分类</option>
                        <?php foreach ($GLOBALS['__GOODS_INDUSTRY_TYPE'] as $key => $val) { ?>
                            <option value="<?php echo $key; ?>" <?php echo $key == $detail['merchant']['industry'] ? 'selected' : ''; ?>><?php echo $val; ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" value="" name="industry_id" id="industry_id">
                </div>

            </div>

            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商品图</label>
                <div class="control-input">
                    <div class="pic-list ui-sortable">
                        <ul class="image-list js-pic-list">
                            <?php $img_arr = json_decode($detail['goods_img'], true); ?>
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
        <div class="form-horizontal form-add">
            <div class="form-head"><span>商户更多信息</span></div>
            <?php $product = json_decode($detail['merchant']['product_type']) ?>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 银联产品类型</label>
                <div class="control-input">
                    <div class="table_css table_css_auto">
                        <div class="table_row">
                            <div class="table_cell">银联产品</div>
                            <div class="table_cell">通道类型</div>
                            <input type="hidden" name="yl_production" id="yl_production" value="">
                        </div>

                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ewm" name="ewm" id="ewm" value="1"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_QRCPDE){echo 'checked';} ?>
                                    <?php }?>
                                    >
                                    <span>银联二维码</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type1" id="ewmzl" value="1"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_QRCPDE && $v->channel_type==1){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type1" id="ewmjl" value="2"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_QRCPDE && $v->channel_type==2){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>间连</span>
                                </label>
                                <input type="hidden" name="typefirst" id="typefirst" value="">
                            </div>
                        </div>
                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ylsf" name="ylsf" id="ylsf" value="2"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_IPHONE){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>银联手机闪付</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type2" id="ylsfzl" value="1"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_IPHONE && $v->channel_type==1){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type2" id="ylsfjl" value="2"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_IPHONE && $v->channel_type==2){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>间连</span>
                                </label>
                                <input type="hidden" name="typesecond" id="typesecond" value="">
                            </div>
                        </div>
                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ylsk" name="ylsk" id="ylsk" value="3"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_CARD){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>银联刷卡</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type3" id="ylskzl" value="1"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_CARD && $v->channel_type==1){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type3" id="ylskjl" value="2"
                                        <?php foreach ($product as $v){ ?>
                                            <?php if($v->type ==UNIONPAY_TYPE_CARD && $v->channel_type==2){echo 'checked';} ?>
                                        <?php }?>
                                    >
                                    <span>间连</span>
                                </label>
                                <input type="hidden" name="typethird" id="typethird" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $ticket_info = json_decode($detail['merchant']['invoice_info'])?>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 发票信息</label>
                <div class="control-input">
                    <div class="bg-gray-lighter p20">
                        <div class="form-group">
                            <label class="control-label"> 发票类型</label>
                            <div class="control-input">
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="pt_ticket" value="1" <?php if($ticket_info[0]->type==1){echo 'checked'; }?>>
                                    <span>增值税普通发票</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="zy_ticket" value="2" <?php if($ticket_info[0]->type==2){echo 'checked'; }?>>
                                    <span>增值税专用发票</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="no_ticket" value="3" <?php if($ticket_info[0]->type==3){echo 'checked'; }?>>
                                    <span>不开票</span>
                                </label>
                                <input type="hidden" id="ticket_type_id" name="ticket_type_id" value="">
                            </div>
                        </div>
                        <div id="ticket_info1" <?php if($ticket_info[0]->type!=1) echo "style=\"display: none\""?>>
                            <div class="form-group tickhead">
                                <label class="control-label"> 发票抬头</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_invoice_title1" value="<?php if($ticket_info[0]->type==1){echo $ticket_info[0]->invoice_title ; }?>">
                                </div>
                            </div>

                            <div class="form-group tickpeoplecode">
                                <label class="control-label"> 纳税人识别号</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_code1" value="<?php if($ticket_info[0]->type==1){echo $ticket_info[0]->code;} ?>">
                                </div>
                            </div>
                        </div>



                        <div id="ticket_info2" <?php if($ticket_info[0]->type!=2) echo "style=\"display: none\""?>>
                            <div class="form-group">
                                <label class="control-label"> 发票抬头</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_invoice_title" value="<?php if($ticket_info[0]->type==2){ echo $ticket_info[0]->invoice_title ;}?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> 注册地址</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_address" value="<?php if($ticket_info[0]->type==2){ echo $ticket_info[0]->address;} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> 纳税人识别号</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_code" value="<?php if($ticket_info[0]->type==2){echo $ticket_info[0]->code;} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> 发票打印电话</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_tel"  value="<?php if($ticket_info[0]->type==2){echo $ticket_info[0]->tel;} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> 基本户开户行</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_bank" value="<?php if($ticket_info[0]->type==2){echo $ticket_info[0]->bank;} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> 基本户开户支行</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_branch_bank"  value="<?php if($ticket_info[0]->type==2){echo $ticket_info[0]->branch_bank;} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> 基本户银行帐号</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_bank_code" value="<?php if($ticket_info[0]->type==2){echo $ticket_info[0]->bank_code;} ?>">
                                </div>
                            </div>
                        </div>

                        <div id="no_ticket_msg" <?php if($ticket_info[0]->type!=3) echo "style=\"display: none\""?>>
                            <div class="form-group">
                                <div class="control-input">
                                    <span class="text-gray-light">不开票，将会承担额外税点</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 财务联系人</label>
                <div class="control-input">
                    <input type="text" class="form-control wper30" placeholder="" id="finance_contact" name="finance_contact" value="<?php echo $detail['merchant']['finance_contact'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 财务联系方式</label>
                <div class="control-input">
                    <input type="text" class="form-control wper30" placeholder="" id="finance_contact_info" name="finance_contact_info" value="<?php echo $detail['merchant']['finance_contact_info'] ?>">
                </div>
            </div>
        </div>
        <div class="form-horizontal form-add">
            <div class="form-head"><span>商户门店</span></div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商户类型</label>
                <div class="control-input">
                    <label>
                        <input type="radio" class="qkj-radio" name="type" id="pptype" value="1" <?php echo $detail['merchant']['type'] == MERCHANT_TYPE_PP?'checked':'' ?>>
                        <span>品牌商户</span>
                    </label>
                    <label>
                        <input type="radio" class="qkj-radio" name="type" id="sqtype" value="2" <?php echo $detail['merchant']['type'] == MERCHANT_TYPE_SQ?'checked':'' ?>>
                        <span>商圈/街区</span>
                    </label>
                    <input type="hidden" name="typee" id="typee" value="">
                </div>
            </div>
            <div class="form-group" id="sqselect"  <?php if($detail['merchant']['type'] != MERCHANT_TYPE_SQ){ ?>style="display: none" <?php }?>>
                <label class="control-label"><em class="text-danger">*</em> 商圈/街区</label>
                <div class="control-input">
                    <select class="form-control wper30" id="block_id" name="block_id">
                        <?php if(!empty($sqlist)){ ?>
                            <?php foreach ($sqlist as $v){ ?>
                                <option value="<?php echo $v['id'] ?>" <?php if($detail['store'][0]['block_id']==$v['id']){echo 'selected';} ?>><?php echo $v['name'] ?></option>
                            <?php }?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group" id="sq" <?php if($detail['merchant']['type'] == MERCHANT_TYPE_PP){ ?>style="display: none" <?php }?>>
                <label class="control-label"><em class="text-danger">*</em> 门店地址</label>

                <div class="control-input">

                    <select class="form-control w100 inline-block" id="pr" name="province_code">
                        <option value="">请选择</option>
                        <?php if(!empty($province)){ ?>
                            <?php foreach ($province as $k=>$v) {?>
                                <option value="<?php echo $k ?>" <?php  if(!empty($detail['store'])&& $detail['merchant']['type'] == MERCHANT_TYPE_SQ){if($detail['store'][0]['province_code']==$k){echo 'selected';}}?>><?php echo $v?></option>
                            <?php }?>
                        <?php }?>
                        <input type="hidden" value="" name="province" id="province">
                    </select>
                    <select class="form-control w100 inline-block" id="ci" name="city_code">
                        <option value="" class="city_option">请选择</option>
                    </select>
                    <input type="hidden" value="" name="city" id="city">
                    <select class="form-control w100 inline-block" id="ar" name="area_code">
                        <option value="" class="area_option">请选择</option>
                    </select>
                    <input type="hidden" value="" name="area" id="area">
                    <input type="text" class="form-control w300 inline-block" placeholder="" name="full_address" id="full_address" value="<?php if($detail['merchant']['type'] == MERCHANT_TYPE_SQ){ echo $detail['store'][0]['address'] ;}?>">
                </div>
                <div class="control-input">
                    <input type="hidden" value="" name="check_city" id="check_city">
                </div>

            </div>
            <div class="form-group" id="pp" <?php if($detail['merchant']['type'] == MERCHANT_TYPE_SQ){ ?>style="display: none" <?php }?>>
                <label class="control-label"><em class="text-danger">*</em> 门店列表</label>
                <div class="control-input">
                    <div class="table_css table_css_auto js-store-table">
                        <div class="table_row">
                            <div class="table_cell">门店名称</div>
                            <div class="table_cell">营业执照名称</div>
                            <div class="table_cell">省</div>
                            <div class="table_cell">市</div>
                            <div class="table_cell">区</div>
                            <div class="table_cell">详细地址</div>
                            <div class="table_cell">操作</div>
                        </div>
                        <?php foreach ($detail['store'] as $key=>$val) {?>
                        <div class="table_row store_list">
                            <div class="table_cell stlist">
                                <input type="text" class="form-control stname w100 inline-block" name="stname" value="<?php echo $val['name'] ?>">
                            </div>
                            <div class="table_cell stlist">
                                <input type="text" class="form-control stbusiness w100 inline-block" name="stbusiness" value="<?php echo $val['business_license_name'] ?>">
                            </div>
                            <div class="table_cell stlist">
                                <select class="form-control w100 inline-block pr" name="stprovince<?php echo $key+1; ?>">
                                    <option value="" name="stprovince">请选择</option>
                                    <?php if(!empty($province)){ ?>
                                        <?php foreach ($province as $k=>$v) {?>
                                            <option name="stprovince" class="store_province_option" value="<?php echo $k ?>" <?php if($k==$val['province_code']){echo "selected";} ?>><?php echo $v?></option>
                                        <?php }?>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="table_cell stlist">
                                <select class="form-control w100 inline-block ci" name="stcity<?php echo $key+1; ?>">
                                    <option value="" name="store_city_option<?php echo $key+1; ?>" class="store_city_option">请选择</option>
                                </select>
                            </div>
                            <div class="table_cell stlist">
                                <select class="form-control w100 inline-block ar" name="stblock<?php echo $key+1; ?>"">
                                <option value="" name="store_area_option<?php echo $key+1; ?>" class="store_area_option">请选择</option>
                                </select>
                            </div>
                            <div class="table_cell stlist">
                                <input type="text"  class="form-control staddress w100 inline-block" name="staddress"  value="<?php echo $val['address'] ?>" >
                            </div>
                            <div class="table_cell stlist">
                                <a href="javascript:;" class="text-primary store-delete">删除</a>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <input type="hidden" name="store_data" id="store_data">
                    <div class="mt10">
                        <a href="javascript:;" class="btn btn-default js-add-store">添加门店</a>
<!--                        <a href="javascript:;" class="btn btn-default js-add-batch-store">批量添加门店</a>-->
                    </div>
                </div>
            </div>
            <input type="hidden" name="store_num" id="store_num" value="">
        </div>
        <div class="form-horizontal form-add">
            <div class="form-head"><span>商户服务信息</span></div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 标准服务</label>
                <div class="control-input">
                    <div class="bg-gray-lighter p20">
                        <div class="form-group">
                            <label class="control-label"> 服务内容</label>
                            <div class="control-input">
                                <p>商户签约，活动启动前，与商户签署营销活动的合作协议，并在平台上传。<br>
                                    物料投放，将指定物料投放到商户门店，拍摄物料照片并上传平台。<br>
                                    商户培训，对指定商户门店的收银员做培训。做好培训记录，并上传平台。<br>
                                    资金结算服务，在活动结束后，按照运营方提供的流水与商户确认对账，并按约定向商户收取发票，收取商户资金到账确认书。</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> 收费标准</label>
                            <?php $standard = json_decode($detail['goodsSku'][0]['merchant_standard_json']) ?>
                            <div class="control-input">
                                <span>实际执行金额</span>
                                <input type="text" class="form-control inline-block w48" placeholder="" id="standard_rate" name="standard_rate" value="<?php echo$standard[0]->rate ?>">
                                <span>%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> 保底费用</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30 inline-block" placeholder=""  value="<?php echo  sprintf("%01.2f",$standard[0]->minimum_guarantee) ?>" id="standard_minmun_guarantee" name="standard_minmun_guarantee" data-content-id="standard_minmun_guarantee">
                                <span>元</span>
                                <p class="text-gray-light">当活动收费标准未达到保底价，按照保底费用收费</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"> 可选服务</label>
                <?php $option = json_decode($detail['goodsSku'][0]['merchant_optional_json'])?>
                <div class="control-input">
                    <div class="bg-gray-lighter p20">
                        <div class="form-group">
                            <div>
                                <label>
                                    <input type="checkbox" name="optional_test" id="optional_test" value="1"
                                        <?php if(!empty($option)){ ?>
                                        <?php foreach ($option as $v) {?>
                                                <?php if($v->type == FWS_TYPE_TEST){ echo 'checked';} ?>
                                            <?php }?>
                                            <?php }?>
                                    >
                                    <span>测试服务</span>
                                    <span>（在活动正式启动前，在指定商户门店用指定支付方式进行测试。把测试交易要素、账单上传平台。）</span>
                                </label>
                                <div>
                                    <input type="text" class="form-control inline-block w100" name="optional_test_price" id="optional_test_price"
                                        <?php if(!empty($option)){ ?>
                                            <?php foreach ($option as $v) {?>
                                                <?php if($v->type == FWS_TYPE_TEST) {?>
                                                    value="<?php echo sprintf("%01.2f",$v->unit_price) ?>"
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                    >
                                    元/门店
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>
                                    <input type="checkbox" name="option_satify" id="option_satify" value="2"
                                        <?php if(!empty($option)){ ?>
                                            <?php foreach ($option as $v) {?>
                                                <?php if($v->type == FWS_TYPE_SATISFY){ echo 'checked';} ?>
                                            <?php }?>
                                        <?php }?>
                                    >
                                    <span>商户满意度回访</span>
                                    <span>（商户满意度报告上传平台。）</span>
                                </label>
                                <div>
                                    <input type="text" class="form-control inline-block w100" name="option_satify_price" id="option_satify_price"
                                    <?php if(!empty($option)){ ?>
                                            <?php foreach ($option as $v) {?>
                                                <?php if($v->type == FWS_TYPE_SATISFY) {?>
                                           value="<?php echo sprintf("%01.2f",$v->unit_price) ?>"
                                                    <?php }?>
                                            <?php }?>
                                        <?php }?>
                                    >
                                    元/门店
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
            <textarea name="content" id="container"><?php echo $detail['content'] ?></textarea>
        </div>

        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150 mr5" onclick="first()">上一步</button>
            <button type="submit" class="btn btn-primary w150 ml5">保存</button>
        </div>

    </div>
</form>

<!--规则选择弹出框-->
<div class="popover">
    <select class="js-example-basic-multiple js-states form-control subGoodsCategory" multiple="multiple">
    </select>
    <a href="javascript:;" class="btn btn-primary btn-popover-sure">确定</a>
    <a href="javascript:;" class="btn btn-default btn-popover-cancel">取消</a>
</div>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/marketing-goods/goodsForm.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/marketing-goods/goods.js'); ?>"></script>
<script>
    //删除
    $(document).on("click",'.store-delete',function () {
        $(this).parent().parent().remove()
    });
    $('#pptype').click(function () {
        $('#sq').hide();
        $('#sqselect').hide();
        $('#pp').show();
    })
    $('#sqtype').click(function () {
        $('#sq').show();
        $('#sqselect').show();
        $('#pp').hide();

    })
    $('#ticket_info2').click(function () {
        $('#ticket_info1').hide();
        $('#ticket_info2').show();
    })

    //不开票
    $('#no_ticket').click(function () {
        $('#ticket_info1,#ticket_info2').hide();
        $('#no_ticket_msg').show();
    })
    $('#pt_ticket').click(function () {
        $('#ticket_info1').show();
        $('#no_ticket_msg,#ticket_info2').hide();
    })
    $('#zy_ticket').click(function () {
        $('#ticket_info2').show();
        $('#no_ticket_msg,#ticket_info1').hide();
    })
    //product_type
    var pro = [];
    $('.ewm').click(function () {

    })
    $('select[name="industry"]').change(function () {
        var industry_val = $('#industry').val()
        $('#industry_id').val(industry_val)
    });
    $('#ar').change(function () {
        var check_city = $('#ar').val()
        var area = $('#ar option:selected').text();
        $('#area').val(area)
        $('#check_city').val(check_city)
    });
    $('#pr').change(function () {
        var province = $('#pr option:selected').text()
        $('#province').val(province)
    });
    $('#ci').change(function () {
        var city = $('#ci option:selected').text()
        $('#city').val(city)
    });





    $('input[name="type"]').click(function () {
        var a = $('input[name="type"]:checked').val();
        $('#typee').val(a)
    })
    $('input[name="ticket_type"]').click(function () {
        var tp = $('input[name="ticket_type"]:checked').val();
        $('#ticket_type_id').val(tp)
    })


    //赋值yl_production
    function val_pro(){
        var str = '';
        if($('#ewm').is(':checked')){
            str =str + $('#ewm').val();
        }
        if($('#ylsf').is(':checked')){
            str =str + $('#ylsf').val();
        }
        if($('#ylsk').is(':checked')){
            str =str + $('#ylsk').val();
        }
        $('#yl_production').val(str)
    }

    //yl类型
    $('#ewm,#ylsf,#ylsk').click(function () {
        val_pro()
        if($('#ewm').is(':checked')==false){
            $("input[name='type1']").removeAttr('checked');
            $('#typefirst').val('');
        }
        if($('#ylsf').is(':checked')==false){
            $("input[name='type2']").removeAttr('checked');
            $('#typesecond').val('');
        }
        if($('#ylsk').is(':checked')==false){
            $("input[name='type3']").removeAttr('checked');
            $('#typethird').val('');
        }
    })
    $('input[name="type1"]').click(function () {
        var tpfirst = $('input[name="type1"]:checked').val()
        $('#typefirst').val(tpfirst);
        if($('#ewmzl').is(':checked')==true || $('#ewmjl').is(':checked')==true){
            $('#ewm').prop('checked',true)
        }
        val_pro()
    })
    $('input[name="type2"]').click(function () {
        var tpsecond = $('input[name="type2"]:checked').val()
        $('#typesecond').val(tpsecond);
        if($('#ylsfzl').is(':checked')==true || $('#ylsfjl').is(':checked')==true){
            $('#ylsf').prop('checked',true)
        }
        val_pro()
    })
    $('input[name="type3"]').click(function () {
        var tpthird = $('input[name="type3"]:checked').val()
        $('#typethird').val(tpthird);
        if($('#ylskzl').is(':checked')==true || $('#ylskjl').is(':checked')==true){
            $('#ylsk').prop('checked',true)
        }
        val_pro()
    })


    var city_code ="<?php echo !empty($detail['store'])?$detail['store'][0]['city_code']:''?>";
    var area_code ="<?php echo !empty($detail['store'])?$detail['store'][0]['area_code']:''?>";
    //省市区下拉框

    //渲染省市区数据
    var select_city = ''
    $.ajax({
        'type': 'get',
        'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
        'data': {'pid': $("#pr").find("option:selected").val()},
        'success': function (data) {
            data = eval("(" + data + ")")

            $(".city_option").remove();
            $("#ci").append("<option class='city_option' value=''>请选择</option>");
            if (data['errCode']==0) {
                for(let key in data['data']){
                    var id = key;
                    var city_name = data['data'][key];
                    $("#ci").append("<option class='city_option'   value="+id+"  >" + city_name + "</option>");
                }
                $("#ci").find('option').each(function (i,v) {
                    if(city_code!=""){
                        if(city_code==$(v).val()){
                            select_city = $(v).val()
                            $(v).attr("selected","selected")
                        }
                    }
                })
                $.ajax({
                    'type': 'get',
                    'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                    'data': {'pid': select_city},
                    'success': function (data) {
                        data = eval("(" + data + ")")
                        $(".area_option").remove();
                        $("#ar").append("<option class='area_option' value=''>请选择</option>");
                        if (data['errCode']==0) {
                            for(let key in data['data']){
                                var id = key;
                                var city_name = data['data'][key];
                                $("#ar").append("<option class='area_option'   value="+id+"  >" + city_name + "</option>");
                            }
                            $("#ar").find('option').each(function (i,v) {
                                if(area_code!=""){
                                    if(area_code==$(v).val()){
                                        $(v).attr("selected",true)
                                    }
                                }
                            })
                        }
                        var check_city = $('#ar option:selected').val()
                        $('#check_city').val(check_city)

                    }
                })
            }
        }
    })




    $("#pr").change(function () {
        $.ajax({
            'type': 'get',
            'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
            'data': {'pid': $("#pr").find("option:selected").val()},
            'success': function (data) {
                data = eval("(" + data + ")")
                $(".city_option").remove();
                $("#ci").append("<option class='city_option' value=''>请选择</option>");
                if (data['errCode']==0) {
                    for(let key in data['data']){
                        var id = key;
                        var city_name = data['data'][key];
                            $("#ci").append("<option class='city_option'   value="+id+"  >" + city_name + "</option>");
                    }
                }
            }
        })
    })

    $("#ci").change(function () {
        $.ajax({
            'type': 'get',
            'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
            'data': {'pid': $("#ci").find("option:selected").val()},
            'success': function (data) {
                data = eval("(" + data + ")")
                $(".area_option").remove();
                $("#ar").append("<option class='area_option' value=''>请选择</option>");
                if (data['errCode']==0) {
                    for(let key in data['data']){
                        var id = key;
                        var city_name = data['data'][key];
                        $("#ar").append("<option class='area_option'   value="+id+"  >" + city_name + "</option>");
                    }
                }
            }
        })
    })

    //option
    $('#optional_test').click(function () {
        if($('#optional_test').is(':checked')==false){
            $('#optional_test_price').val('')
        }
    })
    $('#option_satify').click(function () {
        if($('#option_satify').is(':checked')==false){
            $('#option_satify_price').val('')
        }
    })
    $('#optional_test_price').change(function () {
        if($('#optional_test_price').val()!=''){
            $('#optional_test').prop('checked',true)
        }
    })
    $('#option_satify_price').change(function () {
        if($('#option_satify_price').val()!=''){
            $('#option_satify').prop('checked',true)
        }
    })


    //门店数量

    var count_store= 1;
    var goods_id = "<?php echo $_GET['id'] ?>"

    $('.js-store-table').find('.store_list').each(function (innd,vall) {
        count_store = count_store+1;
    })
    $('.js-add-store').click(function () {

        $.ajax({
            'type': 'get',
            'url': '<?php echo Url::to(['marketing-goods/get-pca']); ?>',
            'data': {'num': count_store,'goods_id':goods_id},
            'success': function (data) {
                $('.js-store-table').append(data);
                count_store = count_store+1;

            }
        })

    })

    //渲染时为hidde隐藏域赋值
    var industry_val = $('#industry').val()
    $('#industry_id').val(industry_val)
    //图片
    buildImg()
    //yl类型
    val_pro()
    var tpfirst = $('input[name="type1"]:checked').val()
    $('#typefirst').val(tpfirst);
    var tpsecond = $('input[name="type2"]:checked').val()
    $('#typesecond').val(tpsecond);
    var tpthird = $('input[name="type3"]:checked').val()
    $('#typethird').val(tpthird);
    var tp = $('input[name="ticket_type"]:checked').val();
    $('#ticket_type_id').val(tp)
    var a = $('input[name="type"]:checked').val();
    $('#typee').val(a)




    //门店列表数据
    var store_data_num = '<?php echo count($detail['store']) ?>' ;
    var store_json = '<?php echo $store_json ?>'
    var store_json_arr= eval("(" + store_json + ")")
    console.log(store_json_arr)



    function get_store_data(i) {

        if(i>store_data_num){
           return;
        }
            $.ajax({
                'type': 'get',
                'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                'data': {'pid': $('[name="stprovince'+i+'"]').find("option:selected").val()},
                'success': function (data) {
                    data = eval("(" + data + ")")

                    $('[name="store_city_option'+i+'"]').remove();
                    $('[name="stcity'+i+'"]').append('<option name="store_city_option' + i +'" class="store_city_option"  value="">请选择</option>');
                    if (data['errCode']==0) {
                        for(let key in data['data']){
                            var id = key;
                            var city_name = data['data'][key];

                            if(key==store_json_arr[i-1]['city_code']){
                                $('[name="stcity'+i+'"]').append('<option name="store_city_option'+ i+ '"  class="store_city_option" selected  value="'+ id +'"  >' + city_name + '</option>')
                            }else{
                                $('[name="stcity'+i+'"]').append('<option name="store_city_option'+ i+ '"  class="store_city_option"  value="'+ id +'"  >' + city_name + '</option>');
                            }
                        }
                    }
                    $.ajax({
                        'type': 'get',
                        'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                        'data': {'pid': $('[name="stcity'+i+'"]').find("option:selected").val()},
                        'success': function (data) {
                            data = eval("(" + data + ")")
                            $('[name="store_area_option'+i+'"]').remove()
                            $('[name="stblock'+i+'"]').append('<option name="store_area_option'+ i +'" value="" class="store_area_option">请选择</option>');
                            if (data['errCode']==0) {
                                for(let key in data['data']){
                                    var id = key;
                                    var city_name = data['data'][key];
                                    if(key==store_json_arr[i-1]['area_code']){
                                        $('[name="stblock'+i+'"]').append('<option name="store_area_option' + i + '" class="store_area_option" selected value="' + id + '">'+ city_name + '</option>')
                                    }else{
                                        $('[name="stblock'+i+'"]').append('<option name="store_area_option' + i + '" class="store_area_option"  value="' + id + '">'+ city_name + '</option>');
                                    }

                                }
                            }
                            i=i+1;
                            get_store_data(i)
                        }
                    })

                }
            })
    }
    get_store_data(1);



    //编辑
    for(var i=1;i<=store_data_num;i++){
        $('[name="stprovince'+i+'"]').change(function () {
            var str = $(this).prop('name')
            var x = str.substr(str.length-1,str.length)
            $('[name="store_area_option'+x+'"]').remove()
            $('[name="stblock'+x+'"]').append('<option name="store_area_option'+ x +'" value="" class="store_area_option">请选择</option>');
            console.log(x)
            $.ajax({
                'type': 'get',
                'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                'data': {'pid': $('[name="'+str+'"]').find("option:selected").val()},
                'success': function (data) {
                    data = eval("(" + data + ")")
                    console.log(data)
                    $('[name="store_city_option'+x+'"]').remove()
                    $('[name="stcity'+x+'"]').append('<option name="store_city_option' + x +'" class="store_city_option"  value="">请选择</option>');
                    if (data['errCode']==0) {
                        for(let key in data['data']){
                            var id = key;
                            var city_name = data['data'][key];
                            $('[name="stcity'+x+'"]').append('<option name="store_city_option'+ x+ '"  class="store_city_option"  value="'+ id +'"  >' + city_name + '</option>');
                        }
                    }
                }
            })
        })
        $('[name="stcity'+i+'"]').change(function () {
            var strc = $(this).prop('name')
            var y = strc.substr(strc.length-1,strc.length)
            $.ajax({
                'type': 'get',
                'url': '<?php echo Url::to(['marketing-goods/get-address']); ?>',
                'data': {'pid': $('[name="stcity'+y+'"]').find("option:selected").val()},
                'success': function (data) {
                    data = eval("(" + data + ")")
                    $('[name="store_area_option'+y+'"]').remove()
                    $('[name="stblock'+y+'"]').append('<option name="store_area_option'+ y +'" value="" class="store_area_option">请选择</option>');
                    if (data['errCode']==0) {
                        for(let key in data['data']){
                            var id = key;
                            var city_name = data['data'][key];
                            $('[name="stblock'+y+'"]').append('<option name="store_area_option' + y + '" class="store_area_option"  value="' + id + '">'+ city_name + '</option>');
                        }
                    }
                }
            })

        })
    }






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