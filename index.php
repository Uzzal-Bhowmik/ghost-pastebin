
<?php

/**
 * @repo:      https://github.com/shrudra/ghost-pastebin/ The Ghost Pastebin GitHub Repo.
   @author:    Sakhawat Hossain (htps://github.com/shrudra/) <sakhwt.hssain@gmail.com>
 * @license:   MIT License

*/
 
session_start();


 /* If user is not logged in, redirect to `login.php` */

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  echo "<script>" . "window.location.href='./login.php';" . "</script>";
  exit;
}

require_once 'config.php';

if (isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pasted_by = mysqli_real_escape_string($conn, $_SESSION['username']);
	$date = date('Y-m-d H:i');

    $sql = "INSERT INTO pastes (title, content, pasted_by, date) VALUES ('$title', '$content', '$pasted_by', '$date')";
	

    if (mysqli_query($conn, $sql)) {
       // Get the current post id
       $post_id = mysqli_insert_id($conn);

       // Redirect to paste.php with the post id
       header("Location: paste.php?id=$post_id");
    } else {
        die("Failed to post: " . mysqli_connect_error());
    }
} else {
    echo "";
}
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Paste | Ghost Pastebin</title>
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
    
    <?php
		  // Check if the user is logged in
if (isset($_SESSION['username'])) {
    // If the user is logged in, show the welcome message
    echo "<h1>welcome, <b>{$_SESSION['username']}</b></h1>";

} else {
    // If the user is not logged in, 
    echo " ";
} ?>
   
	<?php
						   #Set The Local Timezone 
						   date_default_timezone_set("Asia/Dhaka");
						   /* List of all available timezones in PHP = `https://www.php.net/manual/en/timezones.php/` */
						   #show current time
						   echo date("l d/m/y, h:i:sa");
						   
						  ?>
						
    <p class="subheader">This platform is designed for the temporary exchange of pasted information among users. Please be aware that all content you submit is considered public information and may not be stored permanently; it could be removed at any time. We kindly request that you refrain from setting up automated programs to submit data; our platform is intended for direct human use.
    If you have reasonable grounds to believe that any third-party content accessed through this platform violates any laws, regulations, or the rights of others, please notify us in writing at <a href="mailto:#">you@example.com</a>. </p>
  </div>


  <div class="row">
            
            <div class="medium-6 large-6 columns">
			<form method="POST">
              <label>Paste Name / Title:
                <input type="text" name="title" placeholder="Title" required>
              </label>
             
              <label>
                Content:
                <textarea rows="10" cols="50" id= "content" name="content" placeholder="Paste here..." required></textarea>
              </label>
              <input type="submit" class="button secondary" name="submit" value="Paste">
			  </form>
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
      $(document).foundation();
    </script>
  </body>
</html>
