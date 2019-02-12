<?php
namespace app\common\util;
/**
 * Created by PhpStorm.
 * User: 顾磊
 * Date: 2017/9/15
 * Time: 16:29
 */
class uuid {

    /**
     * 生成uuid
     * @param string $prefix
     * @return string
     */
    public static function create($prefix = ""){    //可以指定前缀
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $prefix . $uuid;
    }

}