<?php
	$pageTitle = "Course Details";
	$needsToBeLoggedIn = false;
	$permissions = true;
	include('helpers/base.php');
	include('helpers/header.php');

	$id = $_GET["id"];
	$query = "SELECT CourseInstances.Id AS Id, Title, Abbreviation, CourseNumber, Description, NumberSeats, Name, SectionNumber, GROUP_CONCAT(DISTINCT CONCAT(DayOfWeek, ': ', TIME_FORMAT(BeginTime, '%l:%i %p'), ' - ', TIME_FORMAT(EndTime, '%l:%i %p')) SEPARATOR '</br>') AS DayOfWeek FROM Courses ".
				"JOIN Departments ON Departments.Id = DeptId ".
				"JOIN CourseInstances ON Courses.Id = CourseInstances.CourseId ".
				"JOIN Users On ProfessorId = Users.Id ".
				"JOIN Semesters ON Semesters.Id = SemesterId " .
				"JOIN Meetings ON Meetings.CourseInstanceId = CourseInstances.Id ";
	try
	{
		if(array_key_exists("semester", $_GET))
		{
			$db->makeQuery($query . "WHERE Courses.Id = ? AND Semesters.Id = ? GROUP BY CourseInstances.Id ORDER BY SectionNumber", $id, $_GET["semester"]);
		}
		else
		{
			$db->makeQuery($query . "WHERE Courses.Id = ? AND Current = true GROUP BY CourseInstances.Id ORDER BY SectionNumber", $id);
		}
	}
	catch(Exception $e) {
		die($e->getMessage());
	}
	if($db->numRows == 0) {
		print("No sections exist.");
	}
	else
	{
		$row = $db->result[0];
		print "<h2>".$row["Abbreviation"]." ".$row["CourseNumber"]." - ".$row["Title"]."</h2>";
		print $row["Description"];
?>
<br>
<table>
	<tr>
		<th>Section</th>
		<th>Id</th>
		<th>Days/Times</th>
		<th>Professor</th>
		<th>Seats</th>
	</tr>
<?php
		foreach($db->result as $row)
		{
			print "<tr><td>".$row["SectionNumber"]."</td><td>".$row["Id"]."</td><td>".$row["DayOfWeek"]."</td><td>".$row["Name"]."</td><td>".$row["NumberSeats"]."</td></tr>";
		}
	}
	try
	{
		$db->makeQuery("SELECT Id, Season, Year, Current FROM Semesters");
	}
	catch(Exception $e)
	{
		die($e);
	}
?>
</table>

<?php
	if(@$granted['AddCourses']):
?>
	</br>
	<button type='button' onclick='window.location.assign("addSection.php?courseId=<?php echo $id ?>")'>Add Section</button>
	</br>
	</br>
<?php
	endif;
?>

See other semesters:
<form method="get" action="coursedetail.php">
  <input type="text" name="id" style="display:none" value="<?php print $id?>">
  <select id="semester" name="semester">
    <?php
      foreach($db->result as $row) {
        echo '<option value="' . $row['Id'] . '" selected="' . $row['Current'] . '">' . $row['Season'] . ' ' . $row['Year'] . '</option>';
      }
    ?>
  </select>
  <button type="submit">Submit</button>
</form>
<br>
<a href='courselookup.php'>Course lookup</a>
<?php
	include('helpers/footer.php');
?>

