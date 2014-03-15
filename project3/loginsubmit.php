<?php
include('helpers/header.php');

$userEmail = $_POST['email'];
$userPassword = $_POST['password'];

// $query = sprintf("SELECT Id, Name FROM Users WHERE Email='%s' AND Password=SHA1('%s') LIMIT 1", mysql_real_escape_string($userEmail), mysql_real_escape_string($userPassword));

$query = "SELECT Id, Name FROM Users WHERE Email=? AND Password=SHA1(?) LIMIT 1"

$db->makeQuery($query, $userEmail, $userPassword);

if (!$db->result) {
  die("Invalid Query: " . $db->result);
}

if($db->numRowsReturned == 1) {
  foreach ($db->result as &$row) {
    $userId = $row['Id'];
    $userName = $row['Name'];
    $_SESSION["Id"] = $userId;
  }
}
else {
  die("User does not exist");
}

print "Welcome $userName";

include("helpers/footer.php");
?>