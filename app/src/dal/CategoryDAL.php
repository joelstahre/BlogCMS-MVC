<?php

namespace dal;

require_once("src/blog/model/Category.php");

class CategoryDAL {

	private $mysqli;

	public function __construct(\mysqli $mysqli) {
		$this->mysqli = $mysqli;
	}


	public function getCategories($id) {

		$categoryArray = array();

		$sql = "SELECT
					c.catName
				FROM
					category c
				INNER JOIN postcategory pc
                ON c.catID = pc.catID
                WHERE pc.postID = $id;";

		$statement = $this->prepare($sql);

        $this->execute($statement);

        $result = $statement->get_result();

        while ($object = $result->fetch_array(MYSQLI_ASSOC)) {
        	$categoryArray[] = $object["catName"];
        }
		return $categoryArray;
	}

	public function getAllCategories() {
		$categoryArray = array();

		$sql = "SELECT
					c.catID,
					c.catName
				FROM
					category c";

		$statement = $this->prepare($sql);

        $this->execute($statement);

        $result = $statement->get_result();

        while ($object = $result->fetch_array(MYSQLI_ASSOC)) {
        	$categoryArray[] = new \model\Category($object["catID"], $object["catName"]);
        }

        return $categoryArray;

	}

    public function getCategory($categoryID) {
        $sql = "SELECT
                    catID,
                    catname
                FROM
                    category
                WHERE
                    catID = $categoryID;";

        $statement = $this->prepare($sql);

        if ($statement->execute() === FALSE) {
            throw new \Exception("CommentDAL:: execute of $sql failed " . $statement->error);
        }

        $result = $statement->get_result();

        $object = $result->fetch_array(MYSQLI_ASSOC);
        
        return new \model\Category($object["catID"],
                                  $object["catname"]);

    }

    public function deleteCategory($categoryID) {
        $sql = "DELETE FROM category
                WHERE catID = ?";

        $statement = $this->prepare($sql);

        if ($statement->bind_param("i", $categoryID) === FALSE) {
            throw new \Exception("CategoryDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
    }

    public function insertCategory($category) {
        $categoryName = $category->getCatName();
        $sql = "INSERT INTO category
            (
                catName
            )
            VALUES(?)";

        $statement = $this->prepare($sql);

        if ($statement->bind_param("s", $categoryName) === FALSE) {
            throw new \Exception("CategoryDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
    }


	public function addCategoriesToPost($categoryID, $PostID) {
		$sql = "INSERT INTO postcategory
            (
                postID,
                catID
            )
            VALUES(?, ?)";

        $statement = $this->prepare($sql);

        if ($statement->bind_param("si", $PostID, $categoryID) === FALSE) {
            throw new \Exception("CategoryDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
	}



    private function prepare($sql) {
        $statement = $this->mysqli->prepare($sql);
        if ($statement === FALSE) {
            throw new \Exception("CategoryDAL:: prepare of $sql failed " . $this->mysqli->error);
        }
        return $statement;
    }

    private function execute($statement) {
        if ($statement->execute() === FALSE) {
            throw new \Exception("CategoryDAL:: execute of $sql failed " . $statement->error);
        }
    }

}