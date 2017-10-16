<?php
abstract class Entity {

	public static function get($id){
		$db = Connect::getInstance();
		$tableName = static::$tableName;
		$keyColumn = static::$keyColumn;
		$className = get_called_class();
		$res = $db->query("SELECT * FROM {$tableName} WHERE {$keyColumn} =" . $id);
		$res = $res->fetchObject($className);
		return $res;
	}

	public static function getAll($id){
		$db = Connect::getInstance();
		$tableName = static::$tableName;
		$keyColumn = static::$keyColumn;
		$className = get_called_class();
		$res = $db->query("SELECT * FROM {$tableName} WHERE {$keyColumn} =" . $id);
		$arr = array();
		while($r = $res->fetchObject($className)){
			$arr[] = $r;
		}
		return $arr;
	}

	
	public static function all(){
		$db = Connect::getInstance();
		$tableName = static::$tableName;
		$className = get_called_class();
		$res = $db->query("SELECT * FROM {$tableName}");
		$arr = array();
		while($r = $res->fetchObject($className)){
			$arr[] = $r;
		}
		return $arr;
	}
	
	public static function get_all(){
		$tableName = static::$tableName;
		$className = get_called_class();
		$db = Connect::getInstance();
		$res = $db->query("SELECT * FROM {$tableName}");
		$arr = array();
		while($r = $res->fetchObject($className)){
			$arr[] = $r;
		}
		return $arr;
	}
	
	
	public static function remove($id){
		$db = Connect::getInstance();
		$className = get_called_class();
		$tableName = static::$tableName;
		$keyColumn = static::$keyColumn;
		$res = $db->prepare("DELETE FROM {$tableName} WHERE {$keyColumn}=?");
		$res->bindValue(1, $id);
		$res->execute();
	}

	public static function notUnique($column,$param){
		$db = Connect::getInstance();
		$className = get_called_class();
		$tableName = static::$tableName;
		$query = $db->prepare("SELECT * FROM {$tableName} WHERE {$column}=?");
    	$query->bindValue(1, $param);
    	$query->execute();
    	
    	if($query->rowCount() > 0){
       		return true;
    	}else{
        	return false;
    	}
	}

	public function insert(){
		$db = Connect::getInstance();
		$tableName = static::$tableName;
		$greska = static::$greska;
		$q = "INSERT INTO {$tableName} (";
		$columns = array();
		$values = array();
		foreach($this as $key=>$value){
			$columns[] = $key;
			$values[] = $value;
		}
		foreach($columns as $c){
			$q .= "`" . $c . "`, ";
		}
		$q = trim($q, ', ');
		$q .= ") VALUES (";
		foreach($values as $v){
			$q .= "?, ";
		}
		$q = trim($q, ', ');
		$q .= ')';
		$stmt = $db->prepare($q);
		$n = 1;
		foreach($values as $value){
			$stmt->bindValue($n, $value);
			$n++;
		}
		$stmt->execute();
		if($stmt->rowCount() != 1){
			echo $greska;
		}
	}
	
	public function update(){
		$db = Connect::getInstance();
		$tableName = static::$tableName;
		$keyColumn = static::$keyColumn;
		$q = "UPDATE {$tableName} SET ";
		$values = array();
		foreach($this as $key=>$value){
			if($key == $keyColumn) continue;
			$values[] = $value;
			$q .= "{$key} = ?, ";
		}
		$q = trim($q, ', ');
		$q .= " WHERE {$keyColumn} = ?";
		$stmt = $db->prepare($q);
		$n = 1;
		foreach($values as $value){
			$stmt->bindValue($n, $value);
			$n++;
		}
		$stmt->bindValue($n, $this->$keyColumn);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			return 'Uspesno editovanje u bazi.';
		}else{
			return 'Neuspesno editovanje u bazi.';
		}
	}
	
}