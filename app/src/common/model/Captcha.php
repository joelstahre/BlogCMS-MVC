<?php

namespace model;

class Captcha {

	private $nr1;
	private $nr2;
	private $captchaAnswer;

	private static $sesssionCaptcha = "captchaAnswer";

	public function generateNumbers() {

		$this->nr1 = rand(1, 10);
		$this->nr2 = rand(1, 10);

		$answer = $this->nr1 + $this->nr2;

		$this->captchaAnswer = $answer;
		$_SESSION[self::$sesssionCaptcha] = $answer;

	}

	public function captchaValidate($userInput) {
		if (strlen($userInput) < 1) {

			throw new \Exception("ValidComment::__construct : captcha not ok");
		}
		if ($userInput != $_SESSION[self::$sesssionCaptcha]) {

			throw new \Exception("ValidComment::__construct : captcha not ok");
		}
	}

	public function getCaptchaNr1() {
		return $this->nr1;
	}

	public function getCaptchaNr2() {
		return $this->nr2;
	}

	public function getCaptchaAnswer() {
		return $this->captchaAnswer;
	}

}