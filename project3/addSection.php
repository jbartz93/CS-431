<?php
  $permissions = true;
  include('helpers/base.php');

  $courseId = $_GET['courseId'];

  try {
    $db->makeQuery("SELECT Abbreviation, CourseNumber, DeptId FROM Courses, Departments WHERE Courses.DeptId=Departments.Id AND Courses.Id=? LIMIT 1;", $courseId);
  } catch(Exception $e) {
    die("Error: " . $e);
  }

  $courseDeptId = null;
  $courseName = null;

  if($db->numRows == 1) {
    $courseName = $db->result[0]['Abbreviation'] . " " . $db->result[0]['CourseNumber'];
    $courseDeptId = $db->result[0]['DeptId'];
  }
  else {
    die("Sorry that course does not exist");
  }

  $pageTitle = "Add " . $courseName . " Section";
  include('helpers/header.php');

  if (!$granted['AddCourses']) {
    die("Sorry - you are not allowed to add sections");
  }


  try {
    $db->makeQuery("SELECT Id, Name FROM Users WHERE Role='faculty' AND DeptId=? LIMIT 1", $courseDeptId);
  } catch(Exception $e) {
    die("Error " . $e);
  }

  $professors = array();

  if($db->numRows >= 1) {
    $professors = $db->result;
  }
  else {
    //die("There needs to be a professor before you can create a section");
  }

  // creates the HTML for the time dropdowns
  function createTimeOptions() {
    $timeOptionsHTML = '';
    $hour = 12;
    $minute = 0;
    $morning = true;
    while(true) {
      // the name should be in 24 hour format so easier to put in database
      $hourIn24Format = null;
      if ($morning && $hour == 12) {
        $hourIn24Format = '00';
      }
      else if ($morning && $hour < 10) {
        $hourIn24Format = '0' . $hour;
      }
      else if ($morning || ($hour == 12 && !$morning)) {
        $hourIn24Format = $hour;
      }
      else {
        $hourIn24Format = $hour + 12;
      }

      $time24 = $hourIn24Format . ':' . ($minute == 0 ? '00' : $minute);
      $time = $hour . ':' . ($minute == 0 ? '00' : $minute) . ' ' . ($morning ? 'AM' : 'PM');
      $timeOptionsHTML .= '<option value="'. $time24 . '">'. $time . '</option>';

      $minute = ($minute + 30) % 60;

      if ($hour == 12 && $minute == 0) {
        $hour = 1;
      }
      else if ($hour == 11 && $minute == 0 && $morning) {
        $morning = false;
        $hour++;
      }
      else if ($hour == 11 && $minute == 0 && !$morning) {
        break;
      }
      else if ($hour < 12 && $minute == 0) {
        $hour++;
      }
    }

    return $timeOptionsHTML;
  }
?>
<script type="text/javascript">
  function addMeeting() {
    var timeOptions = '<?php echo createTimeOptions() ?>';
    var newMeetingHTML = '<li><input type="text" name="meetingLocation[]" placeholder="location"> <select name="dayOfWeek[]"><option selected>Day of the Week</option><option name="M">M</option><option name="T">T</option><option name="W">W</option><option name="R">R</option><option name="F">F</option></select> <select name="startTime[]"><option selected>Start Time</option>' + timeOptions + '</select> <select name="endTime[]"><option selected>End Time</option>' + timeOptions + '</select></li>';
    $('#meetings').append(newMeetingHTML);
  }
</script>

<form method="POST" action="addSectionSubmit.php">
  <label for="courseName">Course:</label>
  <input type="text" id="courseName" name="courseName" value="<?php echo $courseName ?>" readonly>
  </br>
  <label for="sectionNumber">Section Number:</label>
  <input type="text" id="sectionNumber" name="sectionNumber">
  </br>
  <label for="professor">Professor:</label>
  <select id="professor" name="professor">
    <?php
      foreach($professors as $professor) {
        echo '<option value="'. $professor["Id"] . '">' . $professor["Name"] . '</option>';
      }
    ?>
  </select>
  </br>
  <label for="numberOfSeats">Number of Seats:</label>
  <select id="numberOfSeats" name="numberOfSeats">
    <?php
      for($i = 1; $i < 100; $i++) {
        echo '<option value="' . $i . '">'. $i . '</option>';
      }
    ?>
  </select>
  </br>
  <ul id="meetings">
    <li>
      <input type="text" name="meetingLocation[]" placeholder="location">
      <select name="dayOfWeek[]">
        <option selected>Day of the Week</option>
        <option name="M">M</option>
        <option name="T">T</option>
        <option name="W">W</option>
        <option name="R">R</option>
        <option name="F">F</option>
      </select>
      <select name="startTime[]">
        <option selected>Start Time</option>
        <?php echo createTimeOptions() ?>
      </select>
      <select name="endTime[]">
        <option selected>End Time</option>
        <?php echo createTimeOptions() ?>
      </select>
    </li>
  </ul>
  <input type="button" value="+ Add Another Meeting" onclick="addMeeting()">
  </br>
  </br>
  <input type="hidden" value="<?php echo $courseId ?>" name="courseId">
  <button type="submit">Create Section</button>
</form>

<?php

  include('helpers/footer.php');
?>