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


//添加规则
(function (window, $, undefined) {
    var specification = function specification(options) {
        var settings = $.extend({}, options);

        this.init(settings);
    };

    specification.prototype = {
        //存放初始值对象
        init: function init(opts) {
            var _this = this,
                templateSku = '',
                skuBdList = '',
                skuArr = [],
                //存放已有的sku数组;
                selectValue; //获取当前选中属性下拉框的值

            //初始化
            $(".js-example-basic-single").select2();

            _this.isShowsSpec(opts.addSkuGroup); //添加规格按钮

            //当回车时往select2里里面增值
            $(document).on('keyup', "input.select2-search__field", function (e) {
                //获得当前打开状态的select对象
                var select = $(".select2.select2-container--open").prev();
                    //获得规则的select对象
                var categoryName = $(this).val(),
                    categoryPID = $('.goodsCategory' + select.attr("data-index")).find('option:selected').val(),

                    //获取输入的值
                    url = '',
                    postData = '';

                //如果是属性下拉框
                if (select.hasClass('js-example-basic-single')) {
                    url = '/goods/add-goods-category.html';
                    postData = { name: categoryName };
                    getSubGoodsCategory(select.attr("data-index"));
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
                                getSubGoodsCategory(select.attr("data-index"));
                                $(".js-sku-bd-list1").html('');
                                _this.createTable();
                            } else {
                                //如果是规格
                                select.append(new Option(redata.name, redata.id, false, true));
                            }
                            //关闭
                            select.select2("close");
                            select.parents('.js-sku-sub-group').find('.js-add-sku').removeClass('hide'); //显示添加sku按钮
                        }
                    });
                }
            });

            //sku选择弹出框 取消按钮 点击
            $(document).on('click', ".btn-popover-cancel", function (e) {
                $(this).parent().hide();
            });

            //规则改变后清空之前的添加的sku
            $(document).on('change', ".js-example-basic-single", function (e) {
                //清空原来已有的
                if (e.target.dataset.index == 1) {
                    $(".js-sku-bd-list" + e.target.dataset.index).html('');
                } else {
                    $(".js-sku-bd-list" + e.target.dataset.index).html('');
                }
                getSubGoodsCategory($(this).attr("data-index"));
                _this.isShowsSpec(opts.addSkuGroup); //添加规格按钮
                _this.createTable(); //新建表格
            });
            //删除sku组
            $(document).on('click', ".js-sku-sub-group-del", function (e) {
                $(this).parent().parent().hide(); //删除当前选项
                $(".js-sku-bd-list2").html(''); //清空原来已有的
                _this.isShowsSpec(opts.addSkuGroup); //添加规格按钮
                _this.createTable(); //新建表格
            });
            //删除单个sku
            $(document).on('click', opts.deleteSkuItem, function (e) {
                var id = $(this).parent().find('input[name="categorys_property[]"]').val();

                $(this).parent().remove(); //删除当前选项
                skuArr = []; //清空sku数组
                _this.storeSkuArr($(this).parent().parent(), skuArr); //重新存储已存在的项
                _this.isShowsSpec(opts.addSkuGroup); //添加规格按钮
                _this.createTable(); //生成表格
            });

            ///////////////////规则添加内容///////////////////
            //添加单个sku
            $(document).on('click', ".js-add-sku1", function (e) {
                selectValue = $(".js-example-basic-single").find("option:selected").val(); //获取当前select选中项的索引值
                _this.popover($(this), 1);
                skuBdList = $(this).prev();

                //把已有的值存入数组
                skuArr = []; //清空sku数组
                _this.storeSkuArr(skuBdList, skuArr);
                $(".js-example-basic-multiple1").select2().val(null).trigger("change"); //清除已选项
            });
            //sku选择弹出框 确认按钮
            $(document).on('click', ".btn-popover-sure1", function (e) {
                var data = $(".js-example-basic-multiple1").select2('data'),
                    flag = false;

                //判断添加的数据是否重复，不重复就添加，重复就不添加
                for (var i = 0; i < data.length; i++) {
                    flag = _this.contains(skuArr, data[i].text);
                    if (!flag) {
                        templateSku += '<div class="sku-item"><span>' + data[i].text + '</span> <a href="javascript:;" class="close close-bg js-delete-sku-item">×</a><input name="categorys_property[]" value="' + data[i].id + '" type="hidden"></div>';
                    } else {
                        layer.msg('值重复，请重新选择');
                    }
                }
                skuBdList.append(templateSku);
                _this.isShowsSpec(opts.addSkuGroup); //添加规格按钮
                _this.createTable(); //生成表格
                $(this).parent().hide(); //隐藏sku选择弹出框
                templateSku = '';
            });

            //////////////////规格添加内容//////////////////
            // 添加单个规格
            $(document).on('click', ".js-add-sku2", function (e) {
                _this.popover($(this), 2);
                skuBdList = $(this).prev();

                //把已有的值存入数组
                skuArr = []; //清空sku数组
                _this.storeSkuArr(skuBdList, skuArr);
                $(".js-example-basic-multiple2").select2().val(null).trigger("change"); //清除已选项
            });
            //sku选择弹出框 确认按钮
            $(document).on('click', ".btn-popover-sure2", function (e) {
                var data = $(".js-example-basic-multiple2").select2('data'),
                    flag = false;

                //判断添加的数据是否重复，不重复就添加，重复就不添加
                for (var i = 0; i < data.length; i++) {
                    flag = _this.contains(skuArr, data[i].text);
                    if (!flag) {
                        templateSku += '<div class="sku-item"><span>' + data[i].text + '</span> <a href="javascript:;" class="close close-bg js-delete-sku-item">×</a><input name="categorys_property[]" value="' + data[i].id + '" type="hidden"></div>';
                    } else {
                        layer.msg('值重复，请重新选择');
                    }
                }
                skuBdList.append(templateSku);
                _this.createTable(); //生成表格
                $(this).parent().hide(); //隐藏sku选择弹出框
                templateSku = '';
            });
            //添加规格 点击后
            $(opts.addSkuGroup).click(function () {
                $(this).hide().prev().show();
                getSubGoodsCategory(2);
            });
        },
        isShowsSpec: function isShowsSpec(addSkuGroup) {
            //是否显示添加规格
            var $addSkuGroup = $(addSkuGroup);
            var $skuSubGroup2 = $(".js-sku-sub-group").eq(1);

            //规格是否已选
            if ($(".js-sku-bd-list1").children().length > 0) {
                //规则是否显示
                if (!$skuSubGroup2.is(":visible")) {
                    $addSkuGroup.show();
                }
            } else {
                //隐藏添加规则和清空之前已选的规则
                $addSkuGroup.hide();
                $skuSubGroup2.hide().find(".js-sku-bd-list2").html();
            }
        },
        popover: function popover(element, index) {
            //sku弹出框
            var position = element.position();
            var popover = $(".js-popover" + index);
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
        createTable: function createTable(arr1, arr2) {
            var goodsSetHtml = '',
                //存table的模板
                $skuItem1 = $(".js-sku-bd-list1 .sku-item"),
                //规则对象里的已选子集
                $skuItem2 = $(".js-sku-bd-list2 .sku-item"),
                //规格对象里的已选子集
                $skuSubGroup2 = $(".js-sku-sub-group").eq(1),
                //规格对象
                $goodsSetThead = $(".goodsSetThead"),
                //表格thead 对象
                _goodsCategoryText1 = $('.goodsCategory1').find('option:selected').text(),
                //规则选择框对象
                _goodsCategoryText2 = $('.goodsCategory2').find('option:selected').text(); //规则选择框对象

            //判断规则是否存在
            if ($skuItem1.length > 0) {
                //循环规则选中的项
                $skuItem1.each(function () {
                    var self = $(this);
                    //如果规格存在则执行下面内容
                    if ($skuItem2.length > 0) {
                        goodsSetHtml += '<tr class="goodsData"><td rowspan="' + $skuItem2.length + '">' + $(this).find("span").html() + '</td>';

                        $skuItem2.each(function (i) {
                            if (i == 0) {
                                goodsSetHtml += '<td>' + $(this).find("span").html() + '<input type="hidden" name="id" value="' + self.find("input").val() + "," + $(this).find("input").val() + '"></td><td><input type="text" name="price" value="" class="table-input" maxlength="7"></td></tr>';
                            } else {
                                goodsSetHtml += '<tr class="goodsData"><td>' + $(this).find("span").html() + '<input type="hidden" name="id" value="' + self.find("input").val() + "," + $(this).find("input").val() + '"></td><td><input type="text" name="price" value="" class="table-input" maxlength="7"></td></tr>';
                            }
                        });
                    } else {
                        goodsSetHtml += '<tr class="goodsData"><td>' + $(this).find("span").html() + '<input type="hidden" name="id" value="' + self.find("input").val() + '"></td><td><input type="text" name="price" value="" class="table-input" maxlength="7"></td>';
                    }
                });
            }

            //如果添加规格显示，且表格头部未添加“规格”,则把规格添加到头部上去
            if ($skuItem2.length > 0) {
                $goodsSetThead.html('<tr><td>' + _goodsCategoryText1 + '</td><td class="sign">' + _goodsCategoryText2 + '</td><td>价格(元)</td></tr>');
            } else {
                $goodsSetThead.html('<tr><td>' + _goodsCategoryText1 + '</td><td>价格(元)</td></tr>');
            }

            //存入表格内
            $('.goodsSetTbody').html(goodsSetHtml);
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