<?php
namespace Syscontent\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/Interface/IApi.php");

class ArticleCat implements IApi{
    var $code;
    
    function api($params){
        $filter = json_decode($params['filter'],1);
        $tree = $params['tree'];
        
		$columns = $params['columns']?$params['columns']:'*';
		$limit = intval($params['limit'])?intval($params['limit']):-1;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
        $mdl_article = FactoryManager::singleCreateProduct('Model_ArticleCat@Syscontent');
        
		$result['total'] = $mdl_article->count($filter);

        if($tree == true){
            $rs = array();
            $this->children($rs,$filter);
        }else{
            $rs = $mdl_article->getList($columns,$filter,$mdl_article->tableName,$limit,$pageno);
        }
        

        $result['list'] = $rs;
   
        if($result){
            $this->code = '00';
        }else{
            $this->code = 'no data';
        }
        return $result;
    }

    function children(&$rs,$filter){
        $id = $filter['id']?$filter['id']:0;
        $deep = $filter['deep']?$filter['deep']+1:1;

        $mdl_article = FactoryManager::singleCreateProduct('Model_ArticleCat@Syscontent');
        if($id){
//            $tfilter['parent_ids|like'] = ",$id,";
            $tfilter['parent_id'] = "$id";
        }
        $tfilter['deep'] = $deep;

        $data = $mdl_article->getList('*',$tfilter,$mdl_article->tableName,-1,$pageno);
//echo "<pre>";
//print_r($data);
        foreach($data as $k=>$v){
            $rs[] = $v;
            $tmpfilter = array();
            $tmpfilter['id'] = $v['id'];
            $tmpfilter['deep'] = $v['deep'];
            
            $this->children($rs,$tmpfilter);
            
        }

    }


    public  function getCode(){
        return $this->code;
    }

    public  function getParams(){
        
    }
}