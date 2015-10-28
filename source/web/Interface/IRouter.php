<?php
	/*
	 * 路由解析
	 * */
    interface IRouter{
		
		/*
		 * 系统启动
		 * return $return['app'] = $appName;
				  $return['class'] = $controllerName;
				  $return['$method'] = $methodName;
				  $return['params'] = $params;
		 * */
    	public function parse($params);
		
		
		
		
    }
