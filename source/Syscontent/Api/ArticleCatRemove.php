<?php
namespace Syscontent\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

class ArticleCatRemove implements IApi{
    var $code;
    
    function api($params){
        if($params['id']){
            $data['id'] = $params['id'];
        }

        $mdl_cat = FactoryManager::singleCreateProduct('Model_ArticleCat@Syscontent');
        $result = $mdl_cat->doRemove($data['id']);

        unset($data['id']);

        if($result){
            $this->code = '00';
            $result = $params;
        }else{
            if($mdl_cat->error){
                $this->code = $mdl_cat->error;
            }else{
                $this->code = 'delete error';
            }
        }

        return $result;
    }


    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}