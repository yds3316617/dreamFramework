<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

class ItemCatAdd implements IApi{
    var $code;
    
    function api($params){
        
        $data['name'] = $params['name'];
        $data['createtime'] = time();
        $data['lastmodifytime'] = $data['createtime'];
        $data['depth'] = $params['depth']?$params['depth']:1;
        $data['parent_id'] = $params['parent_id']?$params['parent_id']:0;

        $mdl_cat = FactoryManager::singleCreateProduct('Model_ItemCat@Sysitem');
        if($data['parent_id']){
            $filter['id'] = $data['parent_id'];
            $parentdata = $mdl_cat->getList('id,path',$filter,$mdl_cat->tableName);
            $data['path'] = $parentdata[0]['path'].$data['parent_id'].",";
        }

        $result = $mdl_cat->add($data);
   
        if($result){
            $data['id'] = $result;
            $this->code = '00';
            $result = $params;
        }else{
            $this->code = 'update error';
        }

        return $data;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}