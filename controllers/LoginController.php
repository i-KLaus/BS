<?php
namespace app\controllers;

use app\common\package\email\SendEmail;
use app\common\util\email;
use app\components\BaseController;
use app\models\LoginForm;
use app\models\OperateAccount;
use app\models\ServiceProviders;
use Yii;

/**
 * Created by PhpStorm.
 * User: 顾磊
 * Date: 2018/7/16
 * Time: 11:13
 */
class LoginController extends BaseController {

    public $layout = "login";
    public $enableCsrfValidation = false;

    public function init(){

    }

    public function actionLogin(){
        $model = new LoginForm();

//        if (!Yii::$app->user->isGuest) {
//            $pid = $this -> getServerId();
//            $service = ServiceProviders::find()
//                -> where(['id' => $pid, 'flag' => FLAG_YES])
//                -> one();
//            if ($service -> status != FWS_STATUS_PASS) {
//                return $this -> redirect(['review', 'id' => $service -> id]);
//            }
//            return $this -> redirect(['goods/list']);
//        }

        $model -> username = $this -> getValue('username');
        $model -> password = $this -> getValue('password');
        if (Yii::$app -> request -> isPost && $model->login()) {
            $pid = $this -> getServerId();
            $service = ServiceProviders::find()
                -> where(['id' => $pid, 'flag' => FLAG_YES])
                -> one();
            if ($service->status != FWS_STATUS_PASS) {
                return $this->redirect(['review', 'id' => $service->id]);
            }
            return $this -> redirect(['goods/list']);
        }
        return $this -> render('login', ['model' => $model]);
    }

    public function actionLoginOut() {
        Yii::$app -> user -> logout();
        Yii::$app -> session -> destroy();

        return $this -> redirect(['login']);
    }

    public function actionRegister() {
        $id = $this -> getValue('id');
        if (empty($id)) {
            $model = new ServiceProviders();
            $model -> create_time = date('Y-m-d H:i:s', time());
        } else {
            $model = ServiceProviders::find()
                -> where(['id' => $id, 'flag' => FLAG_YES])
                -> one();
            $model -> apply_time = date('Y-m-d H:i:s', time());
            $model -> status = FWS_STATUS_OPERATION_AUDIT;
        }

        $post = Yii::$app -> request -> post();
        if (!empty($post) && Yii::$app -> request -> isPost) {
            $model -> code = $this -> generateCode();
            $model -> account = $post['account'];
            $model -> pwd = md5($post['pwd']);
            $model -> name = $post['name'];
            $model -> address = $post['address'];
            $model -> operating_address = $post['operating_address'];
            $model -> business_license = $post['business_license'];
            $model -> legal_person_name = $post['legal_person_name'];
            $model -> legal_person_phone = $post['legal_person_phone'];
            $model -> legal_person_id_card_zm = $post['legal_person_id_card_zm'];
            $model -> legal_person_id_card_fm = $post['legal_person_id_card_fm'];
            $model -> contact_name = $post['contact_name'];
            $model -> contact_phone = $post['contact_phone'];
            $model -> contact_id_card_zm = $post['contact_id_card_zm'];
            $model -> contact_id_card_fm = $post['contact_id_card_fm'];
            $model -> account_name = $post['account_name'];
            $model -> settlement_account = $post['settlement_account'];
            $model -> bank_info = $post['bank_info'];
            $model -> account_opening_permit = $post['account_opening_permit'];
            if ($model -> save()) {
                $loginForm = new LoginForm();
                $loginForm -> username = $post['account'];
                $loginForm -> password = $post['pwd'];
                $loginForm -> login();
                $result = $this -> sendRegisterEmail($model -> name);
                return $this -> redirect(['review', 'id' => $model -> id]);
            }
        }

        return $this -> render('register', [
            'model' => $model
        ]);
    }

    /**
     *  发送注册提醒邮件
     * @param $name         /服务商名称
     * @return string|void
     */
    private function sendRegisterEmail($name) {
        $operate = OperateAccount::find()
            -> where(['and', ['is_admin' => IS_YES, 'flag' => FLAG_YES]])
            -> one();
        if (empty($operate)) {
            return ;
        }

        $body = '<table cellpadding="0" cellspacing="0" style="width: 700px; border: 1px solid #E9F0F9; background: #F7FAFF; font-size: 11pt; text-align: left">' .
            '<tbody><tr><th style="padding: 10px; border: 1px solid #1E82D8; background: #1E82D8; color: #FFF; font-size: 14pt; text-align: left;">审核提醒</th></tr>' .
            '<tr>' .
            '<td style="padding: 10px; border-left: 1px solid #1E82D8; border-right: 1px solid #1E82D8;border-bottom: 1px solid #1E82D8">' .
            '<table style="width: 100%; font-size: 11pt;">' .
            '<tbody><tr>' .
            '<td style="line-height: 30px;">尊敬的'.$operate -> name.'：</td>' .
            '</tr>' .
            '<tr>' .
            '<td style="line-height: 30px; text-indent: 30px;">您好！</td>' .
            '</tr>' .
            '<tr>' .
            '<td style="line-height: 30px; text-indent: 30px;">'.$name.'提交入驻申请，请及时处理，点击以下链接立即处理：</td>' .
            '</tr>' .
            '<tr><td style="word-wrap: break-word; word-break: break-all;"><a href="'.YYS_DOMAIN.'" rel="noopener" target="_blank">'.YYS_DOMAIN.'</a><br>' .
            '<font style="font-size: 9pt; color: #666;">（如果您无法点击这个链接，请将此链接复制到浏览器地址栏后访问。）</font></td></tr>' .
            '<tr><td style="line-height: 30px; text-indent: 30px;">感谢您使用优选平台！本邮件由系统自动发出，请勿回复。</td></tr>' .
            '</tbody></table></td></tr></tbody></table>';

        $result = email::sendEmail('【审核提醒】服务方审核申请', $operate -> account, $body);
        return $result;
    }

    public function actionReview($id) {
        $model = ServiceProviders::find()
            -> where(['id' => $id, 'flag' => FLAG_YES])
            -> one();
        if (empty($model)) {
            Yii::$app -> session -> setFlash('服务商数据不存在');
            return $this -> redirect(['login']);
        }

        if ($model -> status == FWS_STATUS_PASS) {
            return $this -> redirect(['goods/list']);
        }

        return $this -> render('review', [
            'model' => $model
        ]);
    }

    public function actionView($id) {
        if (Yii::$app -> user -> isGuest) {
            return $this -> redirect(['login/login']);
        }

        $model = ServiceProviders::find()
            -> where(['id' => $id, 'flag' => FLAG_YES])
            -> one();
        if (empty($model)) {
            Yii::$app -> session -> setFlash('服务商数据不存在');
            return $this -> redirect(['login']);
        }

        if ($model -> status == FWS_STATUS_PASS) {
            return $this -> redirect(['goods/list']);
        }

        return $this -> render('view', [
            'model' => $model
        ]);
    }

    /**
     *  忘记密码第一步
     */
    public function actionForgetFirst() {
        return $this -> render('forget-first');
    }

    /**
     *  忘记密码第二步
     * @param $code
     * @return string
     */
    public function actionForgetSecond($code) {

        $post = Yii::$app -> request -> post();
        if (!empty($post) && Yii::$app -> request -> isPost) {
            $service = ServiceProviders::find()
                -> where(['and', ['forget_code' => $code, 'flag' => FLAG_YES]])
                -> one();
            if (empty($service)) {
                $this -> setFlash('error_msg', 'code码已过期，请重新获取');
                return $this -> render('forget-second', ['code' => $code]);
            }
            $service -> pwd = md5($post['pwd']);
            $service -> forget_code = '';
            if (!$service -> save()) {
                $this -> setFlash('error_msg', '修改密码失败，请重试');
                return $this -> render('forget-second', ['code' => $code]);
            }

            return $this -> redirect(['forget-success']);
        }

        return $this -> render('forget-second', ['code' => $code]);
    }

    public function actionForgetSuccess() {
        return $this -> render('forget-success');
    }

    /**
     *  忘记密码发送邮件
     * @param $account
     */
    public function actionSendEmail(){
        $transmitLeg_server='smtp.exmail.qq.com';//发送方服务器地址
        $transmitLeg_email='qinjiameng@qinguanjia.net';//发送方邮箱
        $transmitLeg_password='qjm2017QJM';//发送方邮箱密码
        $account = $this -> getValue('account');
        $receiver_email = $account;//接收方邮箱

        $service = ServiceProviders::find()
            -> where(['and', ['account' => $account, 'flag' => FLAG_YES]])
            -> one();
        if (empty($service)) {
            $this -> setFlash('error_msg', '账号数据不存在');
            return $this -> redirect(['forget-first']);
        }

        $code = $this -> forgetCode();
        $body = '<table cellpadding="0" cellspacing="0" style="width: 700px; border: 1px solid #E9F0F9; background: #F7FAFF; font-size: 11pt; text-align: left">' .
            '<tbody><tr><th style="padding: 10px; border: 1px solid #1E82D8; background: #1E82D8; color: #FFF; font-size: 14pt; text-align: left;">邮件激活</th></tr>' .
            '<tr>' .
            '<td style="padding: 10px; border-left: 1px solid #1E82D8; border-right: 1px solid #1E82D8;border-bottom: 1px solid #1E82D8">' .
            '<table style="width: 100%; font-size: 11pt;">' .
            '<tbody><tr>' .
            '<td style="line-height: 30px;">尊敬的'.$service -> name.'：</td>' .
            '</tr>' .
            '<tr>' .
            '<td style="line-height: 30px; text-indent: 30px;">您好！</td>' .
            '</tr>' .
            '<tr>' .
            '<td style="line-height: 30px; text-indent: 30px;">您于 '.date('Y', time()).'年'.date('m', time()).'月'.date('d', time()).'日 在优选平台成功提交了重置密码的请求，请点击下面的链接重置您的密码：</td>' .
            '</tr>' .
            '<tr>' .
            '<td style="word-wrap: break-word; word-break: break-all;"><a href="http://yxfws.qinguanjia.net/login/forget-second.html?code='.$code.'" rel="noopener" target="_blank">http://yxfws.qinguanjia.net/login/forget-second?code='.$code.'</a><br>' .
            '<font style="font-size: 9pt; color: #666;">（如果您无法点击这个链接，请将此链接复制到浏览器地址栏后访问，该链接使用后将立即失效。）</font>' .
            '</td></tr>' .
            '<tr><td style="line-height: 30px; text-indent: 30px;">若不是您本人操作，请忽略此邮件！</td></tr>' .
            '<tr><td style="line-height: 30px; text-indent: 30px;">感谢您使用优选平台！本邮件由系统自动发出，请勿回复。</td></tr>' .
            '</tbody></table></td></tr></tbody></table>';


        $result = SendEmail::send($transmitLeg_server, $transmitLeg_email, $transmitLeg_password, $receiver_email, '忘记密码', $body);

        $service -> forget_code = $code;
        if (!$service -> save()) {
            $this -> setFlash('error_msg', $service -> getErrors());
            return $this -> redirect(['forget-first']);
        }

        return $this -> redirect(['forget-send-email-success']);
    }

    /**
     *  忘记密码发送邮件成功
     */
    public function actionForgetSendEmailSuccess() {
        return $this -> render('forget-send-email-success');
    }

    /**
     *  服务商帐号是否重复
     */
    public function actionCheckAccount() {
        $id = $this -> getValue('id');
        $account = $this -> getValue('account');

        $model = ServiceProviders::find()
            -> where(['and', ['account' => $account, 'flag' => FLAG_YES]])
            -> andFilterWhere(['<>', 'id', $id])
            -> one();

        if (empty($model)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  生成随机服务商编码
     * @return string
     */
    private function generateCode() {
        $number = rand(1, 99999999);

        while (ServiceProviders::find() -> where(['and', ['code' => $number, 'flag' => FLAG_YES]]) -> one()) {
            $number = rand(1, 99999999);
        }

        return $number;
    }

    /**
     *  生成随机code码 忘记密码用
     * @return string
     */
    private function forgetCode() {
        $number = rand(1, 99999999);

        while (ServiceProviders::find() -> where(['and', ['forget_code' => $number, 'flag' => FLAG_YES]]) -> one()) {
            $number = rand(1, 99999999);
        }

        return (string)$number;
    }
}