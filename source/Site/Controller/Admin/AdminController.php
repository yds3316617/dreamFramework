<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;
use Site\IAdminController;

require_once(ROOT_DIR.'/Site/Controller.php');
require_once(ROOT_DIR.'/Site/Interface/IAdminController.php');

class AdminController extends Controller implements IAdminController{

	var $columns = array();
	var $appendColumns = array();
	var $filter = array();
    function __construct(){
    	$this->columns = $this->getColumns();
		$this->appendColumns = $this->getAppendColumns();
		if($_POST['filterValue'] && $_POST['filterCol']){
			$this->filter[$_POST['filterCol']] = $_POST['filterValue'];
		}
        parent::__construct();
    }
	
	
	function index(){
		
		$libUser = FactoryManager::singleCreateProduct('Lib_Admin_User@Site');
		
		if($libUser->checklogin($_COOKIE['admin']) == FALSE){
			echo "请先登录AdminLogin";exit;
		}
		
//		print_r($_POST);exit;
		
//		print_r($this->filter);exit;
		$data = $this->getData();
		
		$title = $this->getTitle();
		
		$curPathinfo = $this->getCurPathinfo();
		
		$searchOptions = array();
		foreach($this->columns['columns'] as $k=>$v){
			if(isset($v['search_type'])){
				$searchOptions[$k] = $v;
			}
		}
		
		$this->assign('searchOptions',$searchOptions);

		$this->assign('data',$data['list']);
		if($data['total']){
			$this->assign('total',$data['total']);
			$this->assign('limit',$data['limit']);
			$this->assign('pages',ceil($data['total']/$data['limit']));
			$this->assign('curpath',BASE_URL.'/index.php/'.$curPathinfo.'.html');
		}
		
		$this->assign('columns',$this->columns);
		$this->assign('appendColumns',$this->appendColumns);
		
		$this->assign('title',$title);
		
		#如果是分页或者ajax，则局部刷新即可
		if($_POST['ajaxPage']){
			$this->display('Site/View/Admin/grid.html');
		}else{
			$this->display('Site/View/Admin/index.html');
		}
	}
	
	

    #展示数据
	function getData(){
		
	}
	
	#设置标题
	function getTitle(){
		
	}
	
	#设置列
	function getColumns(){
		
	}
	
	function getCurPathinfo(){
		return $this->routeInfo['pathinfo'];
	}
	
	function createFormBySchema($tableName){
		$db = FactoryManager::singleCreateProduct('DatabaseManager@Core');
		$rs = $db->getColumns($tableName);
		
		return $this->fetch('Site/View/Admin/Block/form.html');
	}	
}