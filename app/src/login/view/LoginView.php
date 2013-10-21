<?php

namespace view;

class LoginView {

	/**
	 * @var string
	 */
	private static $nameOfUser;

	/**
	 * @var string
	 */
	private static $userName = "username";

	/**
	 * @var string
	 */
	private static $password = "password";

	/**
	 * @var string
	 */
	private static $checkBox = "checkbox";

	/**
	 * @var string
	 */
	private static $submitButton = "submit";

	/**
	 * @var string
	 */
	private static $usernameHolder = "LoginView::UserName";

	/**
	 * @var string
	 */
	private static $passwordHolder = "LoginView::PassWord";

	/**
	 * @var string
	 */
	private $message = "";

	const signedOut = "Du är nu utloggad!";

	/**
	 * Constructor
	 */
	public function __construct() {
		self::$nameOfUser = $this->usernameForinputField();
	}


	/**
	 * @return string HTMLForm
	 * @codereview Längre en 80 tecken
	 */
	public function getFormHTML() {


		return "<div class='container-login' >

      		<form class='form-signin' method='post'>

		        <h2 class='form-signin-heading'>Please sign in</h2>

		        <input type='text' class='form-control' placeholder='Username' value='" . self::$nameOfUser . "' name='" . self::$userName . "' id='UserName'>

		        <input type='password' class='form-control' placeholder='Password' name='" . self::$password . "' id='PassWord'>
		        <label class='checkbox'>
          		<input type='checkbox' value='remember-me' name='" . self::$checkBox . "'> Remember me</label>
        		<button class='btn btn-lg btn-primary btn-block' type='submit' name='" . self::$submitButton . "'>Sign in</button>
      		</form>

    	</div>";




	}

	/**
	 * @return Bool
	 */
	public function wantsToSignIn() {
		return isset($_POST[self::$submitButton]);
	}


	/**
	 * @param String $msg
	 */
	public function setMessage($msg) {
		$this->message = $msg;
	}


	/**
	 * @return string
	 * @todo Fattig
	 */
	public function usernameForinputField() {
		if (isset($_POST[self::$userName])) {
			return $_POST[self::$userName];
		}
	}

	/**
	 * @return string
	 * @throws exception
	 */
	public function getUsername() {

		if (!empty($_POST[self::$userName])) {
			return $_POST[self::$userName];
		} else {
			throw new \Exception("Användarnamn saknas");
		}
	}

	/**
	 * @return string Password
	 * @throws exception
	 */
	public function getPassword() {

		if (!empty($_POST[self::$password])) {
			return sha1($_POST[self::$password]);
		} else {
			throw new \Exception("Lösenord saknas");
		}
	}


	/**
	 * @return boolian
	 */
	public function getCheckboxValue() {
		return isset($_POST[self::$checkBox]);
	}

	/**
	 * Sets coockies för username and password
	 * @todo Should cookies be set in the view?
	 */
	public function setCookies() {

		setcookie(self::$usernameHolder, $this->getUsername(), time() + 160);
		setcookie(self::$passwordHolder, $this->getPassword(), time() + 160);

		$cookieExpTime = time() + 160;

		file_put_contents("cookieExp.txt", $cookieExpTime);
	}

	/**
	 * Unsets coockies för username and password
	 * @todo fixa till hela grejen med att skriva till fil. Hade bråttom!:D
	 */
	public function unSetCookies() {

		setcookie(self::$usernameHolder, "", time() - 3600);
		setcookie(self::$passwordHolder, "", time() - 3600);
		file_put_contents("cookieExp.txt", "");
	}


	public function getCookieExpTime() {
		$cookieExpTime = file_get_contents("cookieExp.txt");
		return $cookieExpTime;
	}

	/**
	 * @return boolean
	 * @codereview Längre en 80 tecken
	 */
	public function hasSavedCookies() {
		return (isset($_COOKIE[self::$usernameHolder]) && isset($_COOKIE[self::$passwordHolder]));

	}


	/**
	 * @return string username
	 */
	public function getUsernameByCookie() {

		return $_COOKIE[self::$usernameHolder];
	}


	/**
	 * @return string Password
	 */
	public function getPasswordByCookie() {

		return $_COOKIE[self::$passwordHolder];
	}


}