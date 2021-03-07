<?php
$response = $_POST["g-recaptcha-response"];

$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
  'secret' => '6Lee6bYUAAAAALQcDMvNeWuHyCHdPeJ_2_FuOx5J',
  'response' => $_POST["g-recaptcha-response"]
);
$options = array(
  'http' => array (
    'method' => 'POST',
    'content' => http_build_query($data)
  )
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success=json_decode($verify);

if ($captcha_success->success==false) {
  echo "<p>Bitte Captcha bestätigen</p>";
} else if ($captcha_success->success==true) {
  $name = stripslashes($_POST['name']);
  // $email = stripslashes($_POST['email']);
  $message = stripslashes($_POST['message']);

  $email = !empty(trim(isset($_POST['email'])?$_POST['email']:''))?$_POST['email']:'larz.knoke@gmail.com';

  $header  = 'MIME-Version: 1.0' . "\r\n";
  $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $header .= "From: $email\r\n";
  $header .= "Reply-To: $email\r\n";
  $header .= "X-Mailer: PHP ". phpversion();

  $formcontent="Von: $name \r\n Email: $email \r\n Nachricht: $message";
  $recipient = "larz.knoke@gmail.com";
  $subject = "Nachricht Bretterbutze";
  $mailheader = "From: $email \r\n";
  mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
}

?>
