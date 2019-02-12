<?php
use app\components\widgets\common\IndexTitleWidget;
use yii\helpers\Url;
?>
<?php echo IndexTitleWidget::widget(); ?>
<form action="<?php echo Url::to(['edit']); ?>" method="get" id="form">
    <input type="hidden" name="_csrf" value="<?php echo Yii::$app -> request -> csrfToken; ?>">
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
                <li class="col-xs-6 btn active"><a href="javascript:;">基本信息</a></li>
                <li class="col-xs-6 btn"><a href="javascript:;">服务详情</a></li>
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
                        <?php foreach ($GLOBALS['__GOODS_INDUSTRY_TYPE'] as $key => $val) { ?>
                            <option value="<?php echo $key; ?>" <?php echo $key == $detail['merchant']['industry'] ? 'selected' : ''; ?>><?php echo $val; ?></option>
                        <?php } ?>
                    </select>
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
            <?php if(!empty($product)){ ?>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 银联产品类型</label>
                <div class="control-input">
                    <div class="table_css table_css_auto">
                        <div class="table_row">
                            <div class="table_cell">银联产品</div>
                            <div class="table_cell">通道类型</div>
                        </div>
                            <?php foreach ($product as $v){ ?>
                                <?php if($v->type ==1){?>
                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ewm" name="ewm" id="" value="1" <?php if($v->type ==UNIONPAY_TYPE_QRCPDE){echo 'checked';} ?>>
                                    <span>银联二维码</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type1" id="ewmzl" value="1" <?php if($v->type ==UNIONPAY_TYPE_QRCPDE && $v->channel_type==1){echo 'checked';} ?>>
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type1" id="ewmjl" value="2" <?php if($v->type ==1 && $v->channel_type==2){echo 'checked';} ?>>
                                    <span>间连</span>
                                </label>
                            </div>
                        </div>
                        <?php }?>
                        <?php if($v->type ==2){?>
                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ylsf" name="ylsf" id="" value="2" <?php if($v->type ==2){echo 'checked';} ?>>
                                    <span>银联手机闪付</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type2" id="ylsfzl" value="1" <?php if($v->type ==2 && $v->channel_type==1){echo 'checked';} ?>>
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type2" id="ylsfzljl" value="2" <?php if($v->type ==2 && $v->channel_type==2){echo 'checked';} ?>>
                                    <span>间连</span>
                                </label>
                            </div>
                        </div>
                        <?php }?>
                        <?php if($v->type ==3){?>
                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ylsk" name="ylsk" id="" value="3" <?php if($v->type ==3){echo 'checked';} ?>>
                                    <span>银联刷卡</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type3" id="ylskzl" value="1" <?php if($v->type ==3 && $v->channel_type==1){echo 'checked';} ?>>
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type3" id="ylskjl" value="2" <?php if($v->type ==3 && $v->channel_type==2){echo 'checked';} ?>>
                                    <span>间连</span>
                                </label>
                            </div>
                        </div>
                                    <?php }?>
                                <?php }?>

                    </div>
                </div>
            </div>
            <?php }?>
            <?php $ticket_info = json_decode($detail['merchant']['invoice_info'])?>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 发票信息</label>
                <div class="control-input">
                    <div class="bg-gray-lighter p20">
                        <div class="form-group">
                            <label class="control-label"> 发票类型</label>
                            <div class="control-input">
                                <?php if($ticket_info[0]->type==1){ ?>
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="" value="1" <?php if($ticket_info[0]->type==1){echo 'checked'; }?>>
                                    <span>增值税普通发票</span>
                                </label>
                                <?php }?>
                                <?php if($ticket_info[0]->type==2){ ?>
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="" value="2" <?php if($ticket_info[0]->type==2){echo 'checked'; }?>>
                                    <span>增值税专用发票</span>
                                </label>
                                <?php }?>
                                <?php if($ticket_info[0]->type==3){ ?>
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="no_ticket" value="3" <?php if($ticket_info[0]->type==3){echo 'checked'; }?>>
                                    <span>不开票</span>
                                </label>
                                <?php }?>
                            </div>
                        </div>
                        <?php if($ticket_info[0]->type!=3) {?>
                        <div class="form-group">
                            <label class="control-label"> 发票抬头</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30" placeholder="" name="ticket_invoice_title" value="<?php echo $ticket_info[0]->invoice_title ?>">
                            </div>
                        </div>
                        <?php if($ticket_info[0]->type==2) {?>
                        <div class="form-group">
                            <label class="control-label"> 注册地址</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30" placeholder="" name="ticket_address" value="<?php echo $ticket_info[0]->address ?>">
                            </div>
                        </div>
                            <?php }?>
                        <div class="form-group">
                            <label class="control-label"> 纳税人识别号</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30" placeholder="" name="ticket_code" value="<?php echo $ticket_info[0]->code ?>">
                            </div>
                        </div>
                        <?php if($ticket_info[0]->type==2) {?>
                            <div class="form-group">
                            <label class="control-label"> 发票打印电话</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30" placeholder="" name="ticket_tel" value="<?php echo $ticket_info[0]->tel ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> 基本户开户行</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30" placeholder="" name="ticket_bank" value="<?php echo $ticket_info[0]->bank ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> 基本户开户支行</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30" placeholder="" name="ticket_branch_bank" value="<?php echo $ticket_info[0]->branch_bank ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> 基本户银行帐号</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30" placeholder="" name="ticket_bank_code" value="<?php echo $ticket_info[0]->bank_code ?>">
                            </div>
                        </div>
                            <?php }?>
                        <?php }?>
                        <?php if($ticket_info[0]->type==3) {?>
                        <div id="no_ticket_msg">
                            <div class="form-group">
                                <div class="control-input">
                                    <span class="text-gray-light">不开票，将会承担额外税点</span>
                                </div>
                            </div>
                        </div>
                        <?php }?>
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
                    <?php if($detail['merchant']['type'] == MERCHANT_TYPE_PP){ ?>
                    <label>
                        <input type="radio" class="qkj-radio" name="type" id="pptype" value="1" <?php echo $detail['merchant']['type'] == MERCHANT_TYPE_PP?'checked':'' ?>>
                        <span>品牌商户</span>
                    </label>
                    <?php }?>
                    <?php if($detail['merchant']['type'] == MERCHANT_TYPE_SQ){ ?>
                    <label>
                        <input type="radio" class="qkj-radio" name="type" id="sqtype" value="2" <?php echo $detail['merchant']['type'] == MERCHANT_TYPE_SQ?'checked':'' ?>>
                        <span>商圈/街区</span>
                    </label>
                    <?php }?>
                </div>
            </div>
            <?php if($detail['merchant']['type'] == MERCHANT_TYPE_SQ){ ?>
            <div class="form-group" id="sqselect" >
                <label class="control-label"><em class="text-danger">*</em> 商圈/街区</label>
                <div class="control-input">
                    <select class="form-control wper30" id="block_id" name="block_id">
                        <?php if(!empty($sqlist)){ ?>
                            <?php foreach ($sqlist as $v){ ?>
                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                <?php }?>
                        <?php } ?>
                    </select>
                </div>
            </div>
                <?php if(!empty($detail['store'])){ ?>
            <div class="form-group" id="sq" >
                <label class="control-label"><em class="text-danger">*</em> 门店地址</label>
                <div class="control-input">
                    <select class="form-control w100 inline-block" id="pr" name="province_code">
                        <option value="<?php echo $detail['store'][0]['province_code'] ?>"><?php echo $detail['store'][0]['province'] ?></option>
                    </select>
                    <select class="form-control w100 inline-block" id="ci" name="city_code">
                        <option value="<?php echo $detail['store'][0]['city_code'] ?>"><?php echo $detail['store'][0]['city'] ?></option>
                    </select>
                    <select class="form-control w100 inline-block" id="ar" name="area_code">
                        <option value="<?php echo $detail['store'][0]['area_code'] ?>"><?php echo $detail['store'][0]['area'] ?></option>
                    </select>
                    <input type="text" class="form-control w300 inline-block" placeholder="" name="full_address" value="<?php echo $detail['store'][0]['address'] ?>">
                </div>
            </div>
                <?php }?>
            <?php }?>
            <?php if($detail['merchant']['type'] == MERCHANT_TYPE_PP) { ?>
            <div class="form-group" id="pp">
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
                        </div>

                        <?php if(!empty($detail['store'])) {?>
                            <?php foreach ($detail['store'] as $v){?>
                        <div class="table_row">
                            <div class="table_cell"><?php echo $v['name'] ?></div>
                            <div class="table_cell"><?php echo $v['business_license_name'] ?></div>
                            <div class="table_cell"><?php echo $v['province'] ?></div>
                            <div class="table_cell"><?php echo $v['city'] ?></div>
                            <div class="table_cell"><?php echo $v['area'] ?></div>
                            <div class="table_cell"><?php echo $v['address'] ?></div>
                        </div>
                            <?php }?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
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
                            <div class="control-input">
                                <span>实际执行金额</span>
                                <?php $standard = json_decode($detail['goodsSku'][0]['merchant_standard_json']) ?>
                                <input type="text" class="form-control inline-block w48" placeholder="" id="standard_rate" name="standard_rate" value="<?php echo$standard[0]->rate ?>">
                                <span>%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> 保底费用</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30 inline-block" placeholder="" value="<?php echo  sprintf("%01.2f",$standard[0]->minimum_guarantee) ?>" id="standard_minmun_guarantee" name="standard_minmun_guarantee" data-content-id="standard_minmun_guarantee">
                                <span>元</span>
                                <p class="text-gray-light">当活动收费标准未达到保底价，按照保底费用收费</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $option = json_decode($detail['goodsSku'][0]['merchant_optional_json'])?>
            <?php if(!empty($option)){ ?>
            <div class="form-group">
                <label class="control-label"> 可选服务</label>
                <div class="control-input">
                    <div class="bg-gray-lighter p20">
                        <?php foreach ($option as $v) {?>
                            <?php if($v->type == 1){ ?>
                        <div class="form-group">
                            <div>
                                <label>
                                    <input type="checkbox" name="optional_test" id="optional_test" value="1" <?php if($v->type == 1){ echo 'checked';} ?>>
                                    <span>测试服务</span>
                                    <span>（在活动正式启动前，在指定商户门店用指定支付方式进行测试。把测试交易要素、账单上传平台。）</span>
                                </label>
                                <div>
                                    <input type="text" class="form-control inline-block w100" name="optional_test_price" id="optional_test_price" value="<?php  echo ($v->type == 1)?sprintf("%01.2f",$v->unit_price):'';?>">
                                    元/门店
                                </div>
                            </div>
                        </div>
                                <?php }?>
                        <?php if($v->type == 2){ ?>
                        <div class="form-group">
                            <div>
                                <label>
                                    <input type="checkbox" name="option_satify" id="option_satify" value="2" <?php if($v->type == 2){ echo 'checked';} ?>>
                                    <span>商户满意度回访</span>
                                    <span>（商户满意度报告上传平台。）</span>
                                </label>
                                <div>
                                    <input type="text" class="form-control inline-block w100" name="option_satify_price" id="option_satify_price" value="<?php  echo ($v->type == 2)?sprintf("%01.2f",$v->unit_price):'';?>">
                                    元/门店
                                </div>
                            </div>
                        </div>
                            <?php }?>
                        <?php }?>

                    </div>
                </div>
            </div>
            <?php }?>
        </div>


        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150" id="button" onclick="second()">下一步</button>
        </div>
    </div>

    <div class="m-content" style="display: none;" id="second">
        <div class="qgj-title">
            <div class="qgj-title_main">商户服务</div>
        </div>

        <div class="qgj-step">
            <ul class="btn-group">
                <li class="col-xs-6 btn"><a href="javascript:;">基本信息</a></li>
                <li class="col-xs-6 btn active"><a href="javascript:;">服务详情</a></li>
            </ul>
        </div>

        <div class="qgj-rich-text">
            <!--富文本-->
            <textarea name="content" id="container"><?php echo $detail['content'] ?></textarea>
        </div>

        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150 mr5" onclick="first()">上一步</button>
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



<script>
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