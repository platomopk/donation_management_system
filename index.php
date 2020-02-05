<?php
    session_start();
    include 'db_connect.php';

    if (isset($_SESSION['id'])) {
        echo 'session set';
        header("location:dashboard.php");  
    }

    if(isset($_POST['submit'])){

        $email= mysqli_real_escape_string($con, $_POST['login_email']);
        $password= mysqli_real_escape_string($con, $_POST['login_password']);


        //check for retailers
        $query= mysqli_query($con,"SELECT userid,name,type,password from users where lower(email)=lower('$email')");

          if (mysqli_num_rows($query)>0) {
                      //making an array
                $rows=array();
                //filling that array
                while($row=mysqli_fetch_assoc($query))
                {
                    if (password_verify($password,$row['password'])) {
                        $_SESSION['id']=$row['userid'];
                        $_SESSION['name']=$row['name'];
                        $_SESSION['type']=$row['type'];
                        header("location:dashboard.php"); 
                    }else{
                        echo "<script>alert('User not found!');</script>";
                    }
                }
          }else{
            echo "<script>alert('No Data Found!');</script>";
          }
    }
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login | Al-Islah Information System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,user-scalable=no">

    <script src="js/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome.min.css">

    <style type="text/css" media="screen">
        body{
            background-color: #CFD8DC;
            background-image: url('/dms/assets/lightbg.png');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .outer {
            display: table;
            position: absolute;
            height: 100%;
            width: 100%;
        }

        .middle {
            display: table-cell;
            vertical-align: middle;
        }

        .inner {
            margin-left: auto;
            margin-right: auto; 
            width: /*whatever width you want*/;
        }    
    </style>

</head>


<body style="overflow-x: hidden">


    <section id="homeSection" style="">


                <div class="outer">
                  <div class="middle">
                    <div class="inner center-block">

            <form id="signInForm"  method="post" style="display:block">
                <section>
                    <div class="row" id="loginWrapper">
                        <div class="container" id="loginContainer">
                            <div class="row" id="loginBox">
                                <!-- login container -->
                                <div style="opacity:0.9;width: 350px;height: auto;margin:0px auto;border-radius: 10px;border-color: #333; background-color:#263238;  border-width: 2px; border-style: solid;">
                                <!-- sms -->
                                <div style="padding:15px; padding-bottom:0px; color:#fff; text-align: center;">
                                    <label style="font-weight: 100;font-size: 18px; text-decoration:underline;    ">Al-Islah Information System</label>
                                </div>
                                <!-- email -->
                                <div style="padding:15px ">
                                    <input class="form-control" type="email" name="login_email" id="login_email" placeholder="Email" required>
                                </div>
                                <!-- password -->
                                <div style="padding:0px 15px 15px 15px">
                                    <input class="form-control" type="password" name="login_password" placeholder="Password" required>
                                </div>
                                <!-- submit -->
                                <div style="padding:0px 15px 15px 15px">
                                    <input type="submit" name="submit" value="Log In" class="btn btn-default" style="width: 100%;background-color: #263238; color:white;">
                                </div>
                                <!-- forgot -->
                                <div style="padding:0px 15px 0px 15px; margin-bottom: 10px; display:none">
                                    <p style="margin:0px;text-align: center;"><a style="text-decoration: none; color:black; cursor:pointer"  id="forgot_email">Forgot Password?</a></p>
                                </div>  
                                <!-- some text -->
                                <div style="padding:0px 15px 15px 15px; display: none">
                                    <p style="text-align: center; font-size: small;">By signing in to our application you agree to abide by the <a target="_blank" href="tnc.html" style="color:black;cursor:pointer "><i>Terms Conditions</i></b></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>  
            </form>

                    </div>
                  </div>
                </div>

    </section>


</body>
</html>