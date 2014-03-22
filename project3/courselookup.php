<?php
  $pageTitle = "Course Search";
  $needsToBeLoggedIn = false;
  include('helpers/base.php');
  include('helpers/header.php');

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
    die("No courses exist.");
  }
?>

<h2>Search Courses</h2>

<form method="get" action="courselookup.php">
  <select id="department" name="department">
    <option value="" selected>Choose a Department</option>
    <?php
      foreach($departments as $department) {
        echo '<option value="' . $department['Id'] . '">' . $department['Abbreviation'] . '</option>';
      }
    ?>
  </select>
  <input type="text" placeholder="Search text" name="query">
  <button type="submit">Search</button>
</form>

<?php
  if(isset($_GET['query']) && isset($_GET['department'])) {
    $query = "%" . $_GET["query"] . "%";
    try {
      $db->makeQuery("SELECT Title, CourseNumber, Description FROM Courses WHERE DeptId = ? AND (Title LIKE ? OR CourseNumber LIKE ?)", $_GET['department'], $query, $query);
    }
    catch(Exception $e) {
      die($e->getMessage());
    }
?>
  <table>
    <tr>
      <th>Title</th>
      <th>Course Number</th>
      <th>Description</th>
    </tr>
    <?php
        foreach($db->result as $row)
        {
          print "<tr><td>".$row["Title"]."</td><td>".$row["CourseNumber"]."</td><td>".$row["Description"]."</td></tr>";
        }
    ?>
  </table>
<?php
  }
?>