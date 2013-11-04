<?php

namespace model;

require_once("src/dal/CategoryDAL.php");

class CategoryHandler {

	private $categoryDAL;

	public function __construct(\mysqli $mysqli) {
		$this->categoryDAL = new \dal\CategoryDAL($mysqli);
	}

	public function getAllCategories() {
		return $this->categoryDAL->getAllCategories();
	}

	public function removeCategory($categoryID) {

		try {
			$test = $this->categoryDAL->getCategory($categoryID);
			
			$this->categoryDAL->deleteCategory($categoryID);
		}catch(\Exception $e) {
			throw $e;
		}
	}

	public function addCategory(\model\Category $category) {
		$this->categoryDAL->insertCategory($category);
	}
}