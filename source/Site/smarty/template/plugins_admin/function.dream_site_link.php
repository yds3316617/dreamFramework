<?php
//引用文件标签
function smarty_function_dream_site_link($params, $template)
{
    $app = $params['app'];
	$mod = $params['mod'];
	$act = $params['act'];
	$strParams = $params['params'];

	$tmp = explode(';',$strParams);

	$_param = array();
	$_param['app'] = $app;
	$_param['mod'] = $mod;
	$_param['act'] = $act;

	foreach($tmp as $k=>$val){
		$t = explode('=',$val);
		$_param[$t[0]] = $t[1];
	}

	$serverInfo = base_system::_server();
	$host = $serverInfo['HTTP_ORIGIN'];
	$script_name = $serverInfo['SCRIPT_NAME'];

	$url = $host.$script_name.'?'.urldecode(http_build_query($_param));

	return $url;
	
	
}


?>