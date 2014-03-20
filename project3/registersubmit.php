<?php
	include('helpers/base.php');
	$user = $_REQUEST['name'];
	$pass = $_REQUEST['password'];
	$email = $_REQUEST['email'];
	$dept = $_REQUEST['department'];
	$give = $_REQUEST['givegrade'];
	$view = $_REQUEST['viewall'];
	$change = $_REQUEST['changeall'];
	$add = $_REQUEST['addcourse'];

	$query = "insert into users (Name, Password, Email, DeptId) values (?, sha1(?), ?, ?)";
	try
	{
		$db->makeQuery($query, $user, $pass, $email, $dept);
	}
	catch (Exception $e)
	{
		die("Error: " . $e);
	}
	$userId = $db->insertId;
	$_SESSION["Id"] = $userId;
	$query = "insert into permissions (UserId, GiveGrade, ViewAllGrades, ChangeAllGrades, AddCourses) values (?, ?, ?, ?, ?)";
	$give = ($give == "on" ? 0 : 1);
	$view = ($view == "on" ? 1 : 0);
	$change = ($change == "on" ? 0 : 1);
	$add = ($add == "on" ? 0 : 1);
	try
	{
		$db->makeQuery($query, $userId, $give, $view, $change, $add);
	}
	catch (Exception $e)
	{
		die("Error: " . $e);
	}
	header("Location: " . BASE_URL . "main.php");
	exit();
?>