<?php

class Database {
  private $connection = null;
  private $db = null;

  private $hostname = "us-cdbr-east-05.cleardb.net";
  private $username = "bc05f276159d04";
  private $password = "cab4ffa7";
  private $database  = "heroku_ad3d13b38fcc39e";

  public $result = array();
  public $numRows = 0;

  public function __construct() {
    $this->connection = mysql_connect($this->hostname, $this->username, $this->password);

    if (!$this->connection) {
      throw new Exception("Invalid database connection:" . mysql_error());
    }

    $this->db = mysql_select_db($this->database, $this->connection);

    if (!$this->db) {
      throw new Exception("Invalid database connection:" . mysql_error());
    }
  }

  public function makeQuery() {
    // reseting variables that change from request to request
    $this->result = array();
    $this->numRows = 0;

    $args = func_get_args();
    $query = array_shift($args);

    $query = $this->formatQuery($query, $args);

    $mysqlResult = mysql_query($query, $this->connection);

    if (!$mysqlResult) {
      throw new Exception("Invalid Query:" . mysql_error());
    }

    // hacky way to figure out if the last query was a select
    if ($query[0] == 'S') {
      $this->numRows = mysql_num_rows($mysqlResult);

      while($row = mysql_fetch_assoc($mysqlResult)) {
        $this->result[] = $row;
      }
    }
  }

  private function formatQuery($query, $queryArgs) {
    $pieces = explode("?", $query);
    $newQuery = "";

    foreach($queryArgs as &$arg) {
      if (is_string($arg)) {
        $arg = mysql_real_escape_string($arg);
      }
    }

    for($i = 0; $i < count($pieces); $i++) {
      $newQuery .= $pieces[$i];
      if ($i < count($queryArgs)) {
        if (is_string($queryArgs[$i])) {
          $newQuery .= "'";
        }
        $newQuery .= $queryArgs[$i];
        if (is_string($queryArgs[$i])) {
          $newQuery .= "'";
        }
      }
    }

    return $newQuery;
  }
}

?>
