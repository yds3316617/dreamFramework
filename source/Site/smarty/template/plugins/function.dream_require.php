<?php
//引用文件标签
function smarty_function_dream_require($params, $template)
{
    $app = $params['app'];
	$file = $params['file'];

    return $app.$file;
}


?>