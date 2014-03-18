<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $pageTitle; ?></title>
  </head>
  <body>
<?php if ($userId) { ?>
    <a href="<?php echo BASE_URL ?>logout.php">Log Out</a>
<?php
  } else if (!$userId && $needsToBeLoggedIn) {
    die("You need to be logged in to view this");
  }
?>