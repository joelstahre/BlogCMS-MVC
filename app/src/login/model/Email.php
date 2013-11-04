<?php

namespace model;

class Email {

	private $email;

	public function __construct($email) {
		if ($this->emailIsOK($email)) {
			$this->email = $email;
		} else {
			throw new \Exception("UserName::__construct : Bad email");
		}
	}

	public function emailIsOK($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return false;
		}
		return true;
	}

	public function __toString() {
		return urlencode($this->email);
	}

}