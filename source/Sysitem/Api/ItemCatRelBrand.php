<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

//$params[has_propvalues];是否包含规格值信息
class ItemCatRelBrand implements IApi{
    var $code;
    
    function api($params){
        $filter = json_decode($params['filter'],1);
		$columns = $params['columns']?$params['columns']:'*';
		$limit = intval($params['limit'])?intval($params['limit']):-1;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
//		print_r($params);exit;
        $mdl_item_brand = FactoryManager::singleCreateProduct('Model_Brand@Sysitem');
        $mdl_item_cat_brand = FactoryManager::singleCreateProduct('Model_ItemCatBrand@Sysitem');

        $result['list'] = $mdl_item_cat_brand->getList($columns,$filter,$mdl_item_cat_brand->tableName,$limit,$pageno,1,array('brand_id|inner'=>$mdl_item_brand->tableName.'@id'));

        
		$result['total'] = $mdl_item_cat_brand->count($filter,array('brand_id|inner'=>$mdl_item_brand->tableName.'@id'));
		
   
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