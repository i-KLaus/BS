<?php
/**
 * Created by PhpStorm.
 * User: Klaus
 * Date: 2018/8/3
 * Time: 9:41
 */
use yii\helpers\Url;
use app\models\ServiceProvidersSubaccount;

//左侧导航权限控制
function rightvalidate($param)
{
    $sub_account_id = Yii::$app->session->get('sub_id');
    $is_admin = Yii::$app->session->get('is_admin');
    if ($is_admin == ACCOUNT_IS_ADMIN_YES) {
        return true;
    } else {
        $res = ServiceProvidersSubaccount::find()
            -> where(['and', ['id' => $sub_account_id, 'flag' => FLAG_YES]])
            -> one();
    }
    if(!empty($res))
    {
        $right=explode(',',$res -> right);
        foreach ($right as $v) {
            $arr[]=(int)$v;
        }
        if(empty($res -> right)){
            return false;
        }else{
            if(in_array($param,$arr)){
                unset($arr);
                return true;
            }else{
                unset($arr);
                return false;
            }
        }
    }else{
        return false;
    }


}

//权限控制
function rightval() {
    $sub_account_id = Yii::$app->session->get('sub_id');
    $is_admin = Yii::$app->session->get('is_admin');
    if ($is_admin == ACCOUNT_IS_ADMIN_YES) {
        return true;
    } else {
        $res = ServiceProvidersSubaccount::find()
            -> where(['and', ['id' => $sub_account_id, 'flag' => FLAG_YES]])
            -> one();
    }
    if(!empty($res)){
        $right=explode(',',$res -> right);
        foreach ($right as $v)
        {
            $arr[]=(int)$v;
        }
        $controller=Yii::$app->request->getPathInfo();
        $controller=explode('/', $controller);
        $controller=$controller[0];
        $controller=strtoupper($controller);
        switch ($controller)
        {
            case 'MARKETING-GOODS':$controller=1;break;
            case 'GOODS':$controller=2;break;
            case 'ORDER':$controller=3;break;
            case 'SERVICE':$controller=4;break;
            case 'ACCOUNT':$controller=5;break;
        }
        if(in_array($controller,$arr))
        {
            return true;
        }else{
            echo("<script>parent.location.href='".Url::to(['/goods/list'])."'</script>");
            return false;
        }
        }else{
            echo("<script>parent.location.href='".Url::to(['/login/login'])."'</script>");
            die;
         }
}
