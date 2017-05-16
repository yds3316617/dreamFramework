<?php
namespace Sysitem\Lib;
use Core\FactoryManager;
use Core\Api;


class Prop{

    //删除规格
    function remove($prop_ids){
        $mdl_prop = FactoryManager::singleCreateProduct('Model_ItemProp@Sysitem');
        $mdl_prop_value = FactoryManager::singleCreateProduct('Model_ItemPropValue@Sysitem');

        $db = FactoryManager::singleCreateProduct('DatabaseManager@Core');
        $db->beginTransaction();
        if($mdl_prop_value->delete(array('prop_id'=>$prop_ids))){
            $result = $mdl_prop->delete(array('id'=>$prop_ids));
        }
        if($result){
            $db->commit();
            return true;
        }else{
            $db->rollBack();
            return false;
        }
    }
	
	


}