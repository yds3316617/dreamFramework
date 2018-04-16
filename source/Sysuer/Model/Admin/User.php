<?php
namespace Sysuer\Model\Admin;
use Core\FactoryManager;
use Core\DatabaseManager;


class User extends DatabaseManager{

    var $tableName = 'sysuser_admin_user';

    var $pk = 'id';

    

        function checkLogin($username,$password){

            $row = $this->getList('*',array('username'=>$username),$this->tableName,1,0);
            $dataPassword = $row[0]['password'];
            $key = $row[0]['seed'];
            $encryptPassword = $this->DESencrypt($key,$password);

//            $rs = $this->update(array('username'=>$username),array('password'=>$encryptPassword));

//            $encryptPassword = $this->DESdencrypt($key,$dataPassword);
//            error_log(var_export($encryptPassword,1),3,'E:/555.txt');
//            print_r($encryptPassword);exit;

            if($dataPassword == $encryptPassword){
                $sess_id = $this->doLogin($row[0]);
                $row[0]['sess_id'] = $sess_id;
                return $row[0];
            }

            return false;
        }

        function doLogin($userInfo){
            $session = FactoryManager::singleCreateProduct('Session@Web');
                        error_log(var_export($userInfo,1),3,'E:/2.txt');
            $sess_id = $session->start('admin');
            $_SESSION['admin']['id'] = $userInfo['id'];
            $_SESSION['admin']['username'] = $userInfo['username'];
            return $sess_id;
        }

        

        function DESencrypt($key,$string){
//            $algorithm = MCRYPT_BLOWFISH; // 加密算法
//            $mode = MCRYPT_MODE_CBC; // 加密或解密的模式
//            $iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode), MCRYPT_DEV_URANDOM);
//            $encrypted_data = mcrypt_encrypt($algorithm, $key, $string, $mode, $iv);
//            $rs = base64_encode($encrypted_data);

            $rs = md5($string);
            return $rs;
        }

        
//        function DESdencrypt($key,$string){
//            $algorithm = MCRYPT_BLOWFISH; // 加密算法
//            $mode = MCRYPT_MODE_CBC; // 加密或解密的模式
//            $iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode), MCRYPT_DEV_URANDOM);
//
//            $string = base64_decode($string);
//            $rs = mcrypt_decrypt($algorithm, $key, $string, $mode, $iv);
//            return $rs;
//        }
}