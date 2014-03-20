<?php
$pageTitle = "Register";
$needsToBeLoggedIn = false;
include('helpers/header.php');
include('helpers/base.php');
?>
<h2>Welcome to our incredibly insecure system!</h2>
<form method="post" submit="registersubmit.php">
Name: <input type="text" required name="name"><br>
Password: <input type="password" required name="password"><br>
Email: <input type="email" required name="email"><br>
Department:<br>
<?php
try
{
	$db->makeQuery("select Id, FullName from departments");
}
catch(Exception $e)
{
	echo $e->getMessage();
}
if($db->numRows == 0)
{
	print "There are no departments at this school<br>";
}
foreach($db->result as $row)
{
	print "<input type='radio' name='department' value='" . $row['$Id'] . "' required>" . $row['FullName'] . "<br>";
}
?>
<br>
What permissions would you like?<br>
<input type="checkbox" name="givegrade"> Give Grades<br>
<input type="checkbox" name="viewall"> View All Grades<br>
<input type="checkbox" name="changeall"> Change Grades<br>
<input type="checkbox" name="addcourse"> Add Courses<br>
<button type="submit">Register</button>
</form>
<?php
include('helpers/footer.php');
?>