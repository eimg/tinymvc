<?php
# Sqlite DB Wrapper
class Database
{
	function Database() {
		global $config;

		try {
			$this->db = new PDO("sqlite:{$config['root']}/{$config['db']}");
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
