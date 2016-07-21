<?php
namespace Core;
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

        $classInfo = explode('@',$className);
        $classInfo = explode('_',$classInfo[0]);
        $className = array_pop($classInfo);
        $class = new $className($paramStr);
        
        return $class;
    }
    
    /*
     * 实例化类
     * $class(string) : 类名
     * $params(array): 构造函数如果需要参数，则传入数组
     * */
    public static function singleCreateProduct($className,$params=array()){
//        echo "<br>";
//        echo $className;
        if(self::$classList[$className]){
            return self::$classList[$className];
        }else{
            $paramStr = implode(',', $params);
            
            self::requireClass($className);
            
            $classInfo = explode('@',$className);
            $classInfo = explode('_',$classInfo[0]);
            $newClassName = array_pop($classInfo);

            $class = new $newClassName($paramStr);
            self::$classList[$className] = $class;
            return $class;
        }
                
    }

    /*
     * 实例化类
     * $class(string) : 类名
     * $params(array): 构造函数如果需要参数，则传入数组
     * */
    public static function singleCreateProduct2($className,$params=array()){
        echo "<br>";
        echo $className;exit;
        if(self::$classList[$className]){
            return self::$classList[$className];
        }else{
            $paramStr = implode(',', $params);
            
            self::requireClass($className);
            
            $classInfo = explode('@',$className);
            $classInfo = explode('_',$classInfo[0]);
            $newClassName = array_pop($classInfo);

            $class = new $newClassName($paramStr);
            self::$classList[$className] = $class;
            return $class;
        }
                
    }
    
    /*
     * 根据下划线,判断文件所在路径，加载类文件
     * $className(string) : class名@app名
     * */
    static function  requireClass(&$className){

        $classInfo = explode('@',$className);
        $appName = $classInfo[1];
        $classInfo = explode('_',$classInfo[0]);
        $className = array_pop($classInfo);

        if(!empty($appName)){
            self::$appId = $appName;
        }else{
            self::$appId = 'core';
        }
        if($classInfo){
            $dirInfo = implode('/',$classInfo);
            $dirInfo .= '/' ;
        }else{
            $dirInfo = '/';
        }

        $path = ROOT_DIR.self::$appId.'/'.$dirInfo.$className.'.php';

        if($classInfo){
            $dirInfo = implode('\\',$classInfo);
            $dirInfo .= '\\' ;
        }else{
            $dirInfo = '';
        }
        $className = self::$appId.'\\'.$dirInfo.$className;
//        echo "<br>";
//        echo $className;
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
