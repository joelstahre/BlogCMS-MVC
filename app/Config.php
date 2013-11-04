<?php
namespace common;
require_once("src/dal/ConfigDAL.php");

class Config {

	protected static  $config = array();

	protected static $configDAL;

	private function __construct() {}

	public static function set ($key, $value) {
		self::$config[$key] = $value;

		self::writeSettingsToDB($key, $value);
	}

	public static function get($key) {
		return self::$config[$key];
	}

	public static function loadSettings(\mysqli $mysqli) {
		self::$configDAL = new \dal\ConfigDAL($mysqli);
		self::$configDAL->loadSettings();
	}

	private static function writeSettingsToDB($key, $value) {
		self::$configDAL->write($key, $value);
	}
}