<?php
  $pageTitle = "Add Course";
  $permissions = true;
  include("helpers/base.php");
  include("helpers/header.php");

  if(!$granted["AddCourses"]) {
    die("User not allowed to add courses.");
  }

  try {
    $db->makeQuery("SELECT Id, Abbreviation FROM Departments");
  }
  catch(Exception $e) {
    die($e->getMessage());
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
    <label for="id">Department</label>
    <select id="department" name="department">
      <option value="" selected>Choose a Department</option>
<?php
    foreach($departments as $department) {
      echo '<option value="' . $department['Id'] . '">' . $department['Abbreviation'] . '</option>';
    }
?>

    </select></br>
    <label for="title">Course Title</label>
    <input type="text" id="title" name="title"></input></br>
    <label for="number">Course Number</label>
    <input type="text" name="number" id="number" name="number"></input></br>
    <label for="description">Description</label>
    <textarea cols="50" rows="10" id="description" name="description"></textarea></br>
    <label for"creditNumber">Number of Credits</label>
    <select id="creditNumber" name="creditNumber">
      <option value="" selected>Credit Number</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
    </select></br>
    <button type="submit">Create Course</button>
  </form>

<?php

  include("helpers/footer.php");
?>