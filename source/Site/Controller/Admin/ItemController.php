<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;

require_once(ROOT_DIR.'/Site/Controller.php');
require_once(ROOT_DIR.'/Site/Interface/IAdminController.php');

class ItemController extends AdminController implements IAdminController{

    function __construct(){
        parent::__construct();
    }

    

}