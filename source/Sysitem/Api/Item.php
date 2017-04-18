<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

class Item implements IApi{
    var $code;
    
    function api($params){
        $filter = json_decode($params['filter'],1);
		$columns = $params['columns']?$params['columns']:'*';
		$limit = intval($params['limit'])?intval($params['limit']):10;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
//		print_r($params);exit;
        $mdl_item = FactoryManager::singleCreateProduct('Model_Item@Sysitem');
        $result['list'] = $mdl_item->getList($columns,$filter,$mdl_item->tableName,$limit,$pageno,1,array('brand_id'=>'sysitem_brand@id'));
		$result['total'] = $mdl_item->count($filter);
		
   
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