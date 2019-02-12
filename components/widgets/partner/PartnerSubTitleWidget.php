<?php
namespace app\components\widgets\partner;
use yii\base\Widget;

class PartnerSubTitleWidget extends Widget {
    public $action;
    public $controller;

    public function run() {
        return $this->render('partnerSubTitleWidget', ['action' => $this->action, 'controller' => $this->controller]);
    }
}