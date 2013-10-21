<?php

namespace view;

class AdminPage {

	/**
	 * @var string
	 */
	private static $logOutButton = "logout";

	/**
	 * @var string
	 */
	private $message = "";


	const rememberMeMessage = "Lyckad Inloggning Och vi kommer ihåg dig nästa gång!";
	const signedInSuccsess = "Lyckad Inloggning";
	const signedInSuccsessCookie = "Lyckad Inloggning Med Cookies";


	/**
	 * @param  string $message [description]
	 * @return String AdminHTML
	 * @todo Fix $username får jag hämta ur session?
	 */
	public function getPage() {
		$username = $_SESSION["username"];
		return "<h2>Välkommen $username!</h2>
				<p>$this->message</p>
				<p><a href='?" . self::$logOutButton ."'>Logga ut</a>";
	}


	/**
	 * @param string $msg
	 */
	public function setMessage($msg) {
		$this->message = $msg;
	}


	/**
	 * @return boolean
	 */
	public function wantsToSignOut() {
		return isset($_GET[self::$logOutButton]);
	}


}