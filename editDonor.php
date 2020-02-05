<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    if (isset($_POST['update']) && isset($_POST['firstname'])) {


    	$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    	$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    	$landline = mysqli_real_escape_string($con, $_POST['landline']);
    	$cellphone = mysqli_real_escape_string($con, $_POST['cell']);
    	$dob = mysqli_real_escape_string($con, $_POST['dob']);
    	$email = mysqli_real_escape_string($con, $_POST['email']);
    	$country = mysqli_real_escape_string($con, $_POST['country']);
    	$province = mysqli_real_escape_string($con, $_POST['state']);
    	$city = mysqli_real_escape_string($con, $_POST['city']);
    	$postalcode = mysqli_real_escape_string($con, $_POST['postalcode']);
    	$address = mysqli_real_escape_string($con, $_POST['address']);
    	$reference = mysqli_real_escape_string($con, $_POST['reference']);
    	$status = mysqli_real_escape_string($con, $_POST['status']);
    	$comments = mysqli_real_escape_string($con, $_POST['comments']);
    	$frequency = mysqli_real_escape_string($con, $_POST['frequency']);
    	$alarms = mysqli_real_escape_string($con, $_POST['alarms']);
    	$createdby = mysqli_real_escape_string($con, $_POST['createdby']);
    	$donorid = mysqli_real_escape_string($con, $_POST['donorid']);

    	$query = mysqli_query($con, 
    		"
    			update donors 
    			set 
	    			firstname = '$firstname',
	    			lastname = '$lastname',
	    			landline = '$landline',
	    			cellphone = '$cellphone',
	    			dob = '$dob',
	    			email = '$email',
	    			country = '$country',
	    			province = '$province',
	    			city = '$city',
	    			postalcode = '$postalcode',
	    			address = '$address',
	    			reference = '$reference',
	    			status = '$status',
	    			comments = '$comments',
	    			frequency = '$frequency',
	    			alarms = '$alarms',
	    			createdby = '$createdby' 
    			where 
    				donorid = '$donorid'
    		"
    	);

    	if ($query) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully updated a donor.");
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

    if (isset($_POST['delete']) && isset($_POST['firstname'])) {
    	$donorid = mysqli_real_escape_string($con, $_POST['donorid']);
    	$sql_check = mysqli_query($con,"DELETE FROM donors WHERE donorid='$donorid'") or die(mysqli_error($con));

    	if ($sql_check) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully deleted a donor.");
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
	<title>Update Donor | Al-Islah</title>
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

		  $("input[type='text']").keyup(function () {
		      this.value = this.value.replace(/,/g, "") ;
		     
		  });

		    $("#cellphoneField").change(function(){
		    	var data =  $("#cellphoneField").val();
		    	if (data.length > 1) {
		    		$.ajax({
		    			type:"GET",
		    			url:"/dms/validateemail.php",
		    			data:"cellphone="+data,
		    			dataType:"json",
		    			success:function(obj){
		    				if (obj) {
		    					//alert(obj[0].donorid);	
		    					$("#firstname").val(obj[0].firstname);
		    					$("#lastname").val(obj[0].lastname);
		    					$("#landline").val(obj[0].landline);
		    					$("#dob").val(obj[0].dob);
		    					$("#cellphoneField").val(obj[0].cellphone);
		    					$("#emailField").val(obj[0].email);
		    					$("#countryId").val(obj[0].country);

								$("#stateId").val(obj[0].province);
								$("#cityId").val(obj[0].city);

		    					
		    					$("#postalcode").val(obj[0].postalcode);
		    					$("#address").val(obj[0].address);
		    					$("#reference").val(obj[0].reference);
		    					$("#comments").val(obj[0].comments);
		    					$("#frequency").val(obj[0].frequency);
		    					$("#donorid").val(obj[0].donorid);

		    					//radio btns
		    					$("input[name=status][value='"+obj[0].status+"']").prop("checked",true);
		    					$("input[name=alarms][value='"+obj[0].alarms+"']").prop("checked",true);
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
					<h3><u><b>Edit Donor</b></u></h3>
					<br>
				</div>
				<div class="col-xs-6 form-group">
					<label for="firstname">First Name</label>
					<input type="text" id="firstname" name="firstname" class="form-control" required>
					<br>
					<label for="lastname">Last Name</label>
					<input type="text" id="lastname" name="lastname" class="form-control" required>
					<br>
					<label for="landline">Landline</label>
					<input type="text" id="landline" onkeypress="validateNumber(event)" name="landline" class="form-control" required>
					<br>
					<label for="cell">Cellphone</label>
					<input type="text" id="cellphoneField" onkeypress="validateNumber(event)" name="cell" class="form-control" required>
					<br>
					<label for="dob">Date of Birth</label>
					<input type="text" name="dob" id="dob" class="form-control" required>
					<br>
					<label for="email">Email</label>
					<input type="email" name="email" id="emailField" class="form-control" required>
					<br>
					<label for="country">Country</label>
					<input type="text" name="country" class="form-control" id="countryId" required>
					<br>
					<label for="province">Province</label>
					<input type="text" name="state" class="form-control" id="stateId" required>
					<br>
					<label for="city">City</label>
					<input type="text" name="city" class="form-control" id="cityId" required>
					<br>
					<label for="postalcode">Postal Code</label>
					<input type="text" onkeypress="validateNumber(event)" name="postalcode" id="postalcode" class="form-control" required>
					<br>
					<label for="address">Address</label>
					<input type="text" id="address" name="address" class="form-control" required>
				</div>
				<div class="col-xs-6 form-group">
					<label for="reference">Reference From</label>
					<input type="text" id="reference" name="reference" class="form-control" required>
					<br>
					<label for="status">Status - Volunteer Non Donor</label>
					<br>
					<label class="radio-inline">
				      <input type="radio" name="status" value="volunteer">Volunteer
				    </label>
				    <label class="radio-inline">
				      <input type="radio" name="status" value="donor">Donor
				    </label>
				    <label class="radio-inline">
				      <input type="radio" name="status" value="non-donor">Non-Donor
				    </label>
				    <br><br>
					<div style="margin-top: 13px;"></div>
					<label for="comments">Comments/Remarks</label>
					<input type="text" id="comments" name="comments" class="form-control" required>
					<br>
					<label for="frequency">Donation Frequency</label>
					<select name="frequency" id="frequency" required class="form-control">
						<option value="1">1 Month</option>
						<option value="2">2 Month</option>
						<option value="3">3 Month</option>
						<option value="4">4 Month</option>
						<option value="5">5 Month</option>
						<option value="6">6 Month</option>
						<option value="7">7 Month</option>
						<option value="8">8 Month</option>
						<option value="9">9 Month</option>
						<option value="10">10 Month</option>
						<option value="11">11 Month</option>
						<option value="12">12 Month</option>
						<option value="13">13 Month</option>
						<option value="14">14 Month</option>
						<option value="15">15 Month</option>
						<option value="16">16 Month</option>
						<option value="17">17 Month</option>
						<option value="18">18 Month</option>
						<option value="19">19 Month</option>
						<option value="20">20 Month</option>
						<option value="21">21 Month</option>
						<option value="22">22 Month</option>
						<option value="23">23 Month</option>
						<option value="24">24 Month</option>
					</select>
					<br>
					<label for="alarms">Donation Alarms</label>
					<br>
					<label class="radio-inline">
				      <input type="radio" name="alarms" value="yes">Alarms On
				    </label>
				    <label class="radio-inline">
				      <input type="radio" name="alarms" value="no">Alarms Off
				    </label>
				    <div style="margin-top: 13px"></div>
					<div style="display: block">
						<br>
						<label for="donorid">Donor ID</label>
						<input type="text" id="donorid" name="donorid" class="form-control" required readonly>
					</div>
					<div style="display: none">
						<br>
						<label for="alarms">Created By</label>
						<input type="text" name="createdby" value="<?php echo $_SESSION['id']; ?>" class="form-control" required>
					</div>

					<div style="text-align:center;">
						<hr>
							<i>All the information above is correct to the best of my knowledge</i>
						<hr>
					</div>
					<div class="center-block text-center">
						<input type="submit" name="update" value="Update Donor" class="btn btn-primary" style="width: 40%;">
						<input type="submit" value="Delete" name="delete" class="btn btn-danger" style="width: 40%;">
					</div>
				</div>	
			</form>
		</div>
	</div>
</section>



</body>
</html>