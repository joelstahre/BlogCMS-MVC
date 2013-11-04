<?php

namespace view;

require_once("src/blog/view/CommentView.php");
require_once("src/blog/view/Pagenation.php");

class PostView {

	private $commentView;
	private $postView;

	private static $postIDHolder = "postID";

	const numberOfPostPerPage = 3;

	public function __construct(\view\CommentView $commentView) {
		$this->commenView = $commentView;
		$this->pagination = new \view\Pagenation();

	}

	/**
	 * @param array of \model\Post objects
	 * @return string HTML
	 */
	public function getAllPostsHTML($posts) {
	    
	    if($posts == null) {
	        return  "<div class='post'>
						No posts aviable!
					</div>";
	    }

		$this->pagination->init($posts, self::numberOfPostPerPage);

        $posts = $this->pagination->getPagenationResults();

        $pageNumbers = "<div class='pagenation'>" . $this->pagination->getLinks() . "</div>";

        $html = "";

        foreach ($posts as $post) {

        $id = $post->getId();
		$author = $post->getAuthor();
		$title = $post->getTitle();
		$content = $post->getContent();
		$preViewContent = $this->getPreviewContent($content);
		$createDate = $post->getCreateDate();
		$categories = $post->getCategories();
		$commentCount = count($post->getComments());

		$categoryString = "";
		foreach ($categories as $category) {
			$categoryString .= "$category | ";
		}

		$html .= "<div class='post'>
						<h2 class='post-title'><a href='?" . self::$postIDHolder . "=$id'>$title</a></h2>
						<div class='post-header'>
							<span>Posted by
								<span class='post-header-author'>$author</span>
									at <span>$createDate </span><span>Category: $categoryString</span>
										<span class='post-header-comment'>
											<span class='badge'>$commentCount</span> comments</span>
						</div>
						<div class='post-content'>$preViewContent</div>
						<a href='?" . self::$postIDHolder . "=$id' class='btn btn-primary' id='readmore'>Read More</a>
					</div>";
        }

        $html .= $pageNumbers;

        return $html;
	}


	/**
	 * @param \model\Post objects
	 * @return string HTML
	 */
	public function getSinglePostHTML(\model\Post $post) {

		$id = $post->getId();
		$author = $post->getAuthor();
		$title = $post->getTitle();
		$content = $post->getContent();
		$createDate = $post->getCreateDate();
		$categories = $post->getCategories();
		$commentCount = count($post->getComments());

		$comments = $this->commenView->getCommentHTML($post);

		$categoryString = "";
		foreach ($categories as $category) {
			$categoryString .= "$category | ";
		}

		$formatedContent = $this->formatContent($content);

		$html = "<div class='post'>
						<h2 class='post-title'><a href='?" . self::$postIDHolder . "=$id'>$title</a></h2>
						<div class='post-header'>
							<span>Posted by <span class='post-header-author'>$author</span> at <span>$createDate </span><span>Category: $categoryString</span><span class='post-header-comment'><span class='badge'>$commentCount</span> comments</span>
						</div>
						<p>$formatedContent</p>
						$comments
					</div>";

		return $html;
	}



	public function formatContent($content) {

		$formatedContent = $content;

		preg_match_all('/^<code>(.*?)<\/code>/smi', $content, $matches);

		$stringsToReplace = array();
		foreach ($matches[1] as $match) {
			$stringsToReplace[] = $match;
		}

		foreach ($stringsToReplace as $key) {
			$newValue = "<code>" . htmlspecialchars($key) . "</code>";
			$formatedContent= preg_replace('/^<code>(.*?)<\/code>/smi', $newValue, $content);
		}

		return $formatedContent;
	}






	public function getError() {
		return "Post do not exist!";
	}


	public function getPreviewContent($string) {
		$striptString = strip_tags($string);
		$preViewString = substr($striptString,0,strrpos(substr($striptString,0,750),' ')) . "...";
		return $preViewString;
	}

}