$(function () {
    var id = $('.goodsCategory').find('option:selected').val();
    $.ajax({
        'type': 'get',
        'url': '/goods/get-sub-goods-category.html',
        'data': {'id': id},
        'dataType': 'json',
        'success': function (result) {
            var html = '';
            for (var i = 0; i < result.length; i++) {
                var obj = result[i];
                html += '<option value="'+obj.id+'">'+obj.name+'</option>';
            }
            $('.subGoodsCategory').html(html);
        }
    });
});