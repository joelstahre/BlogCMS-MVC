<?php

namespace view;


class BlogView {

	private $postView;

	private static $postIDHolder = "postID";

	public function __construct(\view\PostView $postView) {
		$this->postView = $postView;
	}


	private static $admin = "admin";


	/**
	 * @return string HTML
	 * @todo hårdkodat css
	 * @todo hårdkodat länk
	 */
	private function getHeader() {
		$html = "<header id='header'>
					<h1><a href='http://127.0.0.1:8080/BlogProjekt/app/'>This is the blog header</a></h1>
				</header>";
		return $html;
	}

	/**
	 * @return string HTML
	 * @todo hårdkodat css
	 */
	private function getFooter() {
		$html = "<footer id='footer'>This is the blog footer </footer>";
		return $html;
	}


	/**
	 * @return string HTML
	 * @todo hårdkodat css
	 */
	public function getFrontPage($posts) {
		$html = $this->getHeader();
		$html .= "<div id='main'>
				  	<div id='main_left'>";
		$html .= $this->postView->getAllPostsHTML($posts);
		$html .= "	</div>
					<div id='main_right'>";
		$html .= $this->getSideBar();
		$html .= "  </div>
				 </div>";

		$html .= $this->getFooter();
		return $html;
	}

	/**
	 * @return string HTML
	 * @todo hårdkodat css
	 */
	public function getSinglePage($post) {
		$html = $this->getHeader();
		$html .= "<div id='main'>
				  	<div id='main_left'>";
		$html .= $this->postView->getSinglePostHTML($post);
		$html .= "	</div>
					<div id='main_right'>";
		$html .= $this->getSideBar();
		$html .= "  </div>
				 </div>";

		$html .= $this->getFooter();
		return $html;
	}

	public function getSideBar() {
		$html = "<div class='col-xs-10 '>
					<div class='well' id='well'>
						<div>
							<p><b>About this blog</b></p>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<hr>
	           			<ul class='nav'>
			              <li><b>Categories</b></li>
			              <li class='active'><a href='#''>Link</a></li>
			              <li><a href='#'>Link</a></li>
			              <li><a href='#''>Link</a></li>
			              <hr>
			              <li><b>Latest Posts</b></li>
			              <li><a href='#''>Link</a></li>
			              <li><a href='#'>Link</a></li>
			              <li><a href='#'>Link</a></li>
			              <hr>
			              <li><b>Most Popular</b></li>
			              <li><a href='#'>Link</a></li>
			              <li><a href='#'>Link</a></li>
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
