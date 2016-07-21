<?php
namespace Sysuer\Api\Admin;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

class Pam implements IApi{
    var $code;
    
    function api($params){
        $username = $params['username'];
        $password = $params['password'];

        $mdl_user = FactoryManager::singleCreateProduct('Model_Admin_User@Sysuer');
        $result = $mdl_user->checkLogin($username,$password);
        
        if($result){
            $this->code = '0000';
        }else{
            $this->code = '0001';
        }
        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}