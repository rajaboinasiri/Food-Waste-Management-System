<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "user_registration"; // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the session variable is set
if (!isset($_SESSION['userEmail'])) {
    die("User email not set. Please log in.");
}

// Get form data
$email = $_SESSION['userEmail']; // Using the email stored in the session
$food_category = $_POST['food-category'];
$capacity = $_POST['capacity'];
$location = $_POST['location'];
$donation_date = $_POST['donation-date'];
$expiry_date = $_POST['expiry-date'];
$special_instructions = $_POST['special-instructions'];

// Handle image upload
$image_path = null;
if (isset($_FILES['food-images']) && $_FILES['food-images']['error'] == 0) {
    $image_dir = "images/"; // Directory to store images
    $image_name = basename($_FILES['food-images']['name']);
    $image_path = $image_dir . $image_name;
    
    // Check if the file is an image (validating mime type)
    $image_file_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
    if (in_array($image_file_type, ['jpg', 'png', 'jpeg', 'gif'])) {
        // Check file size (e.g., 2MB max)
        if ($_FILES['food-images']['size'] <= 2 * 1024 * 1024) { // 2MB max
            if (move_uploaded_file($_FILES['food-images']['tmp_name'], $image_path)) {
                echo "The file " . htmlspecialchars($image_name) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, your file is too large.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
}

// Prepare SQL query to insert data
$stmt = $conn->prepare("INSERT INTO donations (email, food_category, capacity, location, donation_date, expiry_date, special_instructions, image_path) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters
$stmt->bind_param("ssisssss", $email, $food_category, $capacity, $location, $donation_date, $expiry_date, $special_instructions, $image_path);

// Execute the query
if ($stmt->execute()) {
    // Redirect to donation-status.html page after success
    header("Location: donation-status.html");
    exit();  // Ensure script stops after redirect
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
