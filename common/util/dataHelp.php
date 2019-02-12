<?php
namespace app\common\util;
class dataHelp{
    /**
     * @param $number
     * @return string
     * 转化为分
     */
    public static function convertCent($number) {
        if(!empty($number)){
            //验证是否为字符串,如果是字符串，强制转型会返回0
            $this_number = (float)$number;
            if(!empty($this_number)){
                $number = $this_number * 100;
            }
        }

        return $number;
    }


    /**
     * @param $number
     * @return string
     * 转化元并保留2位小数
     */
    public static function convertYuan($number) {
        if(!empty($number)){
            //验证是否为字符串,如果是字符串，强制转型会返回0
            $this_number = (float)$number;
            if(!empty($this_number)){
                $this_number = $this_number / 100;
                $number = number_format($this_number, 2, '.', '');
            }
        }

        return $number;
    }
    /**
     * 省市区数据转换为数组
     * @param $data
     * @return mixed
     */
    public static function regionConversionArray($data) {
        $result = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $result[$v->area_code] = $v->area_name;
            }
        }
        return $result;
    }

    public static function regionWechatConversionArray($data) {
        $result = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $result[$v->id] = $v->area_name;
            }
        }
        return $result;
    }

}