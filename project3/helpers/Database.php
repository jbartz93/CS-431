<?php

class Database {
  private $connection = null;
  private $db = null;

  private $hostname = "us-cdbr-east-05.cleardb.net";
  private $username = "bc05f276159d04";
  private $password = "cab4ffa7";
  private $database  = "heroku_ad3d13b38fcc39e";

  public $result = array();

  public $error = null;

  public function __construct() {
    $this->connection = mysql_connect($this->hostname, $this->username, $this->password);

    if (!$this->connection) {
      $this->error = mysql_error();
    }

    $this->db = mysql_select_db($this->database, $this->connection);

    if (!$this->db) {
      $this->error = mysql_error();
    }
  }

  public function makeQuery($query) {
    $mysqlResult = mysql_query($query, $this->connection);

    while($row = mysql_affected_rows($mysqlResult)) {
      $this->result[] = $row;
    }

    print_r($this->result);

    if (!$this->result) {
      $this->error = mysql_error();
    }
  }
}

?>
