<?php
# Database Wrapper, Supporting MySQL and Sqlite
# Check config.php for database configuration
# Usage:
#   $db = new db();
#
#   // table, data
#   $db->create('users', array(
#     'fname' => 'john',
#     'lname' => 'doe'
#   ));
#   
#   // table, where, where-bind
#   $db->read('users', "fname LIKE :search", array(
#     ':search' => 'j%'
#   ));
#
#	// table, data, where, where-bind
#   $db->update('users', array(
#     'fname' => 'jame'
#   ), 'gender = :gender', array(
#     ':gender' => 'female'
#   ));
#   
#   // table, where, where-bind
#   $db->delete('users', 'lname = :lname', array(
#     ':lname' => 'doe'
#   ));

class db
{
	function db() {
		global $config;
		$dbuser = $config['dbuser'];
		$dbpass = $config['dbpass'];

		$options = array(
			PDO::ATTR_PERSISTENT => true, 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		try {
			switch($config["dbdriver"]) {
				case "sqlite":
					$conn = "sqlite:{$config['root']}/{$config['db']}";
					break;
				case "mysql":
					$conn = "mysql:host={$config['dbhost']};dbname={$config['dbname']}";
					break;
				default:
					echo "Unsuportted DB Driver! Check the configuration.";
					exit(1);
			}

			$this->db = new PDO($conn, $dbuser, $dbpass, $options);
			
		} catch(PDOException $e) {
			echo $e->getMessage(); exit(1);
		}
	}

	function run($sql, $bind=array()) {
		$sql = trim($sql);
		
		try {

			$result = $this->db->prepare($sql);
			$result->execute($bind);
			return $result;

		} catch (PDOException $e) {
			echo $e->getMessage(); exit(1);
		}
	}

	function create($table, $data) {
		$fields = $this->filter($table, $data);

		$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";

		$bind = array();
		foreach($fields as $field)
			$bind[":$field"] = $data[$field];

		$result = $this->run($sql, $bind);
		return $this->db->lastInsertId();
	}

	function read($table, $where="", $bind=array(), $fields="*") {
		$sql = "SELECT " . $fields . " FROM " . $table;
		if(!empty($where))
			$sql .= " WHERE " . $where;
		$sql .= ";";

		$result = $this->run($sql, $bind);
		$result->setFetchMode(PDO::FETCH_ASSOC);

		$rows = array();
		while($row = $result->fetch()) {
			$rows[] = $row;
		}

		return $rows;
	}

	function update($table, $data, $where, $bind=array()) {
		$fields = $this->filter($table, $data);
		$fieldSize = sizeof($fields);

		$sql = "UPDATE " . $table . " SET ";
		for($f = 0; $f < $fieldSize; ++$f) {
			if($f > 0)
				$sql .= ", ";
			$sql .= $fields[$f] . " = :update_" . $fields[$f]; 
		}
		$sql .= " WHERE " . $where . ";";

		foreach($fields as $field)
			$bind[":update_$field"] = $data[$field];
		
		$result = $this->run($sql, $bind);
		return $result->rowCount();
	}

	function delete($table, $where, $bind="") {
		$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
		$result = $this->run($sql, $bind);
		return $result->rowCount();
	}

	private function filter($table, $data) {
		global $config;
		$driver = $config['dbdriver'];

		if($driver == 'sqlite') {
			$sql = "PRAGMA table_info('" . $table . "');";
			$key = "name";
		} elseif($driver == 'mysql') {
			$sql = "DESCRIBE " . $table . ";";
			$key = "Field";
		} else {	
			$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
			$key = "column_name";
		}	

		if(false !== ($list = $this->run($sql))) {
			$fields = array();
			foreach($list as $record)
				$fields[] = $record[$key];
			return array_values(array_intersect($fields, array_keys($data)));
		}

		return array();
	}
}
