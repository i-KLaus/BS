<?php
use app\common\util\page;
use yii\helpers\Url;
?>

<div class="main-con">
    <div class="main-content" id="mainContent">
        <nav class="navbar">
            <div class="navbar_header"><a href="#">优选运营平台</a></div>
            <div class="navbar_collapse">
                <ul class="navbar_nav navbar--right">
                    <li><a href=""><i class="icon-user h4"></i> 用户名</a></li>
                    <li><a href=""><i class="icon-loginout h4"></i> 退出</a></li>
                </ul>
            </div>
        </nav>
        <div class="m-content">
            <div class="qgj-title">
                <div class="qgj-title_main">需求方管理</div>
            </div>
            <div class="form-horizontal qgj-form-search">
                <div class="row">

                    <div class="form-group col-md-3">
                        <form class="form-inline" action="<?php \yii\helpers\Url::to(['demand/pass'])?>" method="get">
                            <div class="input-group">
                                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                <input type="text" class="form-control bg-gray-lighter wper100" placeholder="搜索" id="key" name="key">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="icon-search"></i></button>
                            </span>
                            </div>
                        </form>
                    </div>



                </div>
                <div class="qgj-nav mt10">
                    <div class="btn-group">
                        <a class="btn btn-default <?php echo ($idx==null)? 'active':''?>"href="list?idx=0">全部</a>
                        <a class="btn btn-default <?php echo ($idx==1)? 'active':''?>"href="list?idx=1" >待审核</a>
                        <a class="btn btn-default <?php echo ($idx==2)? 'active':''?>"href="list?idx=2">待银联审核</a>
                        <a class="btn btn-default <?php echo ($idx==3)? 'active':''?>"href="list?idx=3">已通过</a>
                        <a class="btn btn-default <?php echo ($idx==4)? 'active':''?>"href="list?idx=4">驳回</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-special">
                    <thead>
                    <tr>
                        <th>需求方编号</th>
                        <th>需求方名称</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($res as $v):?>
                        <tr>
                            <td><?php echo $v['code'] ?></td>
                            <td><?php echo $v['name'] ?></td>
                            <td><?php if($v['status']==1){
                                    echo "待审核";
                                }elseif($v['status']==3){
                                    echo "通过";
                                }elseif($v['status']==2){
                                    echo "待银联审核";
                                }elseif($v['status']==4){
                                    echo "驳回";}?></td>
                            <td><?php echo $v['create_time'] ?></td>

                            <td>
                                <a href="pass?idx=0&id=<?php echo $v['id'] ?>" class="text-blue ml10">
                                    <?php  if($v['status']=='2'||$v['status']=='1'){
                                        echo "通过";}else{
                                        echo str_repeat('&nbsp;',8);}?>
                                </a>
                                <a href="#" class="text-blue ml10 js-reject" data-id="2" id="rej" realid="<?php echo $v['id'] ?>">
                                    <?php  if($v['status']=='3'||$v['status']=='2'||$v['status']=='1'){
                                        echo "驳回";}else{
                                        echo str_repeat('&nbsp;',8);}?>
                                </a>
                                <a href="#" class="text-blue ml10">详情</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <?php if (empty($res)){?>
                    <div class="text-center h5 ptb15 bg-white">暂时无数据</div>
                <?php }?>

                <?php if (!empty($res)){ ?>
                    <?php if ($total > $pages) {
                        $page = new page($total, $pages, $page, Url::to(['list']) . '?page={page}', 2, $_GET);
                        echo $page -> myde_write();
                    } ?>
                <?php } ?>

                <!--        <div class="page">-->
                <!--            <a href="javascript:;" class="prev disabled"></a>-->
                <!--            --><?php //foreach($pages as $v): ?>
                <!--            <a href="javascript:;">$v</a>-->
                <!--            --><?php //endforeach;?>
                <!--            <p class="page-remark">...</p>-->
                <!--            <a href="javascript:;" class="next"></a>-->
                <!--            <div class="skip">-->
                <!--                <span>前往</span>-->
                <!--                <input type="text" value="1">-->
                <!--                <span>页</span>-->
                <!--            </div>-->
                <!--        </div>-->
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        layui.use('layer', function () {
            var layer = layui.layer;
            //反驳理由


            $(".js-reject").click(function () {
                var realid=($(this).attr("realid"));
                var id = $(this).attr("data-id");

                layer.prompt({ title: '驳回理由', formType: 2,value:''}, function (value,pass, index) {

                    //提交内容
                    $.ajax({
                        type : "POST",
                        url : "reject",
                        dataType:"json",
                        data :{'realid':realid,'value':value},
                        success : function(data) {
                            if (data.status == true){
                                layer.msg('驳回成功',function () {
                                    window.location.reload();
                                });
//                                    alert("驳回成功！");
//                                    window.location.reload();
                            }else{
                                //todo 报错
                                layer.msg('驳回失败',function () {
                                    window.location.reload();
                                });
                            }

                        },
                        error: function (err) {
                            alert("提交失败,请稍后再试");
                        }
                    });

                    layer.close(index);
                });
            });
        });
    });
</script>