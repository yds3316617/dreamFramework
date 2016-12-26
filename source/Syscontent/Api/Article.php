<?php
namespace Syscontent\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

class Article implements IApi{
    var $code;
    
    function api($params){
        
        $filter = json_decode($params['filter'],1);
		$columns = $params['columns']?$params['columns']:'*';
		$limit = intval($params['limit'])?intval($params['limit']):10;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
//		print_r($params);exit;
        $mdl_article = FactoryManager::singleCreateProduct('Model_Article@Syscontent');
        $result['list'] = $mdl_article->getList($columns,$filter,$mdl_article->tableName,$limit,$pageno);
		$result['total'] = $mdl_article->count($filter);
		
   
        if($result){
            $this->code = '00';
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