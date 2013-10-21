<?php

namespace model;

class Password {

	private $encryptedPassword;

	public function __construct($password) {
		if ($this->passwordIsOK($password)) {
			$this->encryptedPassword =  $this->encryptPassword($password);
		} else {
			throw new \Exception("Password::__construct : Bad password");
		}
	}

	public function passwordIsOK($username) {
		return true;
	}


	private function encryptPassword($rawPassword) {
		return sha1($rawPassword);
	}

	public function getPassword() {
		return $this->encryptedPassword;
	}



}