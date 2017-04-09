<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;
use Site\IAdminController;

require_once(ROOT_DIR.'/Site/Controller.php');
require_once(ROOT_DIR.'/Site/Controller/Admin/AdminController.php');
require_once(ROOT_DIR.'/Site/Interface/IAdminController.php');

class ItemController extends AdminController implements IAdminController{

    function __construct(){
        parent::__construct();
    }

    #展示数据
	function getData(){
		$columns = array_keys($this->columns['columns']);
		$params['filter'] = json_encode($this->filter);
		$params['limit'] = 10;
		$params['pageno'] = $_POST['pageno']?$_POST['pageno']:1;
        $params['columns'] = 'sysitem_item.*,brandname';
//		print_r($params);exit;
		$result = Api::call('item.item.list',$params);
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
	
	#点击编辑按钮展现界面
	function edit(){
		$params['filter'] = json_encode($this->filter);
		$result = Api::call('item.brand.list',$params);
//		print_r($result);exit;
		$tableName = 'sysitem_brand';

        $this->assign('result',json_decode($result,1));

//print_r(json_decode($result,1));exit;
		
		return $this->display('Site/View/Admin/ItemEdit.html');
		$form = $this->createFormBySchema($tableName);

		echo $form;exit;
//		display('Site/View/Admin/brandEdit.html');
	}



    function doEdit(){
        
        
    }

}