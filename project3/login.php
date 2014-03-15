<?php

  include('helpers/footer.php');

  if ($userId) {
?>

    <form method="post" action="loginsubmit.php">
      <input type="text" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit">Login</button>
    </form>

<?php

  }
  else {
    echo "Welcome $userId";
  }

include('helpers/footer.php');
?>