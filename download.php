<?php 

    session_start();
    
    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }


    if (isset($_POST['donations'])) {
        $filename = 'donations'.time().'.csv';
        $file = fopen($filename,"w");
        $result = mysqli_query($con,"select * from donations");

        $donationColumns = 
        array(
            "Id","Category","Campaign ID",
            "Donor ID","Type","Payment Mode",
            "Amount","Bank","Cheque","Items",
            "Items Desc","Condtion","Message",
            "Created On","Rec. By"
        );

        fputcsv($file,$donationColumns);

        while ($row = mysqli_fetch_row($result)) {
                fputcsv($file,$row);
        }
        fclose($file);
        header("content-type: text/plain");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;"); 
        readfile($filename);
        unlink($filename);
        exit();
    }

    if (isset($_POST['donors'])) {
        $filename = 'donors'.time().'.csv';
        $file = fopen($filename,"w");
        $result = mysqli_query($con,"select * from donors");

        $donationColumns = 
        array(
            "Id","First Name","Last Name",
            "Landline","Cellphone","DOB",
            "Email","Country","Province","City",
            "Postal Code","Address","Reference",
            "Status","Comments","Donation Frequency",
            "Alarms","Created By","Created At"
        );

        fputcsv($file,$donationColumns);

        while ($row = mysqli_fetch_row($result)) {
                fputcsv($file,$row);
        }
        fclose($file);
        header("content-type: text/plain");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;"); 
        readfile($filename);
        unlink($filename);
        exit();
    }

    if (isset($_POST['campaigns'])) {
        $filename = 'campaigns'.time().'.csv';
        $file = fopen($filename,"w");
        $result = mysqli_query($con,"select * from campaigns");

        $donationColumns = 
        array(
            "Id","Organizer","Org. Cell",
            "Title","Category","Location",
            "Description","Goal","Deadline","Benificiary",
            "Ben. Cell","Ben. Address","Created At",
            "Status"
        );

        fputcsv($file,$donationColumns);

        while ($row = mysqli_fetch_row($result)) {
                fputcsv($file,$row);
        }
        fclose($file);
        header("content-type: text/plain");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;"); 
        readfile($filename);
        unlink($filename);
        exit();
    }

    if (isset($_POST['volunteers'])) {
        $filename = 'volunteers'.time().'.csv';
        $file = fopen($filename,"w");
        $result = mysqli_query($con,"select * from volunteers");

        $donationColumns = 
        array(
            "Id","Created At","DonorID",
            "CampaignID"
        );

        fputcsv($file,$donationColumns);

        while ($row = mysqli_fetch_row($result)) {
                fputcsv($file,$row);
        }
        fclose($file);
        header("content-type: text/plain");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;"); 
        readfile($filename);
        unlink($filename);
        exit();
    }

?>


<!DOCTYPE html>
<html>
<head>
    <title>Search Donor | Al-Islah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,user-scalable=no">

    <script src="js/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome.min.css">

    <script src="js/form.js" type="text/javascript"></script>

    <script>

        $().ready(function(){
            $("#myProfileLogoutBtn").click(function(){
                window.location = "/dms/logoff.php";
            });
        });

    </script>


    <style type="text/css" media="screen">
        body{
            overflow-x: hidden;
        }
        #mainlogo{
            padding: 5px;
            height: 60px;
            width: 65px;
        }
        img{
            image-rendering: pixelated;
        }

        .btnHover:hover{
            background-color: #CFD8DC;
            cursor: pointer;
        }
        .success{
            border-color: green;
        }
        .danger{
            border-color: red;
        }
        .normal{
            border-color: #ccc;
        }

    </style>


</head>
<body>

<!-- header -->
<?php include 'header.php';?>

<!-- Create New Donor fields -->
<br>
<section>
    <div class="row">
        <div class="container">
            <div>
                <h3><u><b>Bulk Download</b></u></h3>
                <br>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="container">
            <div>
                <u><h4>Categories</h4></u>
            </div>

            <form method="POST">
                <div class="table table-responsive">
                    <table id="donorTable" class="table table-striped table-condensed tabled-hovered table-bordered">
                        <caption>List</caption>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="1">1</td>
                                <td colspan="1">Donations</td>
                                <td><input type="submit" name="donations" value="Download CSV" class="btn btn-xs btn-default"></td>
                            </tr>
                            <tr>
                                <td colspan="1">2</td>
                                <td colspan="1">Donors</td>
                                <td><input type="submit" name="donors" value="Download CSV" class="btn btn-xs btn-default"></td>
                            </tr>
                            <tr>
                                <td colspan="1">3</td>
                                <td colspan="1">Campaigns</td>
                                <td><input type="submit" name="campaigns" value="Download CSV" class="btn btn-xs btn-default"></td>
                            </tr>
                            <tr>
                                <td colspan="1">4</td>
                                <td colspan="1">Volunteers</td>
                                <td><input type="submit" name="volunteers" value="Download CSV" class="btn btn-xs btn-default"></td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
            </form>
        </div>
    </div>
</section>

</body>
</html>