<?php

require_once('template/Smarty.php');
class Smarty_Template extends Smarty{

	//模板目录变量
	var $template_dir ;
	//编译目录变量
	var $compile_dir ;

	var $left_delimiter = '{' ;
	var $right_delimiter= '}';

	//是否开启缓存
	var $caching = false;
	//缓存文件夹
	var $cache_dir ;

	function __construct(){
		parent::__construct();
		spl_autoload_register('smartyAutoload');
		$this->compile_dir = COMPILE_DIR;
	}

	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null){
		
        parent::display($template , $cache_id , $compile_id , $parent );
    }

	function assign($key, $value = null, $nocache = false){
		parent::assign($key, $value, $nocache);
	}

	function __autoload(){
		echo 234;exit;
	}

}
