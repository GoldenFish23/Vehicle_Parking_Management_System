<?php
include 'config.inc.php';

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$cond = !empty($username) && !empty($password);

if ($cond) {

    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM parking_management_system.admin WHERE username = ?");
    $checkStmt->bind_param('s', $username);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        echo "Username already exists. Please choose a different username.<br>";
        echo 'Use this to go back <a href="register_admin.html">Back</a>';
    } 
    else {
        $stmt = $conn->prepare("INSERT INTO parking_management_system.admin (username, password, role)
              VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $password, $role);

        if ($stmt->execute()) {
            echo "New Admin Registered Successfully!";
            echo "<br>";
            echo "Click the link below to redirect to admin page..";
            echo "<br>";
            echo '<a href="admin.html">Admin</a>';
        } 
        else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} 

else {
    echo "Fill all details";
}

$conn->close();
?>