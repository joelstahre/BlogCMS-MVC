<?php

namespace controller;

require_once("src/login/view/LoginView.php");
require_once("src/login/model/LoginModel.php");
require_once("src/admin/controller/AdminController.php");

class LoginController {

	private $loginView;

	private $loginModel;

	private $navigation;

	public function __construct() {
		$this->loginView = new \view\LoginView();
		$this->loginModel = new \model\LoginModel();
		$this->adminController = new \controller\AdminController();
	}


	public function doLoginControll() {

		//If the user wants to SignIn
		if ($this->loginView->wantsToSignIn()) {

			return $this->wantsToSignIn();
		}

		/*
		//If the use has saved cookies
		if ($this->signInView->hasSavedCookies() && !$this->signInModel->isSignedIn()) {
			return $this->signInController->SignInWithCookies();
		}

		//If the user wants to SignOut
		if ($this->adminView->wantsToSignOut()) {
			return $this->signInController->wantsToSignOut();
		}
		*/

		//If the user already is SignedIn
		if ($this->loginModel->isSignedIn()) {
			return $this->adminController->runAdmin();
		}

		//Display the login Form
		return $this->loginView->getFormHTML();
	}


	public function wantsToSignIn() {

		try {

			$this->username = $this->loginView->getUsername();
			$this->password = $this->loginView->getPassword();


			$this->loginModel->doSignIn($this->username, $this->password);


		} catch (\Exception $e) {
			return "fel, hamnade i catch";
		}

		return $this->adminController->runAdmin();
	}

}