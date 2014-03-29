<?php
	include('helpers/base.php');
	include('helpers/header.php');
	$cid = $_REQUEST['courseId'];
	$cid or die('Course Id not defined');
	$query = "BEGIN TRANSACTION; DELETE FROM Registration WHERE UserId=? AND CourseInstanceId=?; UPDATE CourseInstances SET NumberSeats = NumberSeats + 1 WHERE Id = ?; COMMIT;";
	try
	{
		$db->makeQuery($query, $userId, $cid, $cid);
	}
	catch(Exception $e)
	{
		die($e);
	}
	include('helpers/footer.php');
	header('Location: ' . BASE_URL . 'register.php');
?>