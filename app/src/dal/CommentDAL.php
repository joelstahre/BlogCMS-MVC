<?php

namespace dal;

class CommentDAL {

	private $mysqli;

	public function __construct(\mysqli $mysqli) {
		$this->mysqli = $mysqli;
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

		$statement = $this->prepare($sql);

        $this->execute($statement);

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

	public function createComment(\model\Comment $comment) {
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

        $statement = $this->prepare($sql);

        if ($statement->bind_param("sssss", $author,
        								    $email,
        							        $website,
                                            $commentContent,
                                            $postID) === FALSE) {
            throw new \Exception("CommentDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
	}

    public function getAllComments() {
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
                    comments";

        $statement = $this->prepare($sql);

        $this->execute($statement);

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


    public function getComment($commentID) {
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
                    commentID = $commentID;";

        $statement = $this->prepare($sql);

        if ($statement->execute() === FALSE) {
            throw new \Exception("CommentDAL:: execute of $sql failed " . $statement->error);
        }

        $result = $statement->get_result();

        $object = $result->fetch_array(MYSQLI_ASSOC);

        return new \model\Comment($object["commentID"],
                                  $object["author"],
                                  $object["email"],
                                  $object["website"],
                                  $object["comment"],
                                  $object["DATE(createDate)"],
                                  $object["postID"]);

    }


    public function deleteComment($commentId) {
        $sql = "DELETE FROM comments
                WHERE commentID = ?";

        $statement = $this->prepare($sql);

        if ($statement->bind_param("i", $commentId) === FALSE) {
            throw new \Exception("CommentDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
    }

    private function prepare($sql) {
        $statement = $this->mysqli->prepare($sql);
        if ($statement === FALSE) {
            throw new \Exception("CommentDAL:: prepare of $sql failed " . $this->mysqli->error);
        }
        return $statement;
    }

    private function execute($statement) {
        if ($statement->execute() === FALSE) {
            throw new \Exception("CommentDAL:: execute of $sql failed " . $statement->error);
        }
    }
}