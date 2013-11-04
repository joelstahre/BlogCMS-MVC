<?php

namespace view;

class CommentView {

	/**
	 * @var \model\Captcha
	 */
	private $captcha;

	/**
	 * @var string
	 */
	private static $commentAuthor = "author";
	private static $commentEmail = "email";
	private static $commentWebsite = "website";
	private static $commentText = "comment";
	private static $commentCaptcha = "captcha";
	private static $makeComment = "makeComment";
	/**
	 * @todo Constanter?
	 */
	private static $requiredNameMsg = "<span class='error'>Please enter your name.</span>";
	private static $requiredEmailMsg = "<span class='error'>Please enter a valid email address.</span>";
	private static $requiredCommentMsg = "<span class='error'>Comments must have at least 5 characters.</span>";
	private static $requiredcaptchaMsg = "<span class='error'>Captcha is empty.</span>";
	private static $requiredcaptchaMsg2 = "<span class='error'>Wrong answer.</span>";
	private static $invalidCharacters = "<span class='error'>Your name contains invalid characters.</span>";
	private static $commentSuccsess = "<span class='succsess'>Comment succsessfully created.</span>";

	/**
	 * @var string
	 */
	private $nameMsg = "";
	private $emailMsg = "";
	private $commentMsg = "";
	private $captchaMsg = "";
	private $msg = "";

	public $captchaAnswer = "";

	public function __construct(\model\Captcha $captcha) {
		$this->captcha = $captcha;
	}

	/**
	 * @param  \model\Post
	 * @return string HTML
	 * @todo 2. website, formatera.
	 * @todo 3. när man klickar submit så åker sidan upp.
	 */
	public function getCommentHTML(\model\Post $post) {
		$name = $this->getCommentAuthor();
		$email = $this->getCommentEmail();
		$website = $this->getCommentWebsite();
		$comment = $this->getCommentText();

		$nr1 = $this->captcha->getCaptchaNr1();
		$nr2 = $this->captcha->getCaptchaNr2();
		$this->captchaAnswer = $this->captcha->getCaptchaAnswer();

		$html = "<div>
					<h3>Comments</h3>
					<p>$this->msg</p>
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
						<label class='form-label'>Captcha</label>
						<p>What is $nr1 + $nr2</p>
						<div class='controls'>
							<input class='form-control' type='text' value='' name='" . self::$commentCaptcha . "'>$this->captchaMsg
						</div>
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

	/**
	 * @todo Får jag köra unset ?
	 */
	public function commentSuccsess() {
		$this->msg = self::$commentSuccsess;
		unset($_POST);
	}

	public function commentFaild() {
		if (strlen($this->getCommentAuthor()) < 3) {
			$this->nameMsg = self::$requiredNameMsg;
		}
		if ($this->hasTags($this->getCommentAuthor())) {
			$this->nameMsg = self::$invalidCharacters;
		}
		if (!filter_var($this->getCommentEmail(), FILTER_VALIDATE_EMAIL)) {
			$this->emailMsg = self::$requiredEmailMsg;
		}
		if (strlen($this->getCommentText()) < 5) {
			$this->commentMsg = self::$requiredCommentMsg;
		}
		if (strlen($this->getCaptcha()) < 1) {
			$this->captchaMsg =  self::$requiredcaptchaMsg;
		}
		if ($this->captchaAnswer != $this->getCaptcha()) {
			$this->captchaMsg =  self::$requiredcaptchaMsg2;
		}
	}

	public function getNewComment() {
		try {
			return \model\Comment::createCommentFromUser($this->getCommentAuthor(),
														 $this->getCommentEmail(),
														 $this->getCommentWebsite(),
														 $this->getCommentText(),
														 $this->getPostId());
		} catch(\Exception $e) {
			throw $e;
		}
	}

	/**
	 * @todo sträng beroende.
	 */
	public function getPostId() {
		return $_GET["postID"];
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

	/**
	 * @return string
	 */
	public function getCommentEmail() {
		if (!empty($_POST[self::$commentEmail])) {
			return $_POST[self::$commentEmail];
		} else {
			return "";
		}
	}

	/**
	 * @return string
	 */
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
			return htmlspecialchars($_POST[self::$commentText]);
		} else {
			return "";
		}
	}

	/**
	 * @return string
	 */
	public function getCaptcha() {
		if (!empty($_POST[self::$commentCaptcha])) {
			return $_POST[self::$commentCaptcha];
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

	public function hasTags($string) {
		if ($string != strip_tags($string)) {
			return true;
		} else {
			return false;
		}
	}
}