<?php

namespace dal;

class CommentDAL {

	private $mysqli;

	public function __construct() {
		$this->mysqli = new \mysqli("127.0.0.1", "root", "", "blog");
		if ($this->mysqli->connect_errno) {
    		echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}
	}


	public function getComments($id) {

		$commentArray = array();

		$sql = "SELECT
					commentID,
					author,
					email,
					website,
					comment,
					DATE(createDate),
					postID
				FROM
					comments
				WHERE
					postID = $id
                ORDER BY createDate DESC";

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
        	$commentArray[] = new \model\Comment($object["commentID"],
        										 $object["author"],
        										 $object["email"],
        										 $object["website"],
		        								 $object["comment"],
		        								 $object["DATE(createDate)"],
		        								 $object["postID"]);
        }

		return $commentArray;
	}

	public function createComment(\model\ValidComment $comment) {
        $author = $comment->getAuthor();
        $email = $comment->getEmail();
        $website = $comment->getWebsite();
        $commentContent = $comment->getComment();
        $postID = $comment->getPostID();

		$sql = "INSERT INTO comments
            (
                author,
                email,
                website,
                comment,
                postID
            )
            VALUES(?, ?, ?, ?, ?)";

           //http://www.php.net/manual/en/mysqli-stmt.prepare.php
        $statement = $this->mysqli->prepare($sql);
        if ($statement === FALSE) {
            throw new Exception("prepare of $sql failed " . $this->mysqli->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.bind-param.php
        if ($statement->bind_param("sssss", $author,
        								    $email,
        							        $website,
                                            $commentContent,
                                            $postID) === FALSE) {
            throw new Exception("bind_param of $sql failed " . $statement->error);
        }

        //http://www.php.net/manual/en/mysqli-stmt.execute.php
        if ($statement->execute() === FALSE) {
            throw new Exception("execute of $sql failed " . $statement->error);
        }
	}
}