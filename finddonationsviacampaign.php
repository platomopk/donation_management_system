<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
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
        function validateNumber(evt) {
          var theEvent = evt || window.event;
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode( key );
          var regex = /[0-9]|\./;
          if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }
        }

        $().ready(function(){
            $("#myProfileLogoutBtn").click(function(){
                window.location = "/dms/logoff.php";
            });

            // get all campaigns and their ids
            $.getJSON("getallcampaigns.php",function(data){
                var _len = data.length, post, i;
                if (_len>0) {
                var trHTML = "<option value='' disabled selected>Select a Campaign</option>";
                $.each(data, function (i, item) {
                    trHTML+='<option value='+item.campaignid+'>'+item.title+'</option>';
                });
                //$("#campaignid").remove();
                $('#campaignid').append(trHTML);
                  
                }else{
                    alert("No data found!");
                }
            });


            // set a max bar on donation that a specific campaign can recieve
            $("#campaignid").change(function(){
                var data =  $("#campaignid").val();

                $.getJSON("getdonationsviacamp.php?id="+data,function(data){
                    var _len = data.length, post, i;
                    if (_len>0) {
                    var trHTML = '';
                    $.each(data, function (i, item) {
                        trHTML+='<tr><td>'+item.donationcategory+'</td><td>'+item.donorname+'</td><td>'+item.donationtype+'</td><td>'+item.amount+'</td><td>'+item.bankname+'</td><td>'+item.chequenumber+'</td><td>'+item.noofitems+'</td><td>'+item.donationmessage+'</td><td>'+item.donationcondition+'</td><td><a href="/dms/editdonation.php?donationid='+item.donationid+'" target="_blank" class="btn btn-xs btn-default">Edit</a></td></tr>';
                        });
                    $("#donationsTable > tbody > tr").remove();
                    $('#donationsTable tbody').append(trHTML);
                      
                    }else{
                        alert("No data found for this Campaign!");
                    }
                });


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
                <h3><u><b>Find Donations via Campaigns</b></u></h3>
                <br>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <select name="campaignid" id="campaignid" required class="form-control">
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<br>
<section>
    <div class="row">
        <div class="container">
            <div>
                <u><h4>Donations Information</h4></u>
            </div>
            <div class="table table-responsive">
                <table id="donationsTable" class="table table-striped table-condensed tabled-hovered table-bordered">
                    <caption>History</caption>
                    <thead>
                        <tr>
                            <th>Cat</th>
                            <th>Donor Name</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Bank</th>
                            <th>Cheque #</th>
                            <th>Items</th>
                            <th>Message</th>
                            <th>Condition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>



</body>
</html>