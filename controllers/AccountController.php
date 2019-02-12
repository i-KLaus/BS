<?php
namespace app\controllers;

use app\components\BaseController;
use app\models\ServiceProviders;
use app\models\ServiceProvidersSubaccount;
use app\models\UnionpayAccount;
use Yii;
/**
 * Class AccountController
 * @package app\controllers
 *
 * 账户管理
 */
class AccountController extends BaseController{
    /**
     *账号管理首页展示
     */
    public function actionList(){
        $isAdmin = $this->getSession('is_admin');
        $adminId =$this->getSession('pid');
        $sub_account_id = $this -> getSession('sub_id');

        $account = [];

        if($isAdmin == ACCOUNT_IS_ADMIN_YES){
            //获取所有pid为当前id的子账号
            $account = ServiceProviders::findOne($adminId);

            //获取当前子账号信息并压入子账号数组中
            $sub_account = ServiceProvidersSubaccount::find()
                -> where(['and', ['service_providers_id' => $adminId, 'flag' => FLAG_YES]])
                -> orderBy('create_time DESC')
                -> all();
        }else{
            //子账号直接查找
            $sub_account = ServiceProvidersSubaccount::find()
                -> where(['and', ['id' => $sub_account_id, 'flag' => FLAG_YES]])
                -> one();
        }
        return $this->render('list', [
            'account' => $account,
            'sub_account' => $sub_account
        ]);
    }

    /**
     * 修改密码
     */
    public function actionEditPwd(){
        $password = $this -> getValue('password');
        $pwd = $this -> getValue('pwd');
        $pid =$this->getSession('pid');
        $sub_account_id = $this -> getSession('sub_id');
        $is_admin = $this->getSession('is_admin');
        if ($is_admin == ACCOUNT_IS_ADMIN_YES) {
            $model = ServiceProviders::findOne($pid);
        } else {
            $model = ServiceProvidersSubaccount::find()
                -> where(['and', ['id' => $sub_account_id, 'flag' => FLAG_YES]])
                -> one();
        }

        if($model->pwd == md5($pwd)){
            $model->pwd = md5($password);
            if($model->save()){
                echo json_encode(['status'=>1,'info'=>'修改密码成功！']);
            }else{
                echo json_encode(['status'=>0,'info'=>'修改密码失败!']);
                $model->getErrors();
            }
        }else{
            echo json_encode(['status'=>0,'info'=>'登录密码错误!']);
        }

    }

    /**
     * 删除子账号
     */
    public function actionDelete(){
        $sub_account_id = $this -> getSession('sub_id');
        $model = ServiceProvidersSubaccount::find()
            -> where(['and', ['id' => $sub_account_id, 'flag' => FLAG_YES]])
            -> one();
        $model -> flag = FLAG_NO;
        if($model -> save()) {
            echo json_encode(['status' => 1, 'info' => '删除成功！']);
        }else{
            echo json_encode(['status' => 0,'info' => '删除失败!']);
        }
    }

    /**
     * 修改子账号信息
     */
    public function actionEdit(){
        //获取查询参数
        $id = $this -> getValue('id');
        $name = $this->getValue('name');
        $account = $this->getValue('account');
        $rights = $this->getValue('right');
        if(empty($rights)){
            $rights = [];
        }
        //获取数据库权限
        $editModel = ServiceProvidersSubaccount::findOne($id);
        $right = explode(',',$editModel->right);
        
        if(!empty($_POST)) {
            $rightArray = $rights;
            $rightarr = implode(',', $rightArray);
            $model = ServiceProvidersSubaccount::updateAll([
                'name' => $name,
                'account' => $account,
                'right' =>$rightarr,
            ],
                ['id' => $id]
            );
            if ($model) {
                return $this->redirect(['list']);
            }
        }
        return $this->render('edit',[
            'model' => $editModel,
            'right' =>$right,
        ]);
    }

    /**
     * 添加子账号
     */

    public function actionAdd(){
       $model = new ServiceProvidersSubaccount();
       if(!empty($_POST)){
           $model->pwd = md5($this->getValue('pwd'));
           $model->name = $this->getValue('name');
           $model->account = $this->getValue('account');
           if(!empty($_POST['right'])){
               $rightArray = $this->getValue('right');
               $model->right = implode(',',$rightArray);
           }
           $model -> service_providers_id = $this->getSession('pid');
            if($model->save()){
                return $this->redirect(['list']);
            }
       }
        return $this->render('add');
    }

    /**
     * 验证密码正确与否
     */
    public function actionAjaxCheckPwd(){
        $pwd = $this -> getValue('pwd');
        $pid =$this -> getSession('pid');
        $sub_account_id = $this -> getSession('sub_id');
        $is_admin = $this -> getSession('is_admin');
        if ($is_admin == ACCOUNT_IS_ADMIN_YES) {
            $model = ServiceProviders::findOne($pid);
        } else {
            $model = ServiceProvidersSubaccount::find()
                -> where(['and', ['id' => $sub_account_id, 'flag' => FLAG_YES]])
                -> one();
        }

        if($model == md5($pwd)){
            echo json_encode(['status'=>1,'info'=>'密码正确']);
        }else{
            echo json_encode(['status'=>0,'info'=>'密码错误']);
        }
    }

    /**
     * @param $key
     * @return mixed
     * 获取session
     */
    public function getSession($key){
        return Yii::$app->session->get($key);
    }

    /**
     * 将被修改密码的账户和名称传入弹窗
     */
    public function actionChangeAjax(){
        $id = $this -> getValue('id');
        $model = ServiceProvidersSubaccount::find()-> where(['and', ['id' => $id, 'flag' => FLAG_YES]])-> one();
        echo json_encode(array('account'=>$model->account,'name'=>$model->name));
    }

    /**
     *  检查邮箱账号是否已存在
     */
    public function actionCheckAccount() {
        $id = $this -> getValue('id');
        $account = $this -> getValue('account');
        $service = ServiceProviders::find()
            -> where(['and', ['account' => $account, 'flag' => FLAG_YES]])
            -> one();
        $model = ServiceProvidersSubaccount::find()
            -> where(['and', ['account' => $account, 'flag' => FLAG_YES]])
            -> andFilterWhere(['<>', 'id', $id])
            -> one();
        if (empty($model) && empty($service)) {
            return true;
        } else {
            return false;
        }
    }
}