<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    if (isset($_POST['update'])) {

    	$oname = mysqli_real_escape_string($con, $_POST['organizername']);
    	$ocell = mysqli_real_escape_string($con, $_POST['organizercell']);
    	$title = mysqli_real_escape_string($con, $_POST['campaigntitle']);
    	$category = mysqli_real_escape_string($con, $_POST['campaigncategory']);
    	$location = mysqli_real_escape_string($con, $_POST['location']);
    	$description = mysqli_real_escape_string($con, $_POST['description']);
    	$goal = mysqli_real_escape_string($con, $_POST['goal']);
    	$deadline = mysqli_real_escape_string($con, $_POST['deadline']);
    	$bname = mysqli_real_escape_string($con, $_POST['bname']);
    	$bcell = mysqli_real_escape_string($con, $_POST['bcell']);
    	$baddress = mysqli_real_escape_string($con, $_POST['baddress']);
    	$campaignid = mysqli_real_escape_string($con, $_POST['campaignid']);

    	$query = mysqli_query($con, 
    		"
    			update campaigns 
    			set 
	    			oname = '$oname',
	    			ocell = '$ocell',
	    			title = '$title',
	    			category = '$category',
	    			location = '$location',
	    			description = '$description',
	    			goal = '$goal',
	    			deadline = '$deadline',
	    			bname = '$bname',
	    			bcell = '$bcell',
	    			baddress = '$baddress'
    			where 
    				campaignid = '$campaignid'
    		"
    	);

    	if ($query) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully updated a campaign.");
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
	<title>Update Campaign | Al-Islah</title>
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
	        
	        $("input[type='text']").keyup(function () {
		      this.value = this.value.replace(/,/g, "") ;
		     
		  	});

			$( "#deadline" ).datepicker({ dateFormat : "yy-mm-dd" });	

		    $("#title").change(function(){
		    	var data =  $("#title").val();
		    	if (data.length > 1) {
		    		$.ajax({
		    			type:"GET",
		    			url:"/dms/getcampaigndata.php",
		    			data:"title="+data,
		    			dataType:"json",
		    			success:function(obj){
		    				if (obj) {
		    					try{
		    					$("#oname").val(obj[0].oname);
		    					$("#ocell").val(obj[0].ocell);
		    					$("#title").val(obj[0].title);
								$("#category").val(obj[0].category);
								$("#goal").val(obj[0].goal);
		    					$("#deadline").val(obj[0].deadline);
		    					
		    					if (obj[0].status == "passed") {
		    						$('#goal').prop('readonly', true);
		    						$('#deadline').prop('readonly', true);
		    					}else{
									$('#goal').prop('readonly', false);
		    						$('#deadline').prop('readonly', false);
		    					}

		    					$("#location").val(obj[0].location);
		    					$("#description").val(obj[0].description);
		    					$("#bname").val(obj[0].bname);
		    					$("#bcell").val(obj[0].bcell);
		    					$("#baddress").val(obj[0].baddress);
		    					$("#campaignid").val(obj[0].campaignid);
								}catch(err){
									console.log(err);
								}

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
					<h3><u><b>Edit Campaign</b></u></h3>
					<br>
				</div>
				<div class="col-xs-6 form-group">
					<label for="">Organizer Name</label>
					<input type="text" id="oname" name="organizername" class="form-control" required>
					<br>
					<label for="">Organizer Cellphone</label>
					<input type="text" onkeypress="validateNumber(event)" id="ocell" name="organizercell" class="form-control" required>
					<br>
					<label for="">Campaign Title</label>
					<input type="text" name="campaigntitle" id="title" class="form-control" required>
					<br>
					<label for="">Campaign Category</label>
					<select name="campaigncategory" id="category" required class="form-control">
						<option value="all">All</option>
						<option value="zakaat" selected>Zakaat</option>
						<option value="sadqaat">Sadqaat</option>
						<option value="endorsement">Endorsement</option>
						<option value="sponsorship">Sponsorship</option>
						<option value="inkind">Inkind</option>
					</select>
					<br>
					<label for="">Location</label>
					<input type="text" name="location" id="location" class="form-control" required>
					<br>
					<label for="">Description</label>
					<input type="text" name="description" id="description" class="form-control" required>
				</div>
				<div class="col-xs-6 form-group">
					<label for="">Goal Amount (Rs.)</label>
					<input type="text" id="goal" onkeypress="validateNumber(event)" name="goal" class="form-control" required>
					<br>
					<label for="">Deadline</label>
					<input type="text" name="deadline" id="deadline" class="form-control" required>
					<br>
					<label for="">Beneficiary's Name</label>
					<input type="text" name="bname" id="bname" class="form-control" required>
					<br>
					<label for="">Beneficiary's Cell</label>
					<input type="text" name="bcell" id="bcell" class="form-control" required>
					<br>
					<label for="">Beneficiary's Address</label>
					<input type="text" name="baddress" id="baddress" class="form-control" required>
					<br>
					<div style="display: block">
						<label for="campaignid">Campaign ID</label>
						<input type="text" id="campaignid" name="campaignid" class="form-control" required readonly>
					</div>

					<div style="text-align:center;">
						<hr>
							<i>All the information above is correct to the best of my knowledge</i>
						<hr>
					</div>
					<div class="center-block text-center">
						<input type="submit" name="update" value="Update Campaign" class="btn btn-primary" style="width: 100%;">
					</div>
				</div>	
			</form>
		</div>
	</div>
</section>



</body>
</html>