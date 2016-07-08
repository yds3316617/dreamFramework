<?php
namespace Site;
use Core\FactoryManager;

class Controller {
        
        var $tmplObj;

        function __construct(){
            $this->tmplObj = FactoryManager::singleCreateProduct('Template@Site');
            $this->tmplObj->assign('__static_url',BASE_URL.'/statics/');
        }

        function display($path){
            
            $this->tmplObj->display($path);
        }

        function assign($key,$value){
            $this->tmplObj->assign($key,$value);
        }

}