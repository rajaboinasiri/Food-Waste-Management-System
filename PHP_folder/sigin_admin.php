<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "user_registration"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed.'])); 
}


if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request: Missing email or password.']);
    exit;
}

$email = $_POST['email'];
$password = $_POST['password']; 

if ($email === 'admin@gmail.com' && $password === '1234') {
    session_start();
    $_SESSION['isAdmin'] = true;
    echo json_encode(['status' => 'success', 'redirect' => 'donations.html']);
    exit;
}
$stmt->close();
$conn->close();