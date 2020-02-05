<?php 

    session_start();
    
    include 'db_connect.php';
    $display = 'none';
    if ($_SESSION['type'] === "admin") {
        $display = 'block';
    }

    $createdby = $_SESSION['id'];


    if (isset($_POST['submit']) && isset($_POST['cat'])) {

        $cat = ""; $campid = ""; $type = ""; $method = ""; 
        $amount = ""; $cheque = ""; $items = ""; $cellphone = ""; $bank = "";

        if (isset($_POST['cat'])) {
            $cat = $_POST['cat'];
        }

        if (isset($_POST['campid'])) {
            $campid = $_POST['campid'];
        }

        if (isset($_POST['type'])) {
            $type = $_POST['type'];
        }

        if (isset($_POST['method'])) {
            $method = $_POST['method'];
        }

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        }

        if (isset($_POST['cheque'])) {
            $cheque = $_POST['cheque'];
        }

        if (isset($_POST['items'])) {
            $items = $_POST['items'];
        }

        if (isset($_POST['cellphone'])) {
            $cellphone = $_POST['cellphone'];
        }

        if (isset($_POST['bank'])) {
            $bank = $_POST['bank'];
        }

        if (isset($_POST['cond'])) {
            $cond = $_POST['cond'];
        }

        $valArr = array();

        for($i=0;$i<count($cat);$i++)
        {
            // add mixed and full array

            $cat[$i] = mysqli_real_escape_string($con,$cat[$i]);
            $campid[$i] = mysqli_real_escape_string($con,$campid[$i]);
            $type[$i] = mysqli_real_escape_string($con,$type[$i]);
            $method[$i] = mysqli_real_escape_string($con,$method[$i]);
            $amount[$i] = mysqli_real_escape_string($con,$amount[$i]);
            $bank[$i] = mysqli_real_escape_string($con,$bank[$i]);
            $cheque[$i] = mysqli_real_escape_string($con,$cheque[$i]);
            $items[$i] = mysqli_real_escape_string($con,$items[$i]);
            $cellphone[$i] = mysqli_real_escape_string($con,$cellphone[$i]);
            $cond[$i] = mysqli_real_escape_string($con,$cond[$i]);

            
             $valArr[]="(
             '$cat[$i]','$campid[$i]','$type[$i]','$method[$i]',
             '$amount[$i]','$bank[$i]','$cheque[$i]','$items[$i]',
             '$cellphone[$i]','$cond[$i]','$createdby')";
        } 

    
        //attempt insertion 

        $query = "insert into donations 
                    (
                        donationcategory,campaignid,donationtype,
                        paymentmode,amount,bankname,chequenumber,noofitems,
                        donationmessage,donationcondition,createdby
                    ) 
                  values ";
        $query .= implode(',', $valArr);



        $querySearch2= mysqli_query($con,$query);
        
        if (mysqli_affected_rows($con)>0) {
            echo 
            '<script>
                var r = confirm("Successfully uploaded all donations ");
                if (r == true){
                    window.location="/dms/dashboard.php";
                }else{
                    window.location="/dms/dashboard.php";
                }
            </script>';
        }else{
            echo '<script>alert("An error occured while adding donations. Please try again later.");</script>';
        }

    }


?>


<!DOCTYPE html>
<html>
<head>
    <title>Bulk Upload Donations | Al-Islah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,user-scalable=no">

    <script src="js/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome.min.css">

    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/jquery.csv.js"></script> 

    <script>

        $().ready(function(){
            $("#myProfileLogoutBtn").click(function(){
                window.location = "/dms/logoff.php";
            });


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

        var html = '';
        var counter = 1;

        for(var row in data) {
            if (counter==1) {

            }else{
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
                    html+='<td>';
                        html+='<input type="text" value="'+data[row][7]+'" name="cond[]" placeholder="Condition" required>';
                    html+='</td>';
                    html+='<td>';
                        html+='<input type="text" value="'+data[row][9]+'"  placeholder="Message" required>';
                    html+='</td>';
                html+='</tr>';
            }


            counter++;
          }
        

        //$('#contents').html(html);
        $("#csvTable > tbody > tr").remove();
        $("#csvTable > tbody").append(html);
      };
      reader.onerror = function(){ 
        alert('Unable to read ' + file.fileName); 
      };
    }


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

        input[type=text]{
            width: 100%;
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
                <h3><u><b>Bulk Upload Donations</b></u></h3>
            </div>
        </div>
    </div>
</section>

<section>
    <br>
    <div class="row">
        <div class="container">
            <div >
                <div>
                    <h4>Upload CSV file</h4>
                    <span><a href="/dms/donationsample.csv">Please use this format</a></span>
                    <input class="btn btn-default" type="file" id="files" name="files[]" accept=".csv" />
                </div>
            </div>
        </div>
    </div>
</section>



<br>
<section>
    <div class="row">
        <div class="container">
            <div class="table table-responsive">
                <form  method="post" accept-charset="utf-8">
                    <table id="csvTable" class="table table-bordered table-hovered table-striped table-condensed">
                        <caption>CSV Parsed</caption>
                        <thead>
                            <tr>
                                <th>Cat</th>
                                <th>CampID</th>
                                <th>Type</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Bank</th>
                                <th>Cheque#</th>
                                <th>Items</th>
                                <th>Description(Cellphone)</th>
                                <th>Condition</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr style="text-align:center"><td colspan=11><input class="btn btn-primary btn-sm" type="submit" name="submit" value="submit"></td></tr>
                        </tfoot>
                    </table>

                </form>
            </div>
        </div>
    </div>
    
</section>

</body>
</html>