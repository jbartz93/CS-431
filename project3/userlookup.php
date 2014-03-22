<?php
	$pageTitle = "Directory Search";
	$needsToBeLoggedIn = false;
	include('helpers/base.php');
	include('helpers/header.php');
?>
<h3>Search for People</h3>
<form method="get" action="userlookup.php">
	<input type="text" name="q">
	<button type="submit">Search</button>
</form>
<br>
<?php
	if(array_key_exists("q", $_GET))
	{
		$q = "%" . $_GET["q"] . "%";
		$query = "select Name, Email, FullName as Department from Users join Departments on Departments.Id = DeptId where Name like ? or Email like ? or FullName like ?";
		try 
		{
			$db->makeQuery($query, $q, $q, $q);
		}
		catch(Exception $e)
		{
			die($e);
		}
		if($db->numRows > 0)
		{
?>
			<table>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Department</th>
				</tr>
<?php
			foreach($db->result as $row)
			{
				print "<tr><td>".$row["Name"]."</td><td>".$row["Email"]."</td><td>".$row["Department"]."</td></tr>";
			}
?>
			</table>
<?php
		}
		else
		{
			print "No results found for " . $_GET["q"];
		}
	}
	include('helpers/footer.php');
?>