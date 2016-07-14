<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Site\Controller;

require_once(ROOT_DIR.'/Site/Controller.php');

class IndexController extends Controller{

    function __construct(){
        parent::__construct();
    }

    function login(){
//        $server = FactoryManager::singleCreateProduct('DatabaseManager@Core');
//        $server->setDatabase('dreamFrameworkGithub');
//        $result = $server->getList('*',array(),'test');
        $this->display('Site/View/Admin/login.html');
    }

    function adminIndex(){
        $this->display('Site/View/Admin/index.html');
    }

}