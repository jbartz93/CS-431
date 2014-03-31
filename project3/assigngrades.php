<?php
    $pageTitle="Assign Grades";
    $permissions = true;
include('helpers/base.php');
include('helpers/header.php');
    
    if (!($granted['GiveGrade'] OR $granted['AssignAllGrades'])) {
        die('you do not have permission to be here.');
    }
    ?>
<?php
    if($granted['ChangeAllGrades']) {
    ?>
<h3>Assign to Student</h3>

<form method="post" action="assigngradesofstudent.php">
<input type="text" name="studentID" placeholder="Student ID">
<button type="submit">Search</button>
</form>
<?php
    }
    ?>

<?php
    if($granted['GiveGrade']) {
    ?>
<h3>Assign to Section</h3>

<form method="post" action="assigngradesofsection.php">
<input type="text" name="sectionID" placeholder="Section ID">
<button type="submit">Search</button>
</form>
<?php
    }
    ?>

<?php
	include('helpers/footer.php');
    ?>