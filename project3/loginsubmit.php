<?php
include('helpers/header.php');

$userEmail = $_POST['email'];
$userPassword = $_POST['password'];

$db = new Database();

// include('../account.php');

// $mysql = mysql_connect($hostname, $username, $password);

// if (!$mysql) {
//   die('Not connected: ' . mysql_error());
// }

// $db = mysql_select_db($database, $mysql);

// if (!$db) {
//   die("Can't use database: " . mysql_error());
// }

$query = sprintf("SELECT Id, Name FROM Users WHERE Email='%s' AND Password=SHA1('%s') LIMIT 1", mysql_real_escape_string($userEmail), mysql_real_escape_string($userPassword));

$db->makeQuery($query);

// $result = mysql_query($query);

if (!$db->result) {
  die("Invalid Query: " . $db->result);
}

$numRows = mysql_num_rows($db->result);

if($numRows == 1) {
  while ($row = mysql_fetch_assoc($db->result)) {
    $userId = $row['Id'];
    $userName = $row['Name'];
    $_SESSION["Id"] = $userId;
  }
}
else {
  die("User does not exist");
}

print "Welcome $userName";

mysql_free_result($db->result);

include("helpers/footer.php");
?>