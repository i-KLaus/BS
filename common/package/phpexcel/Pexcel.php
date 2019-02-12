<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 16:55
 */

namespace app\common\package\phpexcel;
require_once 'Classes/PHPExcel.php';

use app\models\Region;


class Pexcel {
    public function GetData(){
        $excel = new \PHPExcel();
        $file = $_FILES['file'];
        $num =$_POST['num'];

        $str = substr($file['name'],strpos($file['name'],'.'));
        $name = time().$str;
        if($str=='.xls'||$str=='.xlsx'){
            move_uploaded_file($file['tmp_name'],'./'.$name);
        }
        if($str == '.xlsx'){
            $reader = new \PHPExcel_Reader_Excel2007();
        }elseif ($str == '.xls'){
            $reader = new \PHPExcel_Reader_Excel5();
        }else{
            return "error";
        }
        $phpexcel = $reader->load($name);

        $currentSheet = $phpexcel->getSheet(0);

        $allColumn = $currentSheet->getHighestColumn();

        $allRow = $currentSheet->getHighestRow();

        $area = array('A','B','C','D','E','F');

        for($currenRow=2;$currenRow<=$allRow;$currenRow++){
            for($currentCol=1;$currentCol<=count($area);$currentCol++){
                $address = $area[$currentCol-1].$currenRow;
                $cell = $currentSheet->getCell($address)->getValue();

                if($cell instanceof  PHPExcel_RichText){
                    $cell = $cell->__toString();
                }
                $data[$currenRow-1+$num-1][$currentCol] = $cell;
            }
        }
        foreach ($data as $k=>$v){
            $province = Region::find()->where(['area_parent_id'=>1,'area_name'=>$v[3]])->select('area_code')->one();
            if(!empty($province)){
                $data[$k][7] = $province->area_code;
                $city = Region::find()->where(['like','area_name',$v[4]])->andWhere(['area_parent_id'=>$province->area_code])->select('area_code')->one();
                if(!empty($city)){
                    $data[$k][8] = $city->area_code;

                    $area = Region::find()->where(['like','area_name',$v[5]])->andWhere(['area_parent_id'=>$city->area_code])->select('area_code')->one();
                    if(!empty($area)){
                        $data[$k][9] = $area->area_code;
                    }
                }
            }
        }
        foreach ($data as $val){
            if(count($val)!=9){

                unlink($name);
                return "error-area";
            }
        }

        unlink($name);
        return $data;
    }
}