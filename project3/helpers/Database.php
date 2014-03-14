<?php

class Database {
  private $connection = null;

  private $db = null;

  public $result = null;

  public $error = null;

  public function __construct() {
    include('../../account.php');

    $this->connection = mysql_connect($hostname, $username, $password);

    if (!$mysql) {
      $this->error = mysql_error();
    }

    $this->db = mysql_select_db($database, $mysql);

    if (!$this->db) {
      $this->error = mysql_error();
    }
  }

  public function makeQuery($query) {
    $this->result = mysql_query($query, $this->connection);

    if (!$this->result) {
      $this->error = mysql_error();
    }
  }
}

?>