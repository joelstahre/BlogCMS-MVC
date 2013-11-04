<?php

namespace model;

class Password {

	private $encryptedPassword;

	public function __construct($password) {
		$this->encryptedPassword =  $this->encryptPassword($password);
		
	}

	private function encryptPassword($rawPassword) {
		return sha1($rawPassword);
	}

	public function getPassword() {
		return $this->encryptedPassword;
	}



}