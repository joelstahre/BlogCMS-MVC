<?php

namespace dal;

class ConfigDAL {

	public function __construct(\mysqli $mysqli) {
		$this->mysqli = $mysqli;
		if ($this->mysqli->connect_errno) {
    		echo "ConfigDAL:: Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}
	}

	public function loadSettings() {
		$settingsArray = array();

		$sql = "SELECT
					_index,
					_value
				FROM
					settings";

		$statement = $this->prepare($sql);

        $this->execute($statement);

        $result = $statement->get_result();

        while ($object = $result->fetch_array(MYSQLI_ASSOC)) {
        	$settingsArray[$object["_index"]] = $object["_value"];
        }

         $settingsArray;

         foreach ($settingsArray as $key => $value) {
         	\common\Config::set($key, $value);
         }
	}


    public function write($key, $value) {

        $sql = "UPDATE settings
                SET _value = ?
                WHERE
                    _index = ?";

        $statement = $this->prepare($sql);

        if ($statement->bind_param("ss", $value, $key) === FALSE) {
            throw new \Exception("ConfigDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
    }






	private function prepare($sql) {
        $statement = $this->mysqli->prepare($sql);
        if ($statement === FALSE) {
            throw new \Exception("ConfigDAL:: prepare of $sql failed " . $this->mysqli->error);
        }
        return $statement;
    }

    private function execute($statement) {
        if ($statement->execute() === FALSE) {
            throw new \Exception("ConfigDAL:: execute of $sql failed " . $statement->error);
        }
    }


}