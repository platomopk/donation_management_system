<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    if (isset($_POST['update'])) {

    	$name = mysqli_real_escape_string($con, $_POST['name']);
    	$cell = mysqli_real_escape_string($con, $_POST['cell']);
    	$email = mysqli_real_escape_string($con, $_POST['email']);
    	$city = mysqli_real_escape_string($con, $_POST['city']);
    	$address = mysqli_real_escape_string($con, $_POST['address']);
    	
    	$type = mysqli_real_escape_string($con, $_POST['type']);
    	$userid = mysqli_real_escape_string($con, $_POST['userid']);

    	$query = mysqli_query($con, 
    		"
    			update users 
    			set 
	    			name = '$name',
	    			cell = '$cell',
	    			type = '$type',
	    			email = '$email',
	    			city = '$city',
	    			address = '$address'
    			where 
    				userid = '$userid'
    		"
    	);

    	if ($query) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully updated a user.");
						if (r == true){
							window.location="/dms/dashboard.php";
						}else{
							window.location="/dms/dashboard.php";
						}
					  </script>';
    		}else{
    			echo '<script>alert("An error occured. Please try again later.");</script>';
    		}
    	}
    }

?>


<!DOCTYPE html>
<html>
<head>
	<title>Update User | Al-Islah</title>
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
		    $( "#dob" ).datepicker({
			      changeMonth: true,
			      changeYear: true
		    });

		    $("#emailField").change(function(){
		    	var data =  $("#emailField").val();
		    	if (data.length > 1) {
		    		$.ajax({
		    			type:"GET",
		    			url:"/dms/getuserdata.php",
		    			data:"email="+data,
		    			dataType:"json",
		    			success:function(obj){
		    				if (obj) {
		    					//alert(obj[0].donorid);	
		    					$("#name").val(obj[0].name);
		    					$("#cellphoneField").val(obj[0].cell);
		    					$("#emailField").val(obj[0].email);
								$("#cityId").val(obj[0].city);
		    					
		    					$("#address").val(obj[0].address);
		    					$("#userid").val(obj[0].userid);
		    					$("#type").val(obj[0].type);

		    				}
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
			<form method="post" accept-charset="utf-8">
				<div>
					<h3><u><b>Edit User</b></u></h3>
					<br>
				</div>
				<div class="col-xs-6 form-group">
					<label for="name">Full Name</label>
					<input type="text" id="name" name="name" class="form-control" required>
					<br>
					<label for="cell">Cellphone</label>
					<input type="text" id="cellphoneField" onkeypress="validateNumber(event)" name="cell" class="form-control" required>
					<br>
					<label for="address">Address</label>
					<input type="text" id="address" name="address" class="form-control" required>
					<br>
					<label for="city">City</label>
					<input type="text" name="city" class="form-control" id="cityId" required>

				</div>
				<div class="col-xs-6 form-group">

					<label for="email">Email</label>
					<input type="email" name="email" id="emailField" class="form-control" required>
					<br>
					<label for="type">Privilage Type</label>
					<select id="type" name="type" required class="form-control">
						<option value="user">User</option>
						<option value="admin">Admin</option>
					</select>
					<br>
					<div style="display: block">
						<label for="userid">User ID</label>
						<input type="text" id="userid" name="userid" class="form-control" required readonly>
					</div>

					<div style="text-align:center;">
						<hr>
							<i>All the information above is correct to the best of my knowledge</i>
						<hr>
					</div>
					<div class="center-block text-center">
						<input type="submit" name="update" value="Update User" class="btn btn-primary" style="width: 100%;">
					</div>
				</div>	
			</form>
		</div>
	</div>
</section>



</body>
</html>