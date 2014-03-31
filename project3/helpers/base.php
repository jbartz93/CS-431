<?php
  ini_set('display_errors', 'On');
  error_reporting(E_ALL);

  session_start();

  if(isset($_SESSION["Id"])) {
    $userId = $_SESSION["Id"];
  }
  else {
    $userId = null;
  }

  require_once 'helpers/Database.php';

  try {
    $db = new Database();
  }
  catch (Exception $e) {
    die("Error: " . $e);
  }

  if ($userId) {
    if(@$permissions) {
      try {
        $db->makeQuery("SELECT * FROM Permissions WHERE UserId=? LIMIT 1;", $userId);
      } catch(Exception $e) {
        die($e->getMessage());
      }
      foreach($db->result as $row)
      {
        $granted = array(
          "GiveGrade" => $row["GiveGrade"],
          "ViewAllGrades" => $row["ViewAllGrades"],
          "ChangeAllGrades" => $row["ChangeAllGrades"],
          "AddCourses" => $row["AddCourses"],
        );
      }
    }
  }

  define('BASE_URL', 'http://cs431jjs.herokuapp.com/project3/'');
  function gpaToLetter($gpa)
  {
	$grade = '';
	if($gpa >= 4)
	{
		$grade = 'A';
	}
	else if($gpa >= 3.9)
	{
		$grade = 'A-';
	}
	else if($gpa >= 3.7)
	{
		$grade = 'B+';
	}
	else if($gpa >= 3.4)
	{
		$grade = 'B';
	}
	else if($gpa >= 3)
	{
		$grade = 'B-';
	}
	else if($gpa >= 2.7)
	{
		$grade = 'C+';
	}
	else if($gpa >= 2.4)
	{
		$grade = 'C';
	}
	else if($gpa >= 2)
	{
		$grade = 'C-';
	}
	else if($gpa >= 1.7)
	{
		$grade = 'D+';
	}
	else if($gpa >= 1.4)
	{
		$grade = 'D';
	}
	else if($gpa >= 1)
	{
		$grade = 'D-';
	}
	else if($gpa >= 0.7)
	{
		$grade = 'F+';
	}
	else if($gpa >= 0.4)
	{
		$grade = 'F';
	}
	else if($gpa >= 0)
	{
		$grade = 'F-';
	}
	return $grade;
  }
?>
