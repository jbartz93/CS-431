<!doctype html>
<html>
	<head>
		<title>Main Page</title>
	</head>
	<body>
		<ul>
		<li><a href="viewgrades.php">View Grades</a></li>
		<li><a href="register.php">Add/Drop/View Courses</a></li>
		<?php
			include('account.php');
			$mysqli = mysqli_connect($hostname, $username, $password, $database);
			if (mysqli_connect_errno($mysqli))
			{
				print "Error:" . mysqli_connect_error($mysqli);
				exit();
			}
			//Prepare a statement
			$permissions = mysqli_prepare($mysqli, "select GiveGrade, ChangeAllGrades, AddCourses from Permissions where UserId=? ");
			//Replaces the ? with the given value. The value is automatically cleaned
			mysqli_stmt_bind_param($permissions, 'i', 4); //Replace with the current user id
			//Run the statement. It dies if it fails.
			mysqli_stmt_execute($permissions) or die ("Error: " . mysqli_error($mysqli));
			//Bind the result to some variables
			mysqli_stmt_bind_result($permissions, $grades, $allgrades, $addcourses);
			//Not really sure why this has to be done, but it does
			mysqli_stmt_store_result($permissions);
			if(mysqli_stmt_num_rows($permissions) == 0)
			{
				print "Database problem: user does not have permissions";
			}
			//Fetches the first row and sets the variables to have the values that are in that row
			//Fetching again would get the second row
			mysqli_stmt_fetch($permissions);
			if($grades == 1 or $allgrades == 1)
			{
				print '<li><a href="assigngrades.php">Assign grades</a></li>';
			}
			if($addcourses == 1)
			{
				print '<li><a href="addcourses.php">Add courses</a></li>';
			}
			//Always remember to close
			mysqli_stmt_close($permissions);
		?>
		<li><a href="userlookup.php">User Lookup</a></li>
		<li><a href="courselookup.php">Course lookup</a></li>
		</ul>
	</body>
</html>