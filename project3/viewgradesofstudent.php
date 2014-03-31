<?php
    $pageTitle="View Grades";
    $permissions = true;
    include('helpers/base.php');
    include('helpers/header.php');
    
    $studentid = $_POST['studentID'];
    
    if(!$granted['ViewAllGrades']) {
        die('you do not have permission to access this.')
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
    $ids = "SELECT Id FROM Users WHERE Id = ?";
    $db->makeQuery($ids, $studentid);
    if ($db->numRows > 0){
        $grades = "SELECT Abbreviation, CourseNumber, Title, GradeGPA, CreditValue FROM Courses " .
        "JOIN Departments ON Departments.Id = Courses.DeptId " .
        "JOIN CourseInstances ON CourseInstances.CourseId = Courses.Id " .
        "JOIN Registration ON Registration.CourseInstanceId = CourseInstances.Id " .
        "WHERE UserId = ? ORDER BY (SELECT Year FROM Semesters WHERE Id=SemesterId), Abbreviation, CourseNumber;";
        $db->makeQuery($grades, $studentid);
        $flag = 0;
        $totalGPA = 0;
        $totalCredits = 0;
        foreach($db->result as $row)
        {
            $flag = 1;
            $gpa = $row['GradeGPA'];
            $credits = $row['CreditValue'];
            $grade = gpaToLetter($gpa);
            print "<tr><td>".$row['Abbreviation'] . $row['CourseNumber']. "</td><td>".$row['Title']."</td><td>  $grade</td><td>$credits</td></tr>";
            if($gpa != null)
            {
                $totalGPA += $gpa*$credits;
                $totalCredits += $credits;
            }
        }
    }
	?>
</table>

<?php
    $ids = "SELECT Id FROM Users WHERE Id = ?";
    $db->makeQuery($ids, $studentid);
    
    if ($db->numRows > 0){
        if ($totalCredits == 0){
            print 'GPA: n/a';
        }
        else {
            print 'GPA: ' . ($totalGPA/$totalCredits);
        }
    }
    else {
        print "No student found with id: " . $studentid;
    }
    ?>
<br>
<a href='viewgrades.php'>View Grades</a>
<?php
	include('helpers/footer.php');
    ?>