<?php
namespace app\common\package\email;
require_once 'swiftmailer-master/lib/swift_required.php';

/** 发送邮件
 * Created by PhpStorm.
 * User: tians
 * Date: 2017/7/4
 * Time: 15:36
 */
class SendEmail
{

    /**
     * @param $transmitLeg_server 发送方服务器地址
     * @param $transmitLeg_email 发送方邮箱
     * @param $transmitLeg_password 发送方邮箱密码
     * @param $receiver_email 接收方邮箱
     * @param $title 邮件标题
     * @param $body 邮件内容
     * @return string
     */
    public static function send($transmitLeg_server, $transmitLeg_email, $transmitLeg_password, $receiver_email, $title, $body)
    {
        //发送邮件
        //初始化邮件服务器对象
        $transport = \Swift_SmtpTransport::newInstance($transmitLeg_server, 25);
        //设置用户名和密码
        $transport->setUsername($transmitLeg_email);
        $transport->setPassword($transmitLeg_password);
        $mailer = \Swift_Mailer::newInstance($transport);//发送邮件对象
        $message = \Swift_Message::newInstance();//邮件信息对象
        $message->setFrom(array($transmitLeg_email));//谁发送的
        $message->setTo($receiver_email);//发送给谁
        $message->setSubject($title);//设置邮件主题

        $emailBody = $body;
        $message->setBody($emailBody, "text/html", 'utf-8');
        try {
            $res = $mailer->send($message);
            if ($res) {
                return 'success';
            } else {
                return 'fail';
            }
        } catch (Swift_ConnectionException $e) {
            return die('邮件服务器错误:') . $e->getMessage();
        }

    }
}
