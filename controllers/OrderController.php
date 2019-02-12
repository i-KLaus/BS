<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/7/31
 * Time: 14:13
 */

namespace app\controllers;


use app\common\util\download;
use app\components\BaseController;
use app\models\Block;
use app\models\Category;
use app\models\Goods;
use app\models\GoodsCategoryAttr;
use app\models\GoodsSku;
use app\models\Order;
use app\models\OrderOperationRecord;
use app\models\OrderSku;
use app\models\Store;
use yii\data\Pagination;
use app\common\util\dataHelp;

class OrderController extends BaseController {

    /**
     * 订单列表
     */
    public function actionList() {
        $server_id = $this -> getServerId();
        $keyword = $this -> getValue('keyword');
        $category_p_id = $this -> getValue('category_p_id');
        $category_id = $this -> getValue('category_id');
        $status = $this -> getValue('status');
        $page = $this -> getValue('page', 1);
        $list = [];

        $category = Category::find()
            -> where(['and', ['p_id' => 0, 'flag' => FLAG_YES]])
            -> all();

        $model = Order::find()
            -> where(['and', ['service_providers_id' => $server_id, 'flag' => FLAG_YES]]);

        //订单状态搜索
        if (!empty($status)) {
            switch ($status) {
                case '1': //待确认
                    $model -> andWhere(['in', 'status', [ORDER_STATUS_OPERATION_AUDIT, ORDER_STATUS_DEMANDER_AUDIT, ORDER_STATUS_MERCHANT_AUDIT]]);
                    break;
                case '2': //进行中
                    $model -> andWhere(['in', 'status', [ORDER_STATUS_ACTUALIZE]]);
                    break;
                case '3': //已完成
                    $model -> andWhere(['and', ['status' => ORDER_STATUS_COMPLETED]]);
                    break;
                case '4': //已结束
                    $model -> andWhere(['and', ['status' => ORDER_STATUS_CANCEL]]);
                    break;
            }
        }

        //分类 关键字搜索
        if (!empty($keyword) || !empty($category_id) || !empty($category_p_id)) {
            $order_ids = [];

            $goods = Goods::find()
                -> where(['and', ['service_providers_id' => $server_id, 'flag' => FLAG_YES]]);
            //关键字搜索
            $goods -> andFilterWhere(['like', 'name', $keyword]);
            //二级类别搜索
            $goods -> andFilterWhere(['and', ['category_id' => $category_id]]);
            //服务类别搜索
            if (empty($category_id) && !empty($category_p_id)) {
                $goods -> andWhere(['and', ['pre_category_id' => $category_p_id]]);
            }
            $goods = $goods -> all();
            if (!empty($goods)) {
                $goods_ids = [];
                foreach ($goods as $key => $val) {
                    $goods_ids[] = $val -> id;
                }
                $order_sku = OrderSku::find()
                    -> where(['and', ['service_providers_id' => $server_id, 'flag' => FLAG_YES]])
                    -> andWhere(['in', 'goods_id', $goods_ids])
                    -> all();
                if (!empty($order_sku)) {
                    foreach ($order_sku as $key => $val) {
                        $order_ids[] = $val -> order_id;
                    }
                }
            }
            $model -> andWhere(['in', 'id', array_unique($order_ids)]);
        }

        $count = $model -> count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => PAGE_PARAMS]);
        $model = $model
            -> with(['orderSku'])
            -> offset($pages -> offset)
            -> limit($pages -> limit)
            -> orderBy('create_time DESC')
            -> all();





        if (!empty($model)) {
            foreach ($model as $key => $val) {
                $list[$key] = [
                    'id' => $val -> id,
                    'order_money' => floatval(dataHelp::convertYuan($val -> order_money)),
                    'order_no' => $val -> order_no,
                    'status' => $val -> status,
                    'create_time' => $val -> create_time,
                    'order_sku' => $this -> buildOrderSku($val -> id),
                    'implement_status'=>1//判断是否有implement_money
                ];
            }
        }
        foreach ($list as $k=>$v){
            foreach ($v['order_sku'] as $val){
                if($val['implement_money']==0 && $val['merchant_standard_json']!=''){
                    $list[$k]['implement_status'] = 0;
                    break;
                }
            }
        }

        return $this -> render('list', [
            'list' => $list,
            'keyword' => $keyword,
            'category_p_id' => $category_p_id,
            'category_id' => $category_id,
            'status' => $status,
            'count' => $count,
            'page' => $page,
            'category' => $category
        ]);
    }

    public function actionDetail($id) {
        $server_id = $this -> getServerId();

        $orderRecord = OrderOperationRecord::find()
            -> where(['and', ['order_id' => $id, 'flag' => FLAG_YES]])
            -> all();


        $model = Order::find()
            -> where(['id' => $id, 'service_providers_id' => $server_id, 'flag' => FLAG_YES])
            -> with(['orderEvaluate', 'orderOperationRecord'])
            -> one();
        if (empty($model)) {
            $this -> setFlash('error_msg', '订单数据不存在');
            return $this -> redirect(['list']);
        }


        $data = [
            'id' => $model -> id,
            'order_no' => $model -> order_no,
            'status' => $model -> status,
            'before_cancel_status' => $model->before_cancel_status,
            'order_money' => floatval(dataHelp::convertYuan($model -> order_money)),
            'create_time' => $model -> create_time,
            'order_sku' => $this -> buildOrderSku($model -> id),
            'implement_status'=>1,//判断是否有implement_money
            'activity_start_time' => $model->activity_start_time,
            'activity_end_time' => $model->activity_end_time,
            'activity_name_json' => $model->activity_name_json,
            'activity_rule_json' => $model->activity_rule_json,
            'activity_remark' => $model->activity_remark,
            'activity_file' => $model->activity_file,
            'implement_status'=>1//判断是否有implement_money
        ];

            foreach ($data['order_sku'] as $val){
                if($val['implement_money']==0 && $val['merchant_standard_json']!=''){
                    $data['implement_status'] = 0;
                    break;
                }
            }


        return $this -> render('detail', [
            'data' => $data,
            'orderRecord' => $orderRecord
        ]);
    }

    /**
     *  确认订单
     */
    public function actionDetermineOrder() {
        $server_id = $this -> getServerId();
        $order_no = $this -> getValue('order_no');
        $goUrl = $this -> getValue('goUrl');

        $order = Order::find()
            -> where(['and', ['order_no' => $order_no, 'service_providers_id' => $server_id, 'flag' => FLAG_YES]])
            -> one();
        if (empty($order)) {
            $this -> setFlash('error_msg', '订单数据不存在');
            return $this -> redirect(['list']);
        }

        $order -> status = ORDER_STATUS_ACTUALIZE;
        if (!$order -> save()) {
            $this -> setFlash('error_msg', '订单状态修改失败，请重试');
            if (!empty($goUrl)){
                return $this->redirect($goUrl);
            }
            return $this->redirect(['list']);
        }

        //订单操作日志 - 服务方确认订单
        $order_operation_record = new OrderOperationRecord();
        $order_operation_record->order_id = $order->id;
        $order_operation_record->date = date('Y-m-d H:i:s',time());
        $order_operation_record->operation_type = ORDER_OPERATION_TYPE_CONFIRM;
        $order_operation_record->role = ORDER_OPERATION_ROLE_SERVICE_PROVIDERS;
        $order_operation_record->operator_id = $server_id;
        $order_operation_record->create_time = date('Y-m-d H:i:s',time());
        if (!$order_operation_record->save()){
            $this -> setFlash('error_msg', '订单状态修改失败，请重试');
            if (!empty($goUrl)){
                return $this->redirect($goUrl);
            }
            return $this->redirect(['list']);
        }

        if (!empty($goUrl)) {
            return $this -> redirect($goUrl);
        }
        return $this -> redirect(['list']);
    }

    /**
     *  订单实施
     */
//    public function actionImplementation() {
//        $server_id = $this -> getServerId();
//        $order_no = $this -> getValue('order_no');
//        $goUrl = $this -> getValue('goUrl');
//
//        $order = Order::find()
//            -> where(['and', ['order_no' => $order_no, 'service_providers_id' => $server_id, 'flag' => FLAG_YES]])
//            -> one();
//        if (empty($order)) {
//            $this -> setFlash('error_msg', '订单数据不存在');
//            return $this -> redirect(['list']);
//        }
//
//        $order -> status = ORDER_STATUS_UNPAID;
//        if (!$order -> save()) {
//            $this -> setFlash('error_msg', '订单状态修改失败，请重试');
//        }
//
//        if (!empty($goUrl)) {
//            return $this -> redirect($goUrl);
//        }
//
//        return $this -> redirect(['list']);
//    }

    public function actionUploadData() {
        $order_id = $this -> getValue('order_id');
        $data = $this -> getValue('data');
        $goUrl = $this -> getValue('goUrl');

        $this -> saveOrderRecord($order_id, ORDER_OPERATION_TYPE_UPLOAD, $data);

        if (!empty($goUrl)) {
            return $this -> redirect($goUrl);
        }
        return $this -> redirect(['list']);
    }



    public function actionGetSubCategory($p_id) {
        $data = [];

        if ($p_id == '') {
            echo json_encode($data);exit;
        }

        $category = Category::find()
            -> where(['and', ['p_id' => $p_id, 'flag' => FLAG_YES]])
            -> andWhere(['<>', 'name', '对账收票'])
            -> all();
        if (!empty($category)) {
            foreach ($category as $key => $val) {
                $data[] = [
                    'id' => $val -> id,
                    'name' => $val -> name
                ];
            }
        }

        echo json_encode($data);exit;
    }

    /**
     * 组装订单sku数据
     * @param $order_id
     * @return array
     */
    private function buildOrderSku($order_id) {
        $data = [];

        $order_sku = OrderSku::find()
            -> where(['order_id' => $order_id, 'flag' => FLAG_YES])
            -> with(['goods', 'goodsSku', 'category', 'subCategory', 'merchant'])
            -> all();
        if (empty($order_sku)) {
            return $data;
        }
        foreach ($order_sku as $key => $val) {
            $data[$key] = [
                'num' => $val -> num,
                'implement_money' => $val ->implement_money,
                'price' => floatval(dataHelp::convertYuan($val -> price)),
                'goods_img'=>$this->getGoodsimg($val -> goods_id),
                'merchant_standard_json' => !empty($val -> merchant_standard_json)?json_decode($val -> merchant_standard_json,true):'',
                'merchant_optional_json' => !empty($val -> merchant_optional_json)?json_decode($val -> merchant_optional_json,true):'',
                'platform_standard_json' => !empty($val -> platform_standard_json)?json_decode($val -> platform_standard_json,true):'',
                'platform_optional_json' => !empty($val -> platform_optional_json)?json_decode($val -> platform_optional_json,true):'',
                'pre_category_name' =>$this->getPcategory($val -> goods_id),
                'category_name' => $this->getCategory($val -> goods_id),
                'merchant_alias' => !empty($val -> merchant) ? $val -> merchant -> alias : '',
                'merchant_type' => !empty($val -> merchant) ? $val -> merchant -> type : '',
                'goods_name' => $this->getGoodsname($val -> goods_id),
                'goods_attr' => $this->getGoodsattr($val -> goods_sku_id),
                'store_sq' => $this->getStoresq($val -> goods_id)
            ];
        }

        return $data;
    }

    private function getPcategory($goods_id){
        $id = Goods::find()->where(['flag'=>FLAG_YES,'id'=>$goods_id])->select('pre_category_id')->asArray()->one();
        $name = Category::find()->where(['flag'=>FLAG_YES,'id'=>$id])->select('name')->asArray()->one();
        return $name['name'];

    }

    private function getCategory($goods_id){
        $id = Goods::find()->where(['flag'=>FLAG_YES,'id'=>$goods_id])->select('category_id')->asArray()->one();
        $name = Category::find()->where(['flag'=>FLAG_YES,'id'=>$id])->select('name')->asArray()->one();
        return $name['name'];
    }

    private function getGoodsname($goods_id){
        $name = Goods::find()->where(['flag'=>FLAG_YES,'id'=>$goods_id])->select('name')->asArray()->one();
        if(empty($name)){
            return '';
        }
        return $name['name'];
    }

    private function getGoodsimg($goods_id){
        $name = Goods::find()->where(['flag'=>FLAG_YES,'id'=>$goods_id])->select('goods_img')->asArray()->one();
        if(empty($name)){
            return '';
        }
        return $name['goods_img'];
    }

    private function getGoodsattr($goods_sku_id){
        $attr_id = GoodsSku::find()->where(['flag'=>FLAG_YES,'id'=>$goods_sku_id])->select('goods_category_attr_id')->asArray()->one();
        if(empty($attr_id)){
            return '';
        }
        $attr_id = trim($attr_id['goods_category_attr_id'],',');
        $arr = explode(',',$attr_id);
        $str ='';
        foreach ($arr as $v){
            $attr = GoodsCategoryAttr::find()->where(['flag'=>FLAG_YES,'id'=>$v])->select('attr')->asArray()->one();
            $data[] = $attr['attr'];
        }
        return implode(',',$data);
    }

    private function getStoresq($goods_id){
        $bk_id = Store::find()->where(['flag'=>FLAG_YES,'goods_id'=>$goods_id])->select('block_id')->asArray()->one();
        if(empty($bk_id)){
            return '';
        }
        $block = Block::find()->where(['flag'=>FLAG_YES,'id'=>$bk_id])->asArray()->one();
        return $block['name'];
    }
    /**
     * 保存订单操作记录
     * @param $order_id
     * @param $operation_type
     * @param $data_file
     */
    private function saveOrderRecord($order_id, $operation_type, $data_file) {
        $model = new OrderOperationRecord();
        $model -> order_id = $order_id;
        $model -> date = date('Y-m-d H:i:s', time());
        $model -> operation_type = $operation_type;
        $model -> role = ORDER_OPERATION_ROLE_SERVICE_PROVIDERS;
        $model -> operator_id = $this -> getServerId();
        $model -> data_file = $data_file;
        $model -> create_time = date('Y-m-d H:i:s', time());
        if (!$model -> save()) {
            $this -> setFlash('error_msg', $model -> getErrors());
        } else {
            $this -> setFlash('error_msg', '保存成功');
        }
    }

    public function actionDownload() {
        $src = $this -> getValue('src');
        $format = $this -> getValue('format');

        download::download($src, $format, '');
    }
}