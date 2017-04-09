<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;
use Site\IAdminController;

require_once(ROOT_DIR.'/Site/Controller.php');
require_once(ROOT_DIR.'/Site/Controller/Admin/AdminController.php');
require_once(ROOT_DIR.'/Site/Interface/IAdminController.php');

class ItemPropController extends AdminController implements IAdminController{

    function __construct(){
        parent::__construct();
    }

    #展示数据
	function getData(){
		$columns = array_keys($this->columns['columns']);
		$params['filter'] = json_encode($this->filter);
		$params['limit'] = 10;
		$params['pageno'] = $_POST['pageno']?$_POST['pageno']:1;
        $params['columns'] = '*';
//		print_r($params);exit;
		$result = Api::call('item.prop.list',$params);
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
		return '规格属性列表';
	}
	
	#设置列
	function getColumns(){
		$db = FactoryManager::singleCreateProduct('DatabaseManager@Core');
		$rs = $db->getColumns('sysitem_prop');

		return $rs;
	}
	
	#设置追加列
	function getAppendColumns(){
		$rs[] = array('column'=>'操作','lable'=>'编辑','href'=>BASE_URL.'/index.php/adminPropEdit.html');
		return $rs;
	}

    function getActions(){
        $rs[] = array('title'=>'新增','target'=>'dialog','href'=>BASE_URL.'/index.php/adminPropAdd.html');
		return $rs;
    }


    #点击新增按钮展现界面
	function add(){
		return $this->display('Site/View/Admin/Item/Prop/propAdd.html');
	}
	
	#点击编辑按钮展现界面
	function edit(){
		$params['filter'] = json_encode($this->filter);
		$result = Api::call('item.prop.list',$params);
//		print_r($result);exit;

        $this->assign('result',json_decode($result,1));

//print_r(json_decode($result,1));exit;
		
		return $this->display('Site/View/Admin/Item/Prop/propEdit.html');
	}



    function doEdit(){
        echo 2;exit;
        $params['id'] = $_POST['id'];
        $params['brandname'] = $_POST['brandname'];
        $params['brief'] = $_POST['brief'];
        $result = Api::call('item.prop.edit',$params);
        $jsresult = json_decode($result,1);


        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
        
    }

}