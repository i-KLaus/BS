'use strict';

/**
 * 首页
 */

$(function () {
    //时间选择
    util.layDate.getTime({
        elem: '#time1' //指定元素
    });
    util.layDate.getTime({
        elem: '#time2' //指定元素
    });

    //7天
    $(".js-seven-days").click(function () {
        $(this).parent().parent().prev().val(util.getDayRange(6));
        $(this).addClass("active").siblings().removeClass("active");
    });
    //30天
    $(".js-thirty-days").click(function () {
        $(this).parent().parent().prev().val(util.getDayRange(29));
        $(this).addClass("active").siblings().removeClass("active");
    });
});