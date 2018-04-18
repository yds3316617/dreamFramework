<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;
use Site\IAdminController;

require_once(ROOT_DIR.'/Site/Controller.php');
require_once(ROOT_DIR.'/Site/Controller/Admin/AdminController.php');
require_once(ROOT_DIR.'/Site/Interface/IAdminController.php');

class ArticleCatController extends AdminController implements IAdminController{

    function __construct(){
        //树形显示
        $this->tree = true;
        parent::__construct();
    }

	#展示数据
	function getData(){
		$columns = array_keys($this->columns['columns']);
		$params['filter'] = json_encode($this->filter);
		$params['limit'] = -1;
		$params['pageno'] = $_POST['pageno']?$_POST['pageno']:1;
        $params['tree'] = true;
//		print_r($params);exit;
		$result = Api::call('content.article.cat.list',$params);

		$result = json_decode($result,1);
		
        

		if($result['code'] == '00'){
			$result['data']['limit'] = $params['limit'];
			return $result['data'];
		}else{
			return array();
		}
	}
	
	#设置标题
	function getTitle(){
		return '文章分类列表';
	}
	
	#设置列
	function getColumns(){
		$db = FactoryManager::singleCreateProduct('DatabaseManager@Core');
		$rs = $db->getColumns('syscontent_article_cat');
		
		return $rs;
	}
	
	#设置追加列
	function getAppendColumns(){
        $actions = array();
        $actions[] = array('lable'=>'编辑','target'=>'dialog','href'=>BASE_URL.'/index.php/adminArticleCatEdit.html');

        $actions[] = array('lable'=>'增加子分类','target'=>'dialog','href'=>BASE_URL.'/index.php/adminArticleCatAddChild.html');

        $actions[] = array('lable'=>'删除','target'=>'submit','href'=>BASE_URL.'/index.php/adminArticleCat/doRemove');

		$rs[] = array('column'=>'操作','actions'=>$actions);
		return $rs;
	}

    #列表头部按钮
    function getActions(){
        $rs[] = array('lable'=>'新增一级分类','target'=>'dialog','href'=>BASE_URL.'/index.php/adminArticleCatAdd.html');
		return $rs;
    }

    #点击新增按钮展现界面
	function add(){
		return $this->display('Site/View/Admin/articleCatAdd.html');
	}
	
	#点击编辑按钮展现界面
	function edit(){
		$params['filter'] = json_encode(array('id'=>$_GET['id']));
		$result = Api::call('content.article.cat.list',$params);
        $result = json_decode($result,1);

        $params2['filter'] = json_encode(array('id'=>$result['data']['list'][0]['parent_id']));
        $result2 = Api::call('content.article.cat.list',$params2);

        $this->assign('result',$result);
        $this->assign('parent',json_decode($result2,1));

		return $this->display('Site/View/Admin/articleCatEdit.html');
	}

    #新增文章分类
    function doAdd(){
        $params['id'] = $_POST['id'];
        $params['name'] = $_POST['name'];
        $params['orders'] = $_POST['orders'];
        $params['parent_id'] = 0;
        $params['deep'] = 1;
        $params['parent_ids'] = 0;
        $result = Api::call('content.article.cat.save',$params);
//        print_r($result);exit;
        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
        
    }

    function doEdit(){
        $params['id'] = $_POST['id'];
        $params['name'] = $_POST['name'];
        $params['orders'] = $_POST['orders'];
        $result = Api::call('content.article.cat.save',$params);
        $jsresult = json_decode($result,1);


        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
        
    }
    
    function addChild(){
        $params['filter'] = json_encode(array('id'=>$_GET['id']));
		$result = Api::call('content.article.cat.list',$params);
        $result = json_decode($result,1);

        $this->assign('result',$result);

		return $this->display('Site/View/Admin/articleCatAddChild.html');
    }

    //添加子分类
    function doAddChild(){
        $params['name'] = $_POST['name'];
        $params['orders'] = $_POST['orders'];
        $params['parent_id'] = $_POST['parent_id'];
        $result = Api::call('content.article.cat.save',$params);
        $jsresult = json_decode($result,1);

        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
        
    }

    function doRemove(){
        $params['id'] = $_GET['id'];

        $result = Api::call('content.article.cat.remove',$params);
        $jsresult = json_decode($result,1);


        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
    }

}