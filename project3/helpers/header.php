<?php
  session_start();

  ini_set('display_errors', 'On');
  error_reporting(E_ALL);

  if(isset($_SESSION["Id"])) {
    $userId = $_SESSION["Id"];
  }
  else {
    $userId = null;
  }

  echo $_SESSION["Id"];
  echo "hello johnny";

  require_once 'helpers/Database.php';

  try {
    $db = new Database();
  }
  catch (Exception $e) {
    die("Error: " . $e);
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $pageTitle; ?></title>
  </head>
  <body>

