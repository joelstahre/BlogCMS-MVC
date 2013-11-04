<?php

namespace model;

require_once("src/dal/PostDAL.php");
require_once("src/dal/CategoryDAL.php");

class PostHandler {


	private $postDAL;
	private $categoryDAL;


	public function __construct(\mysqli $mysqli) {
		$this->postDAL = new \dal\PostDAL($mysqli);
		$this->categoryDAL = new \dal\CategoryDAL($mysqli);
	}

	/**
	 * @param  string $id
	 * @return \model\Post
	 */
	public function getSinglePost($id) {


		$singlePost = $this->postDAL->getSinglePost($id);


		return $singlePost;
	}

	/**
	 * @return array of \model\Post objects
	 * @todo 2 felhantering, ifall det inte finns några inlägg.
	 */
	public function getAllPosts() {
		$allPosts = $this->postDAL->getAllPosts();

		return $allPosts;
	}

	public function addPost(\model\Post $newPost) {

		$newPostID = $this->postDAL->newPost($newPost);

		$categories = $newPost->getCategories();

		foreach ($categories as $categoryID) {
			$this->categoryDAL->addCategoriesToPost($categoryID, $newPostID);
		}

		$newSingelePost = $this->getSinglePost($newPostID);

		return $newSingelePost;
	}

	public function savePost(\model\Post $editedPost) {
		 $this->postDAL->savePost($editedPost);
	}

	public function removePost($postID) {

		try {
			$this->postDAL->getSinglePost($postID);
			$this->postDAL->removePost($postID);
		} catch(\Exception $e) {
			throw $e;
			
		}
		
	}
}