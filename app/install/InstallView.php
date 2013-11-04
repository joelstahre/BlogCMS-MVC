<?php

namespace view;

class InstallView {

	private $usernameMsg = "";
	private $passwordMsg = "";
	private $emailMsg = "";

	public function welcome() {
		$username = $this->getUsername();
		$email = $this->getEmail();

		return "<div class='install-container'>
					<div class='install-form'>
						<h1>Welcome to install</h1>
						<p>Please fill out the form below, and hit the install button.</p>
						<form method='post'>
							<div class='form-group'>
								<label class='control-label'>Username</label>
								 <div class='controls'>
								 	<input class='form-control' type='text' value='$username' name='username'>$this->usernameMsg
								 </div>
							</div>

							<div class='form-group'>
								<label class='control-label'>Password</label>
								 <div class='controls'>
								 	<input class='form-control' type='text' name='password'>$this->passwordMsg
								 </div>
							</div>

							<div class='form-group'>
								<label class='control-label'>Email</label>
								 <div class='controls'>
								 	<input class='form-control' type='text' value='$email' name='email'>$this->emailMsg
								 </div>
							</div>

						<input class='btn btn-primary' type='submit' name='install' value='Install your awesome blog'>
						</form>
					</div>
				</div>";
	}

	public function registerFail() {
		if ($this->getUsername() != strip_tags($this->getUsername())) {
			$this->usernameMsg = "<p class='error'>Field contains invalid characters</p>";

		}
		if (strlen($this->getUsername()) < 3) {
			$this->usernameMsg = "<p class='error'>Must contain at least 3 characters</p>";
		}
		if (strlen($this->getUsername()) > 25) {
			$this->usernameMsg = "<p class='error'>Max 25 characters</p>";
		}
		if (strlen($this->getUserInputPassword()) < 5) {
			$this->passwordMsg = "<p class='error'>Must contain at least 5 characters</p>";
		}
		if (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
			$this->emailMsg = "<p class='error'>Not a valid Email Address</p>";
		}
	}

	public function installEnd($pathToApp) {
		return "<div class='install-container'>
					<h1>Installation Complete</h1>
					<p>Press the Continue button to go to your new Awesome Blog</p>
					<a href='$pathToApp' class='btn btn-primary'>Continue</a>
				</div>";
	}


	public function install() {
		return isset($_POST["install"]);
	}

	public function getUsername() {
		if (isset($_POST["username"])) {
			return $_POST["username"];
		}
		return "";
	}

	public function getUserInputPassword() {
		if (isset($_POST["password"])) {
			return $_POST["password"];
		}
		return "";
	}

	public function getPassword() {
		return sha1($_POST["password"]);
	}

	public function getEmail() {
		return $_POST["email"];
	}
}