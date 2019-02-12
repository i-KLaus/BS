<?php
namespace app\controllers;

use app\components\BaseController;
use app\models\GoodsCategory;
use yii\data\Pagination;
use app\models\DemandPerson;
use yii\web\Controller;
use Yii;
/**
 * Created by PhpStorm.
 * User: Klaus
 * Date: 2018/7/18
 * Time: 18:17
 */
class DemandController extends BaseController
{
    /**
     * 需求方审核列表
     */
    public function actionList()
    {
        $key = isset($_GET['key'])&& !empty($_GET['key'])?$_GET['key']:'';
        $status = '';
        $idx=$this->getValue('idx');
        if($idx==null)
        {
            $model=DemandPerson::find();
        }
        else
        {
            $model=DemandPerson::find()->where(['status'=>$idx]);
        }

        if (!empty($key)){
            $model = DemandPerson::find();
            $model->Where(['like','code',$key]);
        }
        if (!empty($status)){
            $model = DemandPerson::find();
            $model->andWhere('status = :status',array(
                ':status' => $status
            ));
        }

        $pages = PAGE_PARAMS; //一页显示记录条数
        $total = $model->count(); //记录条数总数
        $page = empty($_GET['page'])?1:$_GET['page'];//当前页，若未传值，默认为第一页

        if (!empty($page) && $total != 0 && $page > ceil($total / $pages)) {
            $this->page = ceil($total / $pages);
        }
        $num  = ($page - 1) * $pages;
        $list = $model->limit($pages)->offset($num)->all();
        return $this->render('list', [
            'res' => $list,
            'total' => $total,
            'pages' => $pages,
            'page' => $page,
            'idx'=>$idx
        ]);
    }

    /**
     * 审核通过
     */
    public function actionPass()
    {
        $id=$this->getValue('id');
        $idx=$this->getValue('idx');
        DemandPerson::updateAll(['status'=>3],['id'=>$id]);
        return $this->actionList();
    }

    /**
     * 驳回审核
     */
    public function actionReject()
    {
        $result='';
        $id=$this->getValue('realid');;
        $reject_reason=$this->getValue('value');
        $model=DemandPerson::find()->where(['id'=>$id])->one();
        $model->status=FWS_STATUS_REJECT;
        $model->reject_reason=$reject_reason;
        if (!$model->save()){
            echo json_encode(array(
                'status' => false,
                'msg' => json_encode($model->getErrors())
            ));
            exit;
        }
        echo json_encode(array(
            'status' => true
        ));
    }
}
