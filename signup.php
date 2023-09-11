<?php 
session_start(); // Start the PHP session

#include the `signup.conn.php` for creating an account
include 'signup.conn.php';



?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Signup | Ghost Pastebin</title>
	<link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
  </head>
  <body>

<!-- Navigation -->

<div class="top-bar">
  <div class="top-bar-left">
    <ul class="menu" data-responsive-menu="accordion">
      <img src="assets/img/logo.png">
    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="menu">
	   <?php
		  // Check if the user is logged in
if (isset($_SESSION['username'])) {
    // If the user is logged in, show the logout button
    echo "<li><a class='button secondary' href='logout.php'>Logout</a></li>";
} else {
    // If the user is not logged in, show the login form
    echo "<li><a class='button secondary' href='login.php'>Login</a></li>";
} ?>
      
    </ul>
  </div>
</div>
<!-- /Navigation -->

<br>

<div class="row">

  <div class="medium-6 large-5 columns">
    <p class="subheader">Sign up and share your pastes (example: Notes, Codes, Texts etc.) with the world.</p>
     </div>


  <div class="row">
            
            <div class="medium-6 large-6 columns">
			<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		 
                                                         <label>Username:</label>
                                                        <input name="username" id="inputUsername" type="text" placeholder="username" />
                                                        
														

														<span class="alert"><?= $username_err; ?></span>
                                                  
                                                <label>Email address:</label>
                                                <input name="email" id="inputEmail" type="email" placeholder="email address" />
                                           
												<span style="color:ff0000;font-size: smaller;"><?= $email_err; ?></span>
                                                 <label>Password:</label>
                                                        <input name="password" id="inputPassword" type="password" placeholder="create a password" />
                                                      
														<span style="color:ff0000;font-size: smaller;"><?= $password_err; ?></span>
                                             
                                                  <input type="checkbox" onclick="myPwd()" value="" id="flexCheckDefault">
                                                  <label for="flexCheckDefault">
                                               show Password
                                           </label>  
								           <br>
                                               <input type="submit" class="button secondary" name="submit" value="Sign Up">
                                            
                                        </form>
                                   
                                       
										<br>
                                        <span class="small">Have an account? Go to <a href="login.php">login</a></span>
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
