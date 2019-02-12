<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/7/24
 * Time: 17:40
 */

namespace app\controllers;

require_once '../common/package/phpexcel/Classes/PHPExcel.php';

use app\common\util\dataHelp;
use app\common\util\email;
use app\components\BaseController;
use app\models\Block;
use app\models\Category;
use app\models\Goods;
use app\models\Region;
use app\models\WechatCitys;
use app\models\GoodsCategory;
use app\models\GoodsCategoryAttr;
use app\models\GoodsSku;
use app\models\Merchant;
use app\models\Store;
use app\common\package\phpexcel;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use yii\db\Exception;
use yii\helpers\VarDumper;

class MarketingGoodsController extends BaseController {


    private function getGoodsSkuCategoryAttr($goods_sku) {
        $data = [];
        if (empty($goods_sku)) {
            return $data;
        }

        $goods_category_attr_ids = [];
        foreach ($goods_sku as $key => $val) {
            $goods_category_attr_ids[] = str_replace(',', '', $val -> goods_category_attr_id);
        }

        $goods_category_attr = GoodsCategoryAttr::find()
            -> where(['in', 'id', $goods_category_attr_ids])
            -> all();
        if (empty($goods_category_attr)) {
            return $data;
        }

        $goods_category_attr_name = [];
        foreach ($goods_category_attr as $key => $val) {
            $goods_category_attr_name[] = $val -> attr;
        }

        return implode('/', $goods_category_attr_name);
    }
    /**
     *  获取商品二级规格
     * @param $id
     */
    public function actionGetSubGoodsCategory($id) {

        $data = [];

        $category = GoodsCategoryAttr::find()
            -> where(['and', ['goods_category_id' => $id, 'flag' => FLAG_YES]])
            -> andFilterWhere(['or', ['service_providers_id' => $this -> getServerId()], ['service_providers_id' => 0]])
            -> all();
        if (!empty($category)) {
            foreach ($category as $key => $val) {
                $data[$key] = [
                    'id' => $val -> id,
                    'name' => $val -> attr
                ];
            }
        }

        echo json_encode($data);exit;
    }

    /**
     *  添加商品二级规格
     * @param $pid
     * @param $name
     */
    public function actionAddSubGoodsCategory($pid, $name) {
        $model = new GoodsCategoryAttr();

        $model -> service_providers_id = $this->getServerId();
        $model -> goods_category_id = $pid;
        $model -> attr = $name;
        $model -> create_time = date('Y-m-d H:i:s', time());
        if ($model -> save()) {
            echo json_encode(['id' => $model -> id, 'name' => $model -> attr]);exit;
        } else {
            echo json_encode(['error_msg' => implode(';', $model -> getErrors())]);exit;
        }
    }

    /**
     * 上下架
     */
    public function actionSetStatus(){
        $goods_id = $this->getValue('goods_id');
        $goods = Goods::find()->where('id = :id and flag = :flag',array(
            ':id' => $goods_id,
            ':flag' => FLAG_YES
        ))->one();
        $msg = '';
        if ($goods->status == GOODS_STATUS_NORMAL){
            $goods->status = GOODS_STATUS_CANCEL;
            $msg = '下架';
        }else{
            $goods->status = GOODS_STATUS_NORMAL;
            $msg = '上架';
        }
        if (!$goods->save()){
            $this -> setFlash('error_msg', $msg.'失败');
        }
        return $this->redirect(['list']);
    }

    public function actionAdd(){

        if($this->getValue('type')==2){
            $store_num = 1;
        }elseif ($this->getValue('type')==1){
            $store_num = $this->getValue('store_num');
        }

        $provinceId = isset($_GET['province']) && !empty($_GET['province']) ? $_GET['province'] : '9999';
        $cityId = isset($_GET['city']) && !empty($_GET['city']) ? $_GET['city'] : '9999';
        $regionId = isset($_GET['region']) && !empty($_GET['region']) ? $_GET['region'] : '9999';

        $res = $this->GetRegion($provinceId,$cityId,$regionId);
        $province = $res['province'];

        $sqjq = Block::find()->asArray()->all();
        $standard_rate = $this->getValue('standard_rate');
        $standard_minmun_guarantee = $this->getValue('standard_minmun_guarantee');//保底费

        //门店列表json
        $store_data = $this->getValue('store_data');

        //product_type
        $yljson = [];
        if($this->getValue('ewm')){
            array_push($yljson,['type'=>$this->getValue('ewm'),"channel_type"=>$this->getValue('type1')]);
        }
        if($this->getValue('ylsf')){
            array_push($yljson,['type'=>$this->getValue('ylsf'),"channel_type"=>$this->getValue('type2')]);
        }
        if($this->getValue('ylsk')){
            array_push($yljson,['type'=>$this->getValue('ylsk'),"channel_type"=>$this->getValue('type3')]);
        }
        //merchant_optional
        $optional = [];
        if($this->getValue('optional_test')){
            array_push($optional,['type'=>$this->getValue('optional_test'),"unit_price"=>$this->getValue('optional_test_price'),"store_num"=>$store_num]);
        }
        if($this->getValue('option_satify')){
            array_push($optional,['type'=>$this->getValue('option_satify'),"unit_price"=>$this->getValue('option_satify_price'),"store_num"=>$store_num]);
        }





        //product_type json
        $yljson = json_encode($yljson);
        //merchant_optional_json
        $optional = json_encode($optional);

        if($optional=='[]'){
            $optional = '';
        }


        $ticket_type = $this->getValue('ticket_type');
        $ticket = [];
        if($ticket_type==2){
            $ticket_invoice_title = $this->getValue('ticket_invoice_title');
            $ticket_address = $this->getValue('ticket_address');
            $ticket_code = $this->getValue('ticket_code');
            $ticket_tel = $this->getValue('ticket_tel');
            $ticket_bank = $this->getValue('ticket_bank');
            $ticket_branch_bank = $this->getValue('ticket_branch_bank');
            $ticket_bank_code =$this->getValue('ticket_bank_code');
            $ticket = [
                [
                    'type' => $ticket_type,
                    'invoice_title' => $ticket_invoice_title,
                    'address' => $ticket_address,
                    'code' => $ticket_code,
                    'tel' => $ticket_tel,
                    'bank' => $ticket_bank,
                    'branch_bank' => $ticket_branch_bank,
                    'bank_code' => $ticket_bank_code
                ]
            ];
        }
        if($ticket_type==1){
            $ticket_invoice_title = $this->getValue('ticket_invoice_title1');
            $ticket_code = $this->getValue('ticket_code1');
            $ticket = [
                [
                    'type' => $ticket_type,
                    'invoice_title' => $ticket_invoice_title,
                    'code' => $ticket_code,
                ]
            ];
        }
        if($ticket_type==3){
            $ticket_invoice_title = $this->getValue('ticket_invoice_title1');
            $ticket_code = $this->getValue('ticket_code1');
            $ticket = [
                [
                    'type' => $ticket_type,
                ]
            ];
        }

        $standard = [
            ['rate' => $standard_rate,
            'minimum_guarantee'=>$standard_minmun_guarantee,]
        ];





        //商户标准服务json
        $standard = json_encode($standard);
        //发票信息
        $ticket = json_encode($ticket);
        if($ticket=='[]'){
            $ticket= '';
        }


        $pre_category = Category::find() -> where(['and', ['name' => '商户服务']]) -> one();
        $sub_category = Category::find() -> where(['and', ['name' => '商户执行']]) -> one();
        $get = Yii::$app -> request -> get();

//        if(!empty($get)){
//            foreach (json_decode($store_data) as $key => $val) {
//                $data[$key] = [
//                    $val->name,
//                    $val->business_license_name,
//                    $val->province,
//                    $val->province_code,
//                    $val->city,
//                    $val->city_code,
//                    $val->area,
//                    $val->area_code,
//                    $val->address,
//                    date('Y-m-d H:i:s', time())
//                ];
//            }
//            var_dump($data);
//            var_dump($get);
//            die;
//        }



        if(Yii::$app -> request -> isGet && !empty($get)){
            $db = Yii::$app -> db;
            $tr = $db -> beginTransaction();
            try {
                $merchant = new Merchant();
                $merchant -> type = $get['type'];
                $merchant -> name = $get['name'];
                $merchant -> alias = $get['alias'];
                $merchant -> industry = $get['industry'];
                $merchant -> product_type = $yljson;
                $merchant -> invoice_info = $ticket;
                $merchant -> finance_contact = $get['finance_contact'];
                $merchant -> finance_contact_info = $get['finance_contact_info'];
                $merchant -> create_time = date('Y-m-d H:i:s', time());
                if (!$merchant -> save()) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $merchant -> getErrors());
                }

                $goods = new Goods();
                $goods -> service_providers_id = $this->getServerId();
                $goods -> pre_category_id = $pre_category -> id;
                $goods -> category_id = $sub_category -> id;
                $goods -> name = $get['name'];
                $goods -> goods_img = $get['goods_img'];
                $goods -> content = $get['content'];
                $goods -> merchant_id = $merchant->id;
                $goods -> create_time = date('Y-m-d H:i:s', time());
                $goods -> status = BE_EXAMINE;
                if (!$goods -> save()) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $goods -> getErrors());
                }
                if (empty($standard)) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', '信息不存在');
                }
                $goodsSku = new GoodsSku();
                $goodsSku -> goods_id = $goods->id;
                $goodsSku -> merchant_standard_json = $standard;
                $goodsSku -> merchant_optional_json = $optional;
                $goodsSku -> create_time = date('Y-m-d H:i:s', time());
                if (!$goodsSku -> save()) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $goodsSku -> getErrors());
                }

                if($this->getValue('type')==1){//品牌商户
                    foreach (json_decode($store_data) as $key => $val) {
                        $data[$key] = [
                            $merchant ->id,
                            $goods->id,
                            $val->name,
                            $val->business_license_name,
                            $val->province,
                            $val->province_code,
                            $val->city,
                            $val->city_code,
                            $val->area,
                            $val->area_code,
                            $val->address,
                            date('Y-m-d H:i:s', time())
                        ];
                    }

                foreach ($data as $v){
                    $stores  = new Store();
                    $stores -> merchant_id = $merchant ->id;
                    $stores -> goods_id = $goods -> id;
                    $stores -> name = $v[2];
                    $stores -> business_license_name = $v[3];
                    $stores -> province = $v[4];
                    $stores -> province_code = $v[5];
                    $stores -> city = $v[6];
                    $stores -> city_code = $v[7];
                    $stores -> area = $v[8];
                    $stores -> area_code = $v[9];
                    $stores -> address = $v[10];
                    $stores -> create_time = date('Y-m-d H:i:s', time());
                    if (!$stores -> save()) {
                        $tr -> rollBack();
                        $this -> setFlash('error_msg', $stores -> getErrors());
                    }
                }

                }elseif ($this->getValue('type')==2){   //商圈
                    $store = new Store();
                    $store -> merchant_id = $merchant ->id;
                    $store -> block_id = $this->getValue('block_id');
                    $store -> goods_id = $goods ->id;
                    $store -> name = $this->getValue('name');
                    $store -> business_license_name = $this->getValue('name');
                    $store -> province = $this->getValue('province');
                    $store -> province_code = $this->getValue('province_code');
                    $store -> city = $this->getValue('city');
                    $store -> city_code = $this->getValue('city_code');
                    $store -> area = $this->getValue('area');
                    $store -> area_code = $this->getValue('area_code');
                    $store -> address = $this->getValue('full_address');

                    $store -> create_time = date('Y-m-d H:i:s', time());
                    if (!$store -> save()) {
                        $tr -> rollBack();
                        $this -> setFlash('error_msg', $store -> getErrors());
                    }
                }

                $tr -> commit();
                return $this -> redirect(['list']);
            } catch (Exception $e) {
                $tr -> rollBack();
                $this -> setFlash('error_msg', $e);
            }

        }
        return $this->render('add',[
            'sqlist'=>$sqjq,

            'province' => $province
        ]);

    }

    /**
     * 商户服务列表
     */
    public function actionList(){
        //街区商圈
        $sqjq = Block::find()->asArray()->all();


        //商户服务
        $status = $this->getValue('status');
        $keyword = $this->getValue('keyword');
        $type = $this->getValue('type');
        $block = $this->getValue('block');
        $service_provider_id = $this->getServerId();
        $list = Goods::find()->joinWith('merchant')->joinWith('store')->joinWith('serviceProviders')->joinWith('goodsSku')
            ->where(['category_id'=>2,'yx_goods.flag'=>FLAG_YES,'yx_goods_sku.flag'=>FLAG_YES,'yx_goods.service_providers_id'=>$service_provider_id]);
        $list->andFilterWhere(['yx_goods.status'=>$status])
            ->andFilterWhere(['like', 'yx_merchant.name', $keyword])
            ->andFilterWhere(['type'=>$type])
            ->andFilterWhere(['block_id'=>$block]);

        $pages = PAGE_PARAMS;
        $total = $list->count();
        $page = empty($_GET['page'])?1:$_GET['page'];
        if (!empty($page) && $total != 0 && $page > ceil($total / $pages)) {
            $this->page = ceil($total / $pages);
        }
        $num  = ($page - 1) * $pages;
        $list = $list->orderBy('create_time DESC')->limit($pages)->offset($num)->asArray()->all();


        if(!empty($list)){
            foreach ($list as $k=>$v){
                $list[$k]['type'] = $this->_getType($v['id']);
                $list[$k]['block_name']=$this->_getBlock($v['id']);
            }
        }

        return $this->render('list',[
            'list'=>$list,
            'sqlist'=>$sqjq,
            'page'=>$page,
            'count'=>$total
        ]);
    }

    private function _getType($id){
        $type = MERCHANT_TYPE_PP;
        $model = Store::find()->where(['and',['goods_id'=>$id]])->select('block_id')->one();
        if (!empty($model)){
            if($model->block_id != 0){
                $type = MERCHANT_TYPE_SQ;
            }
        }
        return $type;
    }


    private function _getBlock($id){
        $name = '';
        $model = Store::find()->where(['and',['goods_id'=>$id]])->select('block_id')->one();
        if (!empty($model)){
            if($model->block_id != 0){
                $block = Block::find()->where(['and',['id'=>$model->block_id]])->select('name')->one();
                $name = $block->name;
            }
        }
        return $name;
    }

    /**
     * 商户服务详情
     */
    public function actionView(){
        $sqjq = Block::find()->asArray()->all();
        $id = $this->getValue('id');//商品id
        $service_provider_id = $this->getServerId();
        $res = Goods::find()->joinWith('merchant')->joinWith('store')->joinWith('serviceProviders')->joinWith('goodsSku')
            ->where(['yx_goods.id'=>$id,'yx_goods.flag'=>FLAG_YES,'yx_goods.service_providers_id'=>$service_provider_id]);
        $detail = $res->asArray()->one();

        return $this->render('view',[
            'detail'=>$detail,
            'sqlist'=>$sqjq
        ]);
    }
    /**
     * 商户服务编辑
     */
    public function actionEdit(){

        if($this->getValue('type')==2){
            $store_num = 1;
        }elseif ($this->getValue('type')==1){
            $store_num = $this->getValue('store_num');
        }
        $get = Yii::$app -> request -> get();
        $id = $this->getValue('id');
        $provinceId = isset($_GET['province']) && !empty($_GET['province']) ? $_GET['province'] : '9999';
        $cityId = isset($_GET['city']) && !empty($_GET['city']) ? $_GET['city'] : '9999';
        $regionId = isset($_GET['region']) && !empty($_GET['region']) ? $_GET['region'] : '9999';

        $res = $this->GetRegion($provinceId,$cityId,$regionId);
        $province = $res['province'];

        $sqjq = Block::find()->asArray()->all();
        $standard_rate = $this->getValue('standard_rate');
        $standard_minmun_guarantee = $this->getValue('standard_minmun_guarantee');//保底费

        //门店列表json
        $store_data = $this->getValue('store_data');

        //product_type
        $yljson = [];
        if($this->getValue('ewm')){
            array_push($yljson,['type'=>$this->getValue('ewm'),"channel_type"=>$this->getValue('type1')]);
        }
        if($this->getValue('ylsf')){
            array_push($yljson,['type'=>$this->getValue('ylsf'),"channel_type"=>$this->getValue('type2')]);
        }
        if($this->getValue('ylsk')){
            array_push($yljson,['type'=>$this->getValue('ylsk'),"channel_type"=>$this->getValue('type3')]);
        }
        //merchant_optional
        $optional = [];
        if($this->getValue('optional_test')){
            array_push($optional,['type'=>$this->getValue('optional_test'),"unit_price"=>$this->getValue('optional_test_price'),"store_num"=>$store_num]);
        }
        if($this->getValue('option_satify')){
            array_push($optional,['type'=>$this->getValue('option_satify'),"unit_price"=>$this->getValue('option_satify_price'),"store_num"=>$store_num]);
        }





        //product_type json
        $yljson = json_encode($yljson);
        //merchant_optional_json
        $optional = json_encode($optional);
        if($optional=='[]'){
            $optional = '';
        }


        $ticket_type = $this->getValue('ticket_type');
        $ticket = [];
        if($ticket_type==2){
            $ticket_invoice_title = $this->getValue('ticket_invoice_title');
            $ticket_address = $this->getValue('ticket_address');
            $ticket_code = $this->getValue('ticket_code');
            $ticket_tel = $this->getValue('ticket_tel');
            $ticket_bank = $this->getValue('ticket_bank');
            $ticket_branch_bank = $this->getValue('ticket_branch_bank');
            $ticket_bank_code =$this->getValue('ticket_bank_code');
            $ticket = [
                [
                    'type' => $ticket_type,
                    'invoice_title' => $ticket_invoice_title,
                    'address' => $ticket_address,
                    'code' => $ticket_code,
                    'tel' => $ticket_tel,
                    'bank' => $ticket_bank,
                    'branch_bank' => $ticket_branch_bank,
                    'bank_code' => $ticket_bank_code
                ]
            ];
        }
        if($ticket_type==1){
            $ticket_invoice_title = $this->getValue('ticket_invoice_title1');
            $ticket_code = $this->getValue('ticket_code1');
            $ticket = [
                [
                    'type' => $ticket_type,
                    'invoice_title' => $ticket_invoice_title,
                    'code' => $ticket_code,
                ]
            ];
        }
        if($ticket_type==3){
            $ticket_invoice_title = $this->getValue('ticket_invoice_title1');
            $ticket_code = $this->getValue('ticket_code1');
            $ticket = [
                [
                    'type' => $ticket_type,
                ]
            ];
        }

        $standard = [
            ['rate' => $standard_rate,
                'minimum_guarantee'=>$standard_minmun_guarantee,]
        ];


        //商户标准服务json
        $standard = json_encode($standard);
        //发票信息
        $ticket = json_encode($ticket);
        if($ticket=='[]'){
            $ticket= '';
        }




        $merchant_id= '';
        $find = Goods::find()->where(['flag'=>FLAG_YES,'id'=>$id])->select('merchant_id')->asArray()->one();
        if(!empty($find)){
            $merchant_id = $find['merchant_id'];
        }





        if(Yii::$app -> request -> isGet && !empty($get['name']) && !empty($merchant_id)){
            $db = Yii::$app -> db;
            $tr = $db -> beginTransaction();
            try {
                $merchant = Merchant::find()->where(['flag'=>FLAG_YES,'id'=>$merchant_id])->one();
                $merchant -> type = $get['type'];
                $merchant -> name = $get['name'];
                $merchant -> alias = $get['alias'];
                $merchant -> industry = $get['industry'];
                $merchant -> product_type = $yljson;
                $merchant -> invoice_info = $ticket;
                $merchant -> finance_contact = $get['finance_contact'];
                $merchant -> finance_contact_info = $get['finance_contact_info'];
                $merchant -> create_time = date('Y-m-d H:i:s', time());
                if (!$merchant -> save()) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $merchant -> getErrors());
                }
                $goods = Goods::find()->where(['flag'=>FLAG_YES,'id'=>$id])->one();
                $goods -> name = $get['name'];
                $goods -> goods_img = $get['goods_img'];
                $goods -> content = $get['content'];
                $goods -> create_time = date('Y-m-d H:i:s', time());
                $goods -> status = BE_EXAMINE;
                if (!$goods -> save()) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $goods -> getErrors());
                }
                if (empty($standard)) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', '信息不存在');
                }


                $goodsSku = GoodsSku::find()->where(['flag'=>FLAG_YES,'goods_id'=>$id])->one();
                $goodsSku -> merchant_standard_json = $standard;
                $goodsSku -> merchant_optional_json = $optional;
                $goodsSku -> create_time = date('Y-m-d H:i:s', time());
                if (!$goodsSku -> save()) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $goodsSku -> getErrors());
                }

                $store_delete = Store::find()->where(['flag'=>FLAG_YES,'goods_id'=>$id])->all();
                foreach ($store_delete as $v){
                    $v->flag = FLAG_NO;
                    $v->delete();
                }
                if($this->getValue('type')==1){//品牌商户
                    foreach (json_decode($store_data) as $key => $val) {
                        $data[$key] = [
                            $merchant ->id,
                            $goods->id,
                            $val->name,
                            $val->business_license_name,
                            $val->province,
                            $val->province_code,
                            $val->city,
                            $val->city_code,
                            $val->area,
                            $val->area_code,
                            $val->address,
                            date('Y-m-d H:i:s', time())
                        ];
                    }
                    foreach ($data as $v){
                        $stores  = new Store();
                        $stores -> merchant_id = $merchant ->id;
                        $stores -> goods_id = $goods -> id;
                        $stores -> name = $v[2];
                        $stores -> business_license_name = $v[3];
                        $stores -> province = $v[4];
                        $stores -> province_code = $v[5];
                        $stores -> city = $v[6];
                        $stores -> city_code = $v[7];
                        $stores -> area = $v[8];
                        $stores -> area_code = $v[9];
                        $stores -> address = $v[10];
                        $stores -> create_time = date('Y-m-d H:i:s', time());
                        if (!$stores -> save()) {
                            $tr -> rollBack();
                            $this -> setFlash('error_msg', $stores -> getErrors());
                        }
                    }


                }elseif ($this->getValue('type')==2){   //商圈
                    $store_delete = Store::find()->where(['flag'=>FLAG_YES,'goods_id'=>$id])->all();
                    foreach ($store_delete as $v){
                        $v->flag = FLAG_NO;
                        $v->save();
                    }
                    $store = new Store();
                    $store -> merchant_id = $merchant ->id;
                    $store -> block_id = $this->getValue('block_id');
                    $store -> goods_id = $goods ->id;
                    $store -> name = $this->getValue('name');
                    $store -> business_license_name = $this->getValue('name');
                    $store -> province = $this->getValue('province');
                    $store -> province_code = $this->getValue('province_code');
                    $store -> city = $this->getValue('city');
                    $store -> city_code = $this->getValue('city_code');
                    $store -> area = $this->getValue('area');
                    $store -> area_code = $this->getValue('area_code');
                    $store -> address = $this->getValue('full_address');

                    $store -> create_time = date('Y-m-d H:i:s', time());
                    if (!$store -> save()) {
                        $tr -> rollBack();
                        $this -> setFlash('error_msg', $store -> getErrors());
                    }
                }

                $tr -> commit();
                return $this -> redirect(['list']);
            } catch (Exception $e) {
                $tr -> rollBack();
                $this -> setFlash('error_msg', $e);
            }

        }

        $provinceId = isset($_GET['province']) && !empty($_GET['province']) ? $_GET['province'] : '9999';
        $cityId = isset($_GET['city']) && !empty($_GET['city']) ? $_GET['city'] : '9999';
        $regionId = isset($_GET['region']) && !empty($_GET['region']) ? $_GET['region'] : '9999';

        $res = $this->GetRegion($provinceId,$cityId,$regionId);
        $province = $res['province'];
        $sqjq = Block::find()->asArray()->all();
        $id = $this->getValue('id');//商品id
        $service_provider_id = $this->getServerId();
        $res = Goods::find()->joinWith('merchant')->joinWith('store')->joinWith('serviceProviders')->joinWith('goodsSku')
            ->where(['yx_goods.id'=>$id,'yx_goods.flag'=>FLAG_YES,'yx_goods_sku.flag'=>FLAG_YES,'yx_goods.service_providers_id'=>$service_provider_id]);
        $detail = $res->asArray()->one();
        $store_json = [];
        if(!empty($detail)){
            $store_json = json_encode($detail['store']);
        }
        return $this->render('edit',[
            'detail' => $detail,
            'sqlist' => $sqjq,
            'province' => $province,
            'store_json'=> $store_json

        ]);


    }

    public function GetRegion($provinceId,$cityId,$regionId) {
        $data =[];
        $province = dataHelp::regionConversionArray(Region::find() -> where('area_parent_id = 1') -> all());
        $city = dataHelp::regionConversionArray(Region::find() -> where('area_parent_id = :area_parent_id', [':area_parent_id' => $provinceId]) -> all());
        $region = dataHelp::regionConversionArray(Region::find() -> where('area_parent_id = :area_parent_id', [':area_parent_id' => $cityId]) -> all());
        $this -> response = array(
            'errCode' => 0,
        );
        $data = array(
            'province' => $province,
            'city' => $city,
            'region' => $region
        );

        return $data;
    }

    public function actionGetCity() {
        $check = $this -> checkValid(['provinceId', 'cityId']);
        if ($check) {
            $provinceId = $this -> request['provinceId'];
            $province = dataHelp::regionWechatConversionArray(WechatCitys::find() -> where('parent_id = :parent_id', [':parent_id' => 1]) -> all());
            $city = dataHelp::regionWechatConversionArray(WechatCitys::find() -> where('parent_id = :parent_id', [':parent_id' => $provinceId]) -> all());
            $this -> response = array(
                'errCode' => API_ERROR_CODE_SUCCESS,
                'errMsg' => $GLOBALS['__API_ERROR_CODE'][API_ERROR_CODE_SUCCESS]
            );
            $this -> response['data'] = array(
                'province' => $province,
                'city' => $city
            );
        } else {
            $this -> response = array(
                'errCode' => API_ERROR_CODE_LACK_PARAMS,
                'errMsg' => $GLOBALS['__API_ERROR_CODE'][API_ERROR_CODE_LACK_PARAMS]
            );
        }
        $this -> responseJson();
    }

    /**
     * 获取市区数据
     */
    public function actionGetAddress() {
        $id = $this->getValue('pid');

        if ($id) {
            $list = Region::find() -> where('area_parent_id = :area_parent_id', [':area_parent_id' => $id]) -> all();
            $data = dataHelp::regionConversionArray($list);
            $this -> response = array(
                'errCode'=> 0,
                'data' => $data
            );
        } else {
            $this -> response = array(
                'errCode'=> 1,
                'errMsg' => 'error'
            );
        }
        $this -> responseJson();
    }

    /**
     * 获取市区数据wechat
     */
    public function actionGetWechatAddress() {
        $id = $this->getValue('pid');
        if ($id) {
            $list = WechatCitys::find() -> where('parent_id = :parent_id', [':parent_id' => $id]) -> all();
            $data = dataHelp::regionWechatConversionArray($list);
            $this -> response = array(
                'errCode'=> 0,
                'data' => $data
            );
        } else {
            $this -> response = array(
                'errCode'=> 1,
                'errMsg' => 'error'
            );
        }
        $this -> responseJson();
    }

    /**
     * 渲染门店列表
     */
    public function actionGetPca(){
        $service_provider_id = $this->getServerId();
        $num  = empty($_GET['num'])?0:$_GET['num'];
        $goods_id = $this->getValue('goods_id');
        $store = [];
        $store_json = '';
        $store_type = MERCHANT_TYPE_PP;
        if(!empty($goods_id)){

            $store_arr = Store::find()->where(['goods_id'=>$goods_id,'yx_store.flag'=>FLAG_YES])->asArray()->all();

           $store_type = MERCHANT_TYPE_PP;
           foreach ($store_arr as $v){
               if($v['block_id']!=0){
                   $store_type = MERCHANT_TYPE_SQ;
               }
           }
            if($store_type==MERCHANT_TYPE_PP){
                $store = $store_arr;
                $store_json = json_encode($store_arr);
            }
        }



        $provinceId = isset($_GET['province']) && !empty($_GET['province']) ? $_GET['province'] : '9999';
        $cityId = isset($_GET['city']) && !empty($_GET['city']) ? $_GET['city'] : '9999';
        $regionId = isset($_GET['region']) && !empty($_GET['region']) ? $_GET['region'] : '9999';

        $res = $this->GetRegion($provinceId,$cityId,$regionId);
        $province = $res['province'];


        return $this->renderPartial('get_pca',[
            'province'=>$province,
            'num'=>$num,
            'store'=>$store,
            'store_json'=>$store_json
        ]);
    }

    /**
     * 批量上传门店
     */
    public function actionStoreUpload(){
        $phpexcel = new phpexcel\Pexcel();
        $excel = $phpexcel -> GetData();
        $provinceId = isset($_GET['province']) && !empty($_GET['province']) ? $_GET['province'] : '9999';
        $cityId = isset($_GET['city']) && !empty($_GET['city']) ? $_GET['city'] : '9999';
        $regionId = isset($_GET['region']) && !empty($_GET['region']) ? $_GET['region'] : '9999';

        $res = $this->GetRegion($provinceId,$cityId,$regionId);
        $province = $res['province'];

//        var_dump($_POST['num']);


        return $this->renderPartial('uploadstore',[
            'data'=>$excel,
            'province'=>$province,
            'store_json'=>json_encode($excel),
            'num'=>$_POST['num']
        ]);

    }

    public function actionAddStoreList(){
        return $this->render('addstorelist');
    }


}