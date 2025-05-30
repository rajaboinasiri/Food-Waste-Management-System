<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "user_registration"; 

$conn = new mysqli($servername, $username, $password, $dbname);

header('Content-Type: application/json');

if (isset($_POST['name'], $_POST['email'], $_POST['contact'], $_POST['password']) && isset($_SESSION['is_verified']) && $_SESSION['is_verified'] === true) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

   
    $sql = "SELECT email FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists.']);
        exit();
    }


    $stmt = $conn->prepare("INSERT INTO users (name, email, contact, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $contact, $password);

    if ($stmt->execute()) {
        unset($_SESSION['is_verified']);
        echo json_encode(['success' => true, 'message' => 'User registered successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error registering user.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'OTP not verified.']);
}
?>
