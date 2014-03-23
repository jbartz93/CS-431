<?php
  $pageTitle = "Course Details";
  $needsToBeLoggedIn = false;
  include('helpers/base.php');
  include('helpers/header.php');

  try {
	$id = $_GET["id"];
    $db->makeQuery( "SELECT CourseInstances.Id AS Id, Title, Abbreviation, CourseNumber, Description, NumberSeats, Name, SectionNumber FROM Courses ".
					"JOIN Departments ON Departments.Id = DeptId ".
					"JOIN CourseInstances ON Courses.Id = CourseInstances.CourseId ".
					"JOIN Users On ProfessorId = Users.Id ".
					"WHERE Courses.Id = ?", $id);
  }
  catch(Exception $e) {
    die($e->getMessage());
  }
  $row = $db->result[0];
  print "<h2>".$row["Abbreviation"]." ".$row["CourseNumber"]." - ".$row["Title"]."</h2>";
  print $row["Description"];
  if($db->numRows == 0) {
    print("No sections exist.");
  }
  else
  {
?>
<br>
<table>
	<tr>
		<th>Section</th>
		<th>Id</th>
		<th>Professor</th>
		<th>Seats</th>
	</tr>
<?php
		foreach($db->result as $row)
		{
			print "<tr><td>".$row["SectionNumber"]."</td><td>".$row["Id"]."</td><td>".$row["Name"]."</td><td>".$row["NumberSeats"]."</td></tr>";
		}
	}
?>
</table>
<a href='courselookup.php'>Course lookup</a>
<?php
	include('helpers/footer.php');
?>

