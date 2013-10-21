<?php

namespace common\view;

class HTMLPage {

	/**
	 * @param  string
	 * @param  string
	 * @return string HTML
	 * @todo hårdkodat css
	 */
	public function getHTMLPage($title, $body) {
		return "
		<!DOCTYPE html>
		<html>
			<head>
				<title>$title</title>
				<meta http-equiv='content-type' content='text/html; charset=utf8' />
				<link rel='StyleSheet' href='css/style.css' type='text/css' />
				<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'/>
				<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>
			</head>
		<body>
			<div id='container'>
				$body
			</div>
		</body>
		</html>";
	}
}