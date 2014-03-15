<?php
include('helpers/header.php');

$userEmail = $_POST['email'];
$userPassword = $_POST['password'];

$query = sprintf("SELECT Id, Name FROM Users WHERE Email='%s' AND Password=SHA1('%s') LIMIT 1", mysql_real_escape_string($userEmail), mysql_real_escape_string($userPassword));

echo $db->makeQuery($query);

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

print "Welcome $userName";

include("helpers/footer.php");
?>