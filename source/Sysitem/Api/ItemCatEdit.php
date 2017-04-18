<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

class ItemCatEdit implements IApi{
    var $code;
    
    function api($params){
        $data['id'] = $params['id'];
        $data['name'] = $params['name'];

        $mdl_cat = FactoryManager::singleCreateProduct('Model_ItemCat@Sysitem');
        unset($data['id']);
        $result = $mdl_cat->update(array('id'=>$params['id']),$data);
		
   
        if($result){
            $this->code = '00';
            $result = $params;
        }else{
            $this->code = 'update error';
        }

        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}