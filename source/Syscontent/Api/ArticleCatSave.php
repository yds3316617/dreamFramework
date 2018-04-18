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
            $data['parent_id'] = $params['parent_id']?$params['parent_id']:0;
            $data['deep'] = $params['deep']?$params['deep']:0;
            $data['parent_ids'] = $params['parent_ids']?$params['parent_ids']:0;
            $result = $mdl_cat->add($data);
            if($result && $data['parent_id'] && $data['parent_id'] != 0){
                $result = $this->refreshTree($result,$data['parent_id']);
            }
        }else{
            unset($data['id']);
            $result = $mdl_cat->update(array('id'=>$params['id']),$data);
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
        /*
         * 第一步 更新 父分类的 child_count. 如果父分类还有父分类 需要递归处理
         */
        $parent_ids = array();
        $mdl_cat->getParentIds($cat_id,$parent_ids);

        if(empty($parent_ids)){
            return true;
        }
        foreach($parent_ids as $k=>$val){
            $tmp = array();
            $tmp['child_count'] = $mdl_cat->count(array('parent_id'=>$val));

            $mdl_cat->update(array('id'=>$val),$tmp);
        }
        /*
         * 第一步 更新 当前分类的 deep parent_ids
         */
        $tmp = array();
        $tmp['deep'] = count($parent_ids) + 1;
        $tmp['parent_ids'] = implode(',',$parent_ids);
        $mdl_cat->update(array('id'=>$cat_id),$tmp);
        
        return true;
    }


    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}