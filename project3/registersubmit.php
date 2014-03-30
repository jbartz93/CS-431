<?php
	include('helpers/base.php');
	include('helpers/header.php');
	function addClass($c)
	{
		if($c == null || $c == '')
		{
			return;
		}
		$query = "BEGIN TRANSACTION; ".
				 "INSERT INTO Registration (UserId, CourseInstanceId) VALUES (?, ?); ".
				 "UPDATE CourseInstances SET NumberSeats = NumberSeats - 1 WHERE Id = ?; ".
				 "COMMIT;";
		try {
			$db->makeQuery("SELECT NumberSeats FROM CourseInstances WHERE Id = ?", $c);
			if($db->result[0]['NumberSeats'] > 0) {
				$db->makeQuery($query, $userId, $c, $c);
			}
		} catch(Exception $e) {}
	}
	$c1 = $_REQUEST['c1'];
	$c2 = $_REQUEST['c2'];
	$c3 = $_REQUEST['c3'];
	$c4 = $_REQUEST['c4'];
	$c5 = $_REQUEST['c5'];
	$c6 = $_REQUEST['c6'];
	addClass($c1);
	addClass($c2);
	addClass($c3);
	addClass($c4);
	addClass($c5);
	addClass($c6);
	header('Location: ' . BASE_URL . 'register.php');

?>