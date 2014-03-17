<?php
  $needsToBeLoggedIn = false;
  include('helpers/header.php');

  $userEmail = $_POST['email'];
  $userPassword = $_POST['password'];

  $query = "SELECT Id, Name FROM Users WHERE Email=? AND Password=SHA1(?) LIMIT 1";

  try {
    $db->makeQuery($query, $userEmail, $userPassword);
  }
  catch (Exception $e) {
    die("Error: " . $e);
  }

  $numRows = $db->numRows;

  if($numRows == 1) {
    foreach ($db->result as &$row) {
      $userId = $row['Id'];
      $userName = $row['Name'];
      $_SESSION["Id"] = $userId;
    }
  }
  else {
    die("User does not exist");
  }

  header("Location: http://cs431jjs.herokuapp.com/project3/main.php");
  exit();

  print "Welcome $userName";

  include("helpers/footer.php");
?>