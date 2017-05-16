<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
use Sysitem\Lib;
require(ROOT_DIR."Core/Interface/IApi.php");

//$params['ids'];


class ItemPropRemove implements IApi{
    var $code;
    
    function api($params){
        $data = array();
        $ids = json_decode($params['ids'],1);
        if(!$ids){
            $this->code = '缺少参数';
            return false;
        }

        $lib_prop = FactoryManager::singleCreateProduct('Lib_Prop@Sysitem');
        $result = $lib_prop->remove($ids);
        
        if($result){
            $this->code = '00';
            $result = $params;
        }else{
            $this->code = $lib_prop->error;
        }

        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}