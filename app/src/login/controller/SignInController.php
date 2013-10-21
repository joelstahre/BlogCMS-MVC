<?php

namespace controller;
require_once("src/model/SignInModel.php");


class SignInController {

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var \View\SignInPage
	 */
	private $signInView;

	/**
	 * @var \View\AdminPage
	 */
	private $adminView;

	/**
	 * @var \Model\SignInModel
	 */
	private $signInModel;


	/**
	 * Constructor
	 * @param \view\SignInPage   $signInView
	 * @param \view\AdminPage    $adminView
	 */
	public function __construct(\view\SignInPage 	$signInView,
								\view\AdminPage 	$adminView) {

		$this->signInView 	= $signInView;
		$this->adminView 	= $adminView;
		$this->signInModel 	= new \model\SignInModel();

	}

	/**
	 * @return String
	 * @todo Should this controller set the cookies?
	 * @todo duplication
	 */
	public function wantsToSignIn() {

		try {

			$this->username = $this->signInView->getUsername();
			$this->password = $this->signInView->getPassword();

			//IF keep me signedin is checked
			if ($this->signInView->getCheckboxValue()) {
				$this->signInView->setCookies();
				$this->adminView->setMessage(\view\AdminPage::rememberMeMessage);
			} else {
				$this->adminView->setMessage(\view\AdminPage::signedInSuccsess);
			}

			$this->signInModel->doSignIn($this->username, $this->password);


		} catch (\Exception $e) {

			$this->signInView->setMessage($e->getMessage());
			return $this->signInView->getFormHTML();
		}

		return $this->adminView->getPage();
	}


	/**
	 * @return string
	 * @todo enligt usercase så ska kakorna försvinna när man försökt att manipulera dem, kör unSetCookie i catch?
	 */
	public function signInWithCookies() {

		try {

			$this->username = $this->signInView->getUsernameByCookie();
			$this->password = $this->signInView->getPasswordByCookie();
			$cookieExpTime = $this->signInView->getCookieExpTime();
			$this->adminView->setMessage(\view\AdminPage::signedInSuccsessCookie);

			$this->signInModel->doSignInWithCookies($this->username, $this->password, $cookieExpTime);

		} catch (\Exception $e) {
			$this->signInView->setMessage($e->getMessage());
			$this->signInView->unSetCookies();

			return $this->signInView->getFormHTML();
		}

		return $this->adminView->getPage();
	}


	public function wantsToSignOut() {
		if($this->signInModel->doSignOut()) {

			$this->signInView->unSetCookies();

			$this->signInView->setMessage(\view\SignInPage::signedOut);
			return $this->signInView->getFormHTML();
		}
		return $this->signInView->getFormHTML();
	}

}