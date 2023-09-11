<?php
  /* PHPMailer is A full-featured email creation and transfer class for PHP */
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  #Require some files from PHPMailer
  
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

function send_mail($recipient,$subject,$message)
{

  $mail = new PHPMailer();
  $mail->IsSMTP();

  $mail->SMTPDebug  = 0;  
  $mail->SMTPAuth   = TRUE;
  $mail->SMTPSecure = "tls";
  $mail->Port       = 587;
  $mail->Host       = "smtp.gmail.com";
  $mail->Username   = "your_email@example.com"; #Enter E-mail Address 
  $mail->Password   = "your_email_password"; #Enter App Password 

  $mail->IsHTML(true);
  $mail->AddAddress($recipient, "User");
 //Enter your E-mail Address $mail->SetFrom("example@gmail.com", "Ghost Pastebin"); 
  $mail->SetFrom("your_email@example.com", "Ghost Pastebin");
  $mail->Subject = $subject;
  $content = $message;

  $mail->MsgHTML($content); 
  if(!$mail->Send()) {
    return false;
  } else {
    return true;
  }

}

?>