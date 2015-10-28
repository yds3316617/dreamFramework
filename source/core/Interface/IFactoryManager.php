<?php
	/*
	 * 类的管理器,负责实例化类
	 * */
    interface IFactoryManager{
		
    	/*
		 * 实例化类
		 * $class(string) : 类名
		 * $params(array): 构造函数如果需要参数，则传入数组
		 * */
    	public static function createProduct($className,$params);
		
		/*
		 * 单例
		 * */
		public static function singleCreateProduct($className,$params);
		
    }
