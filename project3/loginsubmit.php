<html>
<head>
</head>
<body>
<h2>hello</h2>

<?php

session_start();

print "hellooo";

$email = $_POST['email'];
$password = $_POST['password'];

include('../account.php');

print "what's up?";

$mysql = mysqli_connect($hostname, $username, $password, $database);
if (mysqli_connect_errno($mysql)) {
  print "Error: " . mysqli_connect_error($mysql);
  exit();
}

print("hola");

$userStatement = mysqli_prepare($mysqli, "SELECT Id, Name FROM Users WHERE Email=$email AND Password=SHA1($password) LIMIT 1");

mysqli_stmt_execute($userStatement) or die ("Error: " . mysqli_error($mysql));

print "what's up";

mysqli_stmt_bind_result($userStatement, $userId, $userName);

print "helloooooooooo";

mysqli_stmt_store_result($userStatement);

print "this is up";

if(mysqli_stmt_num_rows($userStatement) == 0) {
  print "User does not exist";
  exit();
}
else {
  $_SESSION["Id"] = $userId;
}

print "me";
print "Welcome $userName";
?>

</body>
</html>
