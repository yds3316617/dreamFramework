<?php
namespace Core;

class Api{

    function apiList(){
        
        return array(
        	#后台登录
            'user.admin.login'=>'Api_Admin_Pam@Sysuer',
            #后台检查是否登录状态
            'user.admin.checklogin'=>'Api_Admin_CheckLogin@Sysuer',
            #后台注销
            'user.admin.loginout'=>'Api_Admin_Loginout@Sysuer',

            #品牌列表
            'item.brand.list'=>'Api_Brand@Sysitem',
            #品牌编辑
            'item.brand.edit'=>'Api_BrandEdit@Sysitem',

            #商品列表
            'item.item.list'=>'Api_Item@Sysitem',
            #商品分类列表
            'item.cat.list'=>'Api_ItemCat@Sysitem',

            #分类编辑
            'item.cat.edit'=>'Api_ItemCatEdit@Sysitem',
            #分类添加
            'item.cat.add'=>'Api_ItemCatAdd@Sysitem',
            #分类删除
            'item.cat.remove'=>'Api_ItemCatRemove@Sysitem',

            #商品属性列表
            'item.prop.list'=>'Api_ItemProp@Sysitem',
            #商品属性编辑
            'item.prop.edit'=>'Api_ItemPropEdit@Sysitem',


            #文章列表
            'content.article.list'=>'Api_Article@Syscontent',
            #文章编辑
            'content.article.edit'=>'Api_ArticleEdit@Syscontent',
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
        $header = "Content-type: text/html";
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
