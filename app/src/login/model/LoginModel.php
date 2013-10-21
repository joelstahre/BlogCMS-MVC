<?php

namespace model;

class LoginModel {

	private static $sessionSignedIn = "signed_in";
	private static $sessionUsername = "username";
	private static $sessionUserAgent = "user_agent";
	private static $serverUserAgent = "HTTP_USER_AGENT";


	/**
	 * @param  string $username
	 * @param  string $password
	 * @throws exception
	 * @todo Fix duplication
	 */
	public function doSignIn($username, $password) {

		if ($username == "Admin" && $password == sha1("Password")) {
			$this->signIn($username);
		} else {
			throw new \Exception("Felaktigt Användarnamn/lösenord.");
		}

	}

	/**
	 * @param  string $username
	 * @param  string $password
	 * @throws exception
	 */
	public function doSignInWithCookies($username, $password, $cookieExpTime) {

		if ($username == "Admin" && $password == sha1("Password") && time() <= $cookieExpTime ) {
			$this->signIn($username);
		} else {
			throw new \Exception("Felaktigt information i cookie.");
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

	/**
	 * @return boolian
	 */
	public function doSignOut() {

		if (isset($_SESSION['signed_in'])) {
			session_unset();
			return true;
		}
	}

}