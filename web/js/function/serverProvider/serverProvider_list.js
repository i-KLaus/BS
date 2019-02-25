"use strict";

/**
 * 运营服务商管理
 */

$(function () {
    layui.use('layer', function () {
        var layer = layui.layer;
        //反驳理由

        $(".js-reject").click(function () {
            var id = $(this).attr("data-id");

            layer.prompt({ title: '驳回理由', formType: 2 }, function (pass, index) {
                //提交内容


                layer.close(index);
            });
        });
    });
});