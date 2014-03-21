<?php
	include('helpers/base.php');
	include('helpers/header.php');
	$cid = $_REQUEST['courseId'];
	$cid or die('Course Id not defined');
	$query = "delete from Registration where UserId=? and CourseInstanceId=?";
	try
	{
		db->makeQuery($query, $userId, $cid);
	}
	catch(Exception $e)
	{
		die($e);
	}
	include('helpers/footer.php');
?>