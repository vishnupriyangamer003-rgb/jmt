
<?php
session_start();
// Log errors instead of hiding them (never suppress with error_reporting(0))
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
include ('phpservices/connection.php');

    $header = '<nav class="navbar" style="background:#ffffff;text-align: center;">
    <div class="container-fluid" style="display: initial;width: initial;">
    
        <div class="header-logo" style="width: 10%;">
            
            

        </div>

        <div class="header-body" style="text-align: center;">
            <ul class="navbar-nav">

				<span id="titlename">
					<img class="mobksymbol" src="images/logo.png" width="100" style="width: 50px;margin-right: 0px!important"  alt="">
					<img class="ksymbol" src="images/karur_chambers_logo.png" style="height: 50px;"  alt="">
				</span>
            

                
            </ul>
        </div>

    </div>
    
</nav>';
?>




