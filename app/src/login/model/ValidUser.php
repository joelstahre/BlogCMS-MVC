<?php

namespace model;

class ValidUser {

	/**
	* @var \model\UserName
	**/
	private $username;

	/**
	* @var \model\Password
	**/
	private $password;

	/**
	* @var \model\Email
	**/
	private $email;

	/**
	* @var string
	**/
	private $cookieExpire;

	public function __construct(UserName $username,
								 Password $password, $email,  $cookieExpire) {
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		$this->cookieExpire = $cookieExpire;
	}

	/**
	* @param \model\UserName
	* @param \model\Password
	* @param \model\Email
	* @return \model\ValidUser
	**/
	public static function createNew(\model\UserName $username, \model\Password $password, Email $email) {
		return new \model\ValidUser($username, $password, $email, "");
	}

	/**
	* @param \model\UserName
	* @param \model\Password
	* @return \model\ValidUser
	**/
	public static function createFromUserInput(\model\UserName $username, \model\Password $password) {
		return new \model\ValidUser($username, $password, "", "");
	}

	/**
	* @param \model\UserName
	* @param \model\Password
	* @param \model\string
	* @return \model\ValidUser
	**/
	public static function createWithCookie(\model\UserName $username, \model\Password $password, $cookieExpire) {
		return new \model\ValidUser($username, $password, "", $cookieExpire);
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

	public function getEmail() {
		return $this->email;
	}

	public function getCookieExpTime() {
		return $this->cookieExpire;
	}
}