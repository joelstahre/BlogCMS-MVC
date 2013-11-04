<?php

namespace model;
require_once("install/InstallDAL.php");

class InstallModel {

	private $install;

	public function __construct(\mysqli $mysqli) {
		$this->installDAL = new \model\InstallDAL($mysqli);
		$this->install = include("install.php");
	}

	public function createTables() {
		$this->installDAL->createTables();
	}

	public function insertDeafaultSetting() {

		//ska hämta detta från install.php
		$index = $this->install["defaultData"]["title"]["index"];
		$value = $this->install["defaultData"]["title"]["value"];
		$this->installDAL->insertDeafaultSetting($index, $value);

		$index = $this->install["defaultData"]["footer"]["index"];
		$value = $this->install["defaultData"]["footer"]["value"];
		$this->installDAL->insertDeafaultSetting($index, $value);

		$index = $this->install["defaultData"]["appPath"]["index"];
		$value = $this->install["defaultData"]["appPath"]["value"];
		$this->installDAL->insertDeafaultSetting($index, $value);
	}

	public function createSampleData() {
		$author =  $this->install["sampleData"]["post"]["author"];
		$title = $this->install["sampleData"]["post"]["title"];
		$content = $this->install["sampleData"]["post"]["content"];

		$this->installDAL->defaultPost($author, $title, $content);

		$category = $this->install["defaultData"]["categories"];

		$this->installDAL->defaultCategory($category);

	}

	public function getAppPath() {
		$path = $_SERVER['PHP_SELF'];
		$remove = 'index.php';
		return $installPath = str_replace($remove, '', $path);
	}

}