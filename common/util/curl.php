<?php
namespace app\common\util;

class curl {
    /**
     * @param $url
     * @param int $timeout
     * @param array $post
     * @param array $header
     * @return mixed|string
     *
     * 执行curl获取远程结果
     */
    public static function curl_get_contents($url, $timeout = 10, $post = array(), $header = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if(!empty($post)){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }


        $content = curl_exec($ch);
//        curl_close($ch);
        if ($content == false) {
            return "curl error:" . curl_error($ch);
        } else {
            return $content;
        }
    }
}