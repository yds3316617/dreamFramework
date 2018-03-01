<?php
//引用文件标签
function smarty_function_dream_script($params, $template)
{
    $src = $params['src'];
	
    return '<script type="text/javascript" src="'.$src.'?'.time().'"></script>';

}


?>