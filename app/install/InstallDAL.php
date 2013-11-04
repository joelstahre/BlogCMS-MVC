<?php

namespace model;

class InstallDAL {

	private $mysqli;

  private $install;

	public function __construct(\mysqli $mysqli) {
		$this->mysqli = $mysqli;
	}

	public function createTables() {

    $this->install = include("install.php");
		$this->settingsTable($this->install["tableSql"]["settings"]);
		$this->categoryTable($this->install["tableSql"]["category"]);
		$this->commentTable($this->install["tableSql"]["comments"]);
		$this->postTable($this->install["tableSql"]["post"]);
		$this->postcategoryTable($this->install["tableSql"]["postcat"]);
		$this->userTable($this->install["tableSql"]["user"]);
	}


	public function settingsTable($sql) {
    $this->query($sql);
	}

	public function categoryTable($sql) {
    $this->query($sql);
	}

	public function commentTable($sql) {
    $this->query($sql);
	}

	public function postTable($sql) {
    $this->query($sql);
	}

	public function postcategoryTable($sql) {
    $this->query($sql);
	}

	public function userTable($sql) {
    $this->query($sql);
	}


  public function insertDeafaultSetting($key, $value) {
    $sql = $this->install["insertSql"]["settings"];
    $statement = $this->prepare($sql);

    if ($statement->bind_param("ss", $key, $value) === FALSE) {
      throw new \Exception("InstallDAL:: bind_param of $sql failed " . $statement->error);
    }

    $this->execute($statement);
	}


	public function defaultPost($author, $title, $content) {
    $sql = $this->install["insertSql"]["post"];
    $statement = $this->prepare($sql);

    if ($statement->bind_param("sss", $author, $title, $content) === FALSE) {
        throw new \Exception("PostDAL:: bind_param of $sql failed " . $statement->error);
    }

    $this->execute($statement);
	}


	public function defaultCategory($category) {
    $sql = $this->install["insertSql"]["category"];
    $statement = $this->prepare($sql);

    if ($statement->bind_param("s", $category) === FALSE) {
        throw new \Exception("PostDAL:: bind_param of $sql failed " . $statement->error);
    }

    $this->execute($statement);
	}

  private function query($sql) {
    if ($this->mysqli->query($sql) === FALSE) {
      throw new \Exception("'$sql' failed " . $this->mysqli->error);
    }
  }


	private function prepare($sql) {
    $statement = $this->mysqli->prepare($sql);
    if ($statement === FALSE) {
        throw new \Exception("InstallDAL:: prepare of $sql failed " . $this->mysqli->error);
    }
    return $statement;
  }

  private function execute($statement) {
    if ($statement->execute() === FALSE) {
        throw new \Exception("InstallDAL:: execute of $sql failed " . $statement->error);
    }
  }
}