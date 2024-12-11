<?php

session_start();
include 'config.inc.php';


$mobile_no = $_POST['mobile_no'];
$password = $_POST['password'];

$sql = "SELECT * FROM parking_management_system.users WHERE mobile_no = $mobile_no and
        password='$password'";
$result = $conn->query($sql); 

if(!empty($mobile_no) && !empty($password)){
    if ($result->num_rows > 0){
        $_SESSION['mobile_no'] = $mobile_no;
        header("Location:book_parking.html");
        exit();
    }
    else{
        echo "User not found";
    }
}
else{
    echo "Please Fill Data";
}

$conn->close();
?>