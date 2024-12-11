<?php
// Start the session
include 'config.inc.php';
session_start();


// Check if the user is logged in
if (!isset($_SESSION['mobile_no'])) {
    echo "Please log in first.";
    exit();
}

$mobile_no = $_SESSION['mobile_no'];

// Automatically find the parking spot based on the mobile number
$sql = "SELECT slot_no, license_no, status 
        FROM parking_management_system.parking_slot 
        WHERE mobile_no = '$mobile_no'";
$result = $conn->query($sql);

$parking_info = null;
if ($result->num_rows > 0) {
    $parking_info = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find / Exit Parking</title>
    <style>
            body{
                background-color:white;
                margin: 0px;
            }
            nav h1{
                font-size: 34px;
                padding:0px 13px;
            }
            nav{
                display: flex;
                align-items: center;
                justify-content: space-between;
                background-color: rgb(55, 43, 225);
                color: White;
                padding: 15px;
            }
            nav ul{
                display: flex;
            }
            nav ul li{
                padding: 10px;
                list-style: none;
            }
            nav ul li a{
                color: white;
                text-decoration: none;
            }
            .back{
                padding:0px 10px;
            }
            form button{
                background-color:red;
                border-radius: 5px;
                padding:7px 20px;
                
                color:white;
                font-size:medium;
            }
            button:hover{
                cursor:pointer;
            }
        </style>
</head>
<body>
    <nav>
        <h1>Find / Exit Parking</h1>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="user.html">User</a></li>
            <li><a href="book_parking.html">Book Parking</a></li>
        </ul>
    </nav>
    <div class = "back">
        <div id="parking-info">
            <?php if ($parking_info): ?>
                <h2>Your Parking Spot:</h2>
                <p>Slot Number: <?php echo $parking_info['slot_no']; ?></p>
                <p>License No: <?php echo $parking_info['license_no']; ?></p>
                <p>Status: <?php echo $parking_info['status']; ?></p>
            <?php else: ?>
                <p>No parking spot found for your account.</p>
            <?php endif; ?>
        </div>

        <?php if ($parking_info): ?>
            <form action="find_exit.php" method="post">
                <input type="hidden" name="license_no" value="<?php echo $parking_info['license_no']; ?>">
                <button type="submit" name="action" value="Exit">Exit</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
