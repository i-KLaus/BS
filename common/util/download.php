<?php
/**
 * Created by PhpStorm.
 * User: Bei
 * Date: 2017/5/17
 * Time: 11:09
 */

namespace app\common\util;


class download {

    public static function download($url, $format, $filename = '') {
        if(empty($filename)) {
            $filename = date('YmdHis', time()) . '.' . $format;
        }

        $str_num = strpos($url, 'images');
        $str = substr($url, $str_num+6); //加上images的长度
        //图片下载路径
        $file = ASOLUTE_PATH . $str;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$filename}");
        header("Content-length: " . filesize($file));
        readfile($file);
    }
}