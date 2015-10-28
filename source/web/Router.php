<?php
require("/interface/IRouter.php");
	/*
	 * 服务器模拟类
	 * */
    class Router implements IRouter{
    	private $urlMap = array(
    		'test'=>'web_Test',
		);
    	
		/*
		 * 路由解析
		 * $pathInfo (Sting):"hello-123.html"
		 * */
		function parse($pathInfo){
			//去斜杠
			$pathInfo = str_replace('/', '', $pathInfo);
			//去 .html
			$pathInfo = str_replace('.html', '', $pathInfo);
			
			$pathInfoArr = explode('-', $pathInfo);
			$mapKey = $pathInfoArr[0];
			unset($pathInfoArr[0]);
			
			//如果配置了路由
			if($classInfo = $this->urlMap[$mapKey]){
				$classInfo = explode('_',$classInfo);
				$appName = $classInfo[0];
				$controllerName = $classInfo[1];
				if($pathInfoArr[1] && !is_numeric($pathInfoArr[1])){
					$methodName = $pathInfoArr[1];
                    unset($pathInfoArr[1]);
				}else{
					$methodName = 'index';
				}
				
				$params = $pathInfoArr;
				
				$return['app'] = $appName;
				$return['class'] = $controllerName;
				$return['$method'] = $methodName;
				$return['params'] = $params;
				
				return $return;
			}else{
				return false;
			}
		}
		
		
		
		
		
    }
