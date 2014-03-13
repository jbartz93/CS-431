<!doctype html>
<html>
	<head>
		<title>Main Page</title>
	</head>
	<body>
		<table>
		<tr>
			<th>Course Number</th>
			<th>Course Title</th>
			<th>Grade</th>
			<th>Credits</th>
			<?php
				$grades = mysqli_prepare("select Abbreviation, CourseNumber, Title, GradeGPA, CreditValue from Courses " +
											"join Departments on Departments.Id = Courses.DeptId " +
											"join CourseInstance on CourseInstance.CourseId = Courses.Id " + 
											"join Registration on Registration.CourseInstanceId = CourseInstance.Id " +
											"where UserId = ?");
				mysqli_stmt_bind_param($grades, 'i', 4); //Replace with the current user id
				mysqli_stmt_execute($grades) or die ("Error: " . mysqli_error($mysqli));
				mysqli_stmt_bind_result($grades, $abbr, $num, $title, $gpa, $credits);
				mysqli_stmt_store_result($grades);
				$totalGPA = 0;
				$totalCredits = 0;
				while(mysqli_stmt_fetch($grades)
				{
					print "<td>$abbr $num</td><td>$title</td><td>$gpa</td><td>$credits</td>";
					$totalGPA += $gpa*$credits;
					$totalCredits += $credits;
				}
			?>
		</table>
		<?php
			print 'GPA: ' + ($totalGPA/$totalCredits);
			
		?>
	</body>
</html>