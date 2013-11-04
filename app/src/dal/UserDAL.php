<?php

namespace dal;

class UserDAL {

    private $mysqli;

	public function __construct(\mysqli $mysqli) {
		$this->mysqli = $mysqli;
	}

	public function findUser($username) {
		$sql = "SELECT
                    password
				FROM
					user
				WHERE
					username = '$username'";

		$statement = $this->prepare($sql);

        $this->execute($statement);

        $result = $statement->get_result();

        $object = $result->fetch_array(MYSQLI_ASSOC);

        return $object['password'];
	}


	public function updateExpireTime($username, $cookieExpire) {
		$sql = "UPDATE user
				SET cookieexptime = ?
				WHERE username = ?";

		$statement = $this->prepare($sql);

        if ($statement->bind_param("ss", $cookieExpire, $username) === FALSE) {
            throw new \Exception("UserDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);

	}


	public function getCoockieExpire($username) {
		$sql = "SELECT
                    cookieexptime
				FROM
					user
				WHERE
					username = '$username'";

		$statement = $this->prepare($sql);

        $this->execute($statement);

        $result = $statement->get_result();

        $object = $result->fetch_array(MYSQLI_ASSOC);

        return $object['cookieexptime'];
	}

    public function insertUser(\model\ValidUser $validUser) {
        $username = $validUser->getUserName();
        $password = $validUser->getPassword();
        $email = $validUser->getEmail();

        $sql = "INSERT INTO user
            (
                username,
                password,
                email
            )
            VALUES(?, ?, ?)";


        $statement = $this->prepare($sql);

        if ($statement->bind_param("sss", $username, $password, $email) === FALSE) {
            throw new \Exception("InstallDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
    }


    private function prepare($sql) {
        $statement = $this->mysqli->prepare($sql);
        if ($statement === FALSE) {
            throw new \Exception("UserDAL:: prepare of $sql failed " . $this->mysqli->error);
        }
        return $statement;
    }

    private function execute($statement) {
        if ($statement->execute() === FALSE) {
            throw new \Exception("UserDAL:: execute of $sql failed " . $statement->error);
        }
    }


}