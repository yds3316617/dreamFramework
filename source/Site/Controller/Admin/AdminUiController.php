<?php
namespace Site\Controller\Admin;
use Core\FactoryManager;
use Core\Api;
use Site\Controller;
use Site\IAdminController;

require_once(ROOT_DIR.'/Site/Controller.php');
require_once(ROOT_DIR.'/Site/Controller/Admin/AdminController.php');
require_once(ROOT_DIR.'/Site/Interface/IAdminController.php');
/*
*  后台ui控件调用
*/
class AdminUiController extends AdminController implements IAdminController{

    function __construct(){
        parent::__construct();
    }

    function uiSelector(){
        $api = $_POST['api'];
        $pageno = $_POST['pageno'];
        $request_uri = $_POST['request_uri'];
        $pk = $_POST['pk'];
        $value = explode(',',$_POST['value']);

        $params = array();
        $params['limit'] = intval($_POST['limit'])?intval($_POST['limit']):10;
        $params['pageno'] = intval($_POST['pageno'])?intval($_POST['pageno']):1;

        unset($_POST['api']);
        unset($_POST['pageno']);
        unset($_POST['request_uri']);
        unset($_POST['limit']);
        unset($_POST['pageno']);
        unset($_POST['pk']);
        unset($_POST['value']);

        $params['filter'] = json_encode(array("$pk|notin"=>$value));
        $leftresult = Api::call($api,$params);
        
        $leftresult = json_decode($leftresult,1);

        $params_right = array();
        $params_right['filter'] = json_encode(array($pk=>$value));
        
        $rightresult = Api::call($api,$params_right);
        $rightresult = json_decode($rightresult,1);

        if($leftresult['code'] == '00'){
            $this->assign('leftresult',$leftresult);
        }

        if($rightresult['code'] == '00'){
            $this->assign('rightresult',$rightresult);
        }

        $this->assign('value',$value);

        $this->assign('request_uri',$request_uri);

        if($leftresult['data']['total']){
			$this->assign('total',$leftresult['data']['total']);
			$this->assign('limit',$params['limit']);
            $this->assign('pageno',$params['pageno']);
            $pages = ceil($leftresult['data']['total']/$params['limit']);
            $pre_pageno = $params['pageno']-1 > 0 ?$params['pageno']-1:1;
            $next_pageno = $params['pageno']+1 > $pages ? $pages:$params['pageno']+1;

            $this->assign('pre_pageno',$pre_pageno);
            $this->assign('next_pageno',$next_pageno);

			$this->assign('pages',$pages);
			$this->assign('curpath',BASE_URL.'/index.php/'.$curPathinfo.'.html');
		}

        $this->display('Site/View/Admin/Ui/selector.html');
    }

}