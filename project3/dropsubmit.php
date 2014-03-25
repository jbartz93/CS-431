<?php
	include('helpers/base.php');
	include('helpers/header.php');
	$cid = $_REQUEST['courseId'];
	$cid or die('Course Id not defined');
	$query = "DELETE FROM Registration WHERE UserId=? AND CourseInstanceId=?";
	try
	{
		$db->makeQuery($query, $userId, $cid);
	}
	catch(Exception $e)
	{
		die($e);
	}
	include('helpers/footer.php');
	header('Location: ' . BASE_URL . 'register.php');
?>