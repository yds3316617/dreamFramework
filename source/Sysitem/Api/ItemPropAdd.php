<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

//$params['name'] = $_POST['brandname'];
//$params['prop_type'] = $_POST['prop_type'];
//$params['prop_values'] = json_encode(array('name'=>,'extra_name'=>'','order_by'=>''));

class ItemPropAdd implements IApi{
    var $code;
    
    function api($params){
        $data['name'] = $params['name'];
        $data['prop_type'] = $params['prop_type']?$params['prop_type']:'sale';

        $prop_values = json_decode($params['prop_values'],1);
        unset($data['prop_values']);



        $mdl_prop = FactoryManager::singleCreateProduct('Model_ItemProp@Sysitem');
        $mdl_prop_value = FactoryManager::singleCreateProduct('Model_ItemPropValue@Sysitem');
        $prop_id = $mdl_prop->add($data);

        foreach($prop_values as $k=>$v){
            $tmp = array();
            $tmp['name'] = $v['name'];
            $tmp['extra_name'] = $v['extra_name'];
            $tmp['order_by'] = intval($v['order_by']);
            $tmp['prop_id'] = $prop_id;
            $mdl_prop_value->add($tmp);
        }
		
   
        if($prop_id){
            $this->code = '00';
            $result = $params;
        }else{
            $this->code = 'add error';
        }

        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}