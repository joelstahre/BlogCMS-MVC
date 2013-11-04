<?php

namespace model;

require_once("src/dal/UserDAL.php");

class RegisterModel {

	private $userDAL;

	public function __construct(\mysqli $mysqli) {
		$this->userDAL = new \dal\UserDAL($mysqli);
	}

	public function registerUser(\model\ValidUser $validUser) {
		$this->userDAL->insertUser($validUser);
	}
}