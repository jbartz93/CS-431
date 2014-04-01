<?php
	include('helpers/base.php');
	function addClass($db, $userId, $c)
	{
		if($c == null || $c == '')
		{
			return;
		}
		$query = "INSERT INTO Registration (UserId, CourseInstanceId) VALUES (?, ?); ";
		$query2 = "UPDATE CourseInstances SET NumberSeats = NumberSeats - 1 WHERE Id = ?; ";
		try {
			$db->makeQuery("SELECT NumberSeats FROM CourseInstances WHERE Id = ?", $c);
			if($db->result[0]['NumberSeats'] > 0) {
				$db->makeQuery("SELECT * FROM Registration WHERE UserId = ? AND CourseInstanceId = ?", $userId, $c);
				if($db->numRows == 0) {
					$db->makeQuery("START TRANSACTION");
					$db->makeQuery($query, $userId, $c);
					$db->makeQuery($query2, $c);
					$db->makeQuery("COMMIT");
				}
			}
		} catch(Exception $e) {die($e);}
	}
	$c1 = $_REQUEST['c1'];
	$c2 = $_REQUEST['c2'];
	$c3 = $_REQUEST['c3'];
	$c4 = $_REQUEST['c4'];
	$c5 = $_REQUEST['c5'];
	$c6 = $_REQUEST['c6'];
	addClass($db, $userId, $c1);
	addClass($db, $userId, $c2);
	addClass($db, $userId, $c3);
	addClass($db, $userId, $c4);
	addClass($db, $userId, $c5);
	addClass($db, $userId, $c6);
	header('Location: ' . BASE_URL . 'register.php');

?>