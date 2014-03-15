<?php

class Database {
  private $connection = null;
  private $db = null;

  private $hostname = "us-cdbr-east-05.cleardb.net";
  private $username = "bc05f276159d04";
  private $password = "cab4ffa7";
  private $database  = "heroku_ad3d13b38fcc39e";

  public $result = array();
  public $numRowsReturned = 0;
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
    $curQueryArgs = func_get_args();
    print_r($curQueryArgs);
    $query = array_shift($curQueryArgs);

    $newQuery = $this->formatQuery($query, $curQueryArgs);
    echo $newQuery;

    $mysqlResult = mysql_query($query, $this->connection);

    while($row = mysql_fetch_assoc($mysqlResult)) {
      $this->result[] = $row;
    }

    $this->numRowsReturned = mysql_num_rows($mysqlResult);

    if (!$this->result) {
      $this->error = mysql_error();
    }
  }

  public function formatQuery($query, $queryArgs) {
    $pieces = split("?", $query);
    $newQuery = "";

    print_r($pieces);
    print_r($queryArgs);

    for($i = 0; $i < $pieces.length(), $i++)
      $newQuery .= $newQuery[$i];
      if ($i < $queryArgs.length()) {
        $newQuery .= $queryArgs[$i];
      }
    }

    return $newQuery;
  }
}

?>
