<?php
namespace Core;
use PDO;
#require("/interface/IFactoryManager.php");
class DatabaseManager {

    #数据库主机IP或者实例名字
    private  $host = '127.0.0.1';

    #数据库 密码
    private  $password = 'root';

    #数据库 用户名
    private  $username = 'root';

    #数据库名
    private  $database;

    #数据库链接
    private  $connection;

    #数据库链接
    public  $error;


    public function setHost($host){
        $this->host = $host;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setDatabase($database){
        $this->database = $database;
    }
    
    /*
     * 链接一个数据库实例
     * 
     * */
    public  function connect(){
        $dsn = "mysql:host=$this->host;dbname=$this->database";
        try{
            if(!$this->connection){
                $this->connection = new PDO($dsn,$this->username,$this->password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            return true;
        }catch(PDOException $e){
            $this->error = 'Caught exception: '.$e->getMessage();
            return false;
        }
    }
    
    function getList($cols,$filter=array(),$tableName,$join=array(),$orderby=1,$limit=-1,$page=1){
        $this->connect();
        $page = $page>0?($page-1):0;
        $this->_select($cols,$tableName)->join($join)->_where($filter)->_orderby($orderby)->_limit($limit,$limit*$page);

        $statement = $this->connection->prepare($this->cur_sql);
        
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function _select($cols,$tableName){
        $this->cur_sql = 'select '.$cols.' from '.$tableName;
        return $this;
    }

    function _where($filter){
        $where_arr = array(' where 1=1 ');
       
        foreach((array)$filter as $k=>$v){
            $sp = explode('|',$k);
			
            if(is_array($v)){
                $where_arr[] = $k.$this->_parseFilter('in',$v);
            }elseif(empty($sp[1])){
                $where_arr[] = $k.$this->_parseFilter('equal',$v);
            }else{
                $where_arr[] = $sp[0].$this->_parseFilter($sp[1],$v);
            }
        }

        $this->cur_sql .= implode($where_arr,' AND ');
		
        return $this;
    }

    function _orderby($orderby){
        $this->cur_sql .= ' order by '.$orderby;
        return $this;
    }

    function _limit($limit,$page){
         if($limit != -1){
            $this->cur_sql .= " limit $page,$limit";
         }else{
            $this->cur_sql .= "";
         }
        return $this;
    }

    function _parseFilter($type,$var){
        if(!is_array($var)){
            $filter_array= array('than'=>' > '.$var,
                                'lthan'=>' < '.$var,
                                'equal'=>' = \''.$var.'\'',
                                'noequal'=>' <> \''.$var.'\'',
                                'tequal'=>' = \''.$var.'\'',
                                'sthan'=>' <= '.$var,
                                'bthan'=>' >= '.$var,
                                'has'=>' like \'%'.$var.'%\'',
                                'like'=>' like \'%'.$var.'%\'',
                                'head'=>' like \''.$var.'%\'',
                                'foot'=>' like \'%'.$var.'\'',
                                'nohas'=>' not like \'%'.$var.'%\'',
                                );
        }else{
            $t_var = $var;
            $filter_array= array(
                                'between'=>' {field}>='.array_shift($t_var).' and '.' {field}<='.array_shift($t_var),
                                'in' =>" in ('".implode("','",$var)."') ",
                                'notin' =>" not in ('".implode("','",$var)."') ",
                                );
        }

        return $filter_array[$type];
    }

    function join($join){
        if(empty($join)) return $this;
        $tsql = ' ';
        if(is_array($join)){
            foreach($join as $k=>$v){
                $temp = explode('@',$v);
                $tableName = $temp[0];
                $foreignCol = $temp[0].'.'.$temp[1];
                $t.=' left join '.$tableName.' on '.$this->tableName.'.'.$k.'='.$foreignCol.' ';
            }
        }
        $this->cur_sql .= $t;
        return $this;
    }
}
