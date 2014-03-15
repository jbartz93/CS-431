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

  public function makeQuery() {
    $args = func_get_args();
    $query = array_shift($args);
    $query = $this->splitQuery($query, $args);

    echo $query;

    $mysqlResult = mysql_query($query, $this->connection);

    if (!$mysqlResult) {
      $this->error = mysql_error();
    }

    $this->numRows = mysql_num_rows($mysqlResult);

    while($row = mysql_fetch_assoc($mysqlResult)) {
      $this->result[] = $row;
    }

  }

  public function splitQuery($query, $queryArgs) {
    $pieces = explode("?", $query);
    $newQuery = "";

    for($i = 0; $i < count($pieces); $i++) {
      $newQuery .= $pieces[$i];
      if ($i < count($queryArgs)) {
        $newQuery .= "'";
        $newQuery .= $queryArgs[$i];
        $newQuery .= "'";
      }
    }

    return $newQuery;
  }
}

?>
