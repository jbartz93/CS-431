<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
		
<?php
	if ($userId) {
		if(@$permissions) {
			try {
				$db->makeQuery("select * from Permissions where UserId=? limit 1", $userId);
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
			
?>
	<a href="<?php echo BASE_URL ?>main.php">Home</a>
    <a href="<?php echo BASE_URL ?>logout.php">Log Out</a>
<?php
  } else if (!$userId && $needsToBeLoggedIn) {
    die("You need to be <a href='".BASE_URL."login.php'>logged in</a> to view this");
  }
?>