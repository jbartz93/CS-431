<?php
  include('helpers/base.php');

  session_destroy();

  header("Location: " . BASE_URL . "login.php");
  exit();
?>