<?php
//引用文件标签
function smarty_function_dream_widgets($params, $template)
{
	$widget_id = $params['id'];
	$theme = base_system::single('site_c_site_theme');

	$theme_id =$theme->theme_id;
	$html = $theme->theme_widgets($widget_id,$theme_id);
	
//    echo "widgets_admin";
//    return $template->fetch($template->main);
}


?>