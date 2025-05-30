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


$acceptedQuery = $conn->prepare("SELECT email, food_category, capacity, location, donation_date, expiry_date, special_instructions, image_path, status FROM donations WHERE status = 'accepted'");
$acceptedQuery->execute();
$acceptedResult = $acceptedQuery->get_result();


$declinedQuery = $conn->prepare("SELECT email, food_category, capacity, location, donation_date, expiry_date, special_instructions, image_path, status FROM donations WHERE status = 'declined'");
$declinedQuery->execute();
$declinedResult = $declinedQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Donations</title>
    <link rel="stylesheet" href="styleprofile.css">
    <style>
        body {
            background-color: #c0b8b0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .donations-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .donation-list {
            width: 45%;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .donation-item p {
            margin: 5px 0;
        }

    </style>
</head>
<body>

    <div class="donations-container">
        <!-- Accepted Donations -->
        <div class="donation-list" id="accepted-donations">
            <h2>Accepted Donations</h2>
            <?php if ($acceptedResult->num_rows > 0): ?>
                <?php while ($donation = $acceptedResult->fetch_assoc()): ?>
                    <div class="donation-item">
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($donation['email']); ?></p>
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
            <?php else: ?>
                <p>No accepted donations found.</p>
            <?php endif; ?>
        </div>

        <!-- Declined Donations -->
        <div class="donation-list" id="declined-donations">
            <h2>Declined Donations</h2>
            <?php if ($declinedResult->num_rows > 0): ?>
                <?php while ($donation = $declinedResult->fetch_assoc()): ?>
                    <div class="donation-item">
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($donation['email']); ?></p>
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
            <?php else: ?>
                <p>No declined donations found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<?php
$acceptedQuery->close();
$declinedQuery->close();
$conn->close();
?>
