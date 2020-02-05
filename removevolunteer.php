<?php

include 'db_connect.php';

	$cid = mysqli_real_escape_string($con,$_GET['cid']);
	$did = mysqli_real_escape_string($con,$_GET['did']);


	$query= mysqli_query($con,
	"Delete from volunteers where campaignid='$cid' and donorid='$did'");

	if (mysqli_affected_rows($con)>0) 
	{
		echo "success";
	}
	else
	{
		echo "err";
	}




?>