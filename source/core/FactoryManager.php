<?php
require("/interface/IFactoryManager.php");
class FactoryManager implements IFactoryManager{
	private  static $classList;
	
	private  static $appId;
	
	/*
	 * 实例化类
	 * $class(string) : 类名
	 * $params(array): 构造函数如果需要参数，则传入数组
	 * */
	public static function createProduct($className,$params=array()){
		$paramStr = implode(',', $params);
		self::requireClass($className);
		$class = new $className($paramStr);
		
		return $class;
	}
	
	/*
	 * 实例化类
	 * $class(string) : 类名
	 * $params(array): 构造函数如果需要参数，则传入数组
	 * */
	public static function singleCreateProduct($className,$params=array()){
		if(self::$classList[$className]){
			return self::$classList[$className];
		}else{
			$paramStr = implode(',', $params);
			self::requireClass($className);
			$class = new $className($paramStr);
			self::$classList['$className'] = $class;
			return $class;
		}
				
	}
	
	/*
	 * 根据下划线,判断文件所在路径，加载类文件
	 * $className(string) : app名_class名
	 * */
	static function  requireClass(&$className){
		$array = explode('_',$className);
		if(!empty($array)){
			self::$appId = $array[0];
			$className = $array[1];
		}else{
			self::$appId = 'core';
		}
		
		$path = ROOT_DIR.self::$appId.'/'.$className.'.php';
		
		if(file_exists($path)){
			require_once($path);
			return true;
		}else{
			echo "$className 类不存在";
			return false;
		}
	}
	
	function getClassList(){
		return self::$classList;
	}
	
	
	
	
}
