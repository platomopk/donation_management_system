<?php
include 'db_connect.php';


if(isset($_GET['email'])) { //change isSet to isset (it will not make any difference)
    $email = mysqli_real_escape_string($con,$_GET['email']); //escape the string

    $sql_check = mysqli_query($con,"SELECT * FROM users WHERE email='$email'") or die(mysqli_error($con));

    $rows = array();

    while($row = mysqli_fetch_assoc($sql_check)){
    	$rows[] = $row;
    }

    echo json_encode($rows);

}
?>