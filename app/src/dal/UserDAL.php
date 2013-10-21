<?php

namespace dal;

class UserDAL {

	public function __construct() {
		$this->mysqli = new \mysqli("127.0.0.1", "root", "", "blog");
		if ($this->mysqli->connect_errno) {
    		echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}
	}

	public function findUser($username) {
		$sql = "SELECT
                    password
				FROM
					user
				WHERE
					username = '$username'";

		$statement = $this->mysqli->prepare($sql);

        if ($statement === FALSE) {
            throw new \Exception("prepare of $sql failed " . $this->mysqli->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.execute.php
        if ($statement->execute() === FALSE) {
            throw new \Exception("execute of $sql failed " . $statement->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.get-result.php
        $result = $statement->get_result();

        $object = $result->fetch_array(MYSQLI_ASSOC);

        return $object['password'];
	}


}