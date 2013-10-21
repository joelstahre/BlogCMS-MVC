<?php

namespace model;

class Navigation {

	public function getAdminPage() {
		header("Location: index.php/?admin");
	}
}