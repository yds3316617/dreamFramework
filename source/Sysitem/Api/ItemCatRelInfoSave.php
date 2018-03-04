<?php
namespace Sysitem\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

//$params[cat_id];分类id
//$params[prop_id];关联属性 json
//$params[brand_id];关联品牌 json
class ItemCatRelInfoSave implements IApi{
    var $code;
    
    function api($params){
        $cat_id = $params['cat_id'];
        $prop_id = json_decode($params['prop_id']);
        $brand_id = json_decode($params['brand_id']);
//		print_r($params);exit;
        $mdl_item_catProp = FactoryManager::singleCreateProduct('Model_ItemCatProp@Sysitem');
        $mdl_item_catBrand = FactoryManager::singleCreateProduct('Model_ItemCatBrand@Sysitem');

        $mdl_item_catProp->delete(array('cat_id'=>$cat_id));
        $mdl_item_catBrand->delete(array('cat_id'=>$cat_id));

        if($prop_id){
            foreach($prop_id as $pk=>$pv){
                $tmp = array();
                $tmp['cat_id'] = $cat_id;
                $tmp['prop_id'] = $pv;
                $mdl_item_catProp->add($tmp);
            }
        }

        if($brand_id){
            foreach($brand_id as $bk=>$bv){
                $tmp = array();
                $tmp['cat_id'] = $cat_id;
                $tmp['brand_id'] = $bv;
                $mdl_item_catBrand->add($tmp);
            }
        }

        $result['code'] = $this->code = '00';

        $result['params'] = $params;
        return $result;
    }

    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}