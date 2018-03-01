<?php
//引用文件标签
function smarty_function_dream_admin_pager($params, $template){
    
if(!$params['data']['current'])$params['data']['current'] = 1;
    if(!$params['data']['total'])$params['data']['total'] = 1;
    if($params['data']['total']<2){
        return '';
    }

    $prev = $params['data']['current']>1?
        '<a target="finder" href="'.$params['data']['link'].'&page='.($params['data']['current']-1).'" class="prev" title='."上一页".'>&laquo;'.'上一页'.'</a>':
        '<span title='."已经是第一页".' class="unprev">'."已经是第一页".'</span>';

    $next = $params['data']['current']<$params['data']['total']?
      '<a target="finder" href="'.$params['data']['link'].'&page='.($params['data']['current']+1).'" class="next last" title='."下一页".'>'.'下一页'.'&raquo;</a>':
        '<span title='."已经是最后一页".' class="unnext">'."已经是最后一页".'</span>';

    if($params['type']=='mini'){
        return <<<EOF
    <div class="pager"><strong class="pagecurrent">{$params['data']['current']}</strong><span class="line">/</span><span class="pageall">{$params['data']['total']}</span>{$prev}{$next}</div>
EOF;
    }else{

        $c = $params['data']['current']; $t=$params['data']['total']; $v = array();  $l=$params['data']['link']; $p=$params['data']['token'];

        if($t<11){
            $v[] = _pager_link(1,$t,$l,$p,$c);
            //123456789
        }else{
            if($t-$c<8){
                $v[] = _pager_link(1,3,$l,$p);
                $v[] = _pager_link($t-8,$t,$l,$p,$c);
                //12..50 51 52 53 54 55 56 57
            }elseif($c<10){
                $v[] = _pager_link(1,max($c+3,10),$l,$p,$c);
                $v[] = _pager_link($t-1,$t,$l,$p);
                //1234567..55
            }else{
                $v[] = _pager_link(1,3,$l,$p);
                $v[] = _pager_link($c-2,$c+3,$l,$p,$c);
                $v[] = _pager_link($t-1,$t,$l,$p);
                //123 456 789
            }
        }
        $links = implode('...',$v);

//    str_replace($params['data']['token'],4,$params['data']['link']);
//    if($params['data']['total']
        return <<<EOF
    <div class="pager">{$prev}{$links}{$next}</div>    
EOF;
        }
}


function _pager_link($from,$to,$link,$p,$current=null){
//    print_r($from);
//    echo "<br>";
//    print_r($to);
//    echo "<br>";
//    print_r($link);
//    echo "<br>";
//    print_r($p);
//    exit;

    
    for($i=$from;$i<$to+1;$i++){
        if($current==$i){
            $r[]='<span class="current"> <strong class="pagecurrent">'.$i.'</strong> </span>';
        }else{
//        $r[]=' <a target="finder" class="pagernum" href="'.str_replace($p,$i,$link).'">'.$i.'</a> ';
          $r[]=' <a target="finder" class="pagernum" href="'.$link.'&page='.$i.'">'.$i.'</a> ';
        }
    }
    return implode(' ',$r);
}

?>