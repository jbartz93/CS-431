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
		$grades = "SELECT Abbreviation, CourseNumber, Title, GradeGPA, CreditValue FROM Courses " .
									"JOIN Departments ON Departments.Id = Courses.DeptId " .
									"JOIN CourseInstances ON CourseInstances.CourseId = Courses.Id " .
									"JOIN Registration ON Registration.CourseInstanceId = CourseInstances.Id " .
									"WHERE UserId = ? ORDER BY (SELECT Year FROM Semesters WHERE Id=SemesterId), Abbreviation, CourseNumber;";
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
	print 'GPA: ' . ($totalGPA/$totalCredits);
	include('helpers/footer.php');
?>