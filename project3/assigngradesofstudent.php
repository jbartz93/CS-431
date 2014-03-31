<?php
    $pageTitle="Assign Grades";
    $permissions = true;
    include('helpers/base.php');
    include('helpers/header.php');
    
    $studentid = $_POST['studentID'];
    
    if (!($granted['AssignAllGrades'])) {
        die('you do not have permission to be here.');
    }
    ?>


<form method="post" action="assigngradessubmit.php">
<table>
<tr>
<th>Course Number</th>
<th>Course Title</th>
<th>Grade</th>
<th>Credits</th>
<th>Change Grade</th>
<th>New Grade</th>
</tr>
<?php
    $ids = "SELECT Id FROM Users WHERE Id = ?";
    $db->makeQuery($ids, $studentid);
    if ($db->numRows > 0){
        $grades = "SELECT Abbreviation, CourseNumber, Title, GradeGPA, CreditValue, CourseInstances.Id AS sectionid FROM Courses " .
        "JOIN Departments ON Departments.Id = Courses.DeptId " .
        "JOIN CourseInstances ON CourseInstances.CourseId = Courses.Id " .
        "JOIN Registration ON Registration.CourseInstanceId = CourseInstances.Id " .
        "WHERE UserId = ? ORDER BY (SELECT Year FROM Semesters WHERE Id=SemesterId), Abbreviation, CourseNumber;";
        $db->makeQuery($grades, $studentid);
        $count = 0;
        $totalGPA = 0;
        $totalCredits = 0;
        
        foreach($db->result as $row)
        {
            $gpa = $row['GradeGPA'];
            $credits = $row['CreditValue'];
            $grade = gpaToLetter($gpa);
            print "<tr><td>".$row['Abbreviation'] . $row['CourseNumber']. "</td><td>".$row['Title']."</td><td>  $grade</td><td>$credits</td>";
            if($gpa != null)
            {
                $totalGPA += $gpa*$credits;
                $totalCredits += $credits;
            }
            print "<td>".
            
                "<input type='checkbox' name='changegrade".$count."'>".
            
            "</td>".
            "<td>".
            
                "<input type='hidden' name='studentid".$count."' value='".$studentid."'/>".
                "<input type='hidden' name='sectionid".$count."' value='".$row['sectionid']."'/>".
                "<input type='text' name='newgrade".$count."' placeholder='".$gpa."'>".
            
            "</td></tr>";
            $count = $count+1;
        }
        
        
        print "<input type='hidden' name='count' value='".$count."'/>";
        
    }
	?>
</table>

<button type="submit">Save Changes</button>

</form>

<?php
    $ids = "SELECT Id FROM Users WHERE Id = ?";
    $db->makeQuery($ids, $studentid);
    
    if ($db->numRows == 0){
        print "No student found with id: " . $studentid;
    }
    ?>
<br>
<a href='assigngrades.php'>Assign Grades</a>
<?php
	include('helpers/footer.php');
    ?>