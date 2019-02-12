

$(function () {
    $('.pageJump').val($('input[name="page"]').val());
});

$('.pageJump').change(function () {
    $('input[name="page"]').val($(this).val());
    $('#searchForm').submit();
});