<?php 
#start session
session_start();
$error = array();

/* require `mail.php` file for send verification code through E-mail */
require "mail.php";
# Require Database Connection
require_once "./config.php";
    
	

	$mode = "enter_email";
	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	
	if(count($_POST) > 0){

		switch ($mode) {
			case 'enter_email':
				
				$email = $_POST['email'];
				//Validate E-mail
				if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					
					$error[] = "<div class='callout warning' data-closable='slide-out-right'>
  Please Enter a Valid Email.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
					
				}elseif(!valid_email($email)){
					
					$error[] = "<div class='callout warning' data-closable='slide-out-right'>
  This Email does not exist.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
		
				}else{

					$_SESSION['forgot']['email'] = $email;
					send_email($email);
					header("Location: reset_password.php?mode=enter_code");
					die;
				}
				break;

			case 'enter_code':
				
				$code = $_POST['code'];
				$result = is_code_correct($code);

				if($result == "The Verification Code is Correct"){
					$_SESSION['forgot']['code'] = $code;
					header("Location: reset_password.php?mode=enter_password");
					die;
				}else{
					$error[] = $result;
				}
				break;

			case 'enter_password':
				
				$password = $_POST['password'];
				
					 if (strlen($password) < 8) {
                  
				   $error[] = "<div class='callout warning' data-closable='slide-out-right'>
  Password Must Contain at least 8 or More Characters.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
				   
                }
				elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
					header("Location: reset_password.php");
					die;
				}else{
					
					save_password($password);
					if(isset($_SESSION['forgot']['code'])){
						unset($_SESSION['forgot']['code']);
					}
                    
					header("Location: login.php");
					die;
				}
				break;
			
			default:
				
				break;
		}
	}

	function send_email($email){
		
		global $conn;
        
		#Code will expire after One Minute
		$expire = time() + (60 * 1);
		#Send Five (5) digit Verification Code
		$code = rand(10000,99999);
		$email = addslashes($email);

		$query = "insert into codes (email,code,expire) value ('$email','$code','$expire')";
		mysqli_query($conn,$query);

		#Send Verification Code Using E-mail
		send_mail($email,'Password Recovery',"Your code is " . $code);
	}
	
	
	function save_password($password){
		
		global $conn;

		$password = password_hash($password, PASSWORD_DEFAULT);
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "update users set password = '$password' where email = '$email' limit 1";
		mysqli_query($conn,$query);

	}
	
	function valid_email($email){
		global $conn;

		$email = addslashes($email);

		$query = "select * from users where email = '$email' limit 1";		
		$result = mysqli_query($conn,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				return true;
 			}
		}

		return false;

	}

	function is_code_correct($code){
		global $conn;

		$code = addslashes($code);
		$expire = time();
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "select * from codes where code = '$code' && email = '$email' order by id desc limit 1";
		$result = mysqli_query($conn,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				if($row['expire'] > $expire){
					
                   return "The Verification Code is Correct";
				   #If The Entered Code is Correct, Show a Success Message
				  
				   return "<div class='callout success' data-closable='slide-out-right'>
  The Verification Code is Correct.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
				   
					
				}else{
					#If The Code is Expired, Then show an Error Message
					
					 return "<div class='callout warning' data-closable='slide-out-right'>
  The Verification Code is Expired.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
				}
			}else{
				#If The Code is Incorrect, Then show an Error Message
				
				return "<div class='callout warning' data-closable='slide-out-right'>
  The Verification Code is Incorrect
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
			}
		}
        #If The Code is Incorrect, Then show an Error Message
		return "<div class='callout warning' data-closable='slide-out-right'>
  The Verification Code is Incorrect
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";

	}

	
?>