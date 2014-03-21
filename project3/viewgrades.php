<?php
$pageTitle="View Grades";
include('helpers/base.php');
include('helpers/header.php');
?>
<table>
	<tr>
	<th>Course Number</th>
	<th>Course Title</th>
	<th>Grade</th>
	<th>Credits</th>
	</tr>
	<?php
		$grades = "select Abbreviation, CourseNumber, Title, GradeGPA, CreditValue from Courses " .
									"join Departments on Departments.Id = Courses.DeptId " .
									"join CourseInstances on CourseInstances.CourseId = Courses.Id " .
									"join Registration on Registration.CourseInstanceId = CourseInstances.Id " .
									"where UserId = ? order by Semester, Abbreviation, CourseNumber";
		$db->makeQuery($grades, $userId);
		$totalGPA = 0;
		$totalCredits = 0;
		foreach($db->result as $row)
		{
			$gpa = $row['GradeGPA'];
			$credits = $row['CreditValue'];
			print "<tr><td>".$row['Abbreviation'] . $row['CourseNumber']. "</td><td>".$row['Title']."</td><td>$gpa</td><td>$credits</td></tr>";
			$totalGPA += $gpa*$credits;
			$totalCredits += $credits;
		}
	?>
</table>
<?php
	print 'GPA: ' + ($totalGPA/$totalCredits);
	include('helpers/footer.php');
?>