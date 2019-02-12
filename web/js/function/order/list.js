$(function () {
    getSubCategory();

    $('#modal').on('show.bs.modal', function (event) {
        var order_id = event.relatedTarget.dataset.id;

        $('#modal').find('input[name="order_id"]').val(order_id);
    });

    $('#modal').on('hide.bs.modal', function (event) {
        $('#modal').find('input[name="order_id"]').val('');
        $('#modal').find('input[name="data"]').val('');
        $('.image-upload-list .sort').each(function () {
            $(this).remove();
        });
    });
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

function buildImg() {
    var data = [];
    $('.image-upload-list .sort').each(function () {
        data.push($(this).find('img').attr('data-name'));
    });
    if (data.length >= 5) {
        $('.image-list--add').hide();
    } else {
        $('.image-list--add').show();
    }
    $('input[name="data"]').val(JSON.stringify(data));
}

$(document).on('click', '.js-delete-pic', function () {
    $(this).parent('li').remove();
    buildImg();
});

$('#modalBtn').click(function () {
    var data = $('input[name="data"]').val();
    if (data == '[]' || data == '') {
        layer.msg('请上传资料后提交保存');
        return false;
    }

    $('#modalForm').submit();
});