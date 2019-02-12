

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
                <div class="qgj-title_main">服务商品</div>
                <p></p>
            </div>
            <div class="form-horizontal qgj-form-search form-search-md">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="control-label">服务分类</label>
                        <div class="control-input">
                            <select class="form-control select1">
                                <?php foreach ($res as $v):?>
                                <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label ">二级分类</label>
                        <div class="control-input">
                            <select class="form-control select2">
                                <option class="op2" value="">全部分类</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="control-input">
                            <div class="input-group w150">
                                <input type="text" class="form-control bg-gray-lighter" placeholder="搜索">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="icon-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="qgj-nav mt10">
                    <a class="btn btn-primary active">添加分类</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-special">
                    <thead>
                    <tr>
                        <th>服务商编号</th>
                        <th>服务商名称</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>126868957</td>
                        <td>服务商名称</td>
                        <td>待审核</td>
                        <td>2018-04-12 15:23</td>
                        <td>
                            <a href="#" class="text-blue mb5">通过</a>
                            <a href="#" class="text-blue mb5">驳回</a>
                            <a href="detail.html" class="text-blue mb5">详情</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center h5 ptb15 bg-white">暂时无数据</div>
                <div class="page">
                    <a href="javascript:;" class="prev disabled"></a>
                    <a href="javascript:;" class="active">1</a>
                    <a href="javascript:;">2</a>
                    <a href="javascript:;">3</a>
                    <a href="javascript:;">4</a>
                    <a href="javascript:;">5</a>
                    <a href="javascript:;">6</a>
                    <p class="page-remark">...</p>
                    <a href="javascript:;" class="next"></a>
                    <div class="skip">
                        <span>前往</span>
                        <input type="text" value="1">
                        <span>页</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function(){
        $(".select1").bind("change",function(){
            var id=($(this).val());
//            alert(id);
            $.ajax({
                type: "POST",//提交方式
                url: "ajaxform",//提交的页面
                dataType: "json",//数据格式
                data: {"id":id}, //提交的数据
                success: function(data)
                {
                    $(".op2").remove();
                    $(".select2").append("<option class='op2' value='0'>-请选择-</option>");
                    if (data != 0) {
                        for ( var i = 0; i < data.length; i++) {
                            var id2 = data[i].id;
                            var Name = data[i].name;
                            $(".select2").append(
                                "<option class='op2'   value="+id2+">"
                                + Name + "</option>");
                        }
                    }

                },
                error: function (err) {
                    alert("提交失败,请稍后再试");
                }
            });
        })
    })
</script>