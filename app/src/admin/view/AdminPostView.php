<?php

namespace view;

class AdminPostView {

	/**
	 * @var string
	 */
	private $message = "";

	/**
	 * @var string
	 */
	private $titleMsg = "";

	/**
	 * @var string
	 */
	private $contentMsg = "";

	/**
	 * @var string
	 */
	private $allPostMessage = "";

	/**
	 * @var string
	 */
	const addPostSuccess = "Post created successfully!";

	/**
	 * @var string
	 */
	const editPostSuccess = "Successfully edited the post!";

	/**
	 * @var string
	 */
	const removePostSuccess = "Successfully deleted the post!";

	/**
	 * @var string
	 */
	private static $title = "title";

	/**
	 * @var string
	 */
	private static $content = "content";

	/**
	 * @var string
	 */
	private static $submit = "newPost";

	/**
	 * @var string
	 */
	private static $save = "save";

	/**
	 * @var string
	 */
	private static $postID = "postID";

	/**
	 * @var string
	 */
	private static $edit = "edit";

	/**
	 * @var string
	 */
	private static $remove = "remove";

	/**
	 * @return string html
	 * @param array of \model\Category objects
	 */
	public function newPost($categories) {
		$title = $this->getTitle();
		$content = $this->getContent();



		$categoryString = "<div>";
		foreach ($categories as $category) {
			$id = $category->getCatID();
			$name = $category->getCatName();
			$categoryString .= "<input type='checkbox' name='check_list[]' value='$id' > $name
								</br>";
		}
		$categoryString .= "</div>";


		$html = "<div class='adminContent'>
					<h2><span class='glyphicon glyphicon-pencil'></span> New Post</h2>
					<form method='post'>
						<div class='form-group'>
							<label class='control-label'>Title</label>
							 <div class='controls'>
							 	$this->titleMsg
							 	<input class='form-control' type='text' name='" . self::$title . "' value='$title' id='Title'>
							 </div>
						</div>

						<label class='form-label'>Post Content</label>
						<div class='controls'>
							$this->contentMsg
							<textarea class='form-control' id='newPostTextArea' name='" . self::$content . "'>$content</textarea>
							</br>
						</div>
						$categoryString
						</br>
						<input class='btn btn-primary' type='submit' name='" . self::$submit . "' value='Submit'>
					</form>
				</div>";

		return $html;
	}

	public function addPostFail() {
		if ($this->hasTags($this->getTitle())) {
			$this->titleMsg = "<span class='error'>Your name contains invalid characters</span>";
		}
		if (strlen($this->getTitle()) < 1) {
			$this->titleMsg = "<span class='error'>Title can not be empty!</span>";
		}
		if (strlen($this->getContent()) < 1) {
			$this->contentMsg = "<span class='error'>Content can not be empty!</span>";
		}
	}

	/**
	 * @return boolian
	 */
	public function hasTags($string) {
		if ($string != strip_tags($string)) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * @param  \model\Post $post
	 * @return string html
	 */
	public function getEditPost($post) {
		$title = $post->getTitle();
		$content = $post->getContent();


		$html = "<div class='adminContent'>
					<h2><span class='glyphicon glyphicon-edit'></span> Edit Post</h2>
					$this->message
					<form method='post'>
						<div class='form-group'>
							<label class='control-label'>Title</label>
							 <div class='controls'>
							 	$this->titleMsg
							 	<input class='form-control' type='text' name='" . self::$title . "' value='$title' id='Title'>
							 </div>
						</div>

						<label class='form-label'>Post Content</label>
						<div class='controls'>
							$this->contentMsg
							<textarea class='form-control' id='newPostTextArea' name='" . self::$content . "'>$content</textarea>
							</br>
						</div>
						Implement categorys
						</br>
						<input class='btn btn-primary' type='submit' name='" . self::$save . "' value='Save'>
					</form>
				</div>";

		return $html;
	}

	/**
	 * @return string html
	 */
	public function getEditPostError() {
		$html = "<div class='adminContent'>
					<h2><span class='glyphicon glyphicon-edit'></span> Edit Post</h2>
					<div class='alert alert-danger'>Post do not exist.</div>
				</div>";

		return $html;
	}

	/**
	 * @param  array of \model\Post objekts
	 * @return string html
	 */
	public function allPosts($posts) {

		$html ="<div class='adminContent'>
					<h2><span class='glyphicon glyphicon-list'></span> All Posts</h2>
					$this->allPostMessage";
		$html .= "<table>
					<tr>
						<th></th>
						<th id='tableTitle'>Title</th>
						<th id='tableAuthor'>Author</th>
						<th>Date</th>
					</tr>";

		foreach ($posts as $post) {
			$id = $post->getId();
			$title = $post->getTitle();
			$author = $post->getAuthor();
			$date = $post->getCreateDate();

			$html .= "<tr>";
			$html .= "<td><a href='?admin&" . self::$edit . "&" . self::$postID . "=$id'<span class='glyphicon glyphicon-edit'></span>
						  <a href='?admin&" . self::$remove . "&" . self::$postID . "=$id'><span class='glyphicon glyphicon-remove'></span></td></a>";
			$html .= "<td><a href='?admin&" . self::$edit . "&" . self::$postID . "=$id'>$title</a></td>";
			$html .= "<td>$author</td>";
			$html .= "<td>$date</td>";
			$html .= "</tr>";
		}

		$html .= "</table>
				</div>";

		return $html;
	}

	/**
	 * Sets message
	 */
	public function addPostSuccess() {
		$this->message = "<div class='alert alert-success'>" . self::addPostSuccess . "</div>";
	}

	/**
	 * Sets message
	 */
	public function editPostSuccess() {
		$this->message = "<div class='alert alert-success'>" . self::editPostSuccess . "</div>";
	}

	/**
	 * Sets message
	 */
	public function removePostFaild() {
		$this->allPostMessage = "<div class='alert alert-danger'>Failed to remove post! Post do not exist.</div>";
	}

	/**
	 * Sets message
	 */
	public function removePostSuccess() {
		$this->allPostMessage = "<div class='alert alert-success'>" . self::removePostSuccess . "</div>";
	}

	public function getNewPost() {
		try {
			return \model\Post::createNewPost($this->getTitle(), $this->getContent(), $this->getCategories());
		} catch(\Exception $e) {
			throw $e;
		}
	}

	public function getEditedPost() {
		try {
			return \model\Post::savePost($this->getPostID(), $this->getTitle(), $this->getContent());
		} catch(\Exception $e) {
			throw $e;
		}
	}


	/**
	 * @return string
	 */
	public function getTitle() {
		if (!empty($_POST[self::$title])) {
			return $_POST[self::$title];
		} else {
			return "";
		}
	}

	/**
	 * @return string
	 */
	public function getContent() {
		if (!empty($_POST[self::$content])) {
			return $_POST[self::$content];
		}
		return "";
	}

	public function getCategories() {
		if (!empty($_POST["check_list"])) {
			$array = array();
			foreach ($_POST["check_list"] as $check) {
				$array[] = $check;
			}
			return $array;
		}
		return array("1");
	}

	/**
	 * @return string
	 */
	public function getPostID() {
		return $_GET[self::$postID];
	}

	/**
	 * @return boolian
	 */
	public function newPostSubmit() {
		return isset($_POST[self::$submit]);
	}

	/**
	 * @return boolian
	 */
	public function savePost() {
		return isset($_POST[self::$save]);
	}

	/**
	 * @return boolian
	 */
	public function editPost() {
		return isset($_GET[self::$edit]);
	}

	/**
	 * @return boolian
	 */
	public function removePost() {
		return isset($_GET[self::$remove]);
	}

}