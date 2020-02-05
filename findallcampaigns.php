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
	<title>List Campaigns | Al-Islah</title>
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

			$.getJSON("getallcampaigns.php",function(data){
                var _len = data.length, post, i;
                if (_len>0) {
                var trHTML = '';
                $.each(data, function (i, item) {
                    trHTML+='<tr><td>'+item.campaignid+'</td><td>'+item.oname+'</td><td>'+item.ocell+'</td><td>'+item.title+'</td><td>'+item.goal+'</td><td>'+item.achieved+'</td><td>'+item.category+'</td><td>'+item.location+'</td><td>'+item.deadline+'</td><td>'+item.bname+'</td><td>'+item.bcell+'</td></tr>';
                });
                $("#campaignTable > tbody > tr").remove();
				$('#campaignTable tbody').append(trHTML);
                  
                }else{
                    alert("No data found!");
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
				<h3><u><b>All Campaigns</b></u></h3>
				<br>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="row">
		<div class="container">
			<div>
				<u><h4>Campaigns Information</h4></u>
			</div>
			<div class="table table-responsive">
				<table id="campaignTable" class="table table-striped table-condensed tabled-hovered table-bordered">
					<caption>History</caption>
					<thead>
						<tr>
							<th>#</th>
                            <th>Org. Name</th>
                            <th>Org. Cell</th>
							<th>Title</th>
                            <th>Goal Rs.</th>
                            <th>Achieved Rs.</th>
							<th>Category</th>
							<th>Location</th>
							<th>Deadline</th>
							<th>Benf. Name</th>
                            <th>Benf. Cell</th>
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