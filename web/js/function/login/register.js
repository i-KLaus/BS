"use strict";

/**
 * 注册
 */

$(function () {
    //placeholder兼容浏览器的解决方案
    //documentMode:ie的特有属性
    if (navigator.appName == "Microsoft Internet Explorer" && (document.documentMode < 10 || document.documentMode == undefined)) {
        var $placeholder = $("input[placeholder]");
        for (var i = 0; i < $placeholder.length; i++) {
            $placeholder.eq(i).val($placeholder.eq(i).attr("placeholder"));
        }
        $placeholder.focus(function () {
            $(this).val("");
        }).blur(function () {
            $(this).val($(this).attr("placeholder"));
        });
    }
});