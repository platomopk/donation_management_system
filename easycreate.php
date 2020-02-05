<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    if (isset($_POST['submit'])) {
    	$campaignid = mysqli_real_escape_string($con, $_POST['campaignid']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $dcellphone = mysqli_real_escape_string($con, $_POST['dcellphone']);
        $dname = mysqli_real_escape_string($con, $_POST['dname']);
        $createdby = mysqli_real_escape_string($con, $_POST['createdby']);
        

        $donorid = '';

        $checkexisting = mysqli_query($con,"select donorid from donors where cellphone='$dcellphone'");
        if(mysqli_num_rows($checkexisting)>0){
            // donor exists
            while($row = mysqli_fetch_assoc($checkexisting)){
                $donorid = $row['donorid'];
            }
            

            // create new donation
            $createnewdonation = mysqli_query($con,"insert into donations 
            (donorid,campaignid,amount,createdby) values ('$donorid','$campaignid','$amount','$createdby')");

            if (mysqli_affected_rows($con)>0) {
                echo 
                '<script>
                    var r = confirm("Successfully created a donation");
                    if (r == true){
                        window.location="/dms/easycreate.php";
                    }else{
                        window.location="/dms/easycreate.php";
                    }
                </script>';
            }else{
                echo '<script>alert("An error occured while adding a donation. Please try again later.");</script>';
            }
            
            
        }else{
            // create new donor
            $donorcreate = mysqli_query($con,"insert into donors (firstname,cellphone,createdby) values ('$dname','$dcellphone','$createdby')");
            if (mysqli_affected_rows($con)>0) {
                // donor created 
                // now find donorid from cellphone
                $checkexisting = mysqli_query($con,"select donorid from donors where cellphone='$dcellphone'");
                if(mysqli_num_rows($checkexisting)>0){
                    // donor exists
                    while($row = mysqli_fetch_assoc($checkexisting)){
                        $donorid = $row['donorid'];
                    }
        
                    // create new donation
                    $createnewdonation = mysqli_query($con,"insert into donations 
                    (donorid,campaignid,amount,createdby) values ('$donorid','$campaignid','$amount','$createdby')");
        
                    if (mysqli_affected_rows($con)>0) {
                        echo 
                        '<script>
                            var r = confirm("Successfully created a donation and added a donor");
                            if (r == true){
                                window.location="/dms/easycreate.php";
                            }else{
                                window.location="/dms/easycreate.php";
                            }
                        </script>';
                    }else{
                        echo '<script>alert("An error occured while adding a donation. Please try again later.");</script>';
                    }
                }else{
                    echo '<script>alert("Donor/Donation could not be added at the moment. Please try again after some time");</script>';
                }

            }else{
                echo '<script>alert("An error occured while adding a donation. Please try again later.");</script>';
            }
        }
        
    }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Create New Donation | Al-Islah</title>
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


		    // search by email and get donorid
		    $("#donorid").change(function(){
		    	var data =  $("#donorid").val();
		    	if (data.length > 1) {
		    		$.ajax({
		    			type:"GET",
		    			url:"/dms/validateemail.php",
		    			data:"cellphone="+data,
		    			dataType:"json",
		    			success:function(obj){
		    				try{
		    					if (obj) {
									
									$("#donorname").html("- Donor Found! <b>" + obj[0].firstname + " " + obj[0].lastname+ "</b>");
			    					$("#donorid").val(obj[0].donorid);
			    					$('#donorid').prop('readonly', true);
			    					$('#donorid').prop('title', obj[0].firstname + " " + obj[0].lastname);
			    				}else{
			    					alert("No donor found with this cell.");
			    				}	
		    				}catch(err){
									alert("No donor found with this cell.");
									$("#donorid").val("");
		    				}
		    				
		    			}
		    		});	
		    	}
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
				$.ajax({
					type:"GET",
	    			url:"/dms/getcampaign.php",
	    			data:"id="+data,
	    			dataType:"json",
	    			success:function(obj){
	    				try{
						$("#goalamount").html("- Goal Amount is <b>" + obj[0].goal + "</b> & Achieved Amount is <b>"+ obj[0].achieved +"</b>");
		    				$("#amount").prop('title',"Goal Amount is " + obj[0].goal + " & Achieved Amount is "+ obj[0].achieved);
		    				var max = obj[0].goal - obj[0].achieved;
		    				//$("#amount").prop('max',max);
		    				//$("#amount").prop('min','0');
	    				}
	    				catch(err){
	    					alert("High and Low was not found.");
	    				}
	    			}
				});
			});


		    $("#dcellphone").change(function(){
		    	var data =  $("#dcellphone").val();
		    	if (data.length > 1) {
		    		$.ajax({
		    			type:"GET",
		    			url:"/dms/validateemail.php",
		    			data:"cellphone="+data,
		    			dataType:"json",
		    			success:function(obj){
		    				if (obj) {
		    					//alert(obj[0].donorid);	
		    					$("#dname").val(obj[0].firstname);
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


<section>
	<div class="row">
		<div class="container">

		</div>
	</div>
</section>


<!-- Create New Donor fields -->
<br>
<section>
	<div class="row">
		<div class="container">
			<form  method="post" accept-charset="utf-8">
				<div>
					<h3><u><b>Easy Create New Donation</b></u></h3>
					<br>
				</div>
				<div class="bg bg-success" style="margin-bottom:20px;">
					<div id="donorname">
					</div>
					<div id="goalamount">
					</div>
				</div>
				
				<div class="col-xs-6 form-group">

                    <u><h4>Donors Information</h4></u>
                    <label for="">Donor Cellphone</label>
					<input type="text" id="dcellphone" name="dcellphone" class="form-control" placeholder="Enter cellphone # to find donor" required>
					<br>
                    <label for="">Donor Name</label>
					<input type="text" id="dname" name="dname" class="form-control" placeholder="Enter Donor Name" >
					<br>
					<div style="display: none">
						<br>
						<label for="alarms">Created By</label>
						<input type="text" name="createdby" value="<?php echo $_SESSION['id']; ?>" class="form-control" required>
					</div>

					
				</div>
				<div class="col-xs-6 form-group">
                    <u><h4>Campaigns Information</h4></u>
					<label for="">Donation Campaign</label>
					<select name="campaignid" id="campaignid" required class="form-control">
					</select>
					<br>
					<label for="">Amount</label>
					<input type="number" name="amount" value="0" id="amount" onkeypress="validateNumber(event)" class="form-control" required>
                    <br>

					<div style="text-align:center;">
						<hr>
							<i>All the information above is correct to the best of my knowledge</i>
						<hr>
					</div>
					<div class="center-block text-center">
						<input type="submit" name="submit" value="Create New Donation" class="btn btn-primary" style="width: 40%;">
						<input type="reset" value="Clear Fields" class="btn btn-danger" style="width: 40%;">
					</div>
				</div>	
			</form>
		</div>
	</div>
</section>

</body>
</html>