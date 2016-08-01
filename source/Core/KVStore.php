<?php
namespace Core;
use Memcache;

class KVStore{

    private $kvObject;

    function __construct(){
        $this->kvObject = new memcache();
        $bool = $this->kvObject->addServer('127.0.0.1',11211);
//        $aa= $this->set('a','a123123');
//        $bb = $this->get('a');
    }

    function start(){
        return $this->kvObject->connect('127.0.0.1',11211);
    }

    function setKvObject($obj){
        $this->kvObject = $obj;
    }

    function set($key,$value,$expire=86400){
        return $this->kvObject->set($key,$value);
    }

    function get($key){
        
        return $this->kvObject->get($key);
    }

    function delete($key){
        return $this->kvObject->delete($key);
    }

    function flush(){
        $this->kvObject->flush();
    }



}
