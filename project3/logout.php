<?php
  include('helpers/header.php');

  session_destroy();

  header("Location: http://cs431jjs.herokuapp.com/project3/logout.php");
  exit();

  include("helpers/footer.php");
?>