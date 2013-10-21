<?php

namespace model;

require_once("src/dal/UserDAL.php");

class LoginModel {

	private static $sessionSignedIn = "signed_in";
	private static $sessionUsername = "username";
	private static $sessionUserAgent = "user_agent";
	private static $serverUserAgent = "HTTP_USER_AGENT";

	private $userDAL;

	public function __construct() {
		$this->userDAL = new \dal\UserDAL();
	}


	/**
	 * @param  \model\ValidUserd
	 * @throws exception if the password dont match the username och the password is wrong.
	 * @todo få tillbaka ett ValidUser objekt?
	 */
	public function doSignIn(\model\ValidUser $validUserClient) {

		$username = $validUserClient->getUsername()->__toString();
		$password = $validUserClient->getPassword();

		$passwordDB = $this->userDAL->findUser($username);


		if($password == $passwordDB) {
			$this->signIn($username);
		} else {
			throw new \Exception("Felaktigt Användarnamn/lösenord.");
		}

	}

	/**
	 * @param  string
	 */
	private function signIn($username) {
		$_SESSION[self::$sessionSignedIn] = true;
		$_SESSION[self::$sessionUsername] = $username;
		$_SESSION[self::$sessionUserAgent] = $_SERVER[self::$serverUserAgent];
	}

	/**
	 * @return boolean
	 */
	public function isSignedIn() {
		if (isset($_SESSION[self::$sessionSignedIn])) {
			if ($_SESSION[self::$sessionUserAgent] == $_SERVER[self::$serverUserAgent]) {
				return true;
			}
		}
	}

	/*
	public function doSignInWithCookies($username, $password, $cookieExpTime) {

		if ($username == "Admin" && $password == sha1("Password") && time() <= $cookieExpTime ) {
			$this->signIn($username);
		} else {
			throw new \Exception("Felaktigt information i cookie.");
		}
	}

	public function doSignOut() {

		if (isset($_SESSION['signed_in'])) {
			session_unset();
			return true;
		}
	}
	*/
}