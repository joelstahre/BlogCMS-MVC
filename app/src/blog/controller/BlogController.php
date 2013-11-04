<?php

namespace controller;

require_once("src/blog/view/BlogView.php");
require_once("src/blog/view/PostView.php");
require_once("src/blog/model/PostHandler.php");
require_once("src/blog/model/CommentHandler.php");
require_once("src/login/controller/LoginController.php");
require_once("src/common/model/Captcha.php");

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
	 * @var \model\PostHandler
	 */
	private $postHandler;

	/**
	 * @var \model\CommentHandler
	 */
	private $commentHandler;

	/**
	 * @var \model\Captcha
	 */
	private $captcha;

	/**
	 * @var array
	 */
	private $allPosts;



	/**
	 * [__construct description]
	 */
	public function __construct(\mysqli $mysqli) {
	    $this->loginController = new \controller\LoginController($mysqli);
		$this->postHandler = 	 new \model\PostHandler($mysqli);
		$this->commentHandler =  new \model\CommentHandler($mysqli);
	    
		$this->captcha = 		 new \model\Captcha();
		$this->commentView = 	 new \view\CommentView($this->captcha);
		$this->postView =    	 new \view\PostView($this->commentView);
		$this->blogView = 	 	 new \view\BlogView($this->postView);

	}

	/**
	 * @return string HTML
	 */
	public function runApp() {
		$this->allPosts = $this->postHandler->getAllPosts();
		//if user wants to gå to admin section
		if ($this->blogView->admin()) {
			return $this->loginController->doLoginControll();
		}

		//if the user wants to create a comment
		if ($this->commentView->postComment()) {
			$this->postComment();
		}

		//If the user wants to see a single post.
		if ($this->blogView->viewSingle()) {

			try {
				//generate new captcha string.
				$this->captcha->generateNumbers();
				$id = $this->blogView->getPostId();
				$singlePost = $this->postHandler->getSinglePost($id);

			} catch(\Exception $e) {
				//echo $e->getMessage();
				return $this->blogView->getErrorPage($this->allPosts);
			}
			return $this->blogView->getSinglePage($singlePost, $this->allPosts);
		}

		//Frontpage, show all posts.
		return $this->blogView->getFrontPage($this->allPosts);
	}


	private function postComment() {
		try {
				$commentFromUser = $this->commentView->getNewComment();

				//validate captcha
				$userCaptchaString = $this->commentView->getCaptcha();
				$this->captcha->captchaValidate($userCaptchaString);

				$this->commentHandler->createComment($commentFromUser);
				$this->commentView->commentSuccsess();
			} catch(\Exception $e) {
				$this->commentView->commentFaild();
				//echo $e->getMessage();//debug
			}
	}

}