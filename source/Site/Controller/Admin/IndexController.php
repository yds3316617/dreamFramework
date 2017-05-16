<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;

require_once(ROOT_DIR.'/Site/Controller.php');

class IndexController extends Controller{

    function __construct(){
        parent::__construct();
    }

    //登录页面
    function login(){
//        $server = FactoryManager::singleCreateProduct('DatabaseManager@Core');
//        $server->setDatabase('dreamFrameworkGithub');
//        $result = $server->getList('*',array(),'test');
        $this->display('Site/View/Admin/login.html');
    }

    function adminIndex(){
        $userObj = FactoryManager::singleCreateProduct('Lib_Admin_User@Site');
        $session = FactoryManager::singleCreateProduct('Session@Web');
        $session->start('admin',$_COOKIE['admin']);
        
        if($userObj->checklogin($_COOKIE['admin'])){
            $this->display('Site/View/Admin/welcome.html');
        }else{
            echo '请先登录';exit;
        }
        
    }

	/*
	 *  后台登录
	 * */
    function doLogin(){
        $result = Api::call('user.admin.login',$_POST);
        
        $result = json_decode($result,1);

        if($result['code'] == '00'){
            //api会返回sess_id 需要更新sess_id
            $session = FactoryManager::singleCreateProduct('Session@Web');
            if($session->start('admin',$result['data']['sess_id']) == false){
                    $this->error($data,'session 开启失败');
            }
            $_COOKIE['admin'] = $result['data']['sess_id'];
//            echo $result['data']['sess_id'];
//            echo "<br>";
//            print_r($_COOKIE);exit;
            $data['nextUrl'] = BASE_URL.'/index.php/adminIndex.html';
            $this->success($data);
            
        }else{
            $this->error($data,'登录失败,请重试');
        }
    }
	
	/*
	 * 后台注销
	 * */
	function doLoginout(){
        $result = Api::call('user.admin.loginout',array('sess_id'=>$_COOKIE['admin']));
        $result = json_decode($result,1);

        if($result['code'] == '00'){
            //api会返回sess_id 需要更新sess_id
            $session = FactoryManager::singleCreateProduct('Session@Web');
            if($session->start('admin',$result['data']['sess_id']) == false){
                    $this->error($data,'session 开启失败');
            }
            unset($_COOKIE['admin']);
//            echo $result['data']['sess_id'];
//            echo "<br>";
//            print_r($_COOKIE);exit;
            $data['nextUrl'] = BASE_URL.'/index.php/adminLogin.html';
            $this->success($data);
            
        }else{
            $this->error($data,'注销失败,请重试');
        }
    }

}