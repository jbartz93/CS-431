<?php
  $pageTitle = "Add Course";
  include("helpers/header.php");

  try {
    $db->makeQuery("SELECT AddCourses FROM Permissions WHERE UserId = ? LIMIT 1;", $userId);
  }
  catch(Exception $e) {
    die($e.getMessage());
  }

  if($db->numRows == 1) {
    if(!$db->result[0]["AddCourses"]) {
      die("User not allowed to add courses.");
    }
  }

  try {
    $db->makeQuery("SELECT Id, Abbreviation FROM Departments");
  }
  catch(Exception $e) {
    die($e.getMessage());
  }

  $departments = array();

  if($db->numRows > 0) {
    $departments = $db->result;
  }
  else {
    die("No departments exist yet. You should create one.");
  }

?>

  <form method="POST" action="addCourseSubmit.php">
    <select name="department">
      <option value="" selected>Choose a Department</option>
<?php
    foreach($departments as $department) {
      echo '<option value="' . $department['Id'] . '">' . $department['Abbreviation'] . '</option>';
    }
?>

    </select>
  </form>

<?php

  include("helpers/footer.php");
?>