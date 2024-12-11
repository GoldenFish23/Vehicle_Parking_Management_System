<?php

include 'config.inc.php';

$sql = "SELECT users.first_name, 
	users.last_name,
    users.mobile_no,
    parking_slot.license_no,
    parking_slot.slot_no AS 'parked_slot',
    parking_slot.entry_time,
    users.address
FROM users
LEFT JOIN parking_slot ON users.mobile_no = parking_slot.mobile_no";
$result = $conn->query($sql);


ob_start();

session_start();
if (!isset($_SESSION['role'])){
    header("Location: admin_login.php");
    exit;
}
$role = $_SESSION['role'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data from Database</title>
    <link rel="stylesheet" href="admin_panel.css">
    <style>
        body{   
            background-color:white;
            margin: 0px;
            height: 100vh;
        }
        nav{
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgb(55, 43, 225);
            color: White;
            padding: 15px;
        }
        nav h1{
            font-size: 34px;
            padding:0px 13px;
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
        .frame{
            height: inherit;
            width: auto;
            display: flex;
            margin:0px;
            background-color:white;
        }
        .menu{
            display: flex;
            flex-direction:column;
            height: inherit;
            width:max-content;
            background-color:blue;
        }
        .menu button{
            padding: 10px;
            background-color:white;
        }
        .table{
            flex:1;
            height: inherit;
            width:75vw;
            padding: 10px;
            overflow:auto;
            display:none;
        }
        form h6{
            color: white;
            font-size: large;
            margin: 0px;
        }
        .dash{
            flex:1;
            height: inherit;
            display: none;
            width:max-content;
            justify-content:space-around;
            align-items:flex-start;
            padding:10px;
        }
        .del_user{
            display:none;
            padding:10px;
        }
        .veh{
            display:block;
            padding:10px;
        }
        .tabOne, .tabTwo{
            justify-content: center;
            background-color:yellow;
            padding:10px;
        }
        .dash h4, .dash h1{
            margin:0px;
        }
    </style>
</head>
<body>
    <nav>
    <h1>Admin Panel</h1>
    <ul>
        <li>
            <a href = "index.html" >Home</a>
        </li>
    </ul>
    </nav>
    <div class = "frame">
        <div class = "menu">
        <button onclick="veh_detail()">Find Vehicle</button>
            <button onclick="dashboard()">Dashboard</button>
            <button onclick="users_detail()">User Info</button>
            <?php if ($role == 'manager'){ ?>
                <button onclick="del_user()">Delete User</button>
            <?php }?>
        </div>
        <div id = "dash" class="dash">
            <div class = "tabOne">
                <h4>Total No. of Users</h4>
                <br>
                <h1>
                    <?php
                        $sqlTwo = "SELECT count(first_name) as users 
                        FROM parking_management_system.users
                        WHERE first_name IS NOT NULL";
                
                        $resultTwo = $conn->query($sqlTwo);
                        if ($resultTwo) {
                            $row = $resultTwo->fetch_assoc();
                            $totalUsers = $row['users'];
                            echo $totalUsers;
                        } 
                        else {
                            echo "Error: " . $conn->error;
                        }
                    ?>
                <h1>
            </div>
            <div class = "tabTwo">
                <h4>No. of Parked Vehicles</h4>
                <br>
                <h1>
                    <?php
                        $sqlThree = "SELECT COUNT(license_no) as totalvehicles 
                        FROM parking_management_system.parking_slot
                        WHERE license_no IS NOT NULL";
                
                        $resultThree = $conn->query($sqlThree);
                        if ($resultThree) {
                            $row = $resultThree->fetch_assoc();
                            $totalVehicles = $row['totalvehicles'];
                            echo $totalVehicles;
                        } 
                        else {
                            echo "Error: " . $conn->error;
                        }
                    ?>
                </h1>
            </div>
        </div>
        <div id = "table" class="table">
            <table class = "tab" border="1">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Mobile No.</th>
                    <th>License No.</th>
                    <th>Parking Slot No.</th>
                    <th>Entry Time
                        (format 'date time')
                    </th>
                    <th>Address</th>
                </tr>
                <?php
                // Display data in the HTML table
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["first_name"] . '</td>';
                        echo '<td>' . $row["last_name"] . '</td>';
                        echo '<td>' . $row["mobile_no"] . '</td>';
                        echo '<td>' . $row["license_no"] . '</td>';
                        echo '<td>' . $row["parked_slot"] . '</td>';
                        echo '<td>' . $row["entry_time"] . '</td>';
                        echo '<td>' . $row["address"] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No data found</td></tr>';
                }
                ?>
            </table>
        </div>
        <div id ="veh" class="veh">
            <form method="post" action="admin_panel.php">
                Search:
                <input type="text" name="search_vehicle" placeholder="License No.">
                <input type="submit" value="Search">
            </form>
            <br>
            <table border="1">
                <tr>
                    <th>License No.</th>
                    <th>Slot No.</th>
                </tr>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['search_vehicle'])) {
                    $search_vehicle = $_POST['search_vehicle'];

                    $sqlFour = "SELECT license_no, slot_no
                                FROM parking_slot
                                WHERE license_no = ?";
                    $stmtFour = $conn->prepare($sqlFour);
                    $stmtFour->bind_param("s", $search_vehicle);
                    $stmtFour->execute();
                    $resultFour = $stmtFour->get_result();

                    if ($resultFour->num_rows > 0) {
                        while ($rowTwo = $resultFour->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $rowTwo["license_no"] . '</td>';
                            echo '<td>' . $rowTwo["slot_no"] . '</td>';
                            echo '</tr>';
                        }
                    }
                    else {
                        echo '<tr><td colspan="3">No data found</td></tr>';
                    }
                }
                ?>
            </table>
        </div>
        <div id = "del_user" class="del_user">
            <form method="post" action="admin_panel.php">
                Del User:
                <input type="text" name="del_user" placeholder="Mobile No.">
                <input type="submit" value="Delete">
            </form>
            <?php 
                if ($role == 'manager'){
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['del_user'])){
                        $del_mob = $_POST['del_user'];

                        if(!empty($del_mob)){
                            $conn->query("SET SQL_SAFE_UPDATES = 0;");
                            $sqlFive = "UPDATE parking_management_system.parking_slot
                                        SET mobile_no = '', entry_time = null, license_no = null, status = 'Empty'
                                        WHERE mobile_no = ?;";

                            $stmtFive = $conn->prepare($sqlFive);
                            $stmtFive->bind_param("s", $del_mob);
                            $stmtFive->execute();

                            $sqlSix = " DELETE from parking_management_system.users
                                        WHERE mobile_no = ?;";

                            $stmtSix = $conn->prepare($sqlSix);
                            $stmtSix->bind_param("s", $del_mob);
                            $stmtSix->execute();

                            $conn->query("SET SQL_SAFE_UPDATES = 1;");
                            
                            if ($stmtFive->affected_rows > 0 || $stmtSix->affected_rows > 0) {
                                echo "User deleted";
                            } else {
                                echo "Error deleting";
                            }

                            $stmtFive->close();
                            $stmtSix->close();
                        }
                        else{
                            echo "Provide num";
                        }
                    }
                } 
                $conn->close(); 
            ?>
        </div>
    </div>
    <script>
        function dashboard() {
            var dash = document.getElementById("dash");
            dash.style.display = "flex";
            var table = document.getElementById("table");
            table.style.display = "none";
            var veh = document.getElementById("veh");
            veh.style.display = "none";
            var del = document.getElementById("del_user");
            del.style.display = "none";
        }
        function users_detail() {
            var dash = document.getElementById("dash");
            dash.style.display = "none";
            var table = document.getElementById("table");
            table.style.display = "block";
            var veh = document.getElementById("veh");
            veh.style.display = "none";
            var del = document.getElementById("del_user");
            del.style.display = "none";
        }
        function veh_detail() {
            var dash = document.getElementById("dash");
            dash.style.display = "none";
            var table = document.getElementById("table");
            table.style.display = "none";
            var veh = document.getElementById("veh");
            veh.style.display = "block";
            var del = document.getElementById("del_user");
            del.style.display = "none";
        }
        function del_user() {
            var dash = document.getElementById("dash");
            dash.style.display = "none";
            var table = document.getElementById("table");
            table.style.display = "none";
            var veh = document.getElementById("veh");
            veh.style.display = "none";
            var del = document.getElementById("del_user");
            del.style.display = "block";
        }
    </script>
</body>
</html>
<?php
// End output buffering and flush output
ob_end_flush();

// Close the database connection
$conn->close();
?>
