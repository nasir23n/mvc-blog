<?php


namespace System\Core;

class DB {
    protected static $onlyInstance;
    public $conn;
    public function __construct() {
        $servername = 'localhost';
        $username = 'root';
        $database = 'mvc';
        $password = '';
        $dsn = 'mysql:host='.$servername.';dbname='.$database;
        try {
            $this->conn = new \PDO($dsn, $username, $password);
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            // $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function query($query=null){
        static $result;
        if ($query != null) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([]);
            $result = $stmt->fetchAll();
        }
        return $result;
    }
    public function insert($table, $fill) {
        $column = '';
        $values = '';

        foreach ($fill as $key => $value) {
            $column .= '`'.$key.'`,';
            $values .= "'".$value."',";
        }
        $column = rtrim($column, ',');
        $values = rtrim($values, ',');

        $sql = "INSERT INTO $table ($column) VALUES ($values)";
        
        $stmt = $this->conn->prepare($sql);
        
        ($stmt->execute()) ? (true) : (false);
    }
    public function get_where($table=null,$condition=array()) {
        // store for output  
        static $result;
        
        // input variables 
        $table_name = $table;
        $cond = $this->make_cond($condition);

        // query section 
        $sql = 'SELECT * FROM '.$table_name.' WHERE '.$cond;

        // execute & make output
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();

        // return section 
        return $result;
    }

    public function select($select='*', $from=NULL, $where=NULL,$limit=NULL) {

        if (is_string($select)) {
            $select = trim($select);
        }

        if ($from == NULL) {
            return false;
        } else {
            $sql = "SELECT $select FROM $from";
        }

        if ($where != NULL) {
            $cond = $this->make_cond($where);
            $sql = "SELECT $select FROM $from WHERE $cond";
        }

        if ($limit != NULL) {
            $sql = "SELECT $select FROM $from WHERE $cond LIMIT $limit";
        }

        // SELECT * FROM Customers WHERE Country='UK' ORDER BY Country DESC;

        // print_r($sql);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }
    public function update($table, array $set, $where) {
        $set_val = $this->_set($set);

        $set_where = $this->make_cond($where);
        $sql = "UPDATE `$table` SET $set_val WHERE $set_where";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        
    }
    public function delete($table, $where) {

        $set_where = $this->make_cond($where);
        $sql = "DELETE FROM `$table` WHERE $set_where;";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        
    }
    private function make_cond($arg=null) {
		$op = array();
		if ($arg!=null) {
			foreach ($arg as $key => $value) {
				$op[] = $key."='".$value."' AND ";
			}
		}
		
		$op = implode(' ', $op);
		$op = trim(substr($op, 0, strlen($op)-4));
		// print_r($op);
		return $op;
	}
    private function _set($arr) {
		$final = null;
		foreach ($arr as $key => $value) {
			$final .= "`".$key."`"."='".$value."',";
		}
		$final = rtrim($final, ',');
		return $final;
	}
    public static function init() {
        if (static::$onlyInstance === null) {
            static::$onlyInstance = new DB;
        }
        return static::$onlyInstance;
    }
}
