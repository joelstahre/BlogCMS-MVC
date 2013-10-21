<?php
require_once("src/blog/controller/BlogController.php");
require_once("src/common/view/HTMLPage.php");
session_start();
$blogController = new \controller\BlogController();
$htmlPage = new \common\view\HTMLPage();

$body = $blogController->runApp();

echo $htmlPage->getHTMLPage("PHP Projekt 'Blog System'", "$body");
