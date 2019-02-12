<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/7/17
 * Time: 9:34
 */

define('FWS_STATUS_OPERATION_AUDIT', 1);//待运营审核
define('FWS_STATUS_UNIONPAY_AUDIT', 2); //待银联审核
define('FWS_STATUS_PASS', 3); //审核通过
define('FWS_STATUS_REJECT', 4); //驳回
$GLOBALS['__FWS_STATUS'] = [
    FWS_STATUS_OPERATION_AUDIT => '待运营审核',
    FWS_STATUS_UNIONPAY_AUDIT => '待银联审核',
    FWS_STATUS_PASS => '审核通过',
    FWS_STATUS_REJECT => '驳回'
];