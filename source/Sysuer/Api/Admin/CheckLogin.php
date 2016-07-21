<?php
namespace Sysuer\Api\Admin;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

class CheckLogin implements IApi{
    var $code = '00';
    
    function api($params){
        if($params['sess_id']){
            $sess_id = $params['sess_id'];
            $session = FactoryManager::singleCreateProduct('Session@Web');
            $session->start('admin',$sess_id);
            $result['id'] = $_SESSION['admin']['id'];
        }else{
            $this->code = 'missing sess_id';
        }

        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}