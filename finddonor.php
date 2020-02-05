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

	        // search btn click
	        $("#searchDonor").click(function(){
	        	var search = $("#searchDonorBar").val();
	        	//alert(search);

				$.getJSON("validateemail.php?cellphone="+search,function(data){
                    var _len = data.length, post, i;
                    if (_len>0) {
                    var trHTML = '';
                    $.each(data, function (i, item) {
                        trHTML='<tr><td>'+item.donorid+'</td><td>'+item.firstname+' '+item.lastname+'</td><td>'+item.email+'</td><td>'+item.cellphone+'</td><td>'+item.address+', '+item.city+', '+item.country+'</td><td>'+item.reference+'</td><td>'+item.createdon+'</td></tr>';
                        });
                    $("#donorTable > tbody > tr").remove();
					$('#donorTable tbody').append(trHTML);
                      
                    }else{
                    	$("#donorTable > tbody > tr").remove();
                        alert("No data found for this cell!");
                    }
                });

				// donationhistory
				$.getJSON("getdonations.php?cell="+search,function(data){
                    var _len = data.length, post, i;
                    if (_len>0) {
                    var trHTML = '';
                    $.each(data, function (i, item) {
                        trHTML+='<tr><td>'+item.donationid+'</td><td>'+item.donationcategory+'</td><td>'+item.campaigntitle+'</td><td>'+item.donationtype+'</td><td>'+item.amount+'</td><td>'+item.bankname+'</td><td>'+item.chequenumber+'</td><td>'+item.noofitems+'</td><td>'+item.donationmessage+'</td><td>'+item.donationcondition+'</td></tr>';
                        });
                    $("#donationsTable > tbody > tr").remove();
					$('#donationsTable tbody').append(trHTML);
                      
                    }else{
                    	$("#donationsTable > tbody > tr").remove();
                        alert("No data found for this cell!");
                    }
                });

	        });

	        // handle enter press in search bar
            $('#searchDonorBar').on("keypress", function(e) {
                if (e.keyCode == 13) {

		        	var search = $("#searchDonorBar").val();
		        	//alert(search);

					$.getJSON("validateemail.php?cellphone="+search,function(data){
	                    var _len = data.length, post, i;
	                    if (_len>0) {
	                    var trHTML = '';
	                    $.each(data, function (i, item) {
	                        trHTML='<tr><td>'+item.donorid+'</td><td>'+item.firstname+' '+item.lastname+'</td><td>'+item.email+'</td><td>'+item.cellphone+'</td><td>'+item.address+', '+item.city+', '+item.country+'</td><td>'+item.reference+'</td><td>'+item.createdon+'</td></tr>';
	                        });
	                    $("#donorTable > tbody > tr").remove();
						$('#donorTable tbody').append(trHTML);
	                      
	                    }else{
	                    	$("#donorTable > tbody > tr").remove();
	                        alert("No data found for this cell!");
	                    }
	                });

					// donationhistory
					$.getJSON("getdonations.php?cell="+search,function(data){
	                    var _len = data.length, post, i;
	                    if (_len>0) {
	                    var trHTML = '';
	                    $.each(data, function (i, item) {
	                        trHTML+='<tr><td>'+item.donationid+'</td><td>'+item.donationcategory+'</td><td>'+item.campaigntitle+'</td><td>'+item.donationtype+'</td><td>'+item.amount+'</td><td>'+item.bankname+'</td><td>'+item.chequenumber+'</td><td>'+item.noofitems+'</td><td>'+item.donationmessage+'</td><td>'+item.donationcondition+'</td></tr>';
	                        });
	                    $("#donationsTable > tbody > tr").remove();
						$('#donationsTable tbody').append(trHTML);
	                      
	                    }else{
	                    	$("#donationsTable > tbody > tr").remove();
	                        alert("No data found for this cell!");
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
				<h3><u><b>Find Donor</b></u></h3>
				<br>
			</div>
			<div class="row">
				<div class="col-lg-6">
				    <div class="input-group">
				      <input id="searchDonorBar" type="text" class="form-control" placeholder="Search via cellphone ...">
				      <span class="input-group-btn">
				        <input id="searchDonor" class="btn btn-default" value="Go!" type="button">
				      </span>
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
				<u><h4>Donor's Information</h4></u>
			</div>
			<div class="table table-responsive">
				<table id="donorTable" class="table table-striped table-condensed tabled-hovered table-bordered">
					<caption>Personal Information</caption>
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Cell</th>
							<th>Address</th>
							<th>Reference</th>
							<th>CreatedOn</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>


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
							<th>#</th>
							<th>Category</th>
							<th>Title</th>
							<th>Type</th>
							<th>Amount</th>
							<th>Bank</th>
							<th>Cheque #</th>
							<th>Items</th>
							<th>Message</th>
							<th>Condition</th>
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