<?php

namespace view;
require_once("Config.php");

class BlogView {

	private $postView;
	
	private $allPosts;

	private static $postIDHolder = "postID";

	public function __construct(\view\PostView $postView) {
		$this->postView = $postView;
	}

	private static $admin = "admin";


	/**
	 * @return string HTML
	 */
	private function getHeader() {

		$blogTitle = \common\Config::get("blogTitle");
		$path = \common\Config::get("appPath");

		$html = "<div id='container'>
					<header id='header'>
						<h1><a href='$path'>$blogTitle</a></h1>
					</header>";
		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getFooter() {
		$blogFooter = \common\Config::get("blogFooter");
		$html = "<footer id='footer'>$blogFooter</footer>
				</div>";
		return $html;
	}


	/**
	 * @param array of \model\Post objects
	 */
	public function getFrontPage($allPosts) {

		$html = $this->getHeader();
		$html .= "<div id='main'>
				  	<div id='main_left'>";
		$html .= $this->postView->getAllPostsHTML($allPosts);
		$html .= "	</div>
					<div id='main_right'>";
		$html .= $this->getSideBar($allPosts);
		$html .= "  </div>
				 </div>";

		$html .= $this->getFooter();
		return $html;
	}

	/**
	 * @return string HTML
	 */
	public function getSinglePage(\model\Post $post, $allPost) {

		$html = $this->getHeader();
		$html .= "<div id='main'>
				  	<div id='main_left'>";
		$html .= $this->postView->getSinglePostHTML($post);
		$html .= "	</div>
					<div id='main_right'>";
		$html .= $this->getSideBar($allPost);
		$html .= "  </div>
				 </div>";

		$html .= $this->getFooter();
		return $html;
	}

	public function getErrorPage($allPost) {
		$html = $this->getHeader();
		$html .= "<div id='main'>
				  	<div id='main_left'>";
		$html .= $this->postView->getError();
		$html .= "	</div>
					<div id='main_right'>";
		$html .= $this->getSideBar($allPost);
		$html .= "  </div>
				 </div>";

		$html .= $this->getFooter();
		return $html;
	}

	public function getSideBar($allPosts) {
	    
	    $postArray = array_slice($allPosts, 0, 3);

		$html = "<div class='col-xs-10 '>
					<div class='well' id='well'>
						<hr>
	           			<ul class='nav'>
			              <li><b>Latest Posts</b></li>";
			              
			              foreach($postArray as $post) {
			                   $id = $post->getID(); 
                    	       $title = $post->getTitle();
                    	       $html .= "<li><a href='?" . self::$postIDHolder . "=$id'>$title</a></li>";
                    	  }
			              
			    $html .= "
			              <hr>
	            		</ul>
	          		</div>
	          	</div>";

        return $html;
	}


	/**
	 * @return boolian
	 */
	public function viewSingle() {
		return isset($_GET[self::$postIDHolder]);
	}

	/**
	 * @return string
	 */
	public function getPostId() {
		return $_GET[self::$postIDHolder];
	}


	public function admin() {
		return isset($_GET[self::$admin]);
	}

}
