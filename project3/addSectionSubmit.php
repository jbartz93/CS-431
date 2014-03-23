<?php
  $permissions = true;
  include('helpers/base.php');

  // probably should do a bunch of error checking here, but whatever

  $courseId = intval($_POST['courseId']);
  $sectionNum = $_POST['sectionNumber'];
  $professorId = intval($_POST['professor']);
  $numOfSeats = intval($_POST['numberOfSeats']);

  try {
    $db->makeQuery("SELECT Id FROM Semesters WHERE Current=true LIMIT 1;");
  } catch(Exception $e) {
    die("Error: " . $e);
  }

  $semesterId = null;

  if ($db->numRows == 1) {
    $semesterId = intval($db->result[0]['Id']);
  }
  else {
    die("We aren't in a semester");
  }

  try {
    $db->makeQuery("INSERT INTO CourseInstances(CourseId, ProfessorId, NumberSeats, SectionNumber, SemesterId) VALUES(?, ?, ?, ?, ?);", $courseId, $professorId, $numOfSeats, $sectionNum, $semesterId);
  } catch(Exception $e) {
    die("Error: " . $e);
  }

  header("Location: " . BASE_URL . "coursedetail.php?id=" . $courseId);
?>