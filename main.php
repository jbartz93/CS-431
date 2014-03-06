<html>
	<head>
		<title>Main Page</title>
	</head>
	<body>
		<ul>
		<li><a href="viewgrades.php">View Grades</a></li>
		<li><a href="register.php">Add/Drop/View Courses</a></li>
		<?php
			if(/*something about permissions here*/)
			{
				print '<li><a href="assigngrades.php">Assign grades</a></li>';
			}
		?>
		</ul>
	</body>
</html>