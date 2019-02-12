<?php
namespace common\package\log;
/**
 * Created by PhpStorm.
 * User: lan
 * Date: 2017/3/24
 * Time: 20:25
 */
class Log {
    const LEVEL_ERROR = 1;//记录一个致命错误消息
    const LEVEL_WARNING = 2;// 记录一个警告消息
    const LEVEL_INFO = 3;//记录一些有用信息的消息
    const LEVEL_TRACE = 4;//记录消息跟踪一段代码如何运行

    public $filename = "log";//日志名
    public $suffix = ".txt";//文件后缀
    public $prefix = 'log_';//前缀
    public $category = "log/";//类别

    /**
     * @param $text
     * @param $level string
     * @param $target
     */
    public function writeLog($content,$level) {
        //创建日志文件
        $log_file = $this->createLogFile();
        //组合日志内容
        $message = $this->contentFormat($content,$level);
        //写入日志
        file_put_contents ($log_file,$message."\r\n", FILE_APPEND );
    }

    /**
     * 创建日志文件
     */
    private function createLogFile(){
        $path = __DIR__."/".$this->category;
        $fileName = $this->prefix.$this->filename."_".date("Y-m-d").$this->suffix;
        //创建日志目录
        if(!file_exists($path)){
            mkdir($path,0777,true);
        }
        //创建日志文件
        if(!file_exists($path.$fileName)){
            fopen($path.$fileName,'a');
        }
        return $path.$fileName;
    }

    /**
     * 格式化日志内容
     * @param $content
     * @param $level
     * @return string
     */
    private function contentFormat($content,$level){
        $message = array(date("Y-m-d H:i:s"));
        switch ($level){
            case 1:
                $message[] = "error";
                break;
            case 2:
                $message[] = "warning";
                break;
            case 3:
                $message[] = "info";
                break;
            case 4:
                $message[] = "trace";
                break;
        }
        $str = '';
        foreach ($message as $v){
            $str .= "[".$v."]";
        }
        $str .= $content;
        return $str;
    }

}