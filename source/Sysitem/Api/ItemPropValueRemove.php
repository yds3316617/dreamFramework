<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

//$params['id'];
//$params['name'];
//$params['prop_type'];
//$params['prop_values']
//$params['newprop_values']

class ItemPropValueRemove implements IApi{
    var $code;
    
    function api($params){
        $data['id'] = $params['id'];

        $mdl_prop_value = FactoryManager::singleCreateProduct('Model_ItemPropValue@Sysitem');
        unset($data['id']);
        $result = $mdl_prop_value->delete(array('id'=>$params['id']));
   
        if($result){
            $this->code = '00';
            $result = $params;
        }else{
            $this->code = 'remove error';
        }

        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}