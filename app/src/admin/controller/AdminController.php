<?php

namespace controller;

require_once("src/admin/view/AdminView.php");
require_once("src/admin/view/AdminPostView.php");
require_once("src/admin/view/AdminCommentView.php");
require_once("src/admin/view/AdminCategoryView.php");
require_once("src/admin/view/SettingsView.php");
require_once("src/blog/model/PostHandler.php");
require_once("src/blog/model/CommentHandler.php");
require_once("src/blog/model/CategoryHandler.php");

class AdminController {

	/**
	 * @var \controller\LoginControlle
	 */
	private $loginController;

	/**
	 * @var \view\AdminView
	 */
	private $adminView;

	/**
	 * @var \view\AdminPostView
	 */
	private $postView;

	/**
	 * @var \view\AdminCommentView
	 */
	private $commentView;

	/**
	 * @var \view\AdminCategoryView
	 */
	private $categoryView;

	/**
	 * @var \view\SettingsView
	 */
	private $settingsView;


	private $postHandler;
	private $commentHandler;
	private $categoryHandler;

	/**
	 * @param \controller\LoginController
	 * @todo 1. Skickar med loginController Får jag göra såhär? HUr göra annars?
	 */
	public function __construct(\controller\LoginController $loginController,
								\mysqli $mysqli) {

		$this->loginController = $loginController;
		$this->adminView = 		 new \view\AdminView();
		$this->postView = 		 new \view\AdminPostView();
		$this->commentView = 	 new \view\AdminCommentView();
		$this->categoryView = 	 new \view\AdminCategoryView();
		$this->settingsView = 	 new \view\SettingsView();
		$this->postHandler = 	 new \model\PostHandler($mysqli);
		$this->commentHandler =  new \model\CommentHandler($mysqli);
		$this->categoryHandler = new \model\CategoryHandler($mysqli);

	}


	/**
	 * @return string html
	 */
	public function runAdmin() {

		//If the user has clicked Submit on a new post.
		if ($this->postView->newPostSubmit()) {
			return $this->doPost();
		}

		//If the user has clicked Save after edit.
		if ($this->postView->savePost()) {
			return $this->savePost();
		}

		//Id the user has clicked edit on a specifik post.
		if ($this->postView->editPost()) {
			return $this->editPost();
		}

		//If the user has clicked Submit on a new category.
		if ($this->categoryView->newCategory()) {
			return $this->newCategory();
		}

		//If the user has clicked remove on a specifik post.
		if ($this->postView->removePost()) {
			return $this->removePost();
		}

		//If the user has clicked remove on a specifik comment.
		if ($this->commentView->removeComment()) {
			return $this->removeComment();
		}

		//If the user has clicked remove on a specifik category.
		if ($this->categoryView->removeCategory()) {
			return $this->removeCategory();
		}

		//Id the user wants to create a new post.
		if ($this->adminView->newPost()) {
			$categories = $this->categoryHandler->getAllCategories();
			return $this->adminView->getContentPage($this->postView->newPost($categories));
		}

		//If the user wants to se all posts.
		if ($this->adminView->allPosts()) {
			return $this->allPosts();
		}

		//If the user wants to se all comments.
		if ($this->adminView->allComments()) {
			return $this->allComments();
		}

		//If the user wants to se all categories.
		if ($this->adminView->allCategories()) {
			return $this->allCategories();
		}


		if($this->settingsView->isSubmitted()){
			//Detta är inte bra!!!
			try {
				$title = $this->settingsView->getBlogName();
				$footer = $this->settingsView->getFooterText();
				\common\Config::set("blogTitle", $title);
				\common\Config::set("blogFooter", $footer);
				$this->settingsView->saveSuccsses();

			}catch(\Exception $e) {

			}
		
		}


		//If the user har clicked settings.
		if ($this->adminView->settings()) {
			return $this->adminView->getContentPage($this->settingsView->getSettings());
		}

		//If the user har clicked logout.
		if ($this->adminView->logOut()) {
			return $this->loginController->wantsToSignOut();
		}

		return $this->getAdminStart();
	}

	/**
	 * @todo är detta ok?!
	 * @return string html
	 */
	public function getAdminStart() {

		//array for stats, borde kanske skapa ett statsObjekt?
		$statsArray = array();
		$statsArray[] = $this->postHandler->getAllPosts();
		$statsArray[] = $this->commentHandler->getAllComments();
		$statsArray[] = $this->categoryHandler->getAllCategories();

		return $this->adminView->getFrontPage($statsArray);
	}

	/**
	 * @todo diregera om till ny url
	 * @return string html
	 */
	public function doPost() {

		try {

			$postFromUser = $this->postView->getNewPost();
			$post = $this->postHandler->addPost($postFromUser);

			$this->postView->addPostSuccess();
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();
			$this->postView->addPostFail();
			//todo väldigt fult att behöva skicka med categorys så här.
			$categories = $this->categoryHandler->getAllCategories();
			return $this->adminView->getContentPage($this->postView->newPost($categories));

		}
		//Show the edit view for the new Post.
		return $this->adminView->getContentPage($this->postView->getEditPost($post));
	}

	public function newCategory() {
		try {

			$newCategory = $this->categoryView->getNewCategory();
			$this->categoryHandler->addCategory($newCategory);

			$this->categoryView->addCategorySuccess();
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();
			$this->categoryView->addCategoryFail();
			return $this->allCategories();

		}
		return $this->allCategories();
	}

	/**
	 * @return string html
	 */
	public function editPost() {

		try {
			$postID = $this->postView->getPostID();
			$post = $this->postHandler->getSinglePost($postID);
			$categories = $this->categoryHandler->getAllCategories();
			//succssess
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();
			return $this->adminView->getContentPage($this->postView->getEditPostError());
		}
		return $this->adminView->getContentPage($this->postView->getEditPost($post, $categories));
	}

	/**
	 * @return string html
	 */
	public function savePost() {

		try {

			$editedPost = $this->postView->getEditedPost();
			$this->postHandler->savePost($editedPost);
			//succssess
			$this->postView->editPostSuccess();
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();
			$this->postView->addPostFail();

			//if the editing goes wrong, fetch the old post and display it with the error messages.
			$postID = $this->postView->getPostID();
			$oldPost = $this->postHandler->getSinglePost($postID);

			return $this->adminView->getContentPage($this->postView->getEditPost($oldPost));

		}
		return $this->adminView->getContentPage($this->postView->getEditPost($editedPost));
	}


	/**
	 * @return string html
	 */
	public function removePost() {

		try {
			$postID = $this->postView->getPostID();
			$this->postHandler->removePost($postID);
			//succssess
			$this->postView->removePostSuccess();
		} catch(\Exception $e) {
			//fail
			$this->postView->removePostFaild();
			//debug echo $e->getMessage();

		}
		return $this->allPosts();
	}

	/**
	 * @return string html
	 */
	public function removeComment() {

		try {
			$commentID = $this->commentView->getCommentID();
			$this->commentHandler->removeComment($commentID);
			//succssess
			$this->commentView->removeCommentSuccess();
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();
			$this->commentView->removeCommentFail();

		}
		return $this->allComments();
	}

	/**
	 * @return string html
	 */
	public function removeCategory() {

		try {
			$categoryID = $this->categoryView->getCategoryID();
			$this->categoryHandler->removeCategory($categoryID);
			//succssess
			$this->categoryView->removeCategorySuccess();
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();
			$this->categoryView->removeCategoryFail();

		}
		return $this->allCategories();
	}


	/**
	 * @return string html
	 */
	public function allPosts() {
		$posts = array();
		try {
			$posts = $this->postHandler->getAllPosts();
			//succssess
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();

		}
		return $this->adminView->getContentPage($this->postView->allPosts($posts));
	}


	/**
	 * @return string html
	 */
	public function allComments() {
		try {
			$comments = $this->commentHandler->getAllComments();
			//succssess
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();

		}
		return $this->adminView->getContentPage($this->commentView->allComments($comments));
	}


	/**
	 * @return string html
	 */
	public function allCategories() {
		try {
			$categories = $this->categoryHandler->getAllCategories();
			//succssess
		} catch(\Exception $e) {
			//fail
			//debug echo $e->getMessage();

		}
		return $this->adminView->getContentPage($this->categoryView->allCategories($categories));
	}

}