<?php

namespace controller;
require_once("install/InstallView.php");
require_once("install/InstallModel.php");

require_once("src/login/model/RegisterModel.php");
require_once("src/login/model/UserName.php");
require_once("src/login/model/Password.php");
require_once("src/login/model/Email.php");
require_once("src/login/model/ValidUser.php");

class InstallController {

	private $installView;

	public function __construct(\mysqli $mysqli) {
		$this->installView = new \view\installView();
		$this->installModel = new \model\InstallModel($mysqli);
		$this->registerModel = new \model\RegisterModel($mysqli);
	}

	public function runInstall() {

		if ($this->installView->install()) {

			try {

				$username = new \model\UserName($this->installView->getUsername());
				$password = new \model\Password($this->installView->getPassword());
				$email = new \model\Email($this->installView->getEmail());

				
				$this->installModel->createTables();

				$this->installModel->insertDeafaultSetting();

				$validUser = \model\ValidUser::createNew($username, $password, $email);

				$this->registerModel->registerUser($validUser);
				
				$this->installModel->createSampleData();
				
				$pathToApp = $this->installModel->getAppPath();

			}catch(\Exception $e) {
				$this->installView->registerFail();
				return $this->installView->welcome();
			}


			//unlink('install.php');
			return $this->installView->installEnd($pathToApp);
		}

		return $this->installView->welcome();
	}



}