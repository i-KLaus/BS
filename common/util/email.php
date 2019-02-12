<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/8/22
 * Time: 16:28
 */

namespace app\common\util;


use app\common\package\email\SendEmail;
use Yii;

class email {

    /**
     *  发送邮件
     * @param $title            /邮件标题
     * @param $receiver_email   /接收方邮箱地址
     * @param $body             /邮件内容
     * @return string
     */
    public static function sendEmail($title, $receiver_email, $body) {
        $transmitLeg_server=Yii::$app -> params['email_server'];//发送方服务器地址
        $transmitLeg_email=Yii::$app -> params['email'];//发送方邮箱
        $transmitLeg_password=Yii::$app -> params['email_pwd'];//发送方邮箱密码

        $result = SendEmail::send($transmitLeg_server, $transmitLeg_email, $transmitLeg_password, $receiver_email, $title, $body);
        return $result;
    }
}