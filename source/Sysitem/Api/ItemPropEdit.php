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

class ItemPropEdit implements IApi{
    var $code;
    
    function api($params){
        $data = array();
        $data['id'] = $params['id'];
        $data['name'] = $params['name'];
        $data['prop_type'] = $params['prop_type']?$params['prop_type']:'sale';

        $mdl_prop = FactoryManager::singleCreateProduct('Model_ItemProp@Sysitem');
        $mdl_prop_value = FactoryManager::singleCreateProduct('Model_ItemPropValue@Sysitem');
        unset($data['id']);
        $result = $mdl_prop->update(array('id'=>$params['id']),$data);

        $propvalue_data = array();
        
        $params['prop_values'] = json_decode($params['prop_values'],1);
        if($params['prop_values']){
            foreach($params['prop_values'] as $p_value_id=>$pv){
                $propvalue_data = array();
                $propvalue_data['name'] = $pv['name'];
                $propvalue_data['extra_name'] = $pv['extra_name'];
                $propvalue_data['order_by'] = $pv['order_by'];
                $mdl_prop_value->update(array('id'=>$p_value_id),$propvalue_data);
            }
        }

        
        $params['newprop_values'] = json_decode($params['newprop_values'],1);
        if(!empty($params['newprop_values'])){
            foreach($params['newprop_values'] as $new_p_value_id=>$new_pv){
                $propvalue_data = array();
                $propvalue_data['name'] = $new_pv['name'];
                $propvalue_data['prop_id'] = $params['id'];
                $propvalue_data['extra_name'] = $new_pv['extra_name'];
                $propvalue_data['order_by'] = $new_pv['order_by'];
                $mdl_prop_value->add($propvalue_data);
            }
        }
   
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