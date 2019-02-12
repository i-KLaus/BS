<?php
namespace app\commands;

use app\models\BankMerchant;
use app\models\MerchantPayAccount;
use app\models\TransactionFlow;
use yii\console\Controller;
use app\common\util\csv;

class ExclController extends Controller{
    /**
     * 间联对账excl下载
     */
    public function actionPaExclDownload(){
        set_time_limit(0);
        $filename = '间连商户对账单.csv';
        $str = "对账时间	,渠道,pid/商户号/编号,支付宝/微信账号名称,亲管家商户名称,".
            "所属服务商,交易金额,有效交易实付金额,结算依据,商户合约费率,结算费率,应结算总金额\n";//excl下载用字符串

        $account = MerchantPayAccount::find()->all();
        if(empty($account)){
            return;
        }

        foreach ($account as $k => $v) {
            $start_time_stamp = strtotime('2017-04-15');
            $end_time_stamp = strtotime('2017-05-01');
            if(!empty($v->pa_mch_id)){
                while (date('Y-m-d', $start_time_stamp) != date('Y-m-d', $end_time_stamp)) {
                    $flow = TransactionFlow::find()
                        ->select('sum(zt_transaction_flow.pay_money) as pay_money')
                        ->where('UNIX_TIMESTAMP(zt_transaction_flow.create_time) > UNIX_TIMESTAMP(:start_time) 
                    and UNIX_TIMESTAMP(zt_transaction_flow.create_time) < UNIX_TIMESTAMP(:end_time)
                    and zt_pay_order.order_status != :order_status
                    and zt_pay_order.store_pay_account like :store_pay_account',
                            [
                                ':start_time' => date('Y-m-d 00:00:00', $start_time_stamp),
                                ':end_time' => date('Y-m-d 23:59:59', $start_time_stamp),
                                ':order_status' => ORDER_STATUS_UNPAID,
                                ':store_pay_account' => "%$v->pa_mch_id%",
                            ])
                        ->joinWith('order')->one();

                    $acc_info = BankMerchant::find()->where('bank_mch_id = :bank_mch_id', [':bank_mch_id' => $v->pa_mch_id])
                        ->joinWith('partner')->one();

                    $merchant_alias_name = !empty($acc_info->merchant_alias_name) ? $acc_info->merchant_alias_name : '';
                    $merchant_name = !empty($acc_info->merchant_name) ? $acc_info->merchant_name : '';
                    $merchant_rate = !empty($acc_info->merchant_rate) ? $acc_info->merchant_rate : '';
                    $partner = !empty($acc_info->partner->name) ? $acc_info->partner->name : '';
                    $pay_money = "\t".dataHelp::convertYuan($flow->pay_money);
                    $pa_mch_id = "\t".$v->pa_mch_id;

                    $str .= "\t".date('Y年m月d日', $start_time_stamp).",平安间连,".$pa_mch_id.",".$merchant_alias_name.",".$merchant_name.",".
                        $partner.",".$pay_money.",,,".$merchant_rate."\n";

                    $start_time_stamp = strtotime('+1 day', $start_time_stamp);
                }
            }
        }

        csv::export_csv($filename, $str);
    }
}