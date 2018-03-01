<?php
//引用文件标签
function smarty_function_dream_css($params, $template)
{
    $href = $params['href'];
    return "<link type='text/css' rel='stylesheet' href='$href'>";
}


?>