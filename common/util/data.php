<?php
namespace app\common\util;

use yii\helpers\Json;

class data {
    /**
     * @param $dataVal
     *
     */
    public static function getData($dataVal) {
        if (isset($dataVal['_csrf'])) {
            unset($dataVal['_csrf']);
        }

        $sign = self::setSign($dataVal);

        $data = $dataVal;
        $data['sign'] = $sign;

        return $data;
    }

    /**
     *生成签名
     */
    private static function setSign($data) {
        //密钥
        $key = 'c92f365233d1c553385341f4ba342cc5';

        //签名步骤一：按字典序排序参数
        ksort($data);
        //拼接键值对
        $string = "";
        foreach ($data as $k => $v) {
            if($k != "sign" && $v !== "" && !is_array($v)){
                $string .= $k . "=" . $v . "&";
            }
        }
        $string = trim($string, "&");
        //签名步骤二：在string后加入KEY
        if(!empty($string)) {
            $string = $string . "&sign=".$key;
        } else {
            $string = "sign=".$key;
        }
        //签名步骤三：MD5加密
        $string = md5($string);
        return $string;
    }

    /**
     * 验证表单参数
     */
     public static function checkValid($data, $params) {
        foreach ($params as $value) {
            if (!isset($data[$value])) {
                return false;
            }
            if (!$data[$value]) {
                return false;
            }
        }
        return true;
    }

    /**
     * 解析请求数据
     */
    public static function  getResponseData($data) {
         return Json::decode($data);
    }

    /**
     * 获取数组中指定下标的值
     * @param $array            /数组
     * @param $index            /下标
     * @param string $default   /默认值
     * @return string
     */
    public static function getDataInArray($array, $index, $default = '') {
        return !empty($array[$index]) ? $array[$index] : $default;
    }
}