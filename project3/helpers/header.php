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
<?php if ($userId) { ?>
    <a href="http://cs431jjs.herokuapp.com/project3/logout.php">Log Out</a>
<?php } ?>
