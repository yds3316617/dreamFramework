<?php
//引用文件标签
function smarty_function_dream_admin_dialogSelect($params, $template)
{
    $url = $params['url'];
    $backurl = $params['backurl'];
	$mod_name = $params['mod'];
    $mod = base_system::instance($params['mod']);
    $key = $params['pk'];
    $view = $params['view'];
	$values = $params['values'];

	$ids = explode(',',$values);
	$filter = array();
	if(!empty($ids)){
		$filter[$key] = $ids;
	}


    if(method_exists($mod,'getFinderList') && $mod instanceof desktop_l_ifinder){
        $data = $mod->getFinderList('*',$filter);
    }else{
        $data = $mod->getList($str_cols,$filter);
    }

	$template->assign('ddata',$data);
	$html = $template->fetch($view);

    $button = "<input type='button' mod='$mod_name' values='$values' view='$view' onclick='selector.dialogSelect(\"$url\",this)' backurl=\"$backurl\" value='选择商品类型' />";

    return $button.$html;
}


?>