<?php

namespace model;

class ValidUser {

	private $username;
	private $password;

	public function __construct(\model\UserName $username, \model\Password $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function getUsername() {
		return $this->username;
	}

	/**
	 * @return string
	 * @todo fix this shit?
	 */
	public function getPassword() {
		return $this->password->getPassword();
	}
}