<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    if (isset($_POST['submit'])) {
    	$name = mysqli_real_escape_string($con, $_POST['name']);
    	$cell = mysqli_real_escape_string($con, $_POST['cell']);
    	$city = mysqli_real_escape_string($con, $_POST['city']);
    	$address = mysqli_real_escape_string($con, $_POST['address']);
    	$email = mysqli_real_escape_string($con, $_POST['email']);
    	$password = mysqli_real_escape_string($con, $_POST['password']);
    	$type = mysqli_real_escape_string($con, $_POST['type']);

    	// hashing password
    	$password = password_hash($password,PASSWORD_DEFAULT);

    	$query = mysqli_query($con, 
    		"Insert into users 
	    		(
	    			email,password,name,cell,address,city,type
	    		) 
    		values 
    			(
					'$email','$password','$name','$cell',
					'$address','$city','$type'
    			)"
    	);

    	if ($query) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully created a user.");
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
	<title>Create New User | Al-Islah</title>
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
		    	if (data.length > 5) {
		    		$.ajax({
		    			type:"POST",
		    			url:"/dms/verifyemailuser.php",
		    			data:"email="+data,
		    			dataType:"text",
		    			success:function(msg){
		    				if (msg == "ok") {
		    					$("#emailField").removeClass('danger');
		    					$("#emailField").removeClass('normal');
		    					$("#emailField").addClass('success');
		    					//alert("You can use this email.")
		    				}else{
		    					$("#emailField").removeClass('normal');
		    					$("#emailField").removeClass('success');
		    					$("#emailField").addClass('danger');
		    					$("#emailField").val("Try with any other email");
		    					alert("User already registered with this email.")
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
					<h3><u><b>Create New User</b></u></h3>
					<br>
				</div>
				<div class="col-xs-6 form-group">
					<label for="name">Full Name</label>
					<input type="text" id="name" name="name" class="form-control" required>
					<br>
					<label for="cell">Cellphone</label>
					<input type="text" onkeypress="validateNumber(event)" name="cell" class="form-control" required>
					<br>
					<label for="address">Address</label>
					<input type="text" name="address" class="form-control" required>
					<br>
					<label for="city">City</label>
					<input type="text" name="city" class="form-control" id="cityId" required>
				</div>
				<div class="col-xs-6 form-group">
					<label for="email">Email</label>
					<input type="email" name="email" id="emailField" class="form-control" required>
					<br>
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" required>
					<br>
					<label for="type">Privilage Type</label>
					<select name="type" required class="form-control">
						<option value="user" selected>User</option>
						<option value="admin">Admin</option>
					</select>
					<br><br>
					<div style="margin-top: 5px;"></div>
					<div class="center-block text-center">
						<input type="submit" name="submit" value="Create New User" class="btn btn-primary" style="width: 40%;">
						<input type="reset" value="Clear Fields" class="btn btn-danger" style="width: 40%;">
					</div>
				</div>	
			</form>			
		</div>
	</div>
	<div style="text-align:center;">
		<hr>
			<i>All the information above is correct to the best of my knowledge</i>
		<hr>
	</div>
</section>



</body>
</html>