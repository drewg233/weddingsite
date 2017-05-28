<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'phpmailer/PHPMailerAutoload.php';

if (isset($_POST['inputEmail'])) {

    //check if any of the inputs are empty
    if (empty($_POST['inputEmail'])) {
        $data = array('success' => false, 'message' => 'Please fill out the form completely.');
        echo json_encode($data);
        exit;
    }

    //create an instance of PHPMailer
    $mail = new PHPMailer();
	
	$myfile = fopen("subscriber.txt", "w") or die("Unable to open file!");
	$txt = $_POST['inputEmail'];
	fwrite($myfile, $txt);
	$txt = "\n";
	fwrite($myfile, $txt);
	fclose($myfile);

    $mail->From = $_POST['inputEmail'];
    $mail->FromName = 'subscriber';
    $mail->AddAddress('themenerds@gmail.com'); //recipient 
    $mail->Subject = 'New Subscription Came';
    $mail->Body = "Subscription Came From: " . $_POST['inputEmail'];

    if (isset($_POST['ref'])) {
        $mail->Body .= "\r\n\r\nRef: " . $_POST['ref'];
    }

    if(!$mail->send()) {
        $data = array('success' => false, 'message' => 'sonting went wrong. Mailer Error: ' . $mail->ErrorInfo);
        echo json_encode($data);
        exit;
    }

    $data = array('success' => true, 'message' => 'Thanks! You added on list.');
    echo json_encode($data);

} else {

    $data = array('success' => false, 'message' => 'Please fill out the form completely.');
    echo json_encode($data);

}