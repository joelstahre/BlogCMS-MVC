<?php

namespace view;

class CommentView {

	private static $commentAuthor = "author";
	private static $commentEmail = "email";
	private static $commentWebsite = "website";
	private static $commentText = "comment";

	private static $makeComment = "makeComment";

	private static $requiredNameMsg = "<span class='error'>Please enter your name.</span>";
	private static $requiredEmailMsg = "<span class='error'>Please enter a valid email address.</span>";
	private static $requiredCommentMsg = "<span class='error'>Comments must have at least 5 characters.</span>";

	private $nameMsg = "";
	private $emailMsg = "";
	private $commentMsg = "";

	/**
	 * @param  \model\Post
	 * @return string HTML
	 * @todo någon if sats ifall det inte finns kommentarer?
	 * @todo website, formatera.
	 * @todo när man klickar submit så åker sidan upp.
	 */
	public function getCommentHTML(\model\Post $post) {
		$name = $this->getCommentAuthor();
		$email = $this->getCommentEmail();
		$website = $this->getCommentWebsite();
		$comment = $this->getCommentText();

		$html = "<div>
					<h3>Comments</h3>
					<p>Write a comment:</p>
					<form method='post'>
						<div class='form-group'>
							<label class='control-label'>Name</label>
							 <div class='controls'>
							 	<input class='form-control' type='text' value='$name' name='" . self::$commentAuthor . "' id='Name'>$this->nameMsg
							 </div>
						</div>
						<div class='form-group'>
							<label class='control-label'>Email</label>
							 <div class='controls'>
							 	<input class='form-control' type='text' value='$email' name='". self::$commentEmail ."' id='Email'>$this->emailMsg
							 </div>
						</div>
						<div class='form-group'>
							<label class='control-label'>Website</label>
							 <div class='controls'>
							 	<input class='form-control' type='text' value='$website' name='". self::$commentWebsite ."' id='Website'>
							 </div>
						</div>

						<label class='form-label'>Comment</label>
						<textarea class='form-control' name='" . self::$commentText . "'>$comment</textarea>$this->commentMsg
						</br>
						<input class='btn btn-primary' type='submit' name='" . self::$makeComment . "' value='Comment'>
					</form>
				</div>";

		$html .= "<div>";

		$comments = $post->getComments();

		foreach ($comments as $comment) {
			$commentAuthor = $comment->getAuthor();
			$commentText = $comment->getComment();
			$commentDate = $comment->getCreatDate();
			$commentWebsite = $comment->getWebsite();
			$html .= "<div>
						<hr>
						<b>$commentAuthor</b> $commentDate<br/>
						<a href='http://$commentWebsite'>$commentWebsite</a>
						<p>$commentText</p>
						</div>";
		}

		$html .= "</div>";

		return $html;
	}

	public function commentFaild() {
		if (strlen($this->getCommentAuthor()) < 3) {
			$this->nameMsg = self::$requiredNameMsg;
		}
		if (!filter_var($this->getCommentEmail(), FILTER_VALIDATE_EMAIL)) {
			$this->emailMsg = self::$requiredEmailMsg;
		}
		if (strlen($this->getCommentText()) < 5) {
			$this->commentMsg = self::$requiredCommentMsg;
		}
	}

	/**
	 * @return string
	 */
	public function getCommentAuthor() {
		if (!empty($_POST[self::$commentAuthor])) {
			return $_POST[self::$commentAuthor];
		} else {
			return "";
		}
	}

	public function getCommentEmail() {
		if (!empty($_POST[self::$commentEmail])) {
			return $_POST[self::$commentEmail];
		} else {
			return "";
		}
	}

	public function getCommentWebsite() {
		if (!empty($_POST[self::$commentWebsite])) {
			return $_POST[self::$commentWebsite];
		} else {
			return "";
		}
	}

	/**
	 * @return string
	 */
	public function getCommentText() {
		if (!empty($_POST[self::$commentText])) {
			return $_POST[self::$commentText];
		} else {
			return "";
		}
	}

	/**
	 * @return boolian
	 */
	public function postComment() {
		return isset($_POST[self::$makeComment]);
	}
}