<?php
namespace Syscontent\Api;
use Core\FactoryManager;
use Core\IApi;
require(ROOT_DIR."Core/interface/IApi.php");

class ArticleEdit implements IApi{
    var $code;
    
//$params['id'] = $_POST['id'];
//$params['title'] = $_POST['title'];
//$params['createtime'] = $_POST['createtime'];
//$params['ispublic'] = $_POST['ispublic'];
//$params['cat_id'] = $_POST['cat_id'];
//$params['content'] = $_POST['content'];

    function api($params){
        
		$limit = intval($params['limit'])?intval($params['limit']):10;
		$pageno = intval($params['pageno'])?intval($params['pageno']):1;
        $params['lastmodifytime'] = time();
//		print_r($params);exit;
        $mdl_article = FactoryManager::singleCreateProduct('Model_Article@Syscontent');
        if(empty($params['id'])){
            if($id = $mdl_article->add($params)){
                $result['data']['id'] = $id;
            }else{
                $this->code = 'add fail';
            }
        }else{
            if($id = $mdl_article->update(array('id'=>$params['id']),$params)){
                $result['data']['id'] = $params['id'];
            }else{
                $this->code = 'update fail';
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