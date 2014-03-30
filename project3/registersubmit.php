<?php
	include('helpers/base.php');
	include('helpers/header.php');
	function addClass($db, $c)
	{
		if($c == null || $c == '')
		{
			return;
		}
		$query = "START TRANSACTION; ".
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
	addClass($db, $c1);
	addClass($db, $c2);
	addClass($db, $c3);
	addClass($db, $c4);
	addClass($db, $c5);
	addClass($db, $c6);
	header('Location: ' . BASE_URL . 'register.php');

?>