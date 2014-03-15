<?php
  $pageTitle = "Login";
  include('helpers/header.php');

  if ($userId) {
    $query = "SELECT Name FROM Users WHERE Id=? LIMIT 1";

    try {
      $db->makeQuery($query, $userId);
    }
    catch (Exception $e) {
      die("Error: " . $e);
    }

    $numRows = $db->numRows;

    if($numRows == 1) {
      echo "Welcome " . $db->result[0]['Name'];
    }
  }
  else {
?>

    <form method="post" action="loginsubmit.php">
      <input type="text" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit">Login</button>
    </form>

<?php

  }

  include('helpers/footer.php');
?>