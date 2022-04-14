<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
require 'vendor/autoload.php';

function EmailNotification($receiver, $subject, $body) {
	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try {
	    //Server settings
	    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
	    $mail->isSMTP();                                            //Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	    $mail->Username   = 'hexauniversity2022@gmail.com';                     //SMTP username
	    $mail->Password   = 'hexauniversitykmdproject';                               //SMTP password
	    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
	    $mail->Port       = '587';                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	    $mail->setFrom('hexauniversity2022@gmail.com');

	    $mail->addAddress($receiver);               //Name is optional

	    //Content
	    $mail->isHTML(true);                                  //Set email format to HTML
	    $mail->Subject = $subject;
	    $mail->Body    = $body;

	    $mail->send();
	    echo 'Message has been sent';
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

?>