<?php
namespace Web;
use Core\FactoryManager;

class Session{

     var $store_type;//存储方式 db,file,memcache

     var $life_time = 30;//默认30分钟

     var $sess_id;

     var $session_storage;

     private $magic_quotes_gpc = false;

/*
Session open (called by session_start())

Session close (called at page end)

Session read (called after session_start() )

Session write (called when session data is to be written)

Session destroy (called by session_destroy() )

Session garbage collect (called randomly)
*/

    function __construct(){
		$this->life_time = 86400;

        $this->session_storage = FactoryManager::singleCreateProduct('KVStore@Core');
        
		session_set_cookie_params($this->life_time);
        
        session_set_save_handler(   array (& $this, "_sess_open"),
                                    array (& $this, "_sess_close"),
                                    array (& $this, "_sess_read"),
                                    array (& $this, "_sess_write"),
                                    array (& $this, "_sess_destroy"),
                                    array (& $this, "_sess_gc")
                                );
    }



	function set($key,$value){
		$_SESSION[$key] = $value;
	}

	function get($key){
		return $_SESSION[$key];
	}

    function setcookie($key,$value){
        setcookie($key,$value,time()+36000);
        
//		$_COOKIE[$key] = $value;
	}

    function start($name='SESSID',$sess_id=''){
        if($this->session_storage->start() == false){
            return false;
        }
        session_name($name);

        if($sess_id){
            $this->sess_id = $sess_id;
        }else{
            if($_COOKIE[$name]){
                $this->sess_id = $_COOKIE[$name];
            }elseif(!$this->sess_id){
                $this->sess_id = md5(microtime().uniqid().mt_rand(0,9999));
            }
        }
        session_id($this->sess_id);
        $bool = session_start();
        if($bool){
            return $this->sess_id;
        }else{
            return $bool;
        }
    }

    function _sess_open($save_path, $session_name){
          return true;
    }

    function _sess_close(){
          unset($_SESSION);
          return true;
    }

    function _sess_read($id){
      return $this->session_storage->get($id);
    }

    //写入session
    function _sess_write($id, $sess_data){
		return $this->session_storage->set($id,$sess_data,$this->life_time);
    }

    //销毁session
    function _sess_destroy($id){
      return $this->session_storage->delete($id);
    }

    //清除过期session
    function _sess_gc($lifetime){
//      return $this->session_storage->_sess_gc($lifetime);
    }

    
}
