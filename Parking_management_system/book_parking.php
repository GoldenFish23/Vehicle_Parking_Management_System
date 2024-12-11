<?php
include 'config.inc.php';

$mobile_no = $_POST['mobile_no'];
$license_no = $_POST['license_no'];
$slot_no = $_POST['spot'];
$entry_time = date('Y-m-d H:i:s');

$sqlOne = "SELECT mobile_no 
           FROM parking_management_system.users 
           WHERE mobile_no = ?";
$stmtOne = $conn->prepare($sqlOne);
$stmtOne->bind_param("s", $mobile_no);
$stmtOne->execute();
$resultOne = $stmtOne->get_result();


//$resultThree = $conn->query($sqlThree);

if ($resultOne->num_rows===1){

    if ($slot_no==="Null"){
        echo "Choose correct slot";
    }
    else if (strlen($license_no)===10){

        $sqlTwo = "SELECT status
            FROM parking_management_system.parking_slot
            WHERE slot_no = ?";
        $stmtTwo = $conn->prepare($sqlTwo);
        $stmtTwo->bind_param("s", $slot_no);
        $stmtTwo->execute();
        $resultTwo = $stmtTwo->get_result();
        $row = $resultTwo->fetch_assoc();

        if ($row['status'] === 'Empty'){

            $sqlThree = "UPDATE parking_management_system.parking_slot
            SET license_no = ?,
            entry_time = ?,
            status = 'Booked',
            mobile_no = ?
            WHERE slot_no = ?";

            $stmtThree = $conn->prepare($sqlThree);
            $stmtThree->bind_param("ssis", $license_no, $entry_time, $mobile_no, $slot_no);
            $stmtThree->execute();

            //$conn->query($sqlThree);
            echo "Slot booked successfully";
            echo "<br>";
            echo "<br>";
            echo 'Click here to go back'; 
            echo "<br>"; 
            echo '<a href="book_parking.html">Back</a>';
        }
        else{
            echo "This slot is already booked";
            echo "<br>";
            echo "<br>";
            echo 'Click here to go back'; 
            echo "<br>"; 
            echo '<a href="book_parking.html">Back</a>';
        }
    }
    else{
        echo "Incorrect License Number";
        echo "<br>";
        echo "<br>";
        echo 'Click here to go back';  
        echo "<br>";
        echo '<a href="book_parking.html">Back</a>';
    }
}
else{
    echo "Incorrect Mobile Number";
    echo "<br>";
    echo "<br>";
    echo 'Click here to go back';  
    echo '<a href="book_parking.html">Back</a>';
}
$conn->close();
?>