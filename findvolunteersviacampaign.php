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
    <title>Search Volunteers | Al-Islah</title>
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


            function removevolunteer(did,cid){
                $.ajax({
                    type:"GET",
                    url:"/dms/removevolunteer.php",
                    data:"did="+did+"&cid="+cid,
                    dataType:"text",
                    success:function(result){
                        if (result === "success") {
                            alert("Deleted!");
                            location.reload();
                        }else{
                            alert("Error!");
                        }
                    }
                }); 
            }

        $().ready(function(){
            $("#myProfileLogoutBtn").click(function(){
                window.location = "/dms/logoff.php";
            });

            // get all campaigns and their ids
            $.getJSON("getallcampaigns.php",function(data){
                var _len = data.length, post, i;
                if (_len>0) {
                var trHTML = "<option value='' disabled selected>Select a Campaign</option><option value='all'>All</option>";
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

                if (data === "all") {
                    $.getJSON("getallvolunteers.php?id="+data,function(data){
                        var _len = data.length, post, i;
                        if (_len>0) {
                        var trHTML = '';
                        $.each(data, function (i, item) {
                            trHTML+='<tr><td>'+item.camTitle+'</td><td>'+item.name+'</td><td>'+item.number+'</td><td>'+item.email+'</td><td>'+item.address+'</td><td>'+item.createdat+'</td><td><a href="javascript:removevolunteer('+item.donorid+','+item.campaignid+');" target="_blank" class="btn btn-xs btn-danger">remove</a></td></tr>';
                            });
                        $("#volunteerTable > tbody > tr").remove();
                        $('#volunteerTable tbody').append(trHTML);
                          
                        }else{
                            $("#volunteerTable > tbody > tr").remove();
                            alert("No data found!");
                        }
                    });
                }else{

                    $.getJSON("getcampaignvolunteers.php?campaignid="+data,function(data){
                        var _len = data.length, post, i;
                        if (_len>0) {
                        var trHTML = '';
                        $.each(data, function (i, item) {
                            trHTML+='<tr><td>'+item.camTitle+'</td><td>'+item.name+'</td><td>'+item.number+'</td><td>'+item.email+'</td><td>'+item.address+'</td><td>'+item.createdat+'</td><td><a href="javascript:removevolunteer('+item.donorid+','+item.campaignid+');" target="_blank" class="btn btn-xs btn-danger">remove</a></td></tr>';
                            });
                        $("#volunteerTable > tbody > tr").remove();
                        $('#volunteerTable tbody').append(trHTML);
                          
                        }else{
                            $("#volunteerTable > tbody > tr").remove();
                            alert("No data found!");
                        }
                    });

                }
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
                <h3><u><b>Find Volunteers via Campaigns</b></u></h3>
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
                <u><h4>Volunteers Information</h4></u>
            </div>
            <div class="table table-responsive">
                <table id="volunteerTable" class="table table-striped table-condensed tabled-hovered table-bordered">
                    <caption>History</caption>
                    <thead>
                        <tr>
                            <th>Campaign Title</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Volunteered On</th>
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