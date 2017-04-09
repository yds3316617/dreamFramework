<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

class ItemCatRemove implements IApi{
    var $code;
    
    function api($params){
        $data['id'] = $params['id'];
        $filter['parent_id'] = $params['id'];

        $mdl_cat = FactoryManager::singleCreateProduct('Model_ItemCat@Sysitem');
        $result['total'] = $mdl_cat->count($filter);

        if($result['total'] > 0){
             $this->code = '有子分类不能删除';
             return false;
        }else{
            $result = $mdl_cat->delete(array('id'=>$params['id']));
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