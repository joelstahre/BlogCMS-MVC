<?php

namespace dal;

require_once("src/blog/model/Post.php");
require_once("src/blog/model/Comment.php");

class PostDAL {

	private $mysqli;

    private $commentDAL;


	public function __construct(\dal\CommentDAL $commentDAL) {
		$this->mysqli = new \mysqli("127.0.0.1", "root", "", "blog");
		if ($this->mysqli->connect_errno) {
    		echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}

        $this->commentDAL = $commentDAL;

	}


	public function getSinglePost($id) {
		$sql = "SELECT
					postID,
                    author,
					title,
					content,
					DATE(createDate)
				FROM
					post p
				WHERE
					postID = $id;";

		$statement = $this->mysqli->prepare($sql);

        if ($statement === FALSE) {
            throw new \Exception("prepare of $sql failed " . $this->mysqli->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.execute.php
        if ($statement->execute() === FALSE) {
            throw new \Exception("execute of $sql failed " . $statement->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.get-result.php
        $result = $statement->get_result();

        $object = $result->fetch_array(MYSQLI_ASSOC);

        $commentArray = $this->commentDAL->getComments($id);

        return new \model\Post($object['postID'],
                               $object['author'],
        					   $object['title'],
        					   $object['content'],
        					   $object['DATE(createDate)'],
        					   $commentArray);
	}


	/**
	 * @return array of \model\Post objects
	 */
	public function getAllPosts() {

		$postArray = array();

		$sql = "SELECT
					postID,
                    author,
					title,
					content,
					DATE(createDate)
				FROM
					post;";

		$statement = $this->mysqli->prepare($sql);
        if ($statement === FALSE) {
            throw new \Exception("prepare of $sql failed " . $this->mysqli->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.execute.php
        if ($statement->execute() === FALSE) {
            throw new \Exception("execute of $sql failed " . $statement->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.get-result.php
        $result = $statement->get_result();


        while ($object = $result->fetch_array(MYSQLI_ASSOC)) {

        	$postArray[] = new \model\Post($object["postID"],
                                           $object['author'],
        								   $object["title"],
        								   $object["content"],
        								   $object["DATE(createDate)"],
        								   $this->commentDAL->getComments($object["postID"]));
        }
        //var_dump($commentArray);
		return $postArray;
	}

}