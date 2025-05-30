<?php
session_start();


$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "user_registration"; 
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['userEmail'])) {
    header("Location: index.html");
    exit();
}

$userEmail = $_SESSION['userEmail'];


$userQuery = $conn->prepare("SELECT name, contact FROM users WHERE email = ?");
$userQuery->bind_param("s", $userEmail);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc();


$donationQuery = $conn->prepare("SELECT food_category, capacity, location, donation_date, expiry_date, special_instructions, image_path, status FROM donations WHERE email = ?");
$donationQuery->bind_param("s", $userEmail);
$donationQuery->execute();
$donationResult = $donationQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styleprofile.css">
    <style>
       
        body {
            background-color: #c0b8b0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .back-btn-container {
            position: absolute;
            top: 10px;
            left: 20px;
            cursor: pointer;
        }

        .back-btn-container a {
            text-decoration: none;
            font-size: 20px;
            color: black;
            padding: 8px 12px;
            border-radius: 5px;
            background-color: #fff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .back-btn-container a:hover {
            background-color: #dcdcdc;
        }

        .profile-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .profile-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            font-size: 16px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        
        .donations-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        .donation-item {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .donation-item img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <div class="back-btn-container">
        <a href="home1.html">&#8592; Back</a>
    </div>

    <div class="profile-wrapper">
        <!-- User Profile Section -->
        <div class="profile-container">
            <h2>User Profile</h2>
            <table>
                <tr><th>Name</th><td><?php echo htmlspecialchars($userData['name']); ?></td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($userEmail); ?></td></tr>
                <tr><th>Phone</th><td><?php echo htmlspecialchars($userData['contact']); ?></td></tr>
            </table>
        </div>

        <!-- Donations Section -->
        <div class="donations-container">
            <h2>Your Donations</h2>
            <?php while ($donation = $donationResult->fetch_assoc()): ?>
                <div class="donation-item">
                    <p><strong>Food Category:</strong> <?php echo htmlspecialchars($donation['food_category']); ?></p>
                    <p><strong>Capacity:</strong> <?php echo htmlspecialchars($donation['capacity']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($donation['location']); ?></p>
                    <p><strong>Donation Date:</strong> <?php echo htmlspecialchars($donation['donation_date']); ?></p>
                    <p><strong>Expiry Date:</strong> <?php echo htmlspecialchars($donation['expiry_date']); ?></p>
                    <p><strong>Special Instructions:</strong> <?php echo htmlspecialchars($donation['special_instructions']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($donation['status']); ?></p>
                    <?php if (!empty($donation['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($donation['image_path']); ?>" alt="Donation Image">
                    <?php else: ?>
                        <p><em>No image provided</em></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php
$userQuery->close();
$donationQuery->close();
$conn->close();
?>
