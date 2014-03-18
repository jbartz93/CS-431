<?php
  ini_set('display_errors', 'On');
  error_reporting(E_ALL);

  session_start();

  $needsToBeLoggedIn = (isset($needsToBeLoggedIn) && !$needsToBeLoggedIn) ? false : true;

  if(isset($_SESSION["Id"])) {
    $userId = $_SESSION["Id"];
  }
  else {
    $userId = null;
  }

  require_once 'helpers/Database.php';

  try {
    $db = new Database();
  }
  catch (Exception $e) {
    die("Error: " . $e);
  }

  define('BASE_URL', 'http://jj431.herokuapp.com/project3/');
?>