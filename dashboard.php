<?php 
    session_start();
    include 'db_connect.php';

    if (!isset($_SESSION['id'])) {
        header("location:index.php");  
    }

    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

?>

<html>
<head>
    <title>Dashboard - Al-Islah IS</title>
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
	
	function hideNoti(donorid){
				$.ajax({
		    			type:"POST",
		    			url:"/dms/createhide.php",
		    			data:"donorid="+donorid,
		    			dataType:"text",
		    			success:function(msg){
		    				if (msg == "ok") {
		    					location.reload();
		    				}else{
		    					alert(msg);
		    				}
		    			}
		    		});
		    		
	}

        $().ready(function(){
            $("#myProfileLogoutBtn").click(function(){
                window.location = "/dms/logoff.php";
            });

            $("#createEasyDonation").click(function(){
                window.location = "/dms/easycreate.php";
            });

            $("#createNewDonor").click(function(){
                window.location = "/dms/createnewdonor.php";
            });

            $("#editDonor").click(function(){
                window.location = "/dms/editDonor.php";
            });

            $("#findDonor").click(function(){
                window.location = "/dms/finddonor.php";
            });

            $("#findAllDonors").click(function(){
                window.location = "/dms/findalldonors.php";
            });

            $("#newUser").click(function() {
               window.location = "/dms/createnewuser.php"; 
            });

            $("#editUser").click(function(){
                window.location = "/dms/edituser.php"; 
            });

            $("#findAllUsers").click(function(){
                window.location = "/dms/findallusers.php"; 
            });

            $("#createNewCampaign").click(function(){
                window.location = "/dms/createnewcampaign.php"; 
            });

            $("#editCampaign").click(function(){
                window.location = "/dms/editcampaign.php"; 
            });

            $("#findAllCampaigns").click(function(){
                window.location = "/dms/findallcampaigns.php"; 
            });   

            $("#createNewDonation").click(function(){
                window.location = "/dms/createnewdonation.php"; 
            });         

            
            $("#findDonationsViaCampaign").click(function(){
                window.location = "/dms/finddonationsviacampaign.php"; 
            });  

            $("#findalldonations").click(function(){
                window.location = "/dms/findalldonations.php"; 
            });  

            $("#findvolunteers").click(function(){
                window.location = "/dms/findvolunteersviacampaign.php"; 
            });  

            $("#downloadbulk").click(function(){
                window.location = "/dms/download.php"; 
            });           

            $("#uploadBulk").click(function(){
                window.location = "/dms/upload.php"; 
            });     

            $.getJSON("getnotices.php",function(data){
                var _len = data.length, post, i;
                if (_len>0) {
                var trHTML = '';
                $.each(data, function (i, item) {
                    trHTML+='<u><div class="bg-warning" style="padding-top:5px; padding-bottom:7px;"><b>'+item.name+'</b> has donation frequency of <b>'+item.frequencymonths+'</b> month(s) and <b>'+item.differ+'</b> month(s) have passed. Give them a call: <b>'+item.cellphone+'</b> <input type="button" class="btn btn-danger btn-xs pull-right" onclick="hideNoti('+item.donorid+');" value="hide"/></div></u>';
                });
                $("#notices div").remove();
                $('#notices').append(trHTML);
                  
                }else{
                    $("#notices div").remove();
                $('#notices').append("No new notifications.");
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

    </style>

</head>

<body>

<!-- header section -->
<!-- header -->
<?php include 'header.php';?>

<br>
<!-- welcome -->
<section style="display:none">
    <div class="row">
        <div class="container">
            <div style="padding: 10px; border:0.5px solid #37474F; box-sizing: border-box;">
                <p class="lead" style="margin-bottom: 0px;">Welcome,  <span style="font-weight: bold;"><?php echo $_SESSION['name']; ?></span>!</p>
            </div>
        </div>
    </div>
</section>

<!-- searchbar -->
<br>
<section>
    <div class="row">
        <div class="container">
            <div style=" background-color:#455A64;padding:10px 0px 10px 10px;  box-shadow: 0px 0px 25px -8px #333; box-sizing: border-box;margin-bottom:10px;">
                <p class="lead" style="color:white;margin-bottom: 0px;  font-size: medium; font-weight: bold">SEARCH</p>
            </div>
            <form action="/dms/search.php" method="GET" style="margin-bottom:0px;"> 
              <div >
                <div >
                  <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Search Here .." />
                    <div class="input-group-btn">
                      <button class="btn btn-primary" type="submit" style="height:34px; background:#455A64">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
        </div>  
    </div>
</section>

<!-- notices -->
<br>
<section>
    <div class="row">
        <div class="container">
            <div style=" background-color:#455A64;padding:10px 0px 10px 10px;  box-shadow: 0px 0px 25px -8px #333; box-sizing: border-box;">
                <p class="lead" style="color:white;margin-bottom: 0px;  font-size: medium; font-weight: bold">NOTIFICATIONS</p>
            </div>
            <div id="notices" style='margin-top: 5px;margin-left: 15px;margin-right: 15px;'>
            </div>
        </div>
    </div>
</section>


<!-- donors -->
<br>
<section>
    <div class="row">
        <div class="container">
            <div style=" background-color:#455A64;padding:10px 0px 10px 10px;  box-shadow: 0px 0px 25px -8px #333; box-sizing: border-box;">
                <p class="lead" style="color:white;margin-bottom: 0px;  font-size: medium; font-weight: bold">DONORS</p>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 ">
                    <div id="createNewDonor" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/plus.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">CREATE <br>(NEW)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="editDonor" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/edit.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">EDIT <br>(DONORS)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="findDonor" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/search.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">FIND <br>(ONE)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="findAllDonors" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/searchhard.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">FIND <br>(ALL)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- donations -->
<br><br>
<section>
    <div class="row">
        <div class="container">
            <div style=" background-color:#455A64;padding:10px 0px 10px 10px;  box-shadow: 0px 0px 25px -8px #333; box-sizing: border-box;">
                <p class="lead" style="color:white;margin-bottom: 0px;  font-size: medium; font-weight: bold">DONATIONS</p>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 ">
                    <div id="createEasyDonation" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/easyplus.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">EASY CREATE <br>(NEW)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 ">
                    <div id="createNewDonation" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/plus.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">CREATE <br>(NEW)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="findDonationsViaCampaign" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/search.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">FIND <br>(VIA CAMPAIGN)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="findalldonations" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/searchhard.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">FIND <br>(ALL)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="uploadBulk" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/upload.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">UPLOAD <br>(BULK)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- campaings -->
<br><br>
<section>
    <div class="row">
        <div class="container">
            <div style=" background-color:#455A64;padding:10px 0px 10px 10px;  box-shadow: 0px 0px 25px -8px #333; box-sizing: border-box;">
                <p class="lead" style="color:white;margin-bottom: 0px;  font-size: medium; font-weight: bold">CAMPAIGNS</p>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 ">
                    <div id="createNewCampaign" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/plus.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">CREATE <br>(NEW)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="editCampaign" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/edit.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">EDIT <br>(CAMPAIGNS)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="findAllCampaigns" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/searchhard.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">FIND <br>(ALL)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- volunteers -->
<br><br>
<section>
    <div class="row">
        <div class="container">
            <div style=" background-color:#455A64;padding:10px 0px 10px 10px;  box-shadow: 0px 0px 25px -8px #333; box-sizing: border-box;">
                <p class="lead" style="color:white;margin-bottom: 0px;  font-size: medium; font-weight: bold">VOLUNTEERS</p>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <div id="findvolunteers" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/searchhard.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">FIND <br>(ALL)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- admin -->
<br><br>
<section id="adminSection" style="display:<?php echo $display; ?>">
    <div class="row">
        <div class="container">
            <div style=" background-color:#455A64;padding:10px 0px 10px 10px;  box-shadow: 0px 0px 25px -8px #333; box-sizing: border-box;">
                <p class="lead" style="color:white;margin-bottom: 0px;  font-size: medium; font-weight: bold">ADMINISTRATION</p>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 ">
                    <div id="newUser" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/plus.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">CREATE USER <br>(NEW)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="editUser" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/edit.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">EDIT <br>(USERS)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="findAllUsers" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/searchhard.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">FIND <br>(ALL)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div id="downloadbulk" class="btnHover" style="border:0.5px dashed #444444; box-sizing: border-box;">
                        <div>
                        <br>
                            <img src="assets/download.png" class="center-block" style="height:60px;width:60px; padding: 5px;">
                        </div>
                        <div >
                            <p class="lead text-center" style="font-size:medium;font-weight: 0; margin-top: 10px;">DOWNLOAD <br>(BULK)</p>
                            <div style="height:5px;"></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<!-- emoty -->
<br><br>

<section id="footerSection" style="background-color: #37474F;color:#fff">
    <br>
    <div class="row">
        <div class="container">
            <div class="row">
                <p style="margin:0px;">&copy; All Rights Reserved 2018</p>
            </div>
        </div>
    </div>
    <br>
</section>

</body>
</html>