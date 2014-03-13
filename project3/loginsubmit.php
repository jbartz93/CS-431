<html>
<head>
</head>
<body>
<h2>hello</h2>

<?php

session_start();

print "hellooo";

$email = $_GET['email'];
$password = $_GET['password'];

include 'account.php';

$mysql = mysqli_connect($hostname, $username, $password, $database);
if (mysqli_connect_errno($mysql)) {
  print "Error: " . mysqli_connect_error($mysql);
  exit();
}

$userStatement = mysqli_prepare($mysqli, "SELECT Id, Name FROM Users WHERE Email=$email AND Password=SHA1($password) LIMIT 1";

mysqli_stmt_execute($userStatement) or die ("Error: " . mysqli_error($mysql));

mysqli_stmt_bind_result($userStatement, $userId, $userName);
mysqli_stmt_store_result($userStatement);

if(mysqli_stmt_num_rows($userStatement) == 0) {
  print "User does not exist";
  exit();
}
else {
  $_SESSION["Id"] = $userId;
}

print "Welcome $userName";
?>

</body>
</html>
