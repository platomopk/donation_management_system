<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    if (isset($_POST['submit'])) {
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

    	$query = mysqli_query($con, 
    		"Insert into campaigns 
	    		(
	    			oname,ocell,title,category,
	    			location,description,goal,deadline,
	    			bname,bcell,baddress
	    		) 
    		values 
    			(
					'$oname','$ocell','$title','$category',
					'$location','$description','$goal','$deadline','$bname',
					'$bcell','$baddress'
    			)"
    	);

    	if ($query) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully created a campaign.");
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
	<title>Create New Campaign | Al-Islah</title>
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
			
			$( "#deadline" ).datepicker({ dateFormat : "yy-mm-dd" });
			
			$("input[type='text']").keyup(function () {
				this.value = this.value.replace(/,/g, "") ;
				
			});

		    $("#title").change(function(){
		    	var data =  $("#title").val();
				data  = $.trim(data);
		    	if (data.length > 1) {
		    		$.ajax({
		    			type:"POST",
		    			url:"/dms/verifytitle.php",
		    			data:"title="+data,
		    			dataType:"text",
		    			success:function(msg){
		    				if (msg == "ok") {
		    					$("#title").removeClass('normal');
		    					$("#title").removeClass('danger');
		    					$("#title").addClass('success');
		    					//alert("You can use this email.")
		    				}else{
		    					$("#title").removeClass('normal');
		    					$("#title").removeClass('success');
		    					$("#title").addClass('danger');
		    					$("#title").val("");
		    					alert("A campaign with this title exists, please try another!")
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
					<h3><u><b>Create New Campaign</b></u></h3>
					<br>
				</div>
				<div class="col-xs-6 form-group">
					<label for="">Organizer Name</label>
					<input type="text" id="organizername" name="organizername" class="form-control no-comma" required>
					<br>
					<label for="">Organizer Cellphone</label>
					<input type="text" onkeypress="validateNumber(event)" name="organizercell" class="form-control no-comma" required>
					<br>
					<label for="">Campaign Title</label>
					<input type="text" id="title" name="campaigntitle" class="form-control no-comma" required>
					<br>
					<label for="">Campaign Category</label>
					<select name="campaigncategory" class="form-control">
						<option value="all" selected>All</option>
						<option value="zakaat">Zakaat</option>
						<option value="sadqaat">Sadqaat</option>
						<option value="endorsement">Endorsement</option>
						<option value="sponsorship">Sponsorship</option>
						<option value="inkind">Inkind</option>
					</select>
					<br>
					<label for="">Location</label>
					<input type="text" name="location" class="form-control no-comma" >
					<br>
					<label for="">Description</label>
					<input type="text" name="description" class="form-control no-comma" >
				</div>
				<div class="col-xs-6 form-group">
					<label for="">Goal Amount (Rs.)</label>
					<input type="text" onkeypress="validateNumber(event)" name="goal" class="form-control" >
					<br>
					<label for="">Deadline</label>
					<input type="text" name="deadline" id="deadline" class="form-control" >
					<br>
					<label for="">Beneficiary's Name</label>
					<input type="text" name="bname" class="form-control no-comma" >
					<br>
					<label for="">Beneficiary's Cell</label>
					<input type="text" name="bcell" onkeypress="validateNumber(event)" class="form-control" >
					<br>
					<label for="">Beneficiary's Address</label>
					<input type="text" name="baddress" class="form-control no-comma" >
					<br><br>
					<div style="margin-top: 5px;"></div>
					<div class="center-block text-center">
						<input type="submit" name="submit" value="Create New Campaign" class="btn btn-primary" style="width: 40%;">
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