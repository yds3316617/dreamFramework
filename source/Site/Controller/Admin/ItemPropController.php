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
		$rs[] = array('column'=>'操作','lable'=>'编辑','target'=>'dialog','href'=>BASE_URL.'/index.php/adminPropEdit.html');
		return $rs;
	}

    function getActions(){
        $rs[] = array('title'=>'新增','target'=>'dialog','href'=>BASE_URL.'/index.php/adminPropAdd.html');
        $rs[] = array('title'=>'删除','target'=>'submit','href'=>BASE_URL.'/index.php/adminItemProp/doRemove.html');
		return $rs;
    }


    #点击新增按钮展现界面
	function add(){
		return $this->display('Site/View/Admin/Item/Prop/propAdd.html');
	}


    function doAdd(){
        $params['name'] = $_POST['name'];
        $params['prop_type'] = $_POST['prop_type'];

        $params['prop_values'] = array();
        foreach($_POST['newprop_values']['name'] as $k=>$v){
            $params['prop_values'][$k]['name'] = $v;

            $params['prop_values'][$k]['extra_name'] = $_POST['newprop_values']['extra_name'][$k];

            $params['prop_values'][$k]['order_by'] = $_POST['newprop_values']['order_by'][$k];

        }

        $params['prop_values'] = json_encode($params['prop_values']);


        $result = Api::call('item.prop.add',$params);
        $jsresult = json_decode($result,1);


        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
        
    }
	
	#点击编辑按钮展现界面
	function edit(){
		$params['filter'] = json_encode($this->filter);
        $params['has_propvalues'] = true;
		$result = Api::call('item.prop.list',$params);

        $this->assign('result',json_decode($result,1));

//print_r(json_decode($result,1));exit;
		
		return $this->display('Site/View/Admin/Item/Prop/propEdit.html');
	}



    function doEdit(){
        $params['id'] = $_POST['id'];
        $params['name'] = $_POST['name'];
        $params['prop_type'] = $_POST['prop_type'];

        if($_POST['prop_values']['name']){
            foreach($_POST['prop_values']['name'] as $pk=>$pv){
                $params['prop_values'][$pk]['name'] = $pv;
                $params['prop_values'][$pk]['extra_name'] = $_POST['prop_values']['extra_name'][$pk];
                $params['prop_values'][$pk]['order_by'] = $_POST['prop_values']['order_by'][$pk];
            }
        }

        if($_POST['newprop_values']['name']){
            foreach($_POST['newprop_values']['name'] as $npk=>$npv){
                $params['newprop_values'][$npk]['name'] = $npv;
                $params['newprop_values'][$npk]['extra_name'] = $_POST['newprop_values']['extra_name'][$npk];
                $params['newprop_values'][$npk]['order_by'] = $_POST['newprop_values']['order_by'][$npk];
            }
        }

        $params['prop_values'] = json_encode($params['prop_values']);
        $params['newprop_values'] = json_encode($params['newprop_values']);

        $result = Api::call('item.prop.edit',$params);
        $jsresult = json_decode($result,1);


        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
        
    }

    function doRemoveValue(){
        $params['id'] = $_POST['prop_value_id'];

        $result = Api::call('item.propvalue.remove',$params);
        $jsresult = json_decode($result,1);


        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
    }

    function doRemove(){
        $params['ids'] = json_encode($_POST['pk']);

        $result = Api::call('item.prop.remove',$params);
        $jsresult = json_decode($result,1);


        if($jsresult['code'] == '00'){
			echo $result;exit;
		}else{
			echo $result;exit;
		}
    }

}