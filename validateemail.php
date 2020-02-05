<?php
include 'db_connect.php';


if(isset($_GET['cellphone'])) { //change isSet to isset (it will not make any difference)
    $cellphone = mysqli_real_escape_string($con,$_GET['cellphone']); //escape the string

    $sql_check = mysqli_query($con,"SELECT * FROM donors WHERE cellphone='$cellphone'") or die(mysqli_error($con));

    $rows = array();

    while($row = mysqli_fetch_assoc($sql_check)){
    	$rows[] = $row;
    }

    echo json_encode($rows);

}
?>