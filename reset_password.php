<?php 
#include `reset_pass_conn.php` for reset password
include 'reset_pass_conn.php';


?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Password Recovery | Ghost Pastebin</title>
	<link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
  </head>
  <body>

<!-- Navigation -->

<div class="top-bar">
  <div class="top-bar-left">
    <ul class="menu" data-responsive-menu="accordion">
      <a href="index.php"><img src="assets/img/logo.png"></a>
    </ul>
  </div>
 
</div>
<!-- /Navigation -->

<br>

<div class="row">

  <div class="medium-6 large-5 columns">
    
    <h1>Welcome to the Password Recovery System </h1>
    <p class="subheader">This system will help you reset your password if you have forgotten it. </p>
  </div>


  <div class="row">
            
            <div class="medium-6 large-6 columns">
			
			
		 <?php 

		                                  	switch ($mode) {
			                               	case 'enter_email':
				                       	?>
										
										 <?php 
										    // use the `$error` as `$err`
							              	foreach ($error as $err) {
												// show the error 
									           echo $err; 
											}
											?>
                                    <br>
                                        <form method="post" action="reset_password.php?mode=enter_email">
                                            
						                        <label>Enter email address</label>
                                                <input name="email" id="inputEmail" type="email" />
                                                
                                                
                                                
                                                <input type="submit" class="button warning" name="submit" value="Next">
                                           
                                        </form>
                                  <br>
											<?php				
				                      	break;

			                            	case 'enter_code':
					               
					                 ?>
									 <br>
									 <?php 
										    // use the `$error` as `$err`
							              	foreach ($error as $err) {
												// show the error 
									           echo $err; 
											}
											?>
									  <form method="post" action="reset_password.php?mode=enter_code">
                                                
									            <label>Enter Code</label>
                                                <input name="code" id="inputCode" type="number" />
                                                
                                          
                                                <a href="reset_password.php">
								                  <input type="button" class="button" value="Start Over">
							                     </a>
						              
                                                <input type="submit" class="button warning" name="submit" value="Next">
                                                
												<div class='callout alert' data-closable='slide-out-right'>
  Code will expire after 60 Seconds. 
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>
                                        </form>
                                   
									
									<?php
				                    	break;

				                    case 'enter_password':
				                     	
					               ?>
									
										
									 <?php 
										    // use the `$error` as `$err`
							              	foreach ($error as $err) {
												// show the error 
									           echo $err; 
											}
											?>
											
									  <form method="post" action="reset_password.php?mode=enter_password">
                                            
											 <p>Enter new password</p>
							                <input type="password" name="password" id="inputPassword" class="password"/>
                                          
										
											
                                                <input type="checkbox" onclick="myPwd()" value="" id="flexCheckDefault">
                                                  <label for="flexCheckDefault">
                                               show Password
                                           </label>
                                         
                                                <a href="reset_password.php">
								                  <input type="button" class="button" value="Start Over">
							                     </a>
						               
                                                <input type="submit" class="button warning" name="submit" value="Next">
                                            
                                        </form>
											<?php
				                             	break;
												
				                                default:
												
				                          	break;
			                              }

		                               ?>
            </div>
          </div>
		  
<footer>
  <div class="row expanded callout secondary">

   
    <div class="medium-6 columns">
      <ul class="menu float-right">
        <li class="menu-text">&copy; Copyright by Ghost Pastebin</li>
      </ul>
    </div>
  </div>

</footer>

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
	 <script>
         function myPwd() {
         var pwd = document.getElementById("inputPassword");
          if (pwd.type === "password") {
         pwd.type = "text";
        } else {
         pwd.type = "password";
        }
      }
     </script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
