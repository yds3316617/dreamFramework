<?php
namespace Core;

class Api{

    function apiList(){
        #后台登录接口
        return array(
            'user.admin.login'=>'Api_Admin_Pam@Sysuer',
            'user.admin.checklogin'=>'Api_Admin_CheckLogin@Sysuer',
        );
    }

    function parseApi($apiName='',$params=array()){
        if(empty($apiName)){
            $apiName = $_REQUEST['method'];
        }
        if(empty($params)){
            $params = $_REQUEST;
            unset($params['method']);
        }
        $apis = $this->apiList();
        $classInfo = $apis[$apiName];

        if($classInfo){
            $class = FactoryManager::createProduct($classInfo);
            
            $data = $class->Api($params);
            
            if($data){
                return $this->success('00',$data);
            }else{
                return $this->error($class->getCode());
            }
        }else{
            
            return $this->error('404','api not found');
        }

    }

    static function call($apiName,$params){
        $ch = curl_init();
        $header = "Content-type: text/xml";
        $post_data = $params;
        $post_data['method'] = $apiName;

        $url = BASE_URL.'/index.php/api';

        //curl将会获取url站点的内容,设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // 我们在POST数据哦！
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        //抓取URL并把它传递给浏览器
        $output = curl_exec($ch);
//        $output = json_decode($output,1);
        return $output;
    }

    function error($code){
        $errorInfo = array('code'=>$code);
        echo json_encode($errorInfo);
        exit;
    }

    function success($code,$data){
        $errorInfo = array('code'=>$code,'data'=>$data);
        echo json_encode($errorInfo);
        exit;
    }


    # 00 成功
    # 0001 登录失败
    # 0002 缺少参数
}
