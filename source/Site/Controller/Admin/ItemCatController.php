<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;
use Site\IAdminController;

require_once(ROOT_DIR.'/Site/Controller.php');
require_once(ROOT_DIR.'/Site/Controller/Admin/AdminController.php');
require_once(ROOT_DIR.'/Site/Interface/IAdminController.php');

#商品分类
class ItemCatController extends AdminController implements IAdminController{

    function __construct(){
        parent::__construct();
    }


    function index(){

		$data = $this->getData();
		
		$title = $this->getTitle();
		
		$curPathinfo = $this->getCurPathinfo();

        $params['limit'] = 5000;
        $params['filter'] = json_encode(array('depth'=>1));
        $result = Api::call('item.cat.list',$params);
        $result = json_decode($result,1);

		$this->assign('data',$result['data']['list']);

        $params['filter'] = json_encode(array('depth'=>2));
        $result = Api::call('item.cat.list',$params);
        $result = json_decode($result,1);
        $this->assign('data2',$result['data']['list']);

        $params['filter'] = json_encode(array('depth'=>3));
        $result = Api::call('item.cat.list',$params);
        $result = json_decode($result,1);
        $this->assign('data3',$result['data']['list']);
		
		$this->assign('title',$title);

	    $this->display('Site/View/Admin/tree.html');

    }


    #展示数据
	function getData(){
		$columns = array_keys($this->columns['columns']);
		$params['filter'] = json_encode($this->filter);
		$params['limit'] = 5000;
		$params['pageno'] = $_POST['pageno']?$_POST['pageno']:1;
        $params['columns'] = '*';
//		print_r($params);exit;
		$result = Api::call('item.cat.list',$params);
//		print_r($result);exit;
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
		return '商品列表';
	}
	
	#设置列
	function getColumns(){
		$db = FactoryManager::singleCreateProduct('DatabaseManager@Core');
		$rs = $db->getColumns('sysitem_item');
		$rs['columns']['brandname'] = array(
                        'lable'=>'品牌名称',
                        'type' => 'varchar',
                        'length'=>30,
                        'width' => '30',
                    );
		return $rs;
	}
	
	#设置追加列
	function getAppendColumns(){
		$rs[] = array('column'=>'操作','lable'=>'编辑','target'=>'_blank','href'=>BASE_URL.'/index.php/adminItemEdit.html');
		return $rs;
	}

    #点击添加按钮展现界面
	function add(){
        $params['filter'] = json_encode(array('depth'=>$_POST['depth']));

        $depth = $_POST['depth'];
        if($depth == 1){
            //1级分类无上级分类
        }else{
            unset($params);
            $params['filter'] = json_encode(array('depth'=>$depth-1));
            $parents = Api::call('item.cat.list',$params);
            $parents = json_decode($parents,1);
            $this->assign('parents',$parents);
        }
		return $this->display('Site/View/Admin/catAdd.html');
	}
	
	#点击编辑按钮展现界面
	function edit(){
		$params['filter'] = json_encode(array('id'=>$_POST['id']));
		$result = Api::call('item.cat.list',$params);
        $result = json_decode($result,1);
        $this->assign('result',$result);

        
        $depth = $result['data']['list'][0]['depth'];
        if($depth == 1){
            //1级分类无上级分类
        }else{
            unset($params);
            $params['filter'] = json_encode(array('id'=>$result['data']['list'][0]['parent_id']));
            $parents = Api::call('item.cat.list',$params);
            $parents = json_decode($parents,1);
            $this->assign('parents',$parents);
        }

		return $this->display('Site/View/Admin/catEdit.html');
	}

    
    function doAdd(){
        $params['id'] = $_POST['id'];
        $params['name'] = $_POST['name'];
        $params['depth'] = $_POST['depth'];
        if($_POST['parent_id']){
            $params['parent_id'] = $_POST['parent_id'];
        }

        $result = Api::call('item.cat.add',$params);
        $jsresult = json_decode($result,1);

        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
    }


    function doRemove(){
        $params['id'] = $_POST['id'];

        $result = Api::call('item.cat.remove',$params);

        $jsresult = json_decode($result,1);

        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
    }


    function doEdit(){
        $params['id'] = $_POST['id'];
        $params['name'] = $_POST['name'];

        $result = Api::call('item.cat.edit',$params);
        $jsresult = json_decode($result,1);

        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
    }

    function showChildren(){
        $params['filter'] = json_encode(array('parent_id'=>$_POST['cat_id']));
		$result = Api::call('item.cat.list',$params);
        $result = json_decode($result,1);
//print_r($result);exit;
        if($_POST['depth'] == 1){
            $this->assign('data2',$result);
            echo $this->display('Site/View/Admin/Item/Cat/depth2.html');exit;
        }else{
            $this->assign('data3',$result);
            echo $this->display('Site/View/Admin/Item/Cat/depth3.html');exit;
        }
        

        
    }

}