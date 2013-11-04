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
		if ($username != strip_tags($username)) {
			return false;
		}
		if (strlen($username) < 3) {
			return false;
		}
		if (strlen($username) > 25) {
			return false;
		}
		return true;
	}

	public function __toString() {
		return urlencode($this->username);
	}

}