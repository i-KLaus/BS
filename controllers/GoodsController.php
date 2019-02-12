<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/7/18
 * Time: 15:46
 */

namespace app\controllers;


use app\common\util\email;
use app\components\BaseController;
use app\models\Category;
use app\components\widgets\goods\GoodsSetWidget;
use app\models\Goods;
use app\models\GoodsCategory;
use app\models\GoodsCategoryAttr;
use app\models\GoodsSku;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use app\common\util\dataHelp;

class GoodsController extends BaseController {

    /**
     * 商品列表
     */
    public function actionList() {
        $server_id = $this->getServerId();
        $category_p_id = $this -> getValue('category_p_id');
        $category_id = $this -> getValue('category_id');
        $keyword = $this -> getValue('keyword');
        $status = $this -> getValue('status');
        $page = $this -> getValue('page', 1);
        $list = [];

        $category = Category::find()
            -> where(['and', ['p_id' => 0, 'flag' => FLAG_YES]])
            -> andWhere(['<>', 'name', '商户服务'])
            -> all();

        $sub_category = Category::find() -> where(['and', ['name' => '商户执行']]) -> one();

        $model = Goods::find()
            -> where(['and', ['service_providers_id' => $server_id, 'flag' => FLAG_YES]])
            -> andWhere(['<>', 'category_id', $sub_category -> id]);

        //关键字搜索
        $model -> andFilterWhere(['like', 'name', $keyword]);
        //上下架状态搜索
        $model -> andFilterWhere(['and', ['status' => $status]]);
        //二级类别搜索
        $model -> andFilterWhere(['and', ['category_id' => $category_id]]);
        //服务类别搜索
        if (empty($category_id) && !empty($category_p_id)) {
            $model -> andWhere(['and', ['pre_category_id' => $category_p_id]]);
        }


        $count = $model -> count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => PAGE_PARAMS]);
        $model = $model
            -> with(['preCategory', 'category', 'serviceProviders'])
            -> offset($pages -> offset)
            -> limit($pages -> limit)
            -> orderBy('create_time DESC')
            -> all();
        if (!empty($model)) {
            foreach ($model as $key => $val) {
                $list[$key] = [
                    'id' => $val -> id,
                    'goods_img' => json_decode($val -> goods_img, true),
                    'name' => $val -> name,
                    'status' => $val -> status,
                    'p_category_name' => $val -> preCategory -> name,
                    'category_name' => $val -> category -> name,
                    'min_price' => dataHelp::convertYuan($this -> getMinGoodsPrice($val -> id)),
                    'max_price' => dataHelp::convertYuan($this -> getMaxGoodsPrice($val -> id)),
                    'service_name' => $val -> serviceProviders -> name,
                    'create_time' => $val -> create_time
                ];
            }
        }

        return $this -> render('list', [
            'list' => $list,
            'category_p_id' => $category_p_id,
            'category_id' => $category_id,
            'keyword' => $keyword,
            'status' => $status,
            'count' => $count,
            'page' => $page,
            'category' => $category
        ]);
    }

    /**
     * 获取最高价
     */
    private function getMinGoodsPrice($goods_id) {
        return GoodsSku::find() -> where(['and', ['goods_id' => $goods_id, 'flag' => FLAG_YES]]) -> min('price');
    }

    /**
     * 获取最低价
     */
    private function getMaxGoodsPrice($goods_id) {
        return GoodsSku::find() -> where(['and', ['goods_id' => $goods_id, 'flag' => FLAG_YES]]) -> max('price');
    }

    /**
     *  获取商品二级规格
     * @param $id
     */
    public function actionGetSubGoodsCategory() {
        $id = explode('||', $this->getValue('id'))[0];
        $data['data'] = [];
        $data['property'] = [];
        $html = '';
        $category = GoodsCategoryAttr::find()
            -> where(['and', ['goods_category_id' => $id, 'flag' => FLAG_YES]])
            -> andFilterWhere(['or', ['service_providers_id' => $this -> getServerId()], ['service_providers_id' => 0]])
            -> all();
        if (!empty($category)) {
            foreach ($category as $key => $val) {
                $data['data'][$val->id] = [
                    'id' => $val -> id,
                    'goods_category_id' => $val ->goods_category_id,
                    'value' => $val -> attr
                ];
            }
            foreach ($data['data'] as $propertyId=>$property){
                $html .= '<option value="'.$propertyId.'||'.$property['goods_category_id'].'||'.$property['value'].'">'.$property['value'].'</option>';
            }
            $data['property'] = $html;
        }

        echo json_encode($data);exit;
    }

    /**
     *  添加商品一级规格
     * @param string $name
     */
    public function actionAddGoodsCategory() {
        $name = $this->getValue('name');
        $model = new GoodsCategory();

        $model -> service_providers_id = Yii::$app -> user -> identity -> getId();
        $model -> name = $name;
        $model -> create_time = date('Y-m-d H:i:s', time());
        if ($model -> save()) {
            echo $model -> id.'||'.  $model -> name;exit;
        } else {
            echo json_encode(['error_msg' => implode(';', $model -> getErrors())]);exit;
        }
    }

    /**
     *  添加商品二级规格
     * @param $pid
     * @param $name
     */
    public function actionAddSubGoodsCategory() {
        $pid = $this->getValue('pid');
        $name = $this->getValue('name');
        $model = new GoodsCategoryAttr();

        $model -> service_providers_id = Yii::$app -> user -> identity -> getId();
        $model -> goods_category_id = $pid;
        $model -> attr = $name;
        $model -> create_time = date('Y-m-d H:i:s', time());
        if ($model -> save()) {
            echo $model -> id;exit;
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

    /**
     * 添加
     */
    public function actionAdd() {

        $category = Category::find()
            -> where(['and', ['p_id' => 0, 'flag' => FLAG_YES]])
            -> andWhere(['<>', 'name', '商户服务'])
            -> asArray()
            -> all();

        $goods_data = $this->getValue('goods_data');
        if(!empty($goods_data)){
            foreach (json_decode($goods_data) as $k=>$v){
                $arr_price[$k] = $v->price;
            }
        }

        $get = Yii::$app -> request -> get();
        if (Yii::$app -> request -> isGet && !empty($get)) {
            $db = Yii::$app -> db;
            $tr = $db -> beginTransaction();
            try {
                $goods = new Goods();
                $goods -> service_providers_id = Yii::$app -> user -> identity -> getId();
                $goods -> pre_category_id = $get['category_p_id'];
                $goods -> category_id = $get['category_id'];
                $goods -> name = $get['name'];
                $goods -> goods_img = $get['goods_img'];
                $goods -> content = $get['content'];
                $goods -> min_price = min($arr_price)*100;
                $goods -> max_price = max($arr_price)*100;
                $goods -> create_time = date('Y-m-d H:i:s', time());
                $goods ->status = BE_EXAMINE;
                if (!$goods -> save()) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $goods -> getErrors());
                }

                $data = [];
                if (empty($goods_data)) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', '商品信息不存在');
                }
                foreach (json_decode($goods_data) as $key => $val) {
                    $data[$key] = [
                        $goods->id,
                        $val->category_id,
                        !empty($val->price) ? dataHelp::convertCent($val->price) : 0,
                        date('Y-m-d H:i:s', time())
                    ];
                }
                $num = $db
                    -> createCommand()
                    -> batchInsert(GoodsSku::tableName(), ['goods_id', 'goods_category_attr_id', 'price', 'create_time'], $data)
                    -> execute();
                $tr -> commit();
                return $this -> redirect(['list']);
            } catch (Exception $e) {
                $tr -> rollBack();
                $this -> setFlash('error_msg', $e);
            }
        }
        return $this->render('add',[
            'category' => $category
        ]);
    }

    /**
     * 商品详情
     */
    public function actionView(){
        $id = $this->getValue('id');
        $res = Goods::find()->with(['preCategory', 'category', 'serviceProviders','goodsSku'])
            ->where(['id'=>$id])
            ->asArray()
            ->one();
        $category = $res['goodsSku'];

        $arr = [];
        $category_attr_id = [];//规格id
        if(!empty($category)){
            foreach ($category as $k=> $v){
                $arr[] = $v['id'].$v['goods_category_attr_id'].$v['price'].',';
            }

            foreach ($arr as $key => $val){
                $c_arr = [];
                $category_str = trim($val,',');
                $c_arr = explode(',',$category_str);
                $category_attr_id[] = $c_arr;

            }
        }


        $attr_arr = [];
        $category_name= [];
        if(!empty($category_attr_id)){
            $category_id = [];
            $attr_first_id = GoodsCategoryAttr::find()->where(['flag'=>FLAG_YES,'id'=>$category_attr_id[0][0]])->select('goods_category_id')->asArray()->one();
            $attr_second_id = GoodsCategoryAttr::find()->where(['flag'=>FLAG_YES,'id'=>$category_attr_id[0][1]])->select('goods_category_id')->asArray()->one();
            $category_id = [$attr_first_id,$attr_second_id];

            if(!empty($category_id)){
                $category_name = [];
                foreach ($category_id as $v){
                    $cat_name = GoodsCategory::find()->where(['flag'=>FLAG_YES,'id'=>$v['goods_category_id']])->select('name')->asArray()->one();
                    $category_name[] = $cat_name;

                }
            }


            foreach ($category_attr_id as $k=>$v){
                //拥有2条attr
                if(count($v)==4) {
                    $attr_first = GoodsCategoryAttr::find()->where(['flag' => FLAG_YES, 'id' => $v[1]])->select('attr')->asArray()->one();
                    $attr_second = GoodsCategoryAttr::find()->where(['flag' => FLAG_YES, 'id' => $v[2]])->select('attr')->asArray()->one();
                    $attr_arr[] = [$v[0],$attr_first, $attr_second, $v[3]];
                }else{//一条attr
                    $attr =  GoodsCategoryAttr::find()->where(['flag' => FLAG_YES, 'id' => $v[1]])->select('attr')->asArray()->one();
                    $attr_arr[] = [$v[0],$attr, $v[2]];
                }

            }

        }

        return $this->render('view',[
            'goods'=>$res,
            'attr'=>$attr_arr,
            'category_name'=>$category_name
        ]);
    }

    /**
     * 获取1级规格
     */
    public function actionCategoryList(){
        $server_id = $this->getServerId();
        $list = GoodsCategory::find()
            -> andFilterWhere(['or', ['service_providers_id' => $this -> getServerId()], ['service_providers_id' => 0]])
            ->select('id,name')->asArray()->all();

        $data= [];
        if(!empty($list)){
            foreach ($list as $k => $v){
                $data[$v['id']] = ['name'=>$v['name']];
            }
            echo json_encode($data);
        }else{
            echo json_encode(['errMsg'=>'error']);
        }

    }

    /**
     * 商品分类二级下拉框ajax
     */
    public function actionGetSubCategory($p_id) {
        $data = [];

        if ($p_id == '') {
            echo json_encode($data);exit;
        }

        $category = Category::find()
            -> where(['and', ['p_id' => $p_id, 'flag' => FLAG_YES]])
            -> andWhere(['<>', 'name', '商户执行'])
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
     * 渲染商品规格列表
     */
    public function actionGetSku(){
        $category = $this->getValue('category');
        $categorys_property = $this->getValue('categorys_property');
        $goodsId = $this->getValue('goodsId');
        $data_category = [];
        if (!empty($category)) {
            foreach ($category as $val) {
                $str = explode('||', $val);
                $data_category[$str[0]] = $str[1];
            }
        }

        $data_categorys_property = [];
        if (!empty($categorys_property)) {
            foreach ($categorys_property as $val) {
                $str = explode('||', $val);
                $data_categorys_property[$str[1]][] = $val;
            }
        }

        $sku = array(); //存储sku 组合值的信息
        foreach ($data_category as $k => $v) {
            $num = 0;
            $tmpArr = $sku;
            if(!empty($tmpArr)) {
                foreach ($tmpArr as $k1 => $v1) {
                    if(!empty($data_categorys_property[$k])) {
                        foreach ($data_categorys_property[$k] as $k2 => $v2) {
                            $str = explode('||', $v2);
                            if (!empty($v1) && !empty($str[0])) {
                                $sku[$num] = ['id' => $v1['id'] . "," . $str[0], 'name' => $v1['name'].' - '.$str[2], 'num' => ''];
                                $num += 1;
                            }
                        }
                    }
                }
            } else {
                foreach ($data_categorys_property[$k] as $_v) {
                    $str = explode('||', $_v);
                    $sku[$num] = ['id' => $str[0], 'name' => $str[2]];
                    $num += 1;
                }
            }
        }

        $goods = [];
        if ($goodsId){
            $goodsDetail = $this ->getData(['goodsId'=>$goodsId], URL_MALL_GOODS_DETAIL);
            $goods['goodsDetail'] = $goodsDetail['data'];
        }

        return $this->renderPartial('get-sku', [
                'data_category' => $data_category,
                'sku' => $sku,
            ]+$goods);
    }

    /**
     * 编辑商品
     */
    public function actionEdit(){
        $id = $this->getValue('id');
        $category_ids = Category::find()
            -> where(['and', ['p_id' => 0, 'flag' => FLAG_YES]])
            -> andWhere(['<>', 'name', '商户服务'])
            -> asArray()
            -> all();
        $goods = Goods::find()->where(['id'=>$id,'flag'=>FLAG_YES])->asArray()->one();

        $res = Goods::find()->with(['preCategory', 'category', 'serviceProviders','goodsSku'])
            ->where(['id'=>$id])
            ->asArray()
            ->one();
        $category = $res['goodsSku'];

        $arr = [];
        $category_attr_id = [];//规格id
        if(!empty($category)){
            foreach ($category as $k=> $v){
                $arr[] = $v['id'].$v['goods_category_attr_id'].$v['price'].',';
            }

            foreach ($arr as $key => $val){
                $c_arr = [];
                $category_str = trim($val,',');
                $c_arr = explode(',',$category_str);
                $category_attr_id[] = $c_arr;

            }
        }

        $attr_arr = [];
        $category_name= [];

        if(!empty($category_attr_id)){
            $category_id = [];
            $attr_first_id = GoodsCategoryAttr::find()->where(['flag'=>FLAG_YES,'id'=>$category_attr_id[0][0]])->select('goods_category_id')->asArray()->one();
            $attr_second_id = GoodsCategoryAttr::find()->where(['flag'=>FLAG_YES,'id'=>$category_attr_id[0][1]])->select('goods_category_id')->asArray()->one();
            $category_id = [$attr_first_id,$attr_second_id];

            if(!empty($category_id)){
                $category_name = [];
                foreach ($category_id as $v){
                    $cat_name = GoodsCategory::find()->where(['flag'=>FLAG_YES,'id'=>$v['goods_category_id']])->select('name')->asArray()->one();
                    $category_name[] = $cat_name;

                }
            }


            foreach ($category_attr_id as $k=>$v){
                //拥有2条attr
                if(count($v)==4) {
                    $attr_first = GoodsCategoryAttr::find()->where(['flag' => FLAG_YES, 'id' => $v[1]])->select('attr')->asArray()->one();
                    $attr_second = GoodsCategoryAttr::find()->where(['flag' => FLAG_YES, 'id' => $v[2]])->select('attr')->asArray()->one();
                    $attr_arr[] = [$v[0],$attr_first, $attr_second, $v[3]];
                }else{//一条attr
                    $attr =  GoodsCategoryAttr::find()->where(['flag' => FLAG_YES, 'id' => $v[1]])->select('attr')->asArray()->one();
                    $attr_arr[] = [$v[0],$attr, $v[2]];
                }
            }
        }

        $arr_price = [];
        $goods_id = $this->getValue('goods_id');
        $goods_data = $this->getValue('goods_sku');

        $sku_data= [];
        if(!empty($goods_data)){
            foreach (json_decode($goods_data) as $k=>$v){
                $arr_price[$k] = $v->price;
            }
            foreach (json_decode($goods_data) as $key => $val) {
                $sku_data[$key] = [
                    $val->price,
                    $val->sku_id
                ];
            }
        }
        if (Yii::$app -> request -> isGet && !empty($goods_id)) {
                $db = Yii::$app -> db;
                $tr = $db -> beginTransaction();
                try {
                    $goodsmodel = Goods::find()->where(['flag'=>FLAG_YES,'id'=>$goods_id])->one();
                    $goodsmodel -> pre_category_id = $this->getValue('category_p_id');
                    $goodsmodel -> category_id = $this->getValue('category_id');
                    $goodsmodel -> name = $this->getValue('name');
                    $goodsmodel -> goods_img = $this->getValue('goods_img');
                    $goodsmodel -> content = $this->getValue('content');
                    if(count($arr_price)>1){
                        $goodsmodel -> min_price = (int)min($arr_price);
                        $goodsmodel -> max_price = (int)max($arr_price);
                    }else{
                        $goodsmodel -> min_price = (int)$arr_price[0];
                        $goodsmodel -> max_price = (int)$arr_price[0];
                    }
                    $goodsmodel -> create_time = date('Y-m-d H:i:s', time());
                    $goodsmodel -> status = BE_EXAMINE;
                    $goodsmodel -> save();
                    if (!$goodsmodel -> save()) {
                        $tr -> rollBack();
                        $this -> setFlash('error_msg', $goodsmodel -> getErrors());
                    }

                    $data = [];
                    if (empty($goods_data)) {
                        $tr -> rollBack();
                        $this -> setFlash('error_msg', '商品信息不存在');
                    }
                    foreach ($sku_data as $v){
                        $goods_sku = GoodsSku::find()->where(['flag'=>FLAG_YES,'id'=>$v[1]])->one();
                        $goods_sku -> price = dataHelp::convertCent($v[0]);
                        if (!$goods_sku -> save()) {
                            $tr -> rollBack();
                            $this -> setFlash('error_msg', $goods_sku -> getErrors());
                        }
                    }
                    $tr -> commit();
                    return $this -> redirect(['list']);
                } catch (Exception $e) {
                    $tr -> rollBack();
                    $this -> setFlash('error_msg', $e);
                }
        }


        return $this->render('edit',[
            'goods'=>$goods,
            'category'=>$category_ids,
            'attr'=>$attr_arr
        ]);
    }
}