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
            	/*******************后台*****************************/
                'adminLogin'=>'Controller_Admin_IndexController:login@Site',
                #后台首页
                'adminIndex'=>'Controller_Admin_IndexController:adminIndex@Site',
                #后台登录认证
                'adminDoLogin'=>'Controller_Admin_IndexController:doLogin@Site',
                #后台注销
                'adminDoLoginout'=>'Controller_Admin_IndexController:doLoginout@Site',
                #后台商品品牌列表
                'adminBrandList'=>'Controller_Admin_BrandController:index@Site',
                #后台品牌编辑
                'adminBrandEdit'=>'Controller_Admin_BrandController:edit@Site',



				/*******************前台*****************************/
                #首页
                'index'=>'Controller_Site_IndexController:index@Site',
                #店铺页
                'shop'=>'Controller_Site_IndexController:shop@Site',
                #商品详情
                'productDetails'=>'Controller_Site_IndexController:productDetails@Site',
                #结算页
                'checkout'=>'Controller_Site_IndexController:checkout@Site',
                #购物车
                'cart'=>'Controller_Site_IndexController:cart@Site',
                #登录
                'login'=>'Controller_Site_IndexController:login@Site',
                #blog列表
                'blog'=>'Controller_Site_IndexController:blog@Site',
                #单个blog
                'blogSingle'=>'Controller_Site_IndexController:blogSingle@Site',
                #404
                '404'=>'Controller_Site_IndexController:notfound@Site',
                #联系我们
                'contactUs'=>'Controller_Site_IndexController:contactUs@Site',
                
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
            
            if($mapKey == 'api'){
                $return['app'] = 'Core';
                $return['class'] = 'Api';
                $return['dir'] = '';
                $return['method'] = 'parseApi';
                $return['classinfo'] = 'Api@Core';
				$return['pathinfo'] = $pathInfo;

                return $return;
            }

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
				$return['pathinfo'] = $pathInfo;

                return $return;
            }else{
                return false;
            }
        }
        
        
        
        
        
    }
