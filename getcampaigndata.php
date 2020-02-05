<?php
include 'db_connect.php';


if(isset($_GET['title'])) { //change isSet to isset (it will not make any difference)
    $title = mysqli_real_escape_string($con,$_GET['title']); //escape the string

    $sql_check = mysqli_query($con,"SELECT campaigns.*, 
	(case when (campaigns.deadline < NOW()) then 'passed' else 'upcoming' end) as status 
     FROM campaigns WHERE title='$title'") or die(mysqli_error($con));

    $rows = array();

    while($row = mysqli_fetch_assoc($sql_check)){
    	$rows[] = $row;
    }

    echo json_encode($rows);

}
?>