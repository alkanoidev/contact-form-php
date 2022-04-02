<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require "DotEnv.php";
	require 'vendor/autoload.php';

    applyCorsHeaders();

	function applyCorsHeaders() {
    	header("Access-Control-Allow-Origin: *");
    	header("Access-Control-Allow-Credentials: true");
    	header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    	header('Access-Control-Allow-Headers: Content-Type, Accept');
	}

	$rest_json = file_get_contents("php://input");
	$_POST = json_decode($rest_json, true);

	if (empty($_POST['fname']) && empty($_POST['email'])){
		die();
	};

	$env = new DotEnv(__DIR__.'/.env');
	$env->load();

	$subject = $_POST['fname'];
	$to = getenv('USERNAME');
	$from = $_POST['email'];
	$msg = $_POST['message'];
	$mail = new PHPMailer();

	try {
		$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    	$mail->isSMTP();   
		$mail->Mailer = "smtp";
    	$mail->Host = 'smtp.gmail.com';
    	$mail->SMTPAuth = true;
    	$mail->Username = $to;
    	$mail->Password = getenv('password');
    	$mail->SMTPSecure = "tls";
    	$mail->Port = "587";

    	//Recipients
    	$mail->setFrom($from, $subject);
    	$mail->addAddress($to, 'alkanoidev');
    	$mail->addReplyTo($from, 'idkk');
    	// $mail->addCC('cc@example.com');
    	// $mail->addBCC('bcc@example.com');

    	//Content
    	$mail->isHTML(true);
    	$mail->Subject = $subject;
    	$mail->Body    = $msg;
    	$mail->AltBody = $msg;

    	$mail->send();
		echo json_encode(["sent"=>true]);
	} catch (Exception $e) {
		echo json_encode(["sent"=>false]);
	}
?>