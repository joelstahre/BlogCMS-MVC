<?php

namespace view;

class AdminView {


	public function getFrontPage() {
		$html = "<h1>Welcome!</h1>
				 <ul>
				 	<li>Posts</li>
				 	<li>Comments</li>
				 	<li>Users</li>
				 	<li>Settings</li>
				 </ul>";

		return $html;
	}
}