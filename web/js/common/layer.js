function operateConfirm(text, url, title) {
    if (!title) {
        title = '提示';
    }
    layer.confirm(text, {
        title: title,
        btn: ['确定', '取消'] //按钮
    }, function(index) {
        location.href = url;
    });
}