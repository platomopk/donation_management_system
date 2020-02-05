<?php
include 'db_connect.php';


if(isset($_GET['id'])) { //change isSet to isset (it will not make any difference)
    $id = mysqli_real_escape_string($con,$_GET['id']); //escape the string

    $sql_check = mysqli_query($con,"SELECT donations.*, (select concat(donors.firstname,' ',donors.lastname) from donors where donors.donorid = donations.donorid) as donorname FROM donations WHERE campaignid='$id'") or die(mysqli_error($con));

    $rows = array();

    while($row = mysqli_fetch_assoc($sql_check)){
    	$rows[] = $row;
    }

    echo json_encode($rows);

}
?>