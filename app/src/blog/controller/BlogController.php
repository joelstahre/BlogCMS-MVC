<?php

namespace controller;

require_once("src/blog/view/BlogView.php");
require_once("src/blog/view/PostView.php");
require_once("src/blog/model/PostList.php");
require_once("src/login/controller/LoginController.php");
require_once("src/blog/model/PostList.php");
require_once("src/blog/model/ValidComment.php");

class BlogController {

	/**
	 * @var \view\BlogView
	 */
	private $blogView;

	/**
	 * @var \view\CommentView
	 */
	private $commentView;

	/**
	 * @var \view\PostView
	 */
	private $postView;

	/**
	 * @var \model\PostList
	 */
	private $postList;

	/**
	 * @var PostDAL
	 */
	private $postDAL;

	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->commentView = new \view\CommentView();
		$this->postView = new \view\PostView($this->commentView);
		$this->blogView = new \view\BlogView($this->postView);
		$this->postDAL = new \dal\PostDAL();
		$this->postList = new \model\PostList($this->postDAL);
		$this->loginController = new \controller\LoginController();
	}

	/**
	 * @return string HTML
	 */
	public function runApp() {


		if ($this->blogView->admin()) {
			return $this->loginController->doLoginControll();
		}

		//if the user wants to create a comment
		if ($this->commentView->postComment()) {
			try {
				$author = $this->commentView->getCommentAuthor();
				$email = $this->commentView->getCommentEmail();
				$website = $this->commentView->getCommentWebsite();
				$comment = $this->commentView->getCommentText();
				$postID = $this->blogView->getPostId();

				$validComment = new \model\ValidComment($author, $email, $website, $comment, $postID);

				$this->postDAL->createComment($validComment);
			} catch(\Exception $e) {
				$this->commentView->commentFaild();
				echo $e->getMessage();//debug
			}
		}


		//If the user wants to se a single post.
		if ($this->blogView->viewSingle()) {

			$id = $this->blogView->getPostId();
			$singlePost = $this->postList->getSinglePost($id);

			return $this->blogView->getSinglePage($singlePost);
		}




		//Frontpage, show all posts.
		$allPosts = $this->postList->getAllPosts();
		return $this->blogView->getFrontPage($allPosts);
	}

}