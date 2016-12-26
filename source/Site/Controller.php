<?php
namespace Site;
use Core\FactoryManager;

class Controller {
        
        var $tmplObj;

        function __construct(){
            $this->tmplObj = FactoryManager::singleCreateProduct('Template@Site');
            $this->tmplObj->assign('__static_url',BASE_URL.'/statics/');
            $this->tmplObj->assign('__base_url',BASE_URL.'/index.php/');
        }

        function display($path){
            $this->tmplObj->display($path);
        }
		
		function fetch($path){
            return $this->tmplObj->fetch($path);
        }

        function assign($key,$value){
            $this->tmplObj->assign($key,$value);
        }

        function success($data,$msg=''){
            $rs['succ'] = true;
            $rs['data'] = $data;
            $rs['msg'] = $msg;
            echo json_encode($rs);exit;
        }

        function error($data,$msg=''){
            $rs['fail'] = true;
            $rs['data'] = $data;
            $rs['error'] = $msg;
            echo json_encode($rs);exit;
        }

}