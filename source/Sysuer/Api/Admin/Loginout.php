<?php
namespace Sysuer\Api\Admin;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

class Loginout implements IApi{
    var $code = '00';
    
    function api($params){
    	
        $sess_id = $params['sess_id'];
		
		if(empty($sess_id)){
			$this->code = 'missing sess_id';
			return false;
		}
        $session = FactoryManager::singleCreateProduct('Session@Web');
        $session->start('admin',$sess_id);
        unset($_SESSION);
        session_destroy();
        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}