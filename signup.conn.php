<?php
# Require Database Connection
require_once "./config.php";


$username_err = $email_err = $password_err = "";
$username = $email = $password = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["username"]))) {
	  
	$username_err = "<div class='callout warning' data-closable='slide-out-right'>
  Please enter a username.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
    
  } else {
    $username = trim($_POST["username"]);
    if (!ctype_alnum(str_replace(array("@", "-", "_"), "", $username))) {
		
		$username_err = "<div class='callout warning' data-closable='slide-out-right'>
 Username can only contain letters, numbers, underscores and special character like '@', '_', or '-'.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
       
    } else {
      
      $sql = "SELECT id FROM users WHERE username = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $reg_username);

       
        $reg_username = $username;

      
        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);
          if (mysqli_stmt_num_rows($stmt) == 1) {
			  
			 $username_err = "<div class='callout warning' data-closable='slide-out-right'>
 Username already exists. please try with another one.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>"; 
            
          }
        } else {
          echo "<script>" . "alert('something went Wrong. please try again later.')" . "</script>";
        }

 
        mysqli_stmt_close($stmt);
      }
    }
  }

 
  if (empty(trim($_POST["email"]))) {
	  
	   "<div class='callout warning' data-closable='slide-out-right'>
 Please enter an email address.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>"; 
    $email_err = "please enter an email address";
  } else {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
	  
	   $email_err = "<div class='callout warning' data-closable='slide-out-right'>
 Please enter a valid email address.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>"; 
	  
    } else {
      
      $sql = "SELECT id FROM users WHERE email = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $reg_email);

        
        $reg_email = $email;

        
        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);

        
          if (mysqli_stmt_num_rows($stmt) == 1) {
         
			 $email_err = "<div class='callout warning' data-closable='slide-out-right'>
 This email is already registered.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>"; 
          }
        } else {
          echo "<script>" . "alert('something went wrong. please try again later.');" . "</script>";
        }

        mysqli_stmt_close($stmt);
      }
    }
  }

  
  if (empty(trim($_POST["password"]))) {
    
	$password_err = "<div class='callout warning' data-closable='slide-out-right'>
 Please enter a password.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>"; 
	
  } else {
    $password = trim($_POST["password"]);
    if (strlen($password) < 8) {
		$password_err = "<div class='callout warning' data-closable='slide-out-right'>
 Password must contain at least 8 or more characters.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>"; 
      
    }
  }

 
  if (empty($username_err) && empty($email_err) && empty($password_err)) {
    $sql = "INSERT INTO users(username, email, password) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "sss", $reg_username, $reg_email, $reg_pwd);

     
      $reg_username = $username;
      $reg_email = $email;
      $reg_pwd = password_hash($password, PASSWORD_DEFAULT);

     
      if (mysqli_stmt_execute($stmt)) {
        echo "<script>" . "alert('Your account is creating successfully, Now you can login.');" . "</script>";
        echo "<script>" . "window.location.href='./login.php'" . "</script>";
	   
        exit;
      } else {
        echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
		 
      }

     
      mysqli_stmt_close($stmt);
    }
  }


  mysqli_close($conn);
}
?>