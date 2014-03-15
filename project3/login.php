<?php
  $pageTitle = "Login";
  include('helpers/header.php');

  if ($userId) {
    echo "Welcome $userId";
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