<?php
  session_start();

  ini_set('display_errors', 'On');
  error_reporting(E_ALL);

  require_once 'helpers/Database.php';

  $db = new Database();
?>

<html>
  <head>
    <title><?php echo $pageTitle; ?></title>
  </head>
  <body>

