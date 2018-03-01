<?php
//引用文件标签
function smarty_function_dream_include($params, $template)
{
    $src = ROOT_DIR.$params['file'];
    return $template->fetch($src);

}


?>