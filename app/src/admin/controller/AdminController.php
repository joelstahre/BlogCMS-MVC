<?php

namespace controller;

require_once("src/admin/view/AdminView.php");

class AdminController {

	public function __construct() {
		$this->adminView = new \view\AdminView();
	}


	public function runAdmin() {
		return $this->adminView->getFrontPage();
	}
}