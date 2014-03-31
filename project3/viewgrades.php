<?php
$pageTitle="View Grades";
    $permissions = true;
include('helpers/base.php');
include('helpers/header.php');
    ?>

<?php
    if($granted['ViewAllGrades']) {
?>
<h3>Look up Student Grades</h3>

<form method="post" action="viewgradesofstudent.php">
<input type="text" name="studentID" placeholder="Student ID">
<button type="submit">Search</button>
</form>

<h3>Look up Section Grades</h3>

<form method="post" action="viewgradesofsection.php">
<input type="text" name="sectionID" placeholder="Section ID">
<button type="submit">Search</button>
</form>
<?php
    }
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
        $flag = 0;
		$totalGPA = 0;
		$totalCredits = 0;
		foreach($db->result as $row)
		{
            $flag = 1;
			$gpa = $row['GradeGPA'];
			$credits = $row['CreditValue'];
			$grade = gpaToLetter($gpa);
			print "<tr><td>".$row['Abbreviation'] . $row['CourseNumber']. "</td><td>".$row['Title']."</td><td>$grade</td><td>$credits</td></tr>";
			if($gpa != null)
			{
				$totalGPA += $gpa*$credits;
				$totalCredits += $credits;
			}
		}
	?>
</table>

<?php
    if ($totalCredits == 0){
        print 'GPA: n/a';
    }
    else {
        print 'GPA: ' . ($totalGPA/$totalCredits);
    }
	include('helpers/footer.php');
?>