<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, email, food_category, capacity, location, donation_date, expiry_date, special_instructions, image_path, status FROM donations WHERE status = 'pending'";
$result = $conn->query($sql);

$donations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donations[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($donations);

$conn->close();
?>
