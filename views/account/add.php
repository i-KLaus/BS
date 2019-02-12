<?php
use \yii\helpers\Url;
use yii\helpers\Html;
use app\components\widgets\common\IndexTitleWidget;
$this->title='添加子账号';
?>
<?php echo IndexTitleWidget::widget(); ?>
        <div class="m-content">
            <div class="qgj-title">
                <div class="qgj-title_main">
                    <a href="<?php echo Url::to(['account/list']);?>" class="back"><i class="layui-icon">&#xe603;</i>返回</a>
                    账号管理-添加子账号
                </div>
            </div>
            <?php echo Html::beginForm(['add'], 'post', array('id' => 'formdata','role'=>'form'));?>
            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <input type="hidden" name="id" value="">
            <div class="pt15 pb30">
                <div class="left-line left-line--indent left-line--blue mb10">账户信息</div>
                <div class="form-horizontal pl10">
                    <div class="form-group">
                        <label class="control-label text-right">邮箱账号</label>
                        <div class="control-input pl-control-input"><input name="account" type="text" class="form-control w200"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-right">账号名称</label>
                        <div class="control-input pl-control-input"><input name="name" type="text" class="form-control w200"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label text-right">初始密码</label>
                        <div class="control-input pl-control-input"><input id="pwd" name="pwd" type="password" class="form-control w200"></div>
                    </div>
                </div>
            </div>

            <div class="pt15 pb30 border-t">
                <div class="left-line left-line--indent left-line--blue mb10">授权管理</div>
                <div class="tree_account pl30 js-treeAccount">
                    <ul>
                        <li>
                            <a href="javascript:;"><i class="tree-icon_arrow"></i> 服务管理</a>
                            <ul>
                                <li>
                                    <label><input name="right[]" value="<?php echo RIGHT_MARKETING_GOODS;?>" type="checkbox" class="qkj-checkbox"> 商户营销</label>
                                </li>
                                <li>
                                    <label><input name="right[]" value="<?php echo RIGHT_GOODS;?>" type="checkbox" class="qkj-checkbox"> 服务商品</label>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="tree-icon_arrow"></i> 订单管理</a>
                            <ul>
                                <li>
                                    <label><input name="right[]" value="<?php echo RIGHT_ORDER;?>" type="checkbox" class="qkj-checkbox"> 全部订单</label>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="tree-icon_arrow"></i> 系统设置</a>
                            <ul>
                                <li>
                                    <label><input name="right[]" value="<?php echo RIGHT_SERVICE_DETAIL;?>" type="checkbox" class="qkj-checkbox"> 服务商信息</label>
                                </li>
                                <li>
                                    <label><input name="right[]" value="<?php echo RIGHT_ACCOUNT;?>" type="checkbox" class="qkj-checkbox"> 账号管理</label>
                                </li>
                            </ul>
                        </li>
                        <input type="hidden" name="right_error">
                    </ul>
                </div>
            </div>

            <div class="btn-wrap text-center mt50 mb20">
                <input type="button" id="save" value="授权保存" class="submit btn btn-md btn-primary w200"/>
            </div>
            <?php echo Html::endForm();?>
        </div>

<script src="<?php echo Yii::getAlias('@web/js/function/system/account_add.js'); ?>"></script>

<script>
    $('#save').click(function () {
        $("#formdata").submit();
    });

    $.validator.addMethod("checkRight",function(value,element,params){
        var right = $('input[name="right[]"]:checked').val();
        if (right) {
            return true;
        }
        return false;
    },"至少选择一个权限");
    $().ready(function() {
        $("#formdata").validate({
        rules: {
            account: {
                required: true,
                maxlength:30,
                email:true,
                remote: {
                    url: 'check-account.html',
                    type: 'get',
                    data: {
                        id: function() {
                            return $('input[name="id"]').val();
                        },
                        account: function() {
                            return $('input[name="account"]').val();
                        }
                    },
                    dataFilter: function (data) {
                        if (data == true) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            name: {
                required: true,
                maxlength:20,
            },
            pwd: {
                required: true,
                rangelength:[6,16],
            },
            right_error: {
                checkRight: true
            }
        },
        messages: {
            account: {
                required: "请输入账号",
                maxlength: "账号长度不能大于30",
                email:"请输入正确的邮箱",
                remote: '您输入的账号已存在'
            },
            name: {
                required: "请输入账号名称",
                maxlength: "账号名称长度不能大于20",
            },
            pwd: {
                required: "请输入密码",
                rangelength: "密码长度为6-16位",
            }
        },
            ignore: ''
    })
    });
</script>

<style>
.error{
    color:red;
}
</style>