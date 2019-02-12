<?php
namespace app\common\util;
class csv {
    /**
     * 导出csv
     * @param type $filename
     * @param type $data
     */
    public static function export_csv($filename,$data) {
        $data = mb_convert_encoding($data, "GBK","utf-8");
        $filename=iconv("utf-8", "gb2312", $filename);
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $data;
        exit();
    }
}