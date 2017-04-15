<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

//$params[has_propvalues];是否包含规格值信息
class ItemProp implements IApi{
    var $code;
    
    function api($params){
        $filter = json_decode($params['filter'],1);
		$columns = $params['columns']?$params['columns']:'*';
		$limit = intval($params['limit'])?intval($params['limit']):10;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
//		print_r($params);exit;
        $mdl_item_prop = FactoryManager::singleCreateProduct('Model_ItemProp@Sysitem');
        $mdl_item_prop_values = FactoryManager::singleCreateProduct('Model_ItemPropValue@Sysitem');
//        error_log(var_export($params,1),3,'E:/1.txt');
        $result['list'] = $mdl_item_prop->getList($columns,$filter,$mdl_item_prop->tableName,$limit,$pageno,1);

        if($params['has_propvalues']){
            foreach($result['list'] as $k=>$v){
                $prop_values = $mdl_item_prop_values->getList('id,name,prop_id,extra_name,order_by',array('prop_id'=>$v['id']),$mdl_item_prop_values->tableName);
                $result['list'][$k]['prop_values'] = $prop_values;
            }
        }
        
		$result['total'] = $mdl_item_prop->count($filter);
		
   
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