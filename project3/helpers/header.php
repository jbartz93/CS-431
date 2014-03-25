<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $pageTitle; ?></title>
  	<link rel="stylesheet" type="text/css" href="styles.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  </head>
  <body>

<?php
  $needsToBeLoggedIn = (isset($needsToBeLoggedIn) && !$needsToBeLoggedIn) ? false : true;

  if ($userId) {
?>
	<a href="<?php echo BASE_URL ?>main.php">Home</a>
    <a href="<?php echo BASE_URL ?>logout.php">Log Out</a>
<?php
  } else if (!$userId && $needsToBeLoggedIn) {
    die("You need to be <a href='".BASE_URL."login.php'>logged in</a> to view this");
  }
?>