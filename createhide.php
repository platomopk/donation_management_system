<?php
include 'db_connect.php';


if(isset($_POST['donorid'])) { //change isSet to isset (it will not make any difference)
    $donorid= mysqli_real_escape_string($con,$_POST['donorid']); //escape the string
$lastdonated = "";

	$getLastDonated = mysqli_query($con,"select donations.createdon from donations where donations.donorid='$donorid' order by donations.createdon desc limit 1");
	
	while ($row = mysqli_fetch_assoc($getLastDonated)){
		$lastdonated = $row['createdon'];	
	}
	
	//echo $donorid.' '.$lastdonated;
	

        $sql_check = mysqli_query($con,"insert into notifications (donorid,lastdonated) values ('$donorid','$lastdonated') ") or die(mysqli_error($con));
        if(mysqli_affected_rows($con) > 0) { //check rows greater then zero (although it will also not make any difference)
            echo 'ok';
        } else {
          echo 'error';
       }
}
?>