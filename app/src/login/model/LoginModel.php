<?php

namespace model;

require_once("src/dal/UserDAL.php");

class LoginModel {

	private static $sessionSignedIn = "signed_in";
	private static $sessionUsername = "username";
	private static $sessionUserAgent = "user_agent";
	private static $serverUserAgent = "HTTP_USER_AGENT";

	private $userDAL;

	public function __construct(\mysqli $mysqli) {
		$this->userDAL = new \dal\UserDAL($mysqli);
	}


	/**
	 * @param  \model\ValidUserd
	 * @throws exception if the password dont match the username och the password is wrong.
	 */
	public function doSignIn(\model\ValidUser $validUserClient) {

		$username = $validUserClient->getUsername()->__toString();
		$password = $validUserClient->getPassword();
		$cookieExpire = $validUserClient->getCookieExpTime();

		$this->userDAL->updateExpireTime($username, $cookieExpire);

		$passwordDB = $this->userDAL->findUser($username);

		if($password == $passwordDB) {
			$this->signIn($username);
		} else {
			throw new \Exception("Felaktigt Användarnamn/lösenord.");
		}

	}


	public function doSignInWithCookies(\model\ValidUser $validUserClient) {

		$username = $validUserClient->getUsername()->__toString();
		$password = $validUserClient->getPassword();
		$cookieExpire = $this->userDAL->getCoockieExpire($username);

		$passwordDB = $this->userDAL->findUser($username);

		if (time() < $cookieExpire) {

			if($password == $passwordDB) {
				$this->signIn($username);
			} else {
				throw new \Exception("Felaktigt Användarnamn/lösenord.");
			}
		} else {
			throw new \Exception("Coockie has expired.");
		}

	}



	public function getCookieExpTime(\model\UserName $username) {
		return $this->userDAL->getCoockieExpire($username);
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


	public function doSignOut() {

		if (isset($_SESSION['signed_in'])) {
			session_unset();
			return true;
		}
	}
}