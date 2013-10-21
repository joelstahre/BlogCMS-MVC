<?php

namespace model;

class UserName {

	private $username;

	public function __construct($username) {
		if ($this->usernameIsOK($username)) {
			$this->username = $username;
		} else {
			throw new \Exception("UserName::__construct : Bad username");
		}
	}

	public function usernameIsOK($username) {
		return true;
	}

	public function __toString() {
		return urlencode($this->username);
	}

}