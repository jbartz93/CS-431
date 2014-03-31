<?php
	include('helpers/base.php');
    
    for ($i=0;$i<$_REQUEST['count'];$i++) {
        if (isset($_REQUEST['changegrade'.$i])) {
            $db->makeQuery("UPDATE registration SET GradeGPA = ".$_REQUEST['newgrade'.$i]." WHERE UserId = ".$_REQUEST['studentid'.$i]." AND CourseInstanceId = ".$_REQUEST['sectionid'.$i].";");
        }
    }
    
	header('Location: ' . BASE_URL . 'assigngrades.php');
    ?>