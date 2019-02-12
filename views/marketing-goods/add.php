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
                商户服务
            </div>
        </div>

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
                    <input type="text" class="form-control wper30" placeholder="" id="alias" name="alias">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商户名称</label>
                <div class="control-input">
                    <input type="text" class="form-control wper30" placeholder="" id="name" name="name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商户类别</label>
                <div class="control-input">
                    <select class="form-control wper30" name="industry" id="industry">
                        <option value="">全部分类</option>
                        <?php foreach ($GLOBALS['__GOODS_INDUSTRY_TYPE'] as $key => $val) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
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
                                    <input type="checkbox" class="qkj-checkbox ewm" name="ewm" id="ewm" value="1">
                                    <span>银联二维码</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type1" id="ewmzl" value="1">
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type1" id="ewmjl" value="2">
                                    <span>间连</span>
                                </label>
                                <input type="hidden" name="typefirst" id="typefirst" value="">
                            </div>
                        </div>
                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ylsf" name="ylsf" id="ylsf" value="2">
                                    <span>银联手机闪付</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type2" id="ylsfzl" value="1">
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type2" id="ylsfjl" value="2">
                                    <span>间连</span>
                                </label>
                                <input type="hidden" name="typesecond" id="typesecond" value="">
                            </div>
                        </div>
                        <div class="table_row">
                            <div class="table_cell text-left">
                                <label>
                                    <input type="checkbox" class="qkj-checkbox ylsk" name="ylsk" id="ylsk" value="3">
                                    <span>银联刷卡</span>
                                </label>
                            </div>
                            <div class="table_cell">
                                <label>
                                    <input type="radio" class="qkj-radio" name="type3" id="ylskzl" value="1">
                                    <span>直连</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="type3" id="ylskjl" value="2">
                                    <span>间连</span>
                                </label>
                                <input type="hidden" name="typethird" id="typethird" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 发票信息</label>
                <div class="control-input">
                    <div class="bg-gray-lighter p20">
                        <div class="form-group">
                            <label class="control-label"> 发票类型</label>
                            <div class="control-input">
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="pt_ticket" value="1">
                                    <span>增值税普通发票</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="zy_ticket" value="2">
                                    <span>增值税专用发票</span>
                                </label>
                                <label>
                                    <input type="radio" class="qkj-radio" name="ticket_type" id="no_ticket" value="3">
                                    <span>不开票</span>
                                </label>
                                <input type="hidden" id="ticket_type_id" name="ticket_type_id" value="">
                            </div>
                        </div>
                        <div id="ticket_info">
                            <div class="form-group tickhead">
                                <label class="control-label"> 发票抬头</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_invoice_title1">
                                </div>
                            </div>

                            <div class="form-group tickpeoplecode">
                                <label class="control-label"> 纳税人识别号</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_code1">
                                </div>
                            </div>




                            <div class="form-group tickhead2" style="display: none">
                                <label class="control-label"> 发票抬头</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_invoice_title">
                                </div>
                            </div>
                            <div class="form-group tickadd" style="display: none">
                                <label class="control-label"> 注册地址</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_address">
                                </div>
                            </div>
                            <div class="form-group tickpeoplecode2" style="display: none">
                                <label class="control-label tickpeoplecode2" style="display: none"> 纳税人识别号</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_code">
                                </div>
                            </div>
                            <div class="form-group ticktell" style="display: none">
                                <label class="control-label" > 发票打印电话</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_tel">
                                </div>
                            </div>
                            <div class="form-group tickbank" style="display: none">
                                <label class="control-label"> 基本户开户行</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_bank">
                                </div>
                            </div>
                            <div class="form-group tickbankbranck" style="display: none">
                                <label class="control-label"> 基本户开户支行</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_branch_bank">
                                </div>
                            </div>
                            <div class="form-group tickbankcode" style="display: none">
                                <label class="control-label"> 基本户银行帐号</label>
                                <div class="control-input">
                                    <input type="text" class="form-control wper30" placeholder="" name="ticket_bank_code">
                                </div>
                            </div>
                        </div>
                        <div id="no_ticket_msg" style="display: none">
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
                    <input type="text" class="form-control wper30" placeholder="" id="finance_contact" name="finance_contact">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 财务联系方式</label>
                <div class="control-input">
                    <input type="text" class="form-control wper30" placeholder="" id="finance_contact_info" name="finance_contact_info">
                </div>
            </div>
        </div>
        <div class="form-horizontal form-add">
            <div class="form-head"><span>商户门店</span></div>
            <div class="form-group">
                <label class="control-label"><em class="text-danger">*</em> 商户类型</label>
                <div class="control-input">
                    <label>
                        <input type="radio" class="qkj-radio" name="type" id="pptype" value="1">
                        <span>品牌商户</span>
                    </label>
                    <label>
                        <input type="radio" class="qkj-radio" name="type" id="sqtype" value="2">
                        <span>商圈/街区</span>
                    </label>
                    <input type="hidden" name="typee" id="typee" value="">
                </div>
            </div>
            <div class="form-group" id="sqselect" style="display: none">
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
            <div class="form-group" id="sq" style="display: none">
                <label class="control-label"><em class="text-danger">*</em> 门店地址</label>

                <div class="control-input">
                    <select class="form-control w100 inline-block" id="pr" name="province_code">
                        <option value="">请选择</option>
                        <?php if(!empty($province)){ ?>
                            <?php foreach ($province as $k=>$v) {?>
                        <option value="<?php echo $k ?>"><?php echo $v?></option>
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
                    <input type="text" class="form-control w300 inline-block" placeholder="" name="full_address" id="full_address">
                </div>
                <div class="control-input">
                    <input type="hidden" value="" name="check_city" id="check_city">
                </div>

            </div>
            <div class="form-group" id="pp" style="display: none">
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


                    </div>
                    <input type="hidden" name="store_data" id="store_data">
                    <div class="mt10">
                        <a href="javascript:;" class="btn btn-default js-add-store">添加门店</a>
<!--                        <a href="#modal" data-toggle="modal" class="btn btn-default js-add-batch-store">批量添加门店</a>-->

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
                            <div class="control-input">
                                <span>实际执行金额</span>
                                <input type="text" class="form-control inline-block w48" placeholder="" id="standard_rate" name="standard_rate">
                                <span>%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> 保底费用</label>
                            <div class="control-input">
                                <input type="text" class="form-control wper30 inline-block" placeholder="" id="standard_minmun_guarantee" name="standard_minmun_guarantee" data-content-id="standard_minmun_guarantee">
                                <span>元</span>
                                <p class="text-gray-light">当活动收费标准未达到保底价，按照保底费用收费</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label"> 可选服务</label>
                <div class="control-input">
                    <div class="bg-gray-lighter p20">
                        <div class="form-group">
                            <div>
                                <label>
                                    <input type="checkbox" name="optional_test" id="optional_test" value="1">
                                    <span>测试服务</span>
                                    <span>（在活动正式启动前，在指定商户门店用指定支付方式进行测试。把测试交易要素、账单上传平台。）</span>
                                </label>
                                <div>
                                    <input type="text" class="form-control inline-block w100" name="optional_test_price" id="optional_test_price">
                                    元/门店
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>
                                    <input type="checkbox" name="option_satify" id="option_satify" value="2">
                                    <span>商户满意度回访</span>
                                    <span>（商户满意度报告上传平台。）</span>
                                </label>
                                <div>
                                    <input type="text" class="form-control inline-block w100" name="option_satify_price" id="option_satify_price">
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
            <textarea name="content" id="container"></textarea>
        </div>

        <div class="ptb30 bg-white text-center">
            <button type="button" class="btn btn-primary w150 mr5" onclick="first()">上一步</button>
            <button type="submit" class="btn btn-primary w150 ml5">保存</button>
        </div>

    </div>
</form>
<!--<form id="uploadForm" enctype="multipart/form-data">-->
<!--    文件:<input id="file" type="file" name="file"/>-->
<!--</form>-->
<!--<button id="upload-store" type="button">确定</button>-->


<div class="modal fade" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">上传资料</h4>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
                文件:<input id="file" type="file" name="file"/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="modalBtn" data-dismiss="modal">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--规则选择弹出框-->
<div class="popover">
    <select class="js-example-basic-multiple js-states form-control subGoodsCategory" multiple="multiple">
    </select>
    <a href="javascript:;" class="btn btn-primary btn-popover-sure">确定</a>
    <a href="javascript:;" class="btn btn-default btn-popover-cancel">取消</a>
</div>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/marketing-goods/goodsForm.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/marketing-goods/goods.js'); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::getAlias('@web/js/function/marketing-goods/add.js'); ?>"></script>
<script>

    $(document).on("click",'.store-delete',function () {
        $(this).parent().parent().remove()
    });


    $('#zy_ticket').click(function () {
        $('.tickadd,.ticktell,.tickbank,.tickbankcode,.tickbankbranck,.tickhead,.tickpeoplecode,.tickhead2,.tickpeoplecode2').show()
        $('.tickhead,.tickpeoplecode').hide()
    })
    $('#pt_ticket').click(function () {
        $('.tickadd,.ticktell,.tickbank,.tickbankcode,.tickbankbranck,.tickhead2,.tickpeoplecode2').hide()
        $('.tickhead,.tickpeoplecode').show()
    })
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

    //不开票
    $('#no_ticket').click(function () {
        $('#ticket_info').hide();
        $('#no_ticket_msg').show();
    })
    $('#pt_ticket,#zy_ticket').click(function () {
        $('#ticket_info').show();
        $('#no_ticket_msg').hide();
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

    //省市区下拉框  商圈类
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
    $('.js-store-table').find('.store_list').each(function (innd,vall) {
        count_store = count_store+1;
    })

    //品牌商户类 门店列表添加
  $('.js-add-store').click(function () {
      $.ajax({
          'type': 'get',
          'url': '<?php echo Url::to(['marketing-goods/get-pca']); ?>',
          'data': {'num': count_store},
          'success': function (data) {
              $('.js-store-table').append(data);
              count_store = count_store+1;
          }
      })

  })
    $(function () {
        $("#modalBtn").click(function () {
            var formData = new FormData($('#uploadForm')[0]);
            formData.append("num",count_store)
            $.ajax({
                'type': 'post',
                'url': "<?php echo Url::to(['store-upload']) ?>",
                'data': formData,count_store,
                'cache': false,
                'processData': false,
                'contentType': false,
                'success':function (data) {
                    $('.js-store-table').append(data);
                    $('.js-store-table').find('.store_list').each(function (innd,vall) {
                        count_store = count_store+1;
                    })
                }
            });
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
