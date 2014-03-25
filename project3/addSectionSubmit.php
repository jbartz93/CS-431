<?php
  $permissions = true;
  include('helpers/base.php');

  // should do a bunch of error checking here, but whatever

  $courseId = intval($_POST['courseId']);
  $sectionNum = $_POST['sectionNumber'];
  $professorId = intval($_POST['professor']);
  $numOfSeats = intval($_POST['numberOfSeats']);
  $meetingLocation = $_POST['meetingLocation'];
  $dayOfWeek = $_POST['dayOfWeek'];
  $endTime = $_POST['endTime'];
  $startTime = $_POST['startTime'];

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

  // add the course instance
  try {
    $db->makeQuery("INSERT INTO CourseInstances(CourseId, ProfessorId, NumberSeats, SectionNumber, SemesterId) VALUES(?, ?, ?, ?, ?);", $courseId, $professorId, $numOfSeats, $sectionNum, $semesterId);
  } catch(Exception $e) {
    die("Error: " . $e);
  }

  $courseInstanceId = $db->insertId;

  // add the meetings
  for($i = 0; $i < count($meetingLocation); $i++) {
    try {
      $db->makeQuery("INSERT INTO Meetings(CourseInstanceId, DayOfWeek, BeginTime, EndTime, Location) VALUES(?, ?, ?, ?, ?);", $courseInstanceId, $dayOfWeek[$i], $startTime[$i], $endTime[$i], $meetingLocation[$i]);
    } catch(Exception $e) {
      die("Error: " . $e);
    }
  }

  header("Location: " . BASE_URL . "coursedetail.php?id=" . $courseId);
?>