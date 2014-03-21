<?php
	$pageTitle = "431 University";
	include('helpers/base.php');
	include('helpers/header.php');
?>
<ul>
<li><a href="viewgrades.php">View Grades</a></li>
<li><a href="register.php">Add/Drop/View Courses</a></li>
<?php
	$query = "select GiveGrade, ChangeAllGrades, AddCourses from Permissions where UserId=? limit 1 ";
	try
	{
		$db->makeQuery($query, $userId);
	}
	catch(Exception $e)
	{
		die $e;
	}
	
	if($db->numRows == 0)
	{
		print "Database problem: user does not have permissions";
	}
	foreach($db->result as $row)
	{
		if($row['GiveGrade'] == 1 or $row['ChangeAllGrades'] == 1)
		{
			print '<li><a href="assigngrades.php">Assign grades</a></li>';
		}
		if($row['AddCourses'] == 1)
		{
			print '<li><a href="addcourses.php">Add courses</a></li>';
		}
	}
?>
<li><a href="userlookup.php">User Lookup</a></li>
<li><a href="courselookup.php">Course lookup</a></li>
</ul>
<?php
	include('helpers/footer.php');
?>