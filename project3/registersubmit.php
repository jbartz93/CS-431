<?php
	include('helpers/base.php');
	include('helpers/header.php');
	$c1 = $_REQUEST['c1'];
	$c2 = $_REQUEST['c2'];
	$c3 = $_REQUEST['c3'];
	$c4 = $_REQUEST['c4'];
	$c5 = $_REQUEST['c5'];
	$c6 = $_REQUEST['c6'];
	$query = "insert into Registration (UserId, CourseInstanceId) values (?, ?)";
	try {
		$db->makeQuery($query, $userId, $c1);
	} catch(Exception $e) {}
	if($c2 != null and $c2 != '') {
		try {
			$db->makeQuery($query, $userId, $c2);
		} catch(Exception $e) {}
	}
	if($c3 != null and $c3 != '') {
		try {
			$db->makeQuery($query, $userId, $c3);
		} catch(Exception $e) {}
	}
	if($c4 != null and $c4 != '') {
		try {
			$db->makeQuery($query, $userId, $c4);
		} catch(Exception $e) {}
	}
	if($c5 != null and $c5 != '') {
		try {
			$db->makeQuery($query, $userId, $c5);
		} catch(Exception $e) {}
	}
	if($c6 != null and $c6 != '') {
		try {
			$db->makeQuery($query, $userId, $c6);
		} catch(Exception $e) {}
	}
	header('Location: ' . BASE_URL . 'register.php');

?>