<?php
    $pageTitle="Assign Grades";
    $permissions = true;
    include('helpers/base.php');
    include('helpers/header.php');
    
    $sectionid = $_POST['sectionID'];
    
    if (!($granted['GiveGrade'])) {
        die('you do not have permission to be here.');
    }
    ?>

<form method="post" action="assigngradessubmit.php">

<table>
<tr>
<th>Student Name</th>
<th>Current Grade</th>
<th>Change Grade</th>
<th>New Grade</th>
</tr>
<?php
    $ids = "SELECT Id FROM CourseInstances WHERE Id = ?";
    $db->makeQuery($ids, $sectionid);
    if ($db->numRows > 0){
        $grades = "SELECT Users.Name, GradeGPA, Users.Id AS studentid FROM Users " .
        "JOIN Registration ON Registration.UserId = Users.Id " .
        "JOIN CourseInstances ON CourseInstances.Id = Registration.CourseInstanceId " .
        "WHERE CourseInstances.Id = ?";
        $db->makeQuery($grades, $sectionid);
        $count = 0;
        foreach($db->result as $row)
        {
            $gpa = $row['GradeGPA'];
            $name = $row['Name'];
            $grade = gpaToLetter($gpa);
            print "<tr><td>$name</td><td>$grade</td>";
            
            print "<td>".
            "<input type='checkbox' name='changegrade".$count."'>".
            "</td>".
            
            "<td>".
            "<input type='hidden' name='studentid".$count."' value='".$row['studentid']."'/>".
            "<input type='hidden' name='sectionid".$count."' value='".$sectionid."'/>".
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
    $ids = "SELECT Id FROM CourseInstances WHERE Id = ?";
    $db->makeQuery($ids, $sectionid);
    if ($db->numRows == 0){
        print "No section found with id: " . $sectionid;
    }
    ?>
<br>
<a href='assigngrades.php'>Assign Grades</a>
<?php
	include('helpers/footer.php');
    ?>