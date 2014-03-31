<?php
    $pageTitle="View Grades";
    $permissions = true;
    include('helpers/base.php');
    include('helpers/header.php');
    
    $sectionid = $_POST['sectionID'];
    
    if(!$granted['ViewAllGrades']) {
        die('you do not have permission to access this.');
    }
    ?>

<table>
	<tr>
	<th>Student Name</th>
	<th>Letter Grade</th>
	</tr>
	<?php
        $ids = "SELECT Id FROM CourseInstances WHERE Id = ?";
        $db->makeQuery($ids, $sectionid);
        if ($db->numRows > 0){
            $grades = "SELECT Users.Name, GradeGPA FROM Users " .
                      "JOIN Registration ON Registration.UserId = Users.Id " .
                      "JOIN CourseInstances ON CourseInstances.Id = Registration.CourseInstanceId " .
                      "WHERE CourseInstances.Id = ?";
            $db->makeQuery($grades, $sectionid);
            foreach($db->result as $row)
            {
                $gpa = $row['GradeGPA'];
                $name = $row['Name'];
                $grade = gpaToLetter($gpa);
                print "<tr><td>$name</td><td>$grade</td></tr>";
                
            }
        }
	?>
</table>

<?php
    $ids = "SELECT Id FROM CourseInstances WHERE Id = ?";
    $db->makeQuery($ids, $sectionid);
    if ($db->numRows == 0){
        print "No section found with id: " . $sectionid;
    }
    ?>
<br>
<a href='viewgrades.php'>View Grades</a>
<?php
	include('helpers/footer.php');
    ?>