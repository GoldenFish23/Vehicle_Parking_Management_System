<?php
session_start();
include 'config.inc.php';

if (!isset($_SESSION['mobile_no'])) {
    echo "Please log in first.";
    exit();
}

$mobile_no = $_SESSION['mobile_no'];
$license_no = $_POST['license_no'];
$action = $_POST['action'];

if ($action == 'Exit') {
    // Exit the parked spot
    $conn->query("SET SQL_SAFE_UPDATES = 0;");
    $sql = "UPDATE parking_management_system.parking_slot
            SET mobile_no = '', entry_time = null, license_no = null, status = 'Empty'
            WHERE mobile_no = '$mobile_no' AND license_no = '$license_no'";
    if ($conn->query($sql) === TRUE) {
        echo "You have successfully exited the parking spot.";
        header("Location: find_exit.html"); // Redirect to a success page after exit
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->query("SET SQL_SAFE_UPDATES = 1;");
}

$conn->close();
?>
