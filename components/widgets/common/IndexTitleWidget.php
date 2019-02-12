<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/7/18
 * Time: 16:22
 */

namespace app\components\widgets\common;


use app\components\widgets\components\BaseWidget;

class IndexTitleWidget extends BaseWidget {

    public function run() {
        return $this -> render('indexTitle');
    }
}