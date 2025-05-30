<?php

header('Content-Type: application/json');  
session_start();

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$otp = rand(100000, 999999);


$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit();
}


$_SESSION['otp'] = $otp; 


$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';           
    $mail->SMTPAuth = true;                  
    $mail->Username = 'contact.plate2planet@gmail.com';  
    $mail->Password = 'fyjl gmwa phkh tkal';    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port = 587;                       

    
    $mail->setFrom('contact.plate2planet@gmail.com', 'Plate2Planet');
    $mail->addAddress($email);  

    
    $mail->isHTML(true);
    $mail->Subject = 'OTP for Updating Password';
    $mail->Body    = "Your OTP for updating password: <b>$otp</b>";

    
    $mail->send();

    echo json_encode(['success' => true, 'otp' => $otp]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to send OTP. Error: ' . $mail->ErrorInfo]);
}
?>