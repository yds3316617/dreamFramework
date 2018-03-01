<?php
//引用文件标签
function smarty_function_dream_include($params, $template)
{
    $src = $params['file'];

    return $template->fetch($src);

}


?>