<?php
	include('helpers/base.php');
	include('helpers/header.php');
	$cid = $_REQUEST['courseId'];
	$cid or die('Course Id not defined');
	$query = "DELETE FROM Registration WHERE UserId=? AND CourseInstanceId=?;";
	$query2 = "UPDATE CourseInstances SET NumberSeats = NumberSeats + 1 WHERE Id = ?;";
	try
	{
		$db->makeQuery("START TRANSACTION");
		$db->makeQuery($query, $userId, $cid);
		$db->makeQuery($query2, $cid);
		$db->makeQuery("COMMIT");
	}
	catch(Exception $e)
	{
		die($e);
	}
	include('helpers/footer.php');
	header('Location: ' . BASE_URL . 'register.php');
?>