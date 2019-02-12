<?php
namespace app\controllers;

use app\components\BaseController;
use app\models\Merchant;
use app\models\OperateAccount;
use app\models\ServiceProviders;
use app\models\DemandPerson;
use app\models\Goods;
use app\models\Category;
use app\models\Order;
use app\models\StatisticeVisit;
use app\models\StatisticsOrder;
use Yii;
/**
 * Created by PhpStorm.
 * User: Klaus
 * Date: 2018/8/7
 * Time: 21:54
 */
class IndexController extends BaseController
{
    /**
     * 首页
     */
    public function actionIndex()
    {
        //方块图
        $service=ServiceProviders::find()->where(['flag'=>FLAG_YES])->all();
        $service_num=count($service);
        $service_nopass=ServiceProviders::find()->where(['flag'=>FLAG_YES,'status'=>FWS_STATUS_OPERATION_AUDIT])->all();
        $service_nopass_num=count($service_nopass);
        $servicedata=[
            'service_num'=>$service_num,
            'service_nopass'=>$service_nopass_num,
        ];
        $demand=DemandPerson::find()->where(['flag'=>FLAG_YES])->all();
        $demand_num=count($demand);
        $demand_nopass=DemandPerson::find()->where(['flag'=>FLAG_YES,'status'=>FWS_STATUS_OPERATION_AUDIT])->all();
        $demand_nopass_num=count($demand_nopass);
        $demanddata=[
            'demand_num'=>$demand_num,
            'demand_nopass'=>$demand_nopass_num,
        ];
        $merchant_num=count(Merchant::find()->where(['flag'=>FLAG_YES])->all());
        $goods=Goods::find()->where(['flag'=>FLAG_YES])->andWhere(['<>','pre_category_id',1])->all();
        $goods_num=count($goods);

        $order_completed=Order::find()->where(['flag'=>FLAG_YES,'status'=>ORDER_STATUS_COMPLETED])->all();
        $order_readyconfirm=Order::find()->where(['flag'=>FLAG_YES,'status'=>ORDER_STATUS_OPERATION_AUDIT])->all();
        $order_completed=count($order_completed);
        $order_readyconfirm=count($order_readyconfirm);
        $order=[
            'order_finish'=>$order_completed,
            'order_readconfirm'=>$order_readyconfirm
        ];


        //走势图
        $minTimstamp = time()-7*24*3600;
        $minDate = date('Y/m/d',$minTimstamp);
        $maxTimestamp = time();
        $maxDate = date('Y/m/d',$maxTimestamp);
        $time['min'] = date('Y/m/d',$minTimstamp);
        $time['max'] = date('Y/m/d',$maxTimestamp);

        //订单
        $orderStaticModel = StatisticsOrder::find()->select(['date','order_num'])->where(['between','date',$minDate,$maxDate])->orderBy('date desc')->asArray()->all();
        $date2Array = array();
        $orderNumber = array();
        if(!empty($orderStaticModel)){
            foreach ($orderStaticModel as $k=>$v){
                array_push($date2Array,$v['date']);
                array_push($orderNumber,$v['order_num']);
            }
        }

        $date2Array = array_reverse($date2Array);
        $orderNumber = array_reverse($orderNumber);
        //访问量
        $visitStaticModel = StatisticeVisit::find()->select(['date','visit_num'])->where(['between','date',$minDate,$maxDate])->orderBy('date desc')->asArray()->all();
        $dateArray = array();
        $visitNumber = array();
        if(!empty($visitStaticModel)){
            foreach ($visitStaticModel as $k=>$v){
                array_push($dateArray,$v['date']);
                array_push($visitNumber,$v['visit_num']);
            }
        }
        $dateArray = array_reverse($dateArray);
        $visitNumber = array_reverse($visitNumber);
//        var_dump($dateArray);
//        var_dump($visitNumber);
//        die;

        /**
         * test
         */


        $res=StatisticsOrder::find()->select('date,order_num')->orderBy('date ASC')->asArray()->all();
//        var_dump($res);
//        die;
        $datetest=[];
        $num=[];
        foreach ($res as $k=>$v)
        {
            array_push($datetest,$v['date']);
            array_push($num,$v['order_num']);
        }
        $datetest=json_encode($datetest);
        $num=json_encode($num);
//        var_dump($datetest);
//        die;


        /**
         * test
         */




















        return $this->render('index',[
            'time'=>$time,
            'date'=>$dateArray,
            'date2'=>$date2Array,
            'order_num'=>$orderNumber,
            'visit_num'=>$visitNumber,
            'service'=>$servicedata,
            'demand'=>$demanddata,
            'merchant'=>$merchant_num,
            'goods'=>$goods_num,
            'order'=>$order,
            //test
            'datetest'=>$datetest,
            'num'=>$num
        ]);
    }

    /**
     * 访问量走势图
     */

    public function actionDatachart()
    {
        if(!empty($_GET['time'])){
            $times = $this->getValue('time');
            $dateArray =explode('-',$times);
            $minDate =trim($dateArray[0]);
            $maxDate = trim($dateArray[1]);
            $minTimstamp = strtotime($minDate);
            $maxTimestamp =strtotime($maxDate);
        }else{
            $minTimstamp = time()-7*24*3600;
            $minDate = date('Y/m/d',$minTimstamp);
            $maxTimestamp = time();
            $maxDate = date('Y/m/d',$maxTimestamp);
        }
        $time['min'] = date('Y/m/d',$minTimstamp);
        $time['max'] = date('Y/m/d',$maxTimestamp);

        $visitStaticModel = StatisticeVisit::find()->select(['date','visit_num'])->where(['between','date',$minDate,$maxDate])->orderBy('date desc')->asArray()->all();
        $dateArray = array();
        $visitNumber = array();
        if(!empty($visitStaticModel)){
            foreach ($visitStaticModel as $k=>$v){
                array_push($dateArray,$v['date']);
                array_push($visitNumber,$v['visit_num']);
            }
        }
        $dateArray = array_reverse($dateArray);
        $visitNumber = array_reverse($visitNumber);
        echo json_encode(array('date'=>$dateArray,'visit_num'=>$visitNumber));
    }

    /**
     * 订单走势图
     */
    public function actionDatacharttwo(){
        if(!empty($_GET['time'])){
            $times = $this->getValue('time');
            $dateArray =explode('-',$times);
            $minDate =trim($dateArray[0]);
            $maxDate = trim($dateArray[1]);
            $minTimstamp = strtotime($minDate);
            $maxTimestamp =strtotime($maxDate);
        }else{
            $minTimstamp = time()-7*24*3600;
            $minDate = date('Y/m/d',$minTimstamp);
            $maxTimestamp = time();
            $maxDate = date('Y/m/d',$maxTimestamp);
        }
        $time['min'] = date('Y/m/d',$minTimstamp);
        $time['max'] = date('Y/m/d',$maxTimestamp);

        $orderStaticModel = StatisticsOrder::find()->select(['date','order_num'])->where(['between','date',$minDate,$maxDate])->orderBy('date desc')->asArray()->all();
        $dateArray = array();
        $orderNumber = array();
        if(!empty($orderStaticModel)){
            foreach ($orderStaticModel as $k=>$v){
                array_push($dateArray,$v['date']);
                array_push($orderNumber,$v['order_num']);
            }
        }
        $dateArray = array_reverse($dateArray);
        $orderNumber = array_reverse($orderNumber);
        echo json_encode(array('date'=>$dateArray,'order_num'=>$orderNumber));
    }


    /**
     * test
     */
    public function actionTes(){
        $time=$this->getValue('time');
        $arrange=explode(' - ',$time);
//        var_dump($arrange);
        $min=$arrange[0];
        $max=$arrange[1];

        $res=StatisticsOrder::find()->where(['between','date',$min,$max])->select('date,order_num')->orderBy('date ASC')->asArray()->all();

        $date=[];
        $num=[];
        if(!empty($res))
        {
            foreach ($res as $v)
            {
                array_push($date,$v['date']);
                array_push($num,$v['order_num']);
            }
            echo json_encode(array('date'=>$date,'num'=>$num));
        }
    }

}