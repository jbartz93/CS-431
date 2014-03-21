<?php>
	$pageTitle="Register for Courses";
	include('helpers/base.php');
	include('helpers/header.php');
?>
<h3>Courses you are in</h3>
<table>
<tr>
	<th>Course Number</th>
	<th>Course Title</th>
	<th>Credits</th>
	<th>Drop</th>
	<?php
		$courses = "select CourseInstances.Id as Id, Abbreviation, CourseNumber, Title, CreditValue from Courses " .
									"join Departments on Departments.Id = Courses.DeptId " .
									"join CourseInstances on CourseInstances.CourseId = Courses.Id " . 
									"join Registration on Registration.CourseInstanceId = CourseInstances.Id " .
									"where UserId = ? order by Semester, Abbreviation, CourseNumber";
		$db->makeQuery($courses, $userId);
		$totalGPA = 0;
		$totalCredits = 0;
		foreach($db->result as $row)
		{
			print "<tr><td>".$row['Abbreviation'] . $row['CourseNumber']. "</td><td>".$row['Title']."</td><td>".$row['CreditValue']."</td>";
	?>
			<td><form method='get' action='dropsubmit.php?courseId=<?php echo $row['Id']?>'><button type='submit'>Drop</button></form></td></tr>
	<?php
			$totalGPA += $gpa*$credits;
			$totalCredits += $credits;
		}
	?>
</table>
<h3>Register</h3>
Enter new courses by id:
<form method='get' action='registersubmit.php'>
	<input type=text name='c1' required>
	<input type=text name='c2'>
	<input type=text name='c3'>
	<input type=text name='c4'>
	<input type=text name='c5'>
	<input type=text name='c6'>
</form>
<?php>
	include('helpers/footer.php');
?>