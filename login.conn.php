<?php
#start the session
session_start();

# Check if the user is already logged in or Not, If yes, it will be redirected to `index.php`
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE) {
  echo "<script>" . "window.location.href='./'" . "</script>";
  exit;
}

# Require Database Connection
require_once "./config.php";


$user_login_err = $user_password_err = $login_err = "";
$user_login = $user_password = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["user_login"]))) {
    $user_login_err = "please enter your username or email address.";
  } else {
    $user_login = trim($_POST["user_login"]);
  }

  if (empty(trim($_POST["user_password"]))) {
    $user_password_err = "please enter your password.";
  } else {
    $user_password = trim($_POST["user_password"]);
  }

  
  if (empty($user_login_err) && empty($user_password_err)) {
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "ss", $param_user_login, $param_user_login);

     
      $param_user_login = $user_login;

     
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

   
        if (mysqli_stmt_num_rows($stmt) == 1) {
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($user_password, $hashed_password)) {

          
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["loggedin"] = TRUE;

             
              echo "<script>" . "window.location.href='./'" . "</script>";
              exit;
            } else {   
             # If password is incorrect, show an error alert
             
			  $login_err = "<div class='callout warning' data-closable='slide-out-right'>
  Invalid username or password.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";

            }
          }
        } else {
		  # If password is incorrect, show an error alert
          $login_err = "<div class='callout warning' data-closable='slide-out-right'>
  Invalid username or password.
  <button class='close-button' aria-label='Dismiss alert' type='button' data-close>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
        }
      } else {
        echo "<script>" . "alert('Something Went Wrong. Please Try Again Later.');" . "</script>";
        echo "<script>" . "window.location.href='./login.php'" . "</script>";
        exit;
      }

     
      mysqli_stmt_close($stmt);
    }
  }

  
  mysqli_close($conn);
}
?>