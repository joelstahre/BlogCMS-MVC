<?php

namespace view;

/**
 *@todo 1. href='?admin&settings bättre sätt?
 */
class AdminView {

	/**
	 * @var string
	 */
	private static $logOut = "logout";

	/**
	 * @var string
	 */
	private static $newPost = "newPost";

	/**
	 * @var string
	 */
	private static $allPost = "allPosts";

	/**
	 * @var string
	 */
	private static $allComments = "allComments";

	/**
	 * @var string
	 */
	private static $allCategories = "allCategories";


	/**
	 * @return string html
	 */
	private function getHeader() {
		$blogName = \common\Config::get("blogTitle");
		$path = \common\Config::get("appPath");
		$html = "<div class='navbar navbar-inverse' role='navigation'>
			     	<div class='container'>
			        	<div class='navbar-header'>
			          		<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
			            		<span class='icon-bar'></span><span class='icon-bar'></span><span class='icon-bar'></span>
			          		</button>
			          		<a class='navbar-brand' href='$path'>$blogName</a>
			        	</div>
			       		<div class='collapse navbar-collapse'>
			          		<ul class='nav navbar-nav'>
			            		<li class='active'>
			              			<a href='?admin'>Start</a>
			            		</li>
			            		<li>
			              			<a href='?admin&settings'>Settings</a>
			            		</li>
			            		<li>
			              			<a href='?admin&" . self::$logOut . "'>Logout</a>
			            		</li>
			          		</ul>
			       		</div>
			      	</div>
			    </div>";
		return $html;
	}

	/**
	 * @return string html
	 */
	private function getFooter() {
		$blogFooter = \common\Config::get("blogFooter");
		$html = "<footer class='adminFooter'>
			    	<p>$blogFooter</p>
			    </footer>";
		return $html;
	}

	/**
	 * @param array of arrays with post and comment objects
	 * @return string html
	 */
	public function getFrontPage($stats) {
		$html = $this->getHeader();
		$html .= "<div class='container'>
					<div class='inner-container'>";
		$html .= $this->getSideBar();
		$html .= $this->getMainContent($stats);

		$html .= "</div>";
		$html .=	"<hr>";
		$html .= $this->getFooter();
		$html .= "</div>";

		return $html;
	}

	/**
	 * @return string html
	 */
	public function getContentPage($content) {
		$html = $this->getHeader();
		$html .= "<div class='container'>
					<div class='inner-container'>";
		$html .= $this->getSideBar();
		$html .= $content;

		$html .= 	"</div>";
		$html .=	"<hr>";
		$html .= $this->getFooter();
		$html .= "</div>";

		return $html;
	}

	/**
	 * @return string html
	 */
	public function getSideBar() {
		$html = "<div>
			       <div class='adminSidebar' id='sidebar' role='navigation'>
					<div class='well sidebar-nav'>
				        <ul class='nav nav-pills nav-stacked'>
				            <li>Posts</li>
				            <li>
				                <a href='?admin&" . self::$newPost . "'><span class='glyphicon glyphicon-pencil'></span> New Post</a>
				            </li>
				            <li>
				                <a href='?admin&" . self::$allPost . "'><span class='glyphicon glyphicon-list'></span> Manage Posts</a>
				            </li>
				            <li>Comments</li>
				            <li>
				                <a href='?admin&" . self::$allComments . "'><span class='glyphicon glyphicon-list-alt'></span> Manage Comments</a>
				            </li>
				            <li>Categories</li>
				            <li>
				                <a href='?admin&" . self::$allCategories . "'><span class='glyphicon glyphicon-pushpin'></span> Manage Categories</a>
				            </li>
				        </ul>
				    </div>
				    </div>
			     </div>";

        return $html;
	}

	public function getMainContent($stats) {
		$posts =  count($stats[0]);
		$comments = count($stats[1]);
		$categories = count($stats[2]);

		$commentsArray = $stats[1];

		$recentComments = array_slice($commentsArray, 3);

		$htmlComment = "";
		foreach ($recentComments as $comment) {
			$content = $comment->getComment();
			$htmlComment .= "<p>$content</p>";
		}

		$html = "<div class='adminContent'>
					<h2><span class='glyphicon glyphicon-dashboard'></span> Dashboard</h2>
					<div class='widget-box'>
						<div class='panel panel-default'>
						  <div class='panel-heading'>
						  	<h3 class='panel-title'><span class='glyphicon glyphicon-stats'></span> Blog Statistics</h3>
						  </div>
						  <div class='panel-body'>
						    <p>$posts Posts</p>
							<p>$comments Comments</p>
							<p>$categories Categories</p>
						  </div>
						</div>
					</div>
					<div class='widget-box'>
						<div class='panel panel-default'>
						  <div class='panel-heading'>
						  	<h3 class='panel-title'><span class='glyphicon glyphicon-list-alt'></span> Recent Comments</h3>
						  </div>
						  <div class='panel-body'>
						    $htmlComment
						  </div>
						</div>
					</div>
				</div>";

		return $html;
	}

	/**
	 * @return boolian
	 */
	public function newPost() {
		return isset($_GET[self::$newPost]);
	}

	/**
	 * @return boolian
	 */
	public function allPosts() {
		return isset($_GET[self::$allPost]);
	}

	/**
	 * @return boolian
	 */
	public function allComments() {
		return isset($_GET[self::$allComments]);
	}

	public function allCategories() {
		return isset($_GET[self::$allCategories]);
	}

	/**
	 * @return boolian
	 */
	public function settings() {
		return isset($_GET['settings']);
	}

	/**
	 * @return boolian
	 */
	public function logOut() {
		return isset($_GET[self::$logOut]);
	}


}