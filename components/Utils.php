<?php
namespace app\components;

use Yii;
use yii\base\Component;

class Utils extends Component {
    /**
     * 获取左右偏移分页页码方法
     *
     * @param string $Url       //当前url,page参数用$page替换
     * @param string $NowPage   //当前页码
     * @param string $SumPage   //总页数
     * @param string $LRNum     //左右偏移量
     *
     * @return string
     * @static
     */
    public static function getPaging($Url = '',$NowPage = '1',$SumPage = '10',$LRNum = '3'){
    
        $i = 0;
        if($SumPage <= 1) {
            return '';
        }
        //起始页号初始化
        $BeginPage = $NowPage - $LRNum - 1;
        //当越界时修正起始页号
        if($NowPage + $LRNum > $SumPage){
            $BeginPage = $SumPage - $LRNum * 2 - 1;
        }
    
        $ShowHtml = '';
        if($NowPage == 1) {
            $ShowHtml .= '<li class="prev disabled"><a href="#">← <span class="hidden-480">上一页</span></a></li> ';
        }
        if($NowPage > 1){
            $t_url = str_replace('$page',$NowPage - 1,$Url);
            $ShowHtml .= '<li class="prev"><a href="'.$t_url.'">← <span class="hidden-480">上一页</span></a></li> ';
        }
        if($BeginPage >= 1){                        //第一页显示条件
            $t_url = str_replace('$page','1',$Url);
            $ShowHtml .= ' <li ><a href="'.$t_url.'">1</a></li> ';
        }
        while ($i <= $LRNum * 2){
    
            //越界后退出
            if ($BeginPage >= $SumPage){
                break;
            }elseif($BeginPage < 0){
                $BeginPage ++;
                continue;
            } else {
                $BeginPage ++;
                if($NowPage == $BeginPage){     //当前页码
                    $ShowHtml .= '<li class="disabled"><a href="#">'.$NowPage.'</a></li>';
                } else {                          //其他页码
                    $t_url = str_replace('$page',$BeginPage,$Url);
                    $ShowHtml .= '<li><a href="'.$t_url.'">'.$BeginPage.'</a></li> ';
                }
                $i ++;
            }
        }
        if($BeginPage < $SumPage){              //最末页显示条件
            $t_url = str_replace('$page',$SumPage,$Url);
            $ShowHtml .= ' <li><a href="'.$t_url.'">'.$SumPage.'</a></li> ';
        }
        if($NowPage < $SumPage){
            $t_url = str_replace('$page',$NowPage + 1,$Url);
            $ShowHtml .= "<li><a href='$t_url'><span class='hidden-480'>下一页</span> →</a> </li> ";
        } else {
            $ShowHtml .= "<li class='disabled'><a href='#'><span class='hidden-480'>下一页</span> →</a> </li>";
        }
    
        if(strpos($Url, 'p$page/')){
            //第一页要替换的URL
            $replace_first_url = str_replace('$page','1',$Url);
            //替换第一页URL地址
            $seo_showhtml = str_replace($replace_first_url , str_replace('p$page/', '', $Url) , $ShowHtml);
            return $seo_showhtml;
        }elseif (strpos($Url, '_$page/')){
            //第一页要替换的URL
            $replace_first_url = str_replace('$page','1',$Url);
            //替换第一页URL地址
            $seo_showhtml = str_replace($replace_first_url , str_replace('_$page/', '/', $Url) , $ShowHtml);
            return $seo_showhtml;
        }else{
            return $ShowHtml;
        }
    }
}