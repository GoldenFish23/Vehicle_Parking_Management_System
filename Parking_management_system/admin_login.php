<?php
session_start();
include 'config.inc.php';

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM parking_management_system.admin WHERE username = ? and
        password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();
    $result = $stmt->get_result(); 

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("Location:admin_panel.php");
    }
    else if ($result->num_rows == 0){
        echo "Invalid Credidential / Fill Properly";
    }
}
$conn->close();
?>