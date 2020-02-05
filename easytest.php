<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

//	print_r($_POST);

    if (isset($_POST['submit'])) {
    	$campaignid = mysqli_real_escape_string($con, $_POST['campaignid']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $dcellphone = mysqli_real_escape_string($con, $_POST['dcellphone']);
        $dname = mysqli_real_escape_string($con, $_POST['dname']);
        $createdby = mysqli_real_escape_string($con, $_POST['createdby']);
        

        $donorid = '';

        $checkexisting = mysqli_query($con,"select donorid from donors where cellphone='$dcellphone'");
        if(mysqli_num_rows($checkexisting)>0){
            // donor exists
            while($row = mysqli_fetch_assoc($checkexisting)){
                $donorid = $row['donorid'];
            }
            

            // create new donation
            $createnewdonation = mysqli_query($con,"insert into donations 
            (donorid,campaignid,amount,createdby) values ('$donorid','$campaignid','$amount','$createdby')");

            if (mysqli_affected_rows($con)>0) {
                echo 
                '<script>
                    var r = confirm("Successfully created a donation");
                    if (r == true){
                        window.location="/dms/easycreate.php";
                    }else{
                        window.location="/dms/easycreate.php";
                    }
                </script>';
            }else{
                echo '<script>alert("An error occured while adding a donation. Please try again later.");</script>';
            }
            
            
        }else{
            // create new donor
            $donorcreate = mysqli_query($con,"insert into donors (firstname,cellphone,createdby) values ('$dname','$dcellphone','$createdby')");
            if (mysqli_affected_rows($con)>0) {
                // donor created 
                // now find donorid from cellphone
                $checkexisting = mysqli_query($con,"select donorid from donors where cellphone='$dcellphone'");
                if(mysqli_num_rows($checkexisting)>0){
                    // donor exists
                    while($row = mysqli_fetch_assoc($checkexisting)){
                        $donorid = $row['donorid'];
                    }
        
                    // create new donation
                    $createnewdonation = mysqli_query($con,"insert into donations 
                    (donorid,campaignid,amount,createdby) values ('$donorid','$campaignid','$amount','$createdby')");
        
                    if (mysqli_affected_rows($con)>0) {
                        echo 
                        '<script>
                            var r = confirm("Successfully created a donation and added a donor");
                            if (r == true){
                                window.location="/dms/easycreate.php";
                            }else{
                                window.location="/dms/easycreate.php";
                            }
                        </script>';
                    }else{
                        echo '<script>alert("An error occured while adding a donation. Please try again later.");</script>';
                    }
                }else{
                    echo '<script>alert("Donor/Donation could not be added at the moment. Please try again after some time");</script>';
                }

            }else{
                echo '<script>alert("An error occured while adding a donation. Please try again later.");</script>';
            }
        }
        
    }

echo mysqli_error($con);
?>
