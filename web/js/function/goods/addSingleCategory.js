'use strict';

/**
 * 添加
 */

/**
 * 获取URL参数
 * @param name
 * @returns {null}
 * @constructor
 */
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}

//添加规则
(function (window, $, undefined) {
    var specification = function specification(options) {
        var settings = $.extend({
            click: ''
        }, options);

        this.init(settings);
    };

    specification.prototype = {
        //存放初始值对象
        init: function init(opts) {
            var _this = this,
                templateSku = '',
                skuBdList = '',
                skuArr = [],
                goodsSetHtml = '',
                //存放已有的sku数组;
            selectValue; //获取当前选中属性下拉框的值

            $(".js-example-basic-single").select2();

            //当回车时往select2里里面增值
            $(document).on('keyup', "input.select2-search__field", function (e) {
                //获得当前打开状态的select对象
                var select = $(".select2.select2-container--open").prev(),
                    //获得规则的select对象
                    categoryName = $(this).val(),
                    categoryPID = $('.goodsCategory').find('option:selected').val(),
                    //获取输入的值
                    url = '',
                    postData = '';

                //如果是属性下拉框
                if (select.hasClass('js-example-basic-single')) {
                    url = '/goods/add-goods-category.html';
                    postData = { name: categoryName};
                } else {
                    //如果是sku
                    url = '/goods/add-sub-goods-category.html';
                    postData = { name: categoryName, pid: categoryPID };
                }

                //回车添加新内容
                if (categoryName && select && e.keyCode == 13) {
                    $.ajax({
                        'url': url,
                        'type': 'get',
                        'async': false,
                        'data': postData,
                        'dataType': 'json',
                        'success': function success(redata) {
                            //往select2里插值
                            //如果是规则
                            if (select.hasClass('js-example-basic-single')) {
                                select.append(new Option(redata.name, redata.id, false, true));
                                getSubGoodsCategory();
                                $(".js-sku-bd-list").html('');
                                $('.goodsSetTbody').html('<tr><td>'+$('.goodsCategory').find('option:selected').text()+'</td><td>价格(元)</td></tr>');
                            }
                            //如果是sku
                            else {
                                    select.append(new Option(redata.name, redata.id, false, true));
                                }
                            //关闭
                            select.select2("close");
                            select.parents('.js-sku-sub-group').find('.js-add-sku').removeClass('hide'); //显示添加sku按钮
                        }
                    });
                }
            });

            //规则改变后清空之前的添加的sku
            $(document).on('change', ".js-example-basic-single", function (e) {
                $(".js-sku-bd-list").html('');
                getSubGoodsCategory();
                $('.goodsSetTbody').html('<tr><td>'+$('.goodsCategory').find('option:selected').text()+'</td><td>价格(元)</td></tr>');
            });

            //添加单个sku
            $(document).on('click', ".js-add-sku", function (e) {
                selectValue = $(".js-example-basic-single").find("option:selected").val(); //获取当前select选中项的索引值

                _this.popover($(this));
                skuBdList = $(this).prev();

                //把已有的值存入数组
                skuArr = []; //清空sku数组
                _this.storeSkuArr(skuBdList, skuArr);
                $(".js-example-basic-multiple").select2().val(null).trigger("change"); //清除已选项
            });
            //删除单个sku
            $(document).on('click', opts.deleteSkuItem, function (e) {
                var id = $(this).parent().find('input[name="categorys_property[]"]').val();
                $('.goodsSetTbody').find('tr[data-id="'+id+'"]').remove();

                $(this).parent().remove();
                //重新把已有的值存入数组
                skuArr = []; //清空sku数组
                _this.storeSkuArr($(this).parents('.js-sku-bd-list'), skuArr);
            });

            //sku选择弹出框 确认按钮
            $(document).on('click', ".btn-popover-sure", function (e) {
                var data = $(".js-example-basic-multiple").select2('data'),
                    flag = false;

                //判断添加的数据是否重复，不重复就添加，重复就不添加
                for (var i = 0; i < data.length; i++) {
                    flag = _this.contains(skuArr, data[i].text);
                    if (!flag) {
                        templateSku += '<div class="sku-item"><span>' + data[i].text + '</span> <a href="javascript:;" class="close close-bg js-delete-sku-item">×</a><input name="categorys_property[]" value="' + data[i].id + '" type="hidden"></div>';
                        goodsSetHtml += '<tr class="goodsData" data-id="'+ data[i].id +'"><td>'+data[i].text+'</td><td><input type="text" name="price" value="" class="table-input" maxlength="7"></td></tr>';
                    } else {
                        layer.msg('值重复，请重新选择');
                    }
                }
                skuBdList.append(templateSku);
                $('.goodsSetTbody').append(goodsSetHtml);
                $(this).parent().hide(); //隐藏sku选择弹出框
                templateSku = '';
                goodsSetHtml = '';
            });
            //sku选择弹出框 取消按钮 点击
            $(document).on('click', ".btn-popover-cancel", function (e) {
                $(this).parent().hide();
            });
        },
        popover: function popover(element) {
            //sku弹出框
            var position = element.position();
            var popover = $(".popover");
            popover.show().css({
                left: position.left - popover.outerWidth() / 2,
                top: position.top + element.outerHeight() + 72
            });
        },
        storeSkuArr: function storeSkuArr(element, arr) {
            //储存每个规格里已有的sku
            var sku = element.children();
            if (sku.length) {
                sku.each(function () {
                    arr.push($(this).find("span").text());
                });
            }
        },
        contains: function contains(arr, obj) {
            //判断某个对象是否在数组里
            var i = arr.length;
            while (i--) {
                if (arr[i] === obj) {
                    return true;
                }
            }
            return false;
        }
    };

    window.specification = window.specification || specification;
})(window, jQuery);