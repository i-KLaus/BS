<?php
use yii\helpers\Url;
use app\components\widgets\common\IndexTitleWidget;
$this->title='账号管理';
?>
<?php echo IndexTitleWidget::widget(); ?>
        <div class="m-content">
            <div class="qgj-title">
                <div class="qgj-title_main">
                    账号管理
                </div>
            </div>
            <!--主账号显示部分-->
            <div class="table-responsive">
                <?php if(Yii::$app->session->get('is_admin') == ACCOUNT_IS_ADMIN_YES){?>
                <div class="qgj-nav mb0">
                    <div class="left-line left-line--indent left-line--blue mt20">你的账号</div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th width="20%">名称</th>
                        <th width="20%">账号</th>
                        <th width="20%">类型</th>
                        <th width="20%">创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $account -> name;?></td>
                            <td><?php echo $account -> account;?></td>
                            <td>主账号</td>
                            <td><?php echo $account -> create_time;?></td>
                            <td><a id="<?php echo $account -> id;?>" href="<?php echo Url::to(['account/edit-pwd','id'=> $account -> id]); ?>#modalModifyPsd" data-toggle="modal" class="text-blue mr10 changeAjax" >修改密码</a></td>
                        </tr>
                    </tbody>
                </table>
                <!-- 子账号显示部分 -->

                    <div class="qgj-nav mb0 mt50">
                        <div class="pull-right mb5"><a href="<?php echo Url::to(['account/add']);?>" class="btn btn-primary mr20">添加子账号</a></div>
                        <div class="left-line left-line--indent left-line--blue w300">其他账号</div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="20%">名称</th>
                            <th width="20%">账号</th>
                            <th width="20%">类型</th>
                            <th width="20%">创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($sub_account)) { ?>
                            <?php foreach($sub_account as $k=>$v){?>
                                <tr>
                                    <td><?php echo $v -> name;?></td>
                                    <td><?php echo $v -> account?></td>
                                    <td>子账号</td>
                                    <td><?php echo $v -> create_time;?></td>
                                    <td>
                                        <a id="<?php echo $v -> id;?>" href="<?php echo Url::to(['account/delete','id'=>$v -> id]); ?>#modalDel" data-toggle="modal" class="text-blue mr10">删除</a>
                                        <a href="<?php echo Url::to(['account/edit','id'=>$v -> id]); ?>" class="text-blue mr10">编辑</a>
                                        <a id="<?php echo $v -> id;?>" href="<?php echo Url::to(['account/edit-pwd','id'=>$v -> id]); ?>#modalModifyPsd" data-toggle="modal" class="text-blue mr10 changeAjax" >修改密码</a>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php }else{?>
                    <div class="qgj-nav mb0">
                        <div class="left-line left-line--indent left-line--blue mt20">你的账号</div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="20%">名称</th>
                            <th width="20%">账号</th>
                            <th width="20%">类型</th>
                            <th width="20%">创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $sub_account -> name;?></td>
                                <td><?php echo $sub_account -> account;?></td>
                                <td>子账号</td>
                                <td><?php echo $sub_account -> create_time;?></td>
                                <td><a id="<?php echo $sub_account -> id;?>" href="<?php echo Url::to(['account/edit-pwd','id'=>$sub_account -> id]); ?>#modalModifyPsd" data-toggle="modal" class="text-blue mr10 changeAjax">修改密码</a></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>

        </div>


<!--修改密码弹出框-->
<form id="formdata">
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <input id="changeId" type="hidden" name="id" value="">
    <div class="modal fade" id="modalModifyPsd">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button id="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal form-add_textleft">
                    <div class="form-group">
                        <label class="control-label">账号</label>
                        <div id="account" class="control-input"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">账号名称</label>
                        <div id="name" class="control-input"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">你的登录密码</label>
                        <div class="control-input"><input type="password" id="pwd" name="pwd" class="form-control w200"><span id="tips"></span></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">新登录密码</label>
                        <div class="control-input"><input type="password" id="password" name="password" class="form-control w200"><span></span></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">确认登录密码</label>
                        <div class="control-input"><input type="password" id="confirm_password" name="confirm_password" class="form-control w200"><span></span></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input  id="btnModifyPsd" class="submit btn btn-primary w150" type="submit" value="保存">
            </div>

        </div>
    </div>
</div>
</form>
<!--删除弹出框-->

<div class="modal fade" id="modalDel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">删除信息</h4>
            </div>
            <div class="modal-body">
                <div class="text-center ptb30">
                    <div class="text-blue h4Half mb15">删除此信息？</div>
                    <div class="text-gray-light h6">删除操作不可恢复</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnDel">确认</button>
                <button type="button" class="btn btn-no" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#closeModal").click(function () {
            $("#pwd").val("");
            $("#password").val("");
            $("#confirm_password").val("");
            $("#tips").html("");
            $("#password-error").remove();
            $("#confirm_password-error").remove();
        });
    });

    $(function () {
        var id;
        $('a').click(function () {
            id = $(this).attr("id");
            document.getElementById('changeId').value=id;
        });
        $('#btnDel').click(function(){
           $.ajax({
               url:"<?php echo Url::to(['account/delete']);?>",
               type:'post',
               dataType:'json',
               data:{'id':id,'_csrf':"<?= Yii::$app->request->csrfToken ?>"},
               success:function(data){
                   if(data.status){
                       window.document.location.href="<?php echo Url::to(['account/list']);?>";
                   }else {
                       alert(data.info);
                       window.document.location.href="<?php echo Url::to(['account/list']);?>";
                   }
               }
           });
        });
    });

    $(function () {
       $(".changeAjax").click(function () {
           var  id = this.id;
           $.ajax({
               url:"<?php echo Url::to(['account/change-ajax']);?>",
               type:'post',
               dataType:'json',
               data:{'id':id,'_csrf':"<?= Yii::$app->request->csrfToken ?>"},
               success:function (data) {
                   $('#account').html(data.account);
                   $('#name').html(data.name);
               }
           });
       });
    });

    $(function () {
        $("#btnModifyPsd").click(function(){
            var datas = $('#formdata').serialize();
            $.ajax({
                url:"<?php echo Url::to(['account/edit-pwd']);?>",
                type:'post',
                dataType:'json',
                data:datas,
                success:function(data){
                    if(data.status) {
                        alert(data.info);
                    }
                }
            });
        });

        $("#pwd").keyup(function(){
            var datas = $('#formdata').serialize();
            $.ajax({
                url:"<?php echo Url::to(['account/ajax-check-pwd']);?>",
                type:'post',
                dataType:'json',
                data:datas,
                success:function(data){
                    if(data.status == 1){
                        $('#tips').html(data.info).css("color","green");
                    }else{
                        $('#tips').html(data.info).css("color","red");
                    }
                }
            });
        });
    });

    $.validator.setDefaults({
        submitHandler: function() {
            window.document.location.href = "<?php echo Url::to(['account/list'])?>";
        }
    });

    $().ready(function() {
        $("#formdata").validate({
            rules: {
                password: {
                    required: true,
                    rangelength:[6,16],
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
            },
            messages: {
                password: {
                    required: "请输入密码",
                    rangelength: "密码长度为6-16位"
                },
                confirm_password: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 5 个字母",
                    equalTo: "两次密码输入不一致"
                },
            }
        })
    });
</script>

<style>
    .error{
        color:red;
    }
</style>
