<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$enteredOtp = $data['otp'] ?? '';

if (!isset($_SESSION['otp'])) {
    echo json_encode(['success' => false, 'message' => 'No OTP session found.']);
    exit();
}

if ((string)$enteredOtp === (string)$_SESSION['otp']) {
    $_SESSION['is_verified'] = true;  // Mark the OTP as verified
    echo json_encode(['success' => true, 'message' => 'OTP verified successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid OTP.']);
}
?>
