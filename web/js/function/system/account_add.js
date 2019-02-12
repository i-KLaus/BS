"use strict";

/**
 * 添加子账号
 */

$(function () {
    $(".js-treeAccount li").click(function (e) {
        var $ul = $(this).find(">ul");
        if ($ul.length && $ul.is(":visible")) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }
        e.stopPropagation();
    });
});