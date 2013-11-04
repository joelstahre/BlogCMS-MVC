<?php

namespace dal;

require_once("src/blog/model/Post.php");
require_once("src/blog/model/Comment.php");
require_once("src/dal/CommentDAL.php");
require_once("src/dal/CategoryDAL.php");

class PostDAL {

	private $mysqli;

    private $commentDAL;
    private $categoryDAL;

	public function __construct(\mysqli $mysqli) {
		$this->mysqli = $mysqli;
        $this->commentDAL = new \dal\CommentDAL($mysqli);
        $this->categoryDAL = new \dal\CategoryDAL($mysqli);

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

        if ($statement->execute() === FALSE) {
            throw new \Exception("PostDAL:: execute of $sql failed " . $statement->error);
        }

        $result = $statement->get_result();

        $object = $result->fetch_array(MYSQLI_ASSOC);


        $commentArray = $this->commentDAL->getComments($id);

        return \model\Post::createPostFromDB($object['postID'],
                                             $object['author'],
                                             $object['title'],
                                             $object['content'],
                                             $object['DATE(createDate)'],
                                             $this->categoryDAL->getCategories($object["postID"]),
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
					post
                ORDER BY createDate DESC;";

		$statement = $this->prepare($sql);

        $this->execute($statement);

        $result = $statement->get_result();


        while ($object = $result->fetch_array(MYSQLI_ASSOC)) {

        	$postArray[] = \model\Post::createPostFromDB($object["postID"],
                                           $object['author'],
        								   $object["title"],
        								   $object["content"],
        								   $object["DATE(createDate)"],
                                           $this->categoryDAL->getCategories($object["postID"]),
        								   $this->commentDAL->getComments($object["postID"]));
        }
		return $postArray;
	}

    public function newPost($newPost) {
        $author = $newPost->getAuthor();
        $title = $newPost->getTitle();
        $content = $newPost->getContent();

        $sql = "INSERT INTO post
            (
                author,
                title,
                content
            )
            VALUES(?, ?, ?)";


        $statement = $this->prepare($sql);

        if ($statement->bind_param("sss", $author, $title, $content) === FALSE) {
            throw new \Exception("PostDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);

        return $this->mysqli->insert_id;
    }



    public function removePost($postId) {
        $sql = "DELETE FROM post
                WHERE postID = ?";

        $statement = $this->prepare($sql);

        if ($statement->bind_param("i", $postId) === FALSE) {
            throw new \Exception("PostDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);
    }


    public function savePost($post) {
        $postId = $post->getId();
        $title = $post->getTitle();
        $content = $post->getContent();

        $sql = "UPDATE post
                SET title = ?,
                    content = ?
                WHERE
                    postID = ?";

        $statement = $this->prepare($sql);

        if ($statement->bind_param("ssi", $title, $content, $postId) === FALSE) {
            throw new \Exception("PostDAL:: bind_param of $sql failed " . $statement->error);
        }

        $this->execute($statement);

    }


    private function prepare($sql) {
        $statement = $this->mysqli->prepare($sql);
        if ($statement === FALSE) {
            throw new \Exception("PostDAL:: prepare of $sql failed " . $this->mysqli->error);
        }
        return $statement;
    }

    private function execute($statement) {
        if ($statement->execute() === FALSE) {
            throw new \Exception("PostDAL:: execute of $sql failed " . $statement->error);
        }
    }

}