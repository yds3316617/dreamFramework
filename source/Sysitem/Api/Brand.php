<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

class Brand implements IApi{
    var $code;
    
    function api($params){
        $filter = json_decode($params['filter'],1);
		$columns = $params['columns']?$params['columns']:'*';
		$limit = intval($params['limit'])?intval($params['limit']):10;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
//		print_r($params);exit;
        $mdl_brand = FactoryManager::singleCreateProduct('Model_Brand@Sysitem');
        $result['list'] = $mdl_brand->getList($columns,$filter,$mdl_brand->tableName,$limit,$pageno);
		$result['total'] = $mdl_brand->count($filter);
		
   
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