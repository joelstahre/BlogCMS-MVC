<?php
require_once("src/blog/controller/BlogController.php");
require_once("install/InstallController.php");
require_once("src/common/view/HTMLPage.php");
session_start();

$settings = include("Settings.php");

$mysqli = new \mysqli($settings["db"]["hostname"],
					  $settings["db"]["dbuser"],
					  $settings["db"]["dbpassword"],
					  $settings["db"]["dbname"]);

$blogController = new \controller\BlogController($mysqli);
$htmlPage = new \common\view\HTMLPage();



if (file_exists("install.php")) {

	$installController = new \controller\InstallController($mysqli);
	$body = $installController->runInstall();
	echo $htmlPage->getHTMLPage("Installing your new awesome blog'", "$body");

} else {

	\common\Config::loadSettings($mysqli);
	$body = $blogController->runApp();
	echo $htmlPage->getHTMLPage("PHP Projekt 'Blog System'", "$body");
}


