<section>
    <div class="row" style="background-color: #37474F; color:white;">
        <div class="container" >
            <div class="row">
                <div class="col-md-3" >
                    <a href="/dms/dashboard.php"><img src="assets/logo.png" id="mainlogo" alt="logo" class="img img-responsive pull-left"></a>
                </div>
                <div class="col-md-9 " >
                    <div class="dropdown pull-right" style="margin-top: 18px; margin-bottom: 14px">
		      <span style="font-size:large; position:relative; margin-right:20px;">Welcome, <span id="loggedinname"><b><?php echo $_SESSION['name']; ?></b></span></span>
                      <span class="dropdown-toggle text-center"  data-toggle="dropdown"><span style="font-size:medium"><i class="fa fa-caret-down fa-1x" id="bars"></i></span></span>
                      <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu">
                        <li><a id="myProfileLogoutBtn">Logout</a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>