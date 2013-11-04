<?php

namespace model;

class Category {

	/**
	 * @var int
	 */
	private $catID;

	/**
	 * @var string
	 */
	private $catName;

	public function __construct($catID, $catName) {
		$this->catID = $catID;

		if ($this->catNameIsOK($catName)) {
			$this->catName = $catName;
		} else {
			throw new \Exception("Category::__construct : Bad catName");
			
		}
		
	}

	/**
	 * @param string
	 * @return \model\Category
	 */
	public static function createNewCategory($categoryName) {
		return new \model\Category(null, $categoryName);
	}

	/**
	 * @return boolian
	 */
	public function catNameIsOK($catName) {
		if ($catName == null) {
			return false;
		}
		if ($catName != strip_tags($catName)) {
			return false;
		}
		if (strlen($catName) < 1) {
			return false;
		}
		return true;
	}

	public function getCatID() {
		return $this->catID;
	}

	public function getCatName() {
		return $this->catName;
	}
}