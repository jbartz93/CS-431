<html>
<head>
</head>
<body>
<h2>hello</h2>

<?php

phpinfo();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();

print "hellooo";

$userEmail = $_POST['email'];
$userPassword = $_POST['password'];

include('../account.php');

$mysql = mysql_connect($hostname, $username, $password, $database) or die(mysql_error());

print $mysql;

print("hola");

$userStatement = mysqli_query($mysql, "SELECT Id, Name FROM Users WHERE Email=$userEmail AND Password=SHA1($userPassword) LIMIT 1");

mysql_stmt_execute($userStatement) or die ("Error: " . mysql_error($mysql));

print "what's up";

mysql_stmt_bind_result($userStatement, $userId, $userName);

print "helloooooooooo";

mysql_stmt_store_result($userStatement);

print "this is up";

if(mysql_stmt_num_rows($userStatement) == 0) {
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
