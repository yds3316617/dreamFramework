<?php
//引用文件标签
function smarty_function_dream_site_link($params, $template)
{
    
    $serverInfo = base_system::_server();
    

	$host = $serverInfo['HTTP_ORIGIN']?$serverInfo['HTTP_ORIGIN']:$serverInfo['HTTP_HOST'];
	$script_name = $serverInfo['SCRIPT_NAME'];

    if($params['url']){
        $dispatchObj = base_system::get_dispatchObj();
        $sitemap = $dispatchObj->get_siteMap();
        $pathinfo = $dispatchObj->get_pathInfo();
        if($params['params']){
            $str=str_replace(',','-',$params['params']);
            $params['url'] .= '-'.$str;
        }
        
        
        return 'http://'.$host.$script_name.'/'.$params['url'].'.html';

    }

    $app = $params['app'];
	$mod = $params['mod'];
	$act = $params['act'];
	$strParams = $params['params'];

	$tmp = explode(';',$strParams);

	$_param = array();
	$_param['app'] = $app;
	$_param['mod'] = $mod;
	$_param['act'] = $act;

    $ctl = $app.'_c'.'_'.$mod;

	foreach($tmp as $k=>$val){
		$t = explode('=',$val);
		$_param[$t[0]] = $t[1];
	}

	

  
    

	$url = 'http://'.$host.$script_name.'?'.urldecode(http_build_query($_param));

	return $url;
	
	
}


?>