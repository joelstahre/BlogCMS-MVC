<?php

namespace view;

class AdminCategoryView {

	/**
	* @var string 
	**/
	private $message = "";

	/**
	* @var string 
	**/
	private $catNameMsg = "";

	/**
	* @var string 
	**/
	const removeCategorySuccess = "Successfully deleted the category!";

	/**
	* @var string 
	**/
	const addCategorySuccess = "Successfully added the category!";

	/**
	* @param array
	* @return string html 
	**/
	public function allCategories($categories) {

		$html ="<div class='adminContent'>
					<h2><span class='glyphicon glyphicon-pushpin'></span> Manage Categories</h2>
					$this->message";
		$html .= "<table>
					<tr>
						<th></th>
						<th id='tableAuthor'>Name</th>
					</tr>";

		foreach ($categories as $category) {
			$id = $category->getCatID();
			$category = $category->getCatName();

			$html .= "<tr>";

			if ($id == "1") {
				$html .= "<td></td>";
			}else {
				$html .= "<td><a href='?admin&removeCategory&categoryID=$id'><span class='glyphicon glyphicon-remove'></span></td></a>";
			}
			$html .= "<td>$category</td>";
			$html .= "</tr>";
		}

		$html .= "</table>

				<form method='post'>
					<div class='form-group'>
						<label class='control-label'>Category name</label>
						<div class='controls'>
							 $this->catNameMsg
							 <input id='addCatInput' class='form-control' type='text' name='category'>
						</div>
					</div>

					<input class='btn btn-primary' type='submit' name='addCategory' value='Add Category'>
				</form>


				</div>";

		return $html;
	}

	public function addCategoryFail() {
		if ($this->hasTags($this->getCatName())) {
			$this->catNameMsg = "<span class='error'>The field contains invalid characters</span>";
		}
		if (strlen($this->getCatName()) < 1) {
			$this->catNameMsg = "<span class='error'>Category can not be empty</span>";
		}
	}

	/**
	* @return boolian 
	**/
	public function hasTags($string) {
		if ($string != strip_tags($string)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* @return string 
	**/
	public function getCatName() {
		return $_POST["category"];
	}

	/**
	* @return boolian 
	**/
	public function newCategory() {
		return isset($_POST["addCategory"]);
	}

	/**
	* @return \model\Category
	**/
	public function getNewCategory() {
		return \model\Category::createNewCategory($_POST["category"]);
	}

	public function addCategorySuccess() {
		$this->message = "<div class='alert alert-success'>" . self::addCategorySuccess . "</div>";
	}

	public function removeCategorySuccess() {
		$this->message = "<div class='alert alert-success'>" . self::removeCategorySuccess . "</div>";
	}

	public function removeCategoryFail() {
		$this->message = "<div class='alert alert-danger'>Category do not exist.</div>";
	}

	/**
	* @return boolian
	**/
	public function removeCategory() {
		return isset($_GET["removeCategory"]);
	}

	/**
	* @return string
	**/
	public function getCategoryID() {
		return $_GET["categoryID"];
	}
}