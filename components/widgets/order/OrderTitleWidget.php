<?php
namespace app\components\widgets\order;
use yii\base\Widget;

class OrderTitleWidget extends Widget {
    public $action;
    public $controller;

    public function run() {
        return $this->render('orderTitleWidget', ['action' => $this->action, 'controller' => $this->controller]);
    }
}