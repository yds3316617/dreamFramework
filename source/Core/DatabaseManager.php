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
    private  $database = 'dreamFrameworkGithub';

    #数据库链接
    private  static $connection;

    #错误信息 string
    public  $error;
	
	#列信息
    public  $columns;


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
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8";
        try{
            if(!self::$connection){
                error_log(var_export(1,1),3,'E:/1.txt');
                self::$connection = new PDO($dsn,$this->username,$this->password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            return true;
        }catch(PDOException $e){
            $this->error = 'Caught exception: '.$e->getMessage();
            return false;
        }
    }

    function beginTransaction(){
        $this->connect();
        self::$connection->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
        self::$connection->beginTransaction();
    }

    function commit(){
        self::$connection->commit();
    }

    function rollBack(){
        self::$connection->rollBack();
    }
    
    function getList($cols,$filter=array(),$tableName=null,$limit=-1,$page=1,$orderby=1,$join=array()){
        $this->connect();
		if(empty($tableName)){
            $tableName = $this->tableName;
        }
        $page = $page>0?($page-1):0;
        $this->_select($cols,$tableName)->join($join)->_where($filter)->_orderby($orderby)->_limit($limit,$limit*$page);
//error_log(var_export($this->cur_sql,1),3,'E:/1.txt');
        $statement = self::$connection->prepare($this->cur_sql);
        
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


    function add($data){
        if($link = $this->connect()){
            $this->cur_sql = $sql = $this->getInsertSql($data);
//error_log(var_export($sql,1),3,'E:/1.txt');
            $resouce = self::$connection->exec($sql);

            $id = self::$connection->lastInsertId();//双主键此处返回值为0

            return $id;
        }else{
            
            //...报异常
        }
    }

    function update($filter,$data){
        if($link = $this->connect()){
            $sql = $this->getUpdateSql($filter,$data);
//error_log(var_export($sql),3,'E:/1.txt');
            $resouce = self::$connection->exec($sql);
            if($resouce === false) return false;

            return true;
        }else{
            
            //...报异常
        }
    }


    function getInsertSql($data){
        array_filter($data);
        array_walk($data,array($this,'sqlFilter'));
        $keys = implode(',',array_keys($data));
        $values = implode(',',array_values($data));
        $sql = 'insert into '.$this->tableName.'('.$keys.')'.'values '.'('.$values.')';

        return $sql;
    }

    function sqlFilter(&$item,&$key){
        $item = '"'.$item.'"';
    }

    function _update($data){
        $arr_up = array();
        foreach($data as $k=>$v){
            if(!is_array($v)){
                $arr_up[]= "$k='$v'";
            }
        }

        $str_up = implode(',',$arr_up);
        $this->cur_sql = 'update '.$this->tableName.' set '.$str_up;
        
        return $this;
    }

    function getUpdateSql($filter,$data){
       $this->_update($data)->_where($filter);
       $sql = $this->cur_sql;

       return $sql;
    }

	function _delete(){
		$this->cur_sql = 'delete from '.$this->tableName.' ';
		return $this;
	}

    function delete($filter){
        $this->connect();
		$this->_delete()->_where($filter);

        $rs = self::$connection->exec($this->cur_sql);
        if($rs === false){
            return false;
        }
        return true;
    }
	
	//获取列信息
	function getColumns($tableName){
		return require(ROOT_DIR.'Core/Dbschema/'.$tableName.'.php');
	}

	function count($filter){
        $this->cur_sql = 'select count(*) as total from '.$this->tableName;
        $this->_where($filter);
        $this->connect();
        
//print_r($this->cur_sql);exit;
        $statement = self::$connection->prepare($this->cur_sql);
        
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
		
		
		return $result['total'];
//		print_r($this->cur_sql);exit;

    }


}
