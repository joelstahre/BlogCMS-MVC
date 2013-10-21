<?php

namespace model;

require_once("src/dal/PostDAL.php");

class PostList {

	/**
	 * @var PostDAL
	 */
	private $postDAL;


	public function __construct(\dal\PostDAL $postDAL) {
		$this->postDAL = $postDAL;
	}

	/**
	 * @param  string $id
	 * @return \model\Post
	 * @todo felhantering, om man försöker hämta en post som inte finns.
	 */
	public function getSinglePost($id) {

		$singlePost = $this->postDAL->getSinglePost($id);

		return $singlePost;
	}

	/**
	 * @return array of \model\Post objects
	 * @todo felhantering, ifall det inte finns några inlägg.
	 */
	public function getAllPosts() {
		$allPosts = $this->postDAL->getAllPosts();

		return $allPosts;
	}
}