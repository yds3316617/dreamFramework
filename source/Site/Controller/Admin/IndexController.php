<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Site\Controller;

require_once(ROOT_DIR.'/Site/Controller.php');

class IndexController extends Controller{

    function __construct(){
        parent::__construct();
    }

    function index(){

        $this->display('Site/View/index.html');
    }

    function adminIndex(){
        $this->display('Site/View/Admin/index.html');
    }

}