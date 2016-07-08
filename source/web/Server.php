<?php
namespace Web;
use Core\FactoryManager;
require_once("/interface/IServer.php");

    /*
     * 服务器模拟类
     * */
    class Server implements IServer{
        
        //路由解析对象
        private $objRouter;
        
        //服务器信息
        private $serverInfo;
        
        function __construct(){
            $this->objRouter = FactoryManager::singleCreateProduct("Router@Web");
        }
        
        /*
         * 系统启动
         * */
        public function run(){
            $routeInfo = $this->parsePath();

            $objClass = FactoryManager::singleCreateProduct($routeInfo['classinfo']);
            $method = $routeInfo['method'];
            //print_r($objClass->$method());exit;
            
            $objClass->$method();

//            echo "跑起来！";
        }
        
        /*
         * 路由解析
         * */
        function parsePath(){
//          print_r($_SERVER);exit;
            $pathInfo = $_SERVER['PATH_INFO'];
            if(empty($pathInfo)){
                echo '服务器不支持path_info';exit;
            }else{
                $objRouter = $this->objRouter->parse($pathInfo);
                if($objRouter === FALSE){
                    echo '非法路径';exit;
                }else{
                    return $objRouter;
                }
            }
            
        }
        
        
        /*
         * 初始化服务器环境
         * 设置内存等
         * */
        public function initEnvironment(){
            //设置报错级别
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            //设置内存大小
            ini_set("memory_limit","32M");
            //设置全局超时时间
            set_time_limit(60);
            
            
            
            
//            echo '初始化中...';
        }
        
        
    }
