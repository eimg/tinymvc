<?php
# Database Wrapper
# Supporting MySQL and Sqlite
# Check config.php for database configuration

class Database
{
	function Database() {
		global $config;

		try {

			switch($config["dbdriver"]) {
				case "sqlite":
					$this->db = new PDO("sqlite:{$config['root']}/{$config['db']}");
					break;
				case "mysql":
					$this->db = new PDO("mysql:host={$config['dbhost']};dbname={$config['dbname']}", $config['dbuser'], $config['dbpass']);
					break;
				default:
					echo "Unsuportted DB Driver! Check the configuration.";
					exit(1);
			}
			
		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}

	function get_query($sql) {
		try {
			$result = $this->db->prepare($sql);
			$result->execute();

			$result->setFetchMode(PDO::FETCH_ASSOC);

			$rows = array();
			while($row = $result->fetch()) {
				$rows[] = $row;
			}

			return $rows;

		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}

	function set_query($sql) {
		try {
			$result = $this->db->prepare($sql);
			$result->execute();

			if($this->db->lastInsertId()) {
				return $this->db->lastInsertId();
			} else {
				return $result->rowCount();
			}

		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}
}
