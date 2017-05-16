<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

class ItemCatRelProp implements IApi{
    var $code;
    
    function api($params){
        $filter = json_decode($params['filter'],1);
		$columns = $params['columns']?$params['columns']:'*';
		$limit = intval($params['limit'])?intval($params['limit']):10;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
//		print_r($params);exit;
        $mdl_cat_prop = FactoryManager::singleCreateProduct('Model_ItemCatProp@Sysitem');
        $mdl_prop = FactoryManager::singleCreateProduct('Model_ItemProp@Sysitem');
      
        $result['list'] = $mdl_cat_prop->getList($columns,$filter,$mdl_cat_prop->tableName,$limit,$pageno,1,array('prop_id'=>$mdl_prop->tableName.'@id'));
        
		$result['total'] = $mdl_cat_prop->count($filter,array('prop_id|inner'=>$mdl_prop->tableName.'@id'));
		
   
        if($result){
            $this->code = '0000';
        }else{
            $this->code = 'no data';
        }
        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}