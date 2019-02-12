<?php
namespace app\common\util;
/**
 * Created by PhpStorm.
 * User: 顾磊
 * Date: 2017/7/13
 * Time: 13:58
 */
class stringHelp {
    /**
     * 字符串转数组
     * @param $delimiter
     * @param $string
     * @return array
     */
    public static function stringToArray($delimiter,$string){
        $arr = explode($delimiter,$string);
        $result = array();
        foreach ($arr as $v){
            if(!empty($v) || $v == 0){
                $result[] = $v;
            }
        }
        return $result;
    }

    /**
     * xml转数组
     * @param $xml
     * @return mixed
     */
    public static function xmlToArray($xml){
        libxml_disable_entity_loader(true);
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $arr;
    }
}