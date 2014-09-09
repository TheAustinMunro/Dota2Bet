<?php
class DBObject {
	public function delete ($dbh) {
		$sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$primary . " = ? LIMIT 1";
		$query = $dbh->connection->prepare($sql);
		$query->execute(array($this->{static::$primary}));
	}
	public function save ($dbh) {
		$keys = array_keys(static::$fields);
		$lastKey = end($keys);
		$parameterArray = array();
		$sql  = "INSERT INTO " . static::$tableName . " ( ";
		foreach (static::$fields as $field=>$type) {
			$sql .= $lastKey === $field ? $field : $field . " , ";
		}
		$sql .= " ) VALUES ( ";
		foreach (static::$fields as $field=>$type) {
			$sql .= $lastKey === $field ? "?" : "?,";
			array_push($parameterArray, $this->$field);
		}
		$sql .= " ) ON DUPLICATE KEY UPDATE ";
		foreach (static::$fields as $field=>$type) {
			$sql .= static::$primary !== $field ? $lastKey === $field ? $field."=?" : $field."=?," : "";
			if (static::$primary !== $field) { array_push($parameterArray, $this->$field); }
		}
		$query = $dbh->connection->prepare($sql);
		$query->execute($parameterArray);
	}
	public static function count($dbh) {
		$sql = "SELECT COUNT(*) Count FROM " . static::$tableName;
		$query = $dbh->connection->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		return empty($results) ? NULL : $results{0}['Count'];
	}
	public static function selectAll ($dbh,$order = "") {
		$class = get_called_class();
		$class = new $class;
		$order = empty($order) ? static::$primary . " ASC " : $order;
		$array = array();
		$sql = "SELECT * FROM " . static::$tableName . " ORDER BY ?";
		$query = $dbh->connection->prepare($sql);
		$query->execute(array($order));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach($results as $result) { array_push($array, self::instantiate($result, $class)); }
		return $array;
	}
	public static function selectByPrimary($dbh,$value=1) {
		$class = get_called_class();
		$class = new $class;
		$array = array();
		$sql = "SELECT * FROM " . static::$tableName . " WHERE " . static::$primary . " = ? LIMIT 1";
		$query = $dbh->connection->prepare($sql);
		$query->execute(array($value));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach($results as $result) { array_push($array, self::instantiate($result, $class)); }
		return $array;

	}
	public static function staticQuery ($sql="", $paramaters="", $dbh="") {
		if (!isset($sql) || empty($sql)) { return null; }
		$x = 0; $array = array();
		$query = $dbh->connection->prepare($sql);
		empty($paramaters) ? $query->execute() : $query->execute($paramaters);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach($results as $result) { $array[$x] = (object)$result; $x++; }
		return empty($array) ? NULL : $array;
	}
	public static function instantiate($recordParam, $className) {
		$object = new $className;
		$objectVars = get_object_vars($object);
		if(isset($object->connection)){unset($object->connection);}
		foreach($recordParam as $attribute=>$value){
			if(array_key_exists($attribute,$objectVars)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}
}