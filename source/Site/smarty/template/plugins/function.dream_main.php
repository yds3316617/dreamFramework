<?php
//引用文件标签
function smarty_function_dream_main($params, $template)
{
    $app = $params['app'];
	$file = $params['file'];
//	print_r($template->tpl_vars['a']->value);exit;

    return $template->fetch($template->main);
}


?>