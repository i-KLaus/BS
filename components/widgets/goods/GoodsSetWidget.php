<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/7/19
 * Time: 14:51
 */

namespace app\components\widgets\goods;


use app\common\util\dataHelp;
use app\components\widgets\components\BaseWidget;
use app\models\Category;
use app\models\GoodsCategory;
use app\models\GoodsCategoryAttr;
use app\models\GoodsSku;
use Yii;

class GoodsSetWidget extends BaseWidget {
    public $category_id;
    public $goods_id = '';

    public function run() {
        $category = Category::find()
            -> where(['and', ['id' => $this -> category_id, 'flag' => FLAG_YES]])
            -> one();

        switch ($category -> name) {
            case '物料投放':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['物料种类', '区域2']);
                return $this -> render('goodsSetWltf', ['data' => $form, 'goods' => $goods]);
                break;
            case '培训巡检':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['巡检类型', '区域2']);
                return $this -> render('goodsSetXjlx', ['data' => $form, 'goods' => $goods]);
                break;
            case '宣传策划':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['种类']);
                return $this -> render('goodsSetXcch', ['data' => $form, 'goods' => $goods]);
                break;
            case '地推服务':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['时间段1', '区域2']);
                return $this -> render('goodsSetDtfw', ['data' => $form, 'goods' => $goods]);
                break;
            case '媒体广告制作与投放':
            case '营销服务的第三方评估与监测':
                $category = $this -> getCategory();
                $goods = $this -> getCustomizeSingleCategoryGoods($this -> goods_id);
                $current = current($goods);
                $category_pid = !empty($current) ? $current['category_pid'] : '';
                return $this -> render('goodsSetCustomizeSingleCategory', ['category' => $category, 'goods' => $goods, 'category_pid' => $category_pid]);
                break;
            case 'APP获客':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['时间段2']);
                return $this -> render('goodsSetApp', ['data' => $form, 'goods' => $goods]);
                break;
            case '发卡用卡':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['时间段2']);
                return $this -> render('goodsSetFkyk', ['data' => $form, 'goods' => $goods]);
                break;
            case '存贷业务':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['时间段2']);
                return $this -> render('goodsSetChyw', ['data' => $form, 'goods' => $goods]);
                break;
            case '客服处理':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['类型', '时间']);
                return $this -> render('goodsSetKfcl', ['data' => $form, 'goods' => $goods]);
                break;
            case '市场调研':
                $goods = $this -> getGoodsSku($this -> goods_id);
                $form = $this -> buildFormData(['时间段3']);
                return $this -> render('goodsSetScdy', ['data' => $form, 'goods' => $goods]);
                break;
            case '物料制作':
            case '业务咨询':
            case '其他服务':
            case '线下展会':
                $category = $this -> getCategory();
                $data = $this -> getCustomizePluralCategoryGoods($this -> goods_id);
                return $this -> render('goodsSetCustomizePluralCategory', ['category' => $category, 'data' => $data]);
                break;
        }
    }

    private function buildFormData($array) {
        $data = [];
        foreach ($array as $key => $val) {
            $category = GoodsCategory::find()
                -> where(['and', ['name' => $val]])
                -> with(['goodsCategoryAttr'])
                -> one();
            $data[$category -> name] = $category -> id;
            if (!empty($category -> goodsCategoryAttr)) {
                foreach ($category -> goodsCategoryAttr as $k => $v) {
                    $data[$v -> attr] = $v -> id;
                }
            }
        }

        return $data;
    }

    private function getGoodsSku($goods_id) {
        $data = [];
        if (!empty($goods_id)) {
            $list = GoodsSku::find()
                -> where(['and', ['goods_id' => $goods_id, 'flag' => FLAG_YES]])
                -> all();
            if (!empty($list)) {
                foreach ($list as $key => $val) {
                    $data[$val -> goods_category_attr_id] = [
                        'price' => floatval(dataHelp::convertYuan($val -> price)),
                        'bill_rate' => floatval($val -> bill_rate),
                        'limit_num' => $val -> limit_num
                    ];
                }
            }
        }

        return $data;
    }

    private function getCategory() {
        $data = [];
        $category = GoodsCategory::find()
            -> where(['and', ['service_providers_id' => Yii::$app -> session -> get('pid'), 'flag' => FLAG_YES]])
            -> all();
        if (!empty($category)) {
            foreach ($category as $key => $val) {
                $data[$key] = [
                    'id' => $val -> id,
                    'name' => $val -> name
                ];
            }
        }

        return $data;
    }

    private function getCustomizeSingleCategoryGoods($goods_id) {
        $data = [];
        if (!empty($goods_id)) {
            $list = GoodsSku::find()
                -> where(['and', ['goods_id' => $goods_id, 'flag' => FLAG_YES]])
                -> all();
            if (!empty($list)) {
                foreach ($list as $key => $val) {
                    $category = $this -> getCategoryView(str_replace(',', '', $val -> goods_category_attr_id));
                    $data[$val -> goods_category_attr_id] = [
                        'id' => $val -> id,
                        'price' => floatval(dataHelp::convertYuan($val -> price)),
                        'bill_rate' => floatval($val -> bill_rate),
                        'limit_num' => $val -> limit_num,
                        'category_pid' => $category -> goods_category_id,
                        'category_id' => $category -> id,
                        'category_name' => $category -> attr,
                    ];
                }
            }
        }

        return $data;
    }

    private function getCustomizePluralCategoryGoods($goods_id) {
        $data = [];
        $p_category_data = [];
        $category_data = [];
        if (!empty($goods_id)) {
            $list = GoodsSku::find()
                -> where(['and', ['goods_id' => $goods_id, 'flag' => FLAG_YES]])
                -> all();
            if (!empty($list)) {
                foreach ($list as $key => $val) {
                    $category_ids = array_filter(explode(',', $val -> goods_category_attr_id));
                    $p_category = $this -> getCategoryView($category_ids[1]);
                    $category = !empty($category_ids[2]) ? $this -> getCategoryView($category_ids[2]) : [];

                    if (empty($data['p_category_id'])) {
                        $data['p_category_id'] = $p_category -> goods_category_id;
                    }
                    if (empty($data['category_id']) && !empty($category)) {
                        $data['category_id'] = $category -> goods_category_id;
                    }

                    if (empty($p_category_data[$category_ids[1]])) {
                        $p_category_data[$p_category -> id] = $p_category -> attr;
                    }
                    if (!empty($category)) {
                        $category_data[$category -> id] = $category -> attr;
                    }

                    $data['goods'][] = [
                        'price' => floatval(dataHelp::convertYuan($val -> price)),
                        'p_category_id' => $p_category -> id,
                        'p_category_name' => $p_category -> attr,
                        'category_id' => !empty($category) ? $category -> id : '',
                        'category_name' => !empty($category) ? $category -> attr : ''
                    ];
                    $data['p_category'] = $p_category_data;
                    $data['category'] = $category_data;
                }
            }
        }

        return $data;
    }

    /**
     * @param $category_id
     * @return array|null|\yii\db\ActiveRecord
     */
    private function getCategoryView($category_id) {
        $category = GoodsCategoryAttr::find()
            -> where(['id' => $category_id])
            -> one();

        return $category;
    }
}