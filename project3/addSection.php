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
    $db->makeQuery("SELECT Id, Name FROM Users, Roles WHERE Users.Id=Roles.UserId AND Role='faculty' AND DeptId=? LIMIT 1", $courseDeptId);
  } catch(Exception $e) {
    die("Error " . $e);
  }

  $professors = array();

  if($db->numRows >= 1) {
    $professors = $db->result;
  }
  else {
    die("There needs to be a professor before you can create a section");
  }
?>
<script type="text/javascript">
  function addMeeting() {
    var timeOptions = '<?php
      $hour = 1;
      $minute = 0;
      $morning = true;
      while(true) {
        echo '<option value="'. $hour . ':' . ($minute == 0 ? '00' : $minute) . '">'. $hour . ':' . ($minute == 0 ? '00' : $minute) . '</option>';

        $minute = ($minute + 30) % 60;

        if ($hour == 12 && $morning) {
          $hour = 1;
          $morning = false;
        }
        else if ($hour == 12 && !$morning) {
          break;
        }
        else if ($hour < 12) {
          $hour++;
        }
      }
    ?>';
    var newSessionTag = '<li><input type="text" name="meetingLocation[]" placeholder="location"><select name="startTime[]"><option selected>Start Time</option>' + timeOptions + '</select><select name="endTime[]"><option selected>End Time</option>' + timeOptions + '</select></li>';
    document.getElementById('meetings').innerHTML += newSessionTag;
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
    <li><input type="text" name="meetingLocation[]" placeholder="location"><select name="startTime[]"><option selected>Start Time</option><?php
      $hour = 1;
      $minute = 0;
      $morning = true;
      while(true) {
        echo '<option value="'. $hour . ':' . ($minute == 0 ? '00' : $minute) . '">'. $hour . ':' . ($minute == 0 ? '00' : $minute) . '</option>';

        $minute = ($minute + 30) % 60;

        if ($hour == 12 && $morning) {
          $hour = 1;
          $morning = false;
        }
        else if ($hour == 12 && !$morning) {
          break;
        }
        else if ($hour < 12) {
          $hour++;
        }
      }
    ?></select><select name="endTime[]"><option selected>End Time</option><?php
      $hour = 1;
      $minute = 0;
      $morning = true;
      while(true) {
        echo '<option value="'. $hour . ':' . ($minute == 0 ? '00' : $minute) . '">'. $hour . ':' . ($minute == 0 ? '00' : $minute) . '</option>';

        $minute = ($minute + 30) % 60;

        if ($hour == 12 && $morning) {
          $hour = 1;
          $morning = false;
        }
        else if ($hour == 12 && !$morning) {
          break;
        }
        else if ($hour < 12) {
          $hour++;
        }
      }
    ?></select></li>
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