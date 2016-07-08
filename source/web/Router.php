<?php
namespace Web;
require("/interface/IRouter.php");
	/*
	 * 服务器模拟类
	 * */
    class Router implements IRouter{
    	private $urlMap;

        function __construct(){
            $this->urlMap = array(
                'test'=>'Controller_Admin_IndexController@Site',
                'adminIndex'=>'Controller_Admin_IndexController:adminIndex@Site',
            );
        }
    	
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
                $classInfo = explode('@',$classInfo);
                $appName = $classInfo[1];

				$classInfo = explode('_',$classInfo[0]);
				
				$controllerName = array_pop($classInfo);
                $controllerNameArr = explode(':',$controllerName);
                $controllerName = $controllerNameArr[0];
                
                
				if($controllerNameArr[1] && !is_numeric($controllerNameArr[1])){
					$methodName = $controllerNameArr[1];
                    unset($controllerNameArr[1]);
				}else{
					$methodName = 'index';
				}
				
				$params = $pathInfoArr;
				
				$return['app'] = $appName;
				$return['class'] = $controllerName;
                $return['dir'] = $classInfo;
				$return['method'] = $methodName;
				$return['params'] = $params;
                $return['classinfo'] = str_replace(":$methodName",'',$this->urlMap[$mapKey]);
				
				return $return;
			}else{
				return false;
			}
		}
		
		
		
		
		
    }
