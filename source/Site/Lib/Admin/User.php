<?php
namespace Site\Lib\Admin;
use Core\FactoryManager;
use Core\Api;


class User{

    //检测是否登录
    function checklogin($sess_id){
        $result = Api::call('user.admin.checklogin',array('sess_id'=>$sess_id));
        $result = json_decode($result,1);

        if($result['code'] == '00'){
            if($result['data']['id']){
                return $result['data']['id'];
            }
        }

        return false;
    }


}