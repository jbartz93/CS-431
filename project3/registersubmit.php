<?php
	include('helpers/base.php');
	$user = $_POST['name'];
	$pass = $_POST['password'];
	$email = $_POST['email'];
	$dept = $_POST['department'];
	$give = $_POST['givegrade'];
	$view = $_POST['viewall'];
	$change = $_POST['changeall'];
	$add = $_POST['addcourse'];

	$query = "insert into users (Name, Password, Email, DeptId) values (?, ?, ?, ?)";
	try
	{
		$db->makeQuery($query, $user, sha1($pass), $email, $dept);
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