<?php
namespace app\components;
require(dirname(__FILE__) . '/../common/constant/constant.php');

use app\models\Platform;
use app\models\ServiceProviders;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;

class BaseController extends Controller {

    public $layout = 'main';
    public $response;

    public function init() {
        $platform = Platform::find()->where('platform_type = :platform_type',array(
            ':platform_type' => 2
        ))->one();
        if (empty($platform) || $platform->status != 1){
            Yii::$app -> session -> setFlash('error_msg','平台已被冻结');
            echo("<script>parent.location.href='".Url::to(['/login/login-out'])."'</script>");
            die();
        }

        if (empty(Yii::$app -> session -> get('pid'))) {
            echo("<script>window.location.href='".Url::to(['/login/login'])."'</script>");
            die();
        }
        rightval();
        if (!Yii::$app->user->isGuest) {
            $service = ServiceProviders::find()
                -> where(['id' => $this -> getServerId(), 'flag' => FLAG_YES])
                -> one();
            if ($service -> status != FWS_STATUS_PASS) {
                echo("<script>window.location.href='".Url::to(['/login/review', 'id' => $service -> id])."'</script>");
                die();
            }
        }
        return true;
    }

    /**
     *  post、get提交取值
     */
    public function getValue($attribute, $defaults = '') {
        $var = '';
        if(\Yii::$app->request->isGet) {
            $var = Yii::$app->request->get($attribute);
        }
        if(\Yii::$app->request-> isPost) {
            $var = Yii::$app->request->post($attribute);
        }
        return !empty($var) ? $var : $defaults;
    }

    /**
     *  设置提示信息
     * @param $key
     * @param $msg
     */
    protected function setFlash($key, $msg) {
        if (is_array($msg)) {
            $text = '';
            foreach ($msg as $key => $val) {
                $text .= implode(';', $val) . ';';
            }
        } else {
            $text = $msg;
        }
        Yii::$app -> session -> setFlash($key, $text);
    }

    protected function getServerId() {
        return Yii::$app -> session -> get('pid');
    }

    protected function responseJson() {
        header('Content-type:text/html;charset=utf-8');
        echo json_encode($this->response);
        exit();
    }
}

