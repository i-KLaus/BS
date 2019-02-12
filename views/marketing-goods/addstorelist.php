<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 17:20
 */
?>

<!--<form action="store-upload.html" enctype="multipart/form-data" method="post">-->
<!--    <div class="form-group">-->
<!--        <label for="exampleInputFile">导入Excel表格</label>-->
<!--        <input type="file" name="file" id="exampleInputFile">-->
<!--    </div>-->
<!--    <button type="button" class="btn btn-default">提交</button>-->
<!--</form>-->
<form id="uploadForm" enctype="multipart/form-data">
    文件:<input id="file" type="file" name="file"/>
</form>
<button id="upload" type="button">确定</button>
<div class="js-store-table">

</div>
<script type="text/javascript">
    $(function () {
        $("#upload").click(function () {
            var formData = new FormData($('#uploadForm')[0]);
            $.ajax({
                type: 'post',
                url: "store-upload.html",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
            }).success(function (data) {
                $('.js-store-table').append(data);
            }).error(function () {
                alert("上传失败");
            });
        });
    });
</script>
