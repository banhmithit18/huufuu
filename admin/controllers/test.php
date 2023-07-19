<?php 
require('mailserver/PHPMailerAutoload.php');
require('mailserver/class.phpmailer.php');
require('mailserver/class.smtp.php');
require('mailserver/class.pop3.php');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->IsHTML(true);
$mail->Username = 'sales@leonwallet.com';
$mail->Password = 'password';
$mail->From = 'sales@leonwallet.com';
$mail->FromName = 'Leon Sales Team';
$mail->AddAddress($to);
$mail->AddReplyTo('sales@leonwallet.com', 'Leon Sales Team');
$mail->Subject = $sub;
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
$mail->Body = $message;
if(!$mail->Send()){
  echo "1"; // ERROR
}else{
  echo "0"; // SUCCESS
}
?>

?>