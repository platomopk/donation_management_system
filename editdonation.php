<?php 
    session_start();

    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    $donationid = "";

    if (!isset($_GET['donationid']) || $_GET['donationid']==="" || $_GET['donationid']===null) {
    	die("You cannot open this page.");
    }else{
    	$donationid = mysqli_real_escape_string($con,$_GET['donationid']);
    }

    if (isset($_POST['update'])) {
    	$donorid = mysqli_real_escape_string($con, $_POST['donorid']);
    	$donationcategory = mysqli_real_escape_string($con, $_POST['category']);
    	$campaignid = mysqli_real_escape_string($con, $_POST['campaignid']);
    	$donationtype = mysqli_real_escape_string($con, $_POST['type']);
    	$paymentmode = mysqli_real_escape_string($con, $_POST['paymentmode']);
    	$amount = mysqli_real_escape_string($con, $_POST['amount']);
    	$bankname = mysqli_real_escape_string($con, $_POST['bank']);
    	$chequenumber = mysqli_real_escape_string($con, $_POST['chequenumber']);
    	$noofitems = mysqli_real_escape_string($con, $_POST['noofitems']);
    	$itemsdesc = mysqli_real_escape_string($con, $_POST['itemdesc']);
    	$donationcondition = mysqli_real_escape_string($con, $_POST['donationcondition']);
    	$donationmessage = mysqli_real_escape_string($con, $_POST['donationmessage']);

    	$createdby = mysqli_real_escape_string($con, $_POST['createdby']);

    	$query = mysqli_query($con, 
    		"Update donations set 
	    		
	    			donationcategory='$donationcategory',
	    			campaignid='$campaignid',
	    			donorid='$donorid',
	    			donationtype='$donationtype',
	    			paymentmode='$paymentmode',
	    			amount='$amount',
	    			bankname='$bankname',
	    			chequenumber='$chequenumber',
	    			noofitems='$noofitems',
	    			itemsdesc='$itemsdesc',
	    			donationcondition='$donationcondition',
	    			donationmessage='$donationmessage'

	    	where donationid = '$donationid'
	    	"
    	);

    	if ($query) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully updated a donation.");
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

    if (isset($_POST['delete'])) {

    	$query = mysqli_query($con, 
    		"delete from donations where donationid = '$donationid'"
    	);

    	if ($query) {
    		if (mysqli_affected_rows($con)>0) {
				echo '<script>
						var r = confirm("Successfully deleted a donation.");
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
	<title>Edit Donation | Al-Islah</title>
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
		    

			var globaldonorid = "";

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



				// get from page and check for the values after campaign loads
				var donationid = <?php echo $donationid; ?>;
				$.ajax({
					type:"GET",
	    			url:"/dms/getdonation.php",
	    			data:"id="+donationid,
	    			dataType:"json",
	    			success:function(obj){
	    				try{
		    				//alert(obj[0].donationcategory);
		    				$("#donorid").val(obj[0].donorid);
		    				globaldonorid = obj[0].donorid;
		    				$("#donorid").prop('readonly', true);
		    				$("#category").val(obj[0].donationcategory);
		    				$("#campaignid").val(obj[0].campaignid);
		    				$("#type").val(obj[0].donationtype);
		    				$("#paymentmode").val(obj[0].paymentmode);
		    				$("#amount").val(obj[0].amount);
		    				$("#bank").val(obj[0].bankname);
		    				$("#chequenumber").val(obj[0].chequenumber);
		    				$("#noofitems").val(obj[0].noofitems);
		    				$("#itemdesc").val(obj[0].itemsdesc);
		    				$("#donationcondition").val(obj[0].donationcondition);
		    				$("#donationmessage").val(obj[0].donationmessage);



							var datacampaign =  $("#campaignid").val();
							//get the selected value and populate min max
							$.ajax({
								type:"GET",
				    			url:"/dms/getcampaign.php",
				    			data:"id="+datacampaign,
				    			dataType:"json",
				    			success:function(obj){
				    				try{
					    				$("#amount").prop('title',"Goal Amount is " + obj[0].goal + " & Achieved Amount is "+ obj[0].achieved);
					    				var max = obj[0].goal - obj[0].achieved;
					    				// $("#amount").prop('max',max);
					    				// $("#amount").prop('min','0');
				    				}
				    				catch(err){
				    					alert("High and Low was not found. getcampaign");
				    				}
				    			}
							});

	    				}
	    				catch(err){
	    					alert("Data not found.");
	    				}
	    			}
				});

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
<section>
    <div class="row" style="background-color: #37474F; color:white;">
        <div class="container" >
            <div class="row">
                <div class="col-md-3" >
                    <img src="assets/logo.png" id="mainlogo" alt="logo" class="img img-responsive pull-left">
                </div>
                <div class="col-md-9 " >
                    <div class="dropdown pull-right" style="margin-top: 18px; margin-bottom: 14px">
                      <span class="dropdown-toggle text-center"  data-toggle="dropdown"><span><i class="fa fa-caret-down fa-2x" id="bars"></i></span></span>
                      <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu">
                        <li><a id="myProfileLogoutBtn">Logout</a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Create New Donor fields -->
<br>
<section>
	<div class="row">
		<div class="container">
			<form method="post" accept-charset="utf-8">
				<div>
					<h3><u><b>Edit Donation</b></u></h3>
					<br>
				</div>
				<div class="col-xs-6 form-group">
					<label for="">Donor Id</label>
					<input type="text" id="donorid" name="donorid" class="form-control" placeholder="Enter email to find donor" required>
					<br>
					<label for="">Donation Category</label>
					<select name="category" id="category" required class="form-control">
						<option value="zakaat">Zakaat</option>
						<option value="sadqaat">Sadqaat</option>
					</select>
					<br>
					<label for="">Donation Campaign</label>
					<select name="campaignid" id="campaignid" required class="form-control">
					</select>
					<br>
					<label for="">Donation Type</label>
					<select name="type" id="type" required class="form-control">
						<option value="amount">Amount</option>
						<option value="items">Items</option>
						<option value="inkind">InKind</option>
					</select>
					<br>
					<label for="">Payment Mode</label>
					<select name="paymentmode" id="paymentmode" required class="form-control">
						<option value="none">None</option>
						<option value="cash">Cash</option>
						<option value="cheque">Cheque</option>
					</select>
					<br>
					<label for="">Amount</label>
					<input type="number" name="amount" id="amount" onkeypress="validateNumber(event)" class="form-control" required>
				</div>
				<div class="col-xs-6 form-group">
					<label for="">Bank Name</label>
					<input type="text" name="bank" class="form-control" id="bank" required>
					<br>
					<label for="">Cheque Number</label>
					<input type="text" name="chequenumber" class="form-control" id="chequenumber" required>
					<br>
					<label for=""># of Items</label>
					<input type="text" name="noofitems" class="form-control" id="noofitems" required>
					<br>
					<label for="">Items Description</label>
					<textarea style="min-height:120px;" type="text" name="itemdesc" id="itemdesc" class="form-control" required></textarea>
					<br>
					<label for="">Donation Condition</label>
					<input type="text" id="donationcondition" name="donationcondition" class="form-control" required>
					<br>
					<label for="">Donation Message</label>
					<input type="text" name="donationmessage" id="donationmessage" class="form-control" required>
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
						<input type="submit" name="update" value="Update This Donation" class="btn btn-primary" style="width: 40%;">
						<input type="submit" name="delete" value="Delete This Donation" class="btn btn-danger" style="width: 40%;">
					</div>
				</div>	
			</form>
		</div>
	</div>
</section>



</body>
</html>