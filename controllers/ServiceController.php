<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/7/31
 * Time: 15:16
 */

namespace app\controllers;


use app\components\BaseController;
use app\models\ServiceProviders;

class ServiceController extends BaseController {

    public function actionDetail() {
        $service_id = $this -> getServerId();

        $model = ServiceProviders::find()
            -> where(['and', ['id' => $service_id, 'flag' => FLAG_YES]])
            -> one();
        if (empty($model)) {
            $this -> setFlash('error_msg', '未查询到运营服务商数据');
            return $this -> redirect(['index/home']);
        }

        return $this -> render('detail', [
            'model' => $model
        ]);
    }
}