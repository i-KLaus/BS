<?php
namespace app\common\util;
/* * *********************************************
 * @类名:   page
 * @参数:   $myde_total - 总记录数
 *          $myde_size - 一页显示的记录数
 *          $myde_page - 当前页
 *          $myde_url - 获取当前的url
 * @功能:   分页实现
 * @作者:   宋海阁
 */

class page {

    private $myde_total;          //总记录数
    private $myde_size;           //一页显示的记录数
    private $myde_page;           //当前页
    private $myde_page_count;     //总页数
    private $myde_i;              //起头页数
    private $myde_en;             //结尾页数
    private $myde_url;            //获取当前的url
    private $myde_get;            //get参数
    /*
     * $show_pages
     * 页面显示的格式，显示链接的页数为2*$show_pages+1。
     * 如$show_pages=2那么页面上显示就是[首页] [上页] 1 2 3 4 5 [下页] [尾页] 
     */
    private $show_pages;

    public function __construct($myde_total = 1, $myde_size = 1, $myde_page = 1, $myde_url, $show_pages = 2, $myde_get, $condition=[]) {
        $this->myde_total = $this->numeric($myde_total);
        $this->myde_size = $this->numeric($myde_size);
        $this->myde_page = $this->numeric($myde_page);

        $this->myde_page_count = ceil($this->myde_total / $this->myde_size);
        $this->myde_url = $myde_url;
        $this->myde_get = $this -> transcoding($myde_get, $condition);
        if ($this->myde_total < 0)
            $this->myde_total = 0;
        if ($this->myde_page < 1)
            $this->myde_page = 1;
        if ($this->myde_page_count < 1)
            $this->myde_page_count = 1;
        if ($this->myde_page > $this->myde_page_count)
            $this->myde_page = $this->myde_page_count;
        $this->limit = ($this->myde_page - 1) * $this->myde_size;
        $this->myde_i = $this->myde_page - $show_pages;
        $this->myde_en = $this->myde_page + $show_pages;
        if ($this->myde_i < 1) {
            $this->myde_en = $this->myde_en + (1 - $this->myde_i);
            $this->myde_i = 1;
        }
        if ($this->myde_en > $this->myde_page_count) {
            $this->myde_i = $this->myde_i - ($this->myde_en - $this->myde_page_count);
            $this->myde_en = $this->myde_page_count;
        }
        if ($this->myde_i < 1)
            $this->myde_i = 1;
    }

    //检测是否为数字
    private function numeric($num) {
        if (strlen($num)) {
            if (!preg_match("/^[0-9]+$/", $num)) {
                $num = 1;
            } else {
                $num = substr($num, 0, 11);
            }
        } else {
            $num = 1;
        }
        return $num;
    }

    private function transcoding($get, $condition) {
        //如果为单页面多列表，那么手动传保留参数
        //如果为单页面单列表，那么自动保留page参数
        if(!in_array('is_more_page', $condition)){
            $condition[] = 'page';
        }

        $value = '';
        foreach ($get as $k => $v) {
            if (!in_array($k, $condition)) {
                if(is_array($v)){
                    foreach ($v as $k1 => $v1) {
                        $value .= urlencode('&') . "$k".urlencode('[]')."=$v1";
                    }
                } else {
                    $value .= urlencode('&') . "$k=$v";
                }
            }
        }
        return $value;
    }

    //地址替换
    private function page_replace($page) {
        return urldecode(str_replace("{page}", $page, $this->myde_url) . $this->myde_get);
    }

    //首页
    private function myde_home() {
        if ($this->myde_page != 1) {
            return "<li class='first hidden'><a href='" . $this->page_replace(1) . "' title='首页'>&lt;&lt; 首页</a></li>";
        } else {
            return "<li class='first hidden'><a href=''>首页</a></li>";
        }
    }

    //上一页
    private function myde_prev() {
        if ($this->myde_page != 1) {
            return '<a href="'. $this->page_replace($this->myde_page - 1) .'" class="prev"></a>';
        } else {
            return '<a href="'. $this->page_replace($this->myde_page - 1) .'" class="prev disabled"></a>';
        }
    }

    //下一页
    private function myde_next() {
        if ($this->myde_page != $this->myde_page_count) {
            return '<a href="'.$this->page_replace($this->myde_page + 1).'" class="next"></a>';
        } else {
            return '<a href="javascript:;" class="next disabled"></a>';
        }
    }

    //尾页
    private function myde_last() {
        if ($this->myde_page != $this->myde_page_count) {
            return "<li class='last'><a href='" . $this->page_replace($this->myde_page_count) . "' title='尾页'>尾页 &gt;&gt;</a></li>";
        } else {
            return "<li class='last'><a href=''>尾页</a></li>";
        }
    }

    //输出
    public function myde_write() {
        $str = "<div class='page'>";
        $str.=$this->myde_prev();
        $count = 0;
        for ($i = $this->myde_i; $i <= $this->myde_en; $i++) {
            if ($count == 5){
                $str.='<p class="page-remark">...</p>';
                break;
            }
            if ($i == $this->myde_page) {
                $str .= '<a href="'. $this->page_replace($i)  .'" class="active">'.$i.'</a>';
            } else {
                $str .= '<a href="'. $this->page_replace($i) .'">'.$i.'</a>';
            }
            $count ++;
        }
        $str.=$this->myde_next();
//        $str.= '<div class="skip"><span>前往</span><input class="pageJump" type="text" value=""><span>页</span>';
        $str.="</div>";

        return $str;
    }



}

?>