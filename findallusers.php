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
	<title>Find Users | Al-Islah</title>
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

			$.getJSON("getallusers.php",function(data){
                var _len = data.length, post, i;
                if (_len>0) {
                var trHTML = '';
                $.each(data, function (i, item) {
                    trHTML+='<tr><td>'+item.userid+'</td><td>'+item.name+'</td><td>'+item.email+'</td><td>'+item.cell+'</td><td>'+item.address+', '+item.city+'</td><td>'+item.type+'</td><td>'+item.createdat+'</td></tr>';
                });
                $("#userTable > tbody > tr").remove();
				$('#userTable tbody').append(trHTML);
                  
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
				<h3><u><b>All Users</b></u></h3>
				<br>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="row">
		<div class="container">
			<div>
				<u><h4>User's Information</h4></u>
			</div>
			<div class="table table-responsive">
				<table id="userTable" class="table table-striped table-condensed tabled-hovered table-bordered">
					<caption>Personal Information</caption>
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Cell</th>
							<th>Address</th>
							<th>Type</th>
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

</body>
</html>