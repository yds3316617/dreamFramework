<?php
namespace Core;
class Tools{
   
   //根据中文获取首字母
   static function getFirst($str){
         $str= iconv("UTF-8","gb2312", $str);//如果程序是gbk的，此行就要注释掉 
        if (preg_match("/^[\x7f-\xff]/", $str)) 
        { 
            $fchar=ord($str{0}); 
            if($fchar>=ord("A") and $fchar<=ord("z") )return strtoupper($str{0}); 
            $a = $str; 
            $val=ord($a{0})*256+ord($a{1})-65536; 
            if($val>=-20319 and $val<=-20284)return "A"; 
            if($val>=-20283 and $val<=-19776)return "B"; 
            if($val>=-19775 and $val<=-19219)return "C"; 
            if($val>=-19218 and $val<=-18711)return "D"; 
            if($val>=-18710 and $val<=-18527)return "E"; 
            if($val>=-18526 and $val<=-18240)return "F"; 
            if($val>=-18239 and $val<=-17923)return "G"; 
            if($val>=-17922 and $val<=-17418)return "H"; 
            if($val>=-17417 and $val<=-16475)return "J"; 
            if($val>=-16474 and $val<=-16213)return "K"; 
            if($val>=-16212 and $val<=-15641)return "L"; 
            if($val>=-15640 and $val<=-15166)return "M"; 
            if($val>=-15165 and $val<=-14923)return "N"; 
            if($val>=-14922 and $val<=-14915)return "O"; 
            if($val>=-14914 and $val<=-14631)return "P"; 
            if($val>=-14630 and $val<=-14150)return "Q"; 
            if($val>=-14149 and $val<=-14091)return "R"; 
            if($val>=-14090 and $val<=-13319)return "S"; 
            if($val>=-13318 and $val<=-12839)return "T"; 
            if($val>=-12838 and $val<=-12557)return "W"; 
            if($val>=-12556 and $val<=-11848)return "X"; 
            if($val>=-11847 and $val<=-11056)return "Y"; 
            if($val>=-11055 and $val<=-10247)return "Z"; 
            
        }  
        else 
        {
            $c=preg_match('/[a-zA-Z]/', strtoupper(substr( $str, 0, 1 )));
            if($c){
                return strtoupper(substr( $str, 0, 1 )) ;
            }
        } 
        return false; 
    }

}
