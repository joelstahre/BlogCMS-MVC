<?php

namespace controller;

require_once("src/login/view/LoginView.php");
require_once("src/login/model/LoginModel.php");
require_once("src/login/model/UserName.php");
require_once("src/login/model/Password.php");
require_once("src/login/model/ValidUser.php");
require_once("src/admin/controller/AdminController.php");

class LoginController {

	private $loginView;

	private $loginModel;

	public function __construct(\mysqli $mysqli) {
		$this->loginView = new \view\LoginView();
		$this->loginModel = new \model\LoginModel($mysqli);
		$this->adminController = new \controller\AdminController($this, $mysqli);
	}


	public function doLoginControll() {


		//If the user already is SignedIn
		if ($this->loginModel->isSignedIn()) {
			return $this->adminController->runAdmin();
		}

		//If the use has saved cookies
		if ($this->loginView->hasSavedCookies()) {
			return $this->signInWithCookies();
		}

		//If the user wants to SignIn
		if ($this->loginView->wantsToSignIn()) {

			return $this->wantsToSignIn();
		}

		//Display the login Form
		return $this->loginView->getFormHTML();
	}


	public function wantsToSignIn() {

		try {

			$username = new \model\UserName($this->loginView->getUsername());
			$password = new \model\Password($this->loginView->getPassword());

			//IF keep me signedin is checked
			if ($this->loginView->rememberMe()) {
				$cookieExpire = $this->loginView->setCookies();

				$validUser = \model\ValidUser::createWithCookie($username, $password, $cookieExpire);
				$this->loginModel->doSignIn($validUser);

			} else {
				$validUser = \model\ValidUser::createFromUserInput($username, $password);
				$this->loginModel->doSignIn($validUser);
			}

		} catch (\Exception $e) {
			$this->loginView->loginFaild();
			//debug echo $e->getMessage();
			return $this->loginView->getFormHTML();;
		}

		return $this->adminController->runAdmin();
	}


	public function signInWithCookies() {

		try {

			$username = new \model\UserName($this->loginView->getUsernameByCookie());
			$password = new \model\Password($this->loginView->getPasswordByCookie());

			$validUser = \model\ValidUser::createFromUserInput($username, $password);

			$this->loginModel->doSignInWithCookies($validUser);

		} catch (\Exception $e) {

			$this->loginView->unSetCookies();
			$this->loginView->loginFaild();
			// echo $e->getMessage();//debug
			return $this->loginView->getFormHTML();
		}

		return $this->adminController->runAdmin();
	}


	public function wantsToSignOut() {
		// echo "Utloggad";//debug
		if($this->loginModel->doSignOut()) {

			$this->loginView->unSetCookies();
			$this->loginView->logOutMessage();
			return $this->loginView->getFormHTML();
		}
	}

}