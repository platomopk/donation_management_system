<?php 
session_start();
include 'db_connect.php';

    $choice =''; $retailerId='';

    if (isset($_GET['retailerId'])) {
        $retailerId = $_GET['retailerId'];    
    }

    if (isset($_GET['choice'])) {
        $choice = $_GET['choice'];    
    }else{
    	$choice=0;
    }
    

?>

<!DOCTYPE html>
<html>
<head>
    <title>Al-Islah - Add Outlets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,user-scalable=no">

    <script src="js/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="slick/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="slick/slick/slick-theme.css">
    <script src="js/form.js"></script> 
    <script src="js/jquery.csv.js"></script> 


    <style type="text/css" media="screen">
        body{
            background-color: #e8f2ff;
            overflow-x: hidden;
            height: 100%;
        }
        #headerContainer{
        background-color:#fff;
            height: 100px;
            width: 100%;
            margin: 0px auto;
            text-align: center;
        }
        .form-control{
            margin-bottom: 5px;
        }

    </style>

    <script type="text/javascript">



        $().ready(function(){

            //var myLatlng = new google.maps.LatLng(parseFloat(latvalue),parseFloat(lngvalue));


           	if(isAPIAvailable()) {
		        $('#files').bind('change', handleFileSelect);
		        //$("#propertiesSection").css('display', 'block');		
		    }


       		
        });

      function isAPIAvailable() {
          // Check for the various File API support.
          if (window.File && window.FileReader && window.FileList && window.Blob) {
            // Great success! All the File APIs are supported.
            return true;
          } else {
            // source: File API availability - http://caniuse.com/#feat=fileapi
            // source: <output> availability - http://html5doctor.com/the-output-element/
            document.writeln('The HTML5 APIs used in this form are only available in the following browsers:<br />');
            // 6.0 File API & 13.0 <output>
            document.writeln(' - Google Chrome: 13.0 or later<br />');
            // 3.6 File API & 6.0 <output>
            document.writeln(' - Mozilla Firefox: 6.0 or later<br />');
            // 10.0 File API & 10.0 <output>
            document.writeln(' - Internet Explorer: Not supported (partial support expected in 10.0)<br />');
            // ? File API & 5.1 <output>
            document.writeln(' - Safari: Not supported<br />');
            // ? File API & 9.2 <output>
            document.writeln(' - Opera: Not supported');
            return false;
          }
        }

        function handleFileSelect(evt) {
           

          var files = evt.target.files; // FileList object
          var file = files[0];

          // read the file contents
          printTable(file);

        }

    function printTable(file) {
      var reader = new FileReader();
      reader.readAsText(file);


      reader.onload = function(event){
        var csv = event.target.result;
        var data = $.csv.toArrays(csv);

        //alert(data);
        var html = '';
        var counter = 1;

        for(var row in data) {

            html+='<tr>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][0]+'" name="cat[]" placeholder="Category" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][1]+'" name="campid[]" placeholder="CampaignID" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][2]+'" name="type[]" placeholder="Type" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][3]+'" name="method[]" placeholder="Method" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][4]+'" name="amount[]" placeholder="Amount" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][5]+'" name="bank[]" placeholder="Bank" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][6]+'" name="cheque[]" placeholder="Cheque" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][7]+'" name="items[]" placeholder="Items" required>';
                html+='</td>';
                html+='<td>';
                    html+='<input type="text" value="'+data[row][8]+'" name="cellphone[]" placeholder="Cell" required>';
                html+='</td>';
            html+='</tr>';

        	counter++;
          }
        
        //$('#contents').html(html);
        $("#manualTable > tbody > tr").remove();
        $("#manualTable > tbody").append(html);
      };
      reader.onerror = function(){ 
      	alert('Unable to read ' + file.fileName); 
      };
    }


    </script>

</head>
<body>


<section id="manualSection" style="display: block;overflow-x: auto;">


	<section >
	    <br>
	    <div class="row">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
	                    <section>
	                        
	                    <form method="POST">

	                        <?php
                            echo '<table class="table table-striped table-bordered" id="manualTable"><thead><tr><th>Cat</th><th>CampID</th><th>Type</th><th>Method</th><th>Amount</th><th>Bank</th><th>Cheque#</th><th>Items</th><th>Cell</th></tr></thead><tbody>';


	                            for ($i = 1; $i <=$choice; $i++) {

                                    echo '<tr><td><input type="text" name="cat[]" placeholder="Category" required></td><td><input type="text" name="campid[]" placeholder="Campaign ID" required></td><td><input type="text" name="type[]" placeholder="Donation Type"required></td><td><input type="text" name="method[]" placeholder="Method" required></td><td><input type="text" name="amount[]" placeholder="Amount" required></td><td><input type="text" name="bank[]" placeholder="Bank" required></td><td><input type="text" name="cheque[]" placeholder="Cheque #" required></td><td><input type="text" name="items[]" placeholder="Items" required></td><td><input type="text" name="cell[]" placeholder="Cellphone" required></td></tr>';

	                            }

                            echo '</tbody></table>';

	                        ?>
	                      <input type="submit" name="submit" value="Save these outlets" class="btn btn-primary">
	                    </form>
	                    </section>
	                    
	                </div>
	            </div>
	        </div>
	    </div>
	    <br>
	</section>
</section>


<section id="csvSection" style="display: block">
	<section>
	    <br>
	    <div class="row">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
	                    <h4>Upload CSV file</h4>
	                    <a href=""><p>Please use this format</p></a>
	                    <input class="btn btn-default" type="file" id="files" name="files[]"  />
	                    <hr style="background-color: white;color:white;height:2px;">
	                </div>
	            </div>
	        </div>
	    </div>
	</section>


</section>

<section>
    <div id="contents">
        
    </div>
</section>



</body>
</html>

