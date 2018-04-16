<?php
namespace Syscontent\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

class ArticleCatSave implements IApi{
    var $code;
    
    function api($params){
        if($params['id']){
            $data['id'] = $params['id'];
        }

        $data['name'] = $params['name'];

        if($params['orders']){
            $data['orders'] = $params['orders'];
        }

        $mdl_cat = FactoryManager::singleCreateProduct('Model_ArticleCat@Syscontent');

        if(empty($data['id'])){
            $result = $mdl_cat->add($data);
        }else{
            unset($data['id']);
            $result = $mdl_cat->update(array('id'=>$params['id']),$data);
        }

        if(empty($data['id']) && $data['parent_id'] && $data['parent_id'] != 0){
            $result = $this->refreshTree($data['id']);
        }
        
		
   
        if($result){
            $this->code = '00';
            $result = $params;
        }else{
            $this->code = 'update error';
        }

        return $result;
    }

    function refreshTree($cat_id){
        $mdl_cat = FactoryManager::singleCreateProduct('Model_ArticleCat@Syscontent');

        return true;
    }


    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}