/**
 * Created by Bei on 2017/4/16.
 */

function upload_img(input_id, uploader, file_type, folder, thumb,callback) {
    $('#' + input_id).replaceWith('<div id="'+ input_id +'">选择图片</div>');

    // 初始化Web Uploader
    var uploader = WebUploader.create({
        auto: true, // 选完文件后，是否自动上传。
        swf: './Uploader.swf', // swf文件路径
        server: uploader, // 文件接收服务端
        fileVal: 'Filedata',  //设置文件上传域的name
        formData: { "folder": folder, 'thumb': thumb }, //提交给服务器端的参数
        fileSingleSizeLimit: 1024 * 1024 * 2,  //限制文件总大小  2M
        fileNumLimit: undefined,  // 限制文件数量
        duplicate :true,
        pick: { // 选择文件的按钮
            id: '#' + input_id,
            innerHTML: '<span class="uploadify-button-text"></span>' //按钮文字
        },
        accept: {  // 只允许选择图片文件。
            title: 'Images',  //文字描述
            extensions: file_type,
        }
    });

    $('#'+ input_id).removeClass('uploadify').addClass('uploadify-wrap');
    $('#'+ input_id).find('span').parent().removeClass('uploadify-button').addClass('uploadify-link');

    uploader.on('uploadSuccess', function (file, response) { //一个文件上传成功后的响应事件处理
        var fileName = response.fileName;
        if (callback) {
            callback(fileName);
        }
    });
}