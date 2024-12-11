<?php
include 'config.inc.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$mobile_no = str_replace(" ", "", $_POST['mobile_no']);
$address = $_POST['address'];
$password = $_POST['password'];

$cond = !empty($first_name) && !empty($last_name) && !empty($address) && !empty($mobile_no) && (strlen($mobile_no) === 10) && !empty($password);

        
if ($cond) {
    $stmt = $conn->prepare("INSERT INTO parking_management_system.users (first_name, last_name, mobile_no, address, password)
          VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssiss', $first_name, $last_name, $mobile_no, $address, $password);
    
    if ($stmt->execute()){
        echo "New User Registered Successfully!";
        echo "<br>";
        echo "Click the link below to redirect to user page..";
        echo "<br>";
        echo '<a href = "user.html">User</a>';
    }
    else {
        echo "Error: ".$stmt->error;
    }
    $stmt->close();
}
else {
    if (strlen($mobile_no) != 10){
        echo "Incorrect mobile number, please fill 10 digits";
    }
    else{
        echo "All fields required!";
    }
}
$conn->close();
?>