$(function () {
    getSubCategory();
});

$('select[name="category_p_id"]').change(function () {
    getSubCategory();
});
function getSubCategory() {
    var pid = $('select[name="category_p_id"]').find('option:selected').val();
    $.ajax({
        'type': 'get',
        'url': 'get-sub-category.html',
        'data': {'p_id': pid},
        'dataType': 'json',
        'success': function (result) {
            var html = '<option value="" selected>全部类别</option>';
            for (var i = 0; i < result.length; i++) {
                var obj = result[i];
                if (obj.id == category_id) {
                    html += '<option value="'+obj.id+'" selected>'+obj.name+'</option>';
                } else {
                    html += '<option value="'+obj.id+'">'+obj.name+'</option>';
                }
            }
            $('select[name="category_id"]').html(html);
        }
    });
}


function statusSearch(val) {
    $('input[name="status"]').val(val);
    $('#searchForm').submit();
}