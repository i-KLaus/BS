<?php

include ('fwsConstant.php');
include ('imageConstant.php');
include ('orderConstant.php');
include ('goodsConstant.php');
include ('rightConstant.php');

//是否类型
define('IS_YES', 1);//是
define('IS_NO', 2);//否
//待审核、驳回
define('BE_EXAMINE', 3);//待审核
define('BE_REJECT', 4);//驳回

//删除标志位
define('FLAG_YES', 1);//正常
define('FLAG_NO', 2);//删除

//分页每页条数
define('PAGE_PARAMS', 20);

//角色
define('ORDER_OPERATION_ROLE_DEMAND_PERSON',1);//需求方
define('ORDER_OPERATION_ROLE_SERVICE_PROVIDERS',2);//服务方
define('ORDER_OPERATION_ROLE_OPERATE_ACCOUNT',3);//运营方
define('ORDER_OPERATION_ROLE_UNIONPAY_ACCOUNT',4);//银联
$GLOBALS['_ORDER_OPERATION_ROLE'] = [
    ORDER_OPERATION_ROLE_DEMAND_PERSON => '需求方',
    ORDER_OPERATION_ROLE_SERVICE_PROVIDERS => '服务方',
    ORDER_OPERATION_ROLE_OPERATE_ACCOUNT => '运营方',
    ORDER_OPERATION_ROLE_UNIONPAY_ACCOUNT => '银联方'
];

define('ACTIVITY_TYPE_CARD',1);//卡类
define('ACTIVITY_TYPE_APP',2);//APP类
define('ACTIVITY_TYPE_ONLINE',3);//线上类
define('ACTIVITY_TYPE_OTHER',4);//其他
$GLOBALS['__ACTIVITY_TYPE'] = [
    ACTIVITY_TYPE_CARD => '卡类',
    ACTIVITY_TYPE_APP => 'APP类',
    ACTIVITY_TYPE_ONLINE => '线上类',
    ACTIVITY_TYPE_OTHER => '其他'
];

define('ACTIVITY_RULE_TYPE_DISCOUNT',1);//折扣
define('ACTIVITY_RULE_TYPE_CASH',2);//满减
define('ACTIVITY_RULE_TYPE_RETURNCASH',3);//返现
define('ACTIVITY_RULE_TYPE_POINTS',4);//积分
define('ACTIVITY_RULE_TYPE_COUPON',5);//送券
define('ACTIVITY_RULE_TYPE_OTHER',6);//其他
$GLOBALS['__ACTIVITY_RULE_TYPE'] = [
    ACTIVITY_RULE_TYPE_DISCOUNT => '折扣',
    ACTIVITY_RULE_TYPE_CASH => '满减',
    ACTIVITY_RULE_TYPE_RETURNCASH => '返现',
    ACTIVITY_RULE_TYPE_POINTS => '积分',
    ACTIVITY_RULE_TYPE_COUPON => '送券',
    ACTIVITY_RULE_TYPE_OTHER => '其他',
];

//是否是主账号
define('ACCOUNT_IS_ADMIN_YES',1);//是
define('ACCOUNT_IS_ADMIN_NO',2);//否

//银联产品
define('UNIONPAY_TYPE_QRCPDE',1);//银联二维码
define('UNIONPAY_TYPE_IPHONE',2);//银联手机闪付
define('UNIONPAY_TYPE_CARD',3);//银联刷卡
$GLOBALS['__UNION_TYPE'] = [
    UNIONPAY_TYPE_QRCPDE => '银联二维码',
    UNIONPAY_TYPE_IPHONE => '银联手机闪付',
    UNIONPAY_TYPE_CARD=>'银联刷卡',
];
//服务商可选服务类型
define('FWS_TYPE_TEST',1);//测试
define('FWS_TYPE_SATISFY',2);//满意回访

//通道类型
define('UNION_CHANNEL_TYPE_DCONNECT',1);//直连
define('UNION_CHANNEL_TYPE_ECONNECT',2);//间连
$GLOBALS['__UNION_CHANNEL_TYPE'] = [
    UNION_CHANNEL_TYPE_DCONNECT => '直连',
    UNION_CHANNEL_TYPE_ECONNECT => '间连',
];

define('INVOICE_INFO_TYPE_COMMON',1);//增值税普通发票
define('INVOICE_INFO_TYPE_PRO',2);//增值税专用发票
define('INVOICE_INFO_TYPE_NO',3);//不开票
$GLOBALS['_INVOICE_INFO_TYPE'] = [
    INVOICE_INFO_TYPE_COMMON => '增值税普通发票',
    INVOICE_INFO_TYPE_PRO => '增值税专用发票',
    INVOICE_INFO_TYPE_NO=>'不开票',
];
//商户类型
define('MERCHANT_TYPE_PP',1);//品牌商户
define('MERCHANT_TYPE_SQ',2);//商圈/街区
$GLOBALS['MERCHANT_TYPE'] = [
    MERCHANT_TYPE_PP => '品牌商户',
    MERCHANT_TYPE_SQ => '商圈/街区',
];