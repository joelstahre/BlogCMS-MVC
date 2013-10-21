<?php

namespace view;

require_once("src/blog/view/CommentView.php");

class PostView {

	private $commentView;

	private static $postIDHolder = "postID";

	public function __construct(\view\CommentView $commentView) {
		$this->commenView = $commentView;
	}


	/**
	 * @param array of \model\Post objects
	 * @return string HTML
	 * @todo hårdkodat css
	 */
	public function getAllPostsHTML($posts) {

		$html = "";

		foreach ($posts as $post) {

			$id = $post->getId();
			$author = $post->getAuthor();
			$title = $post->getTitle();
			$content = $post->getContent();
			$preViewContent = $this->getPreviewContent($content);
			$createDate = $post->getCreateDate();
			$commentCount = count($post->getComments());

			$html .= "<div class='post'>
						<h2 class='post-title'><a href='?" . self::$postIDHolder . "=$id'>$title</a></h2>
						<div class='post-header'>
							<span>Posted by <span class='post-header-author'>$author</span> at <span>$createDate </span><span>Category: </span><span class='post-header-comment'>$commentCount comments</span>
						</div>
						<div class='post-content'>$preViewContent</div>
						<a href='?" . self::$postIDHolder . "=$id' class='btn btn-primary' id='readmore'>Read More</a>
					</div>";
		}

		return $html;
	}


	/**
	 * @param \model\Post objects
	 * @return string HTML
	 * @todo hårdkodat css
	 */
	public function getSinglePostHTML(\model\Post $post) {

		$id = $post->getId();
		$author = $post->getAuthor();
		$title = $post->getTitle();
		$content = $post->getContent();
		$createDate = $post->getCreateDate();
		$commentCount = count($post->getComments());

		$comments = $this->commenView->getCommentHTML($post);

		$html = "<div class='post'>
						<h2 class='post-title'><a href='?" . self::$postIDHolder . "=$id'>$title</a></h2>
						<div class='post-header'>
							<span>Posted by <span class='post-header-author'>$author</span> at <span>$createDate </span><span>Category: </span><span class='post-header-comment'>$commentCount commens</span>
						</div>
						<p>$content</p>
						$comments
					</div>";

		return $html;
	}


	public function getPreviewContent($string) {
		$preViewString = substr($string,0,strrpos(substr($string,0,650),' ')) . "...";
		return $preViewString;
	}

}