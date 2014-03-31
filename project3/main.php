<?php
	$pageTitle = "431 University";
	$permissions = true;
	include('helpers/base.php');
	include('helpers/header.php');
?>
<ul>
<li><a href="viewgrades.php">View Grades</a></li>
<li><a href="register.php">Add/Drop/View Courses</a></li>
<?php
	if($granted['GiveGrade'] == 1 or $granted['ChangeAllGrades'] == 1)
	{
		print '<li><a href="assigngrades.php">Assign grades</a></li>';
	}
	if($granted['AddCourses'] == 1)
	{
		print '<li><a href="addCourse.php">Add courses</a></li>';
	}
?>
<li><a href="userlookup.php">User Lookup</a></li>
<li><a href="courselookup.php">Course lookup</a></li>
</ul>
<?php
	include('helpers/footer.php');
?>