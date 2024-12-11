# Vehicle_Parking_Management_System
## A Database Management System Project
This is a basic database management system for vehicle parking management.<h3>

### Technical Requirement For The Project:
•	Front-End: HTML, CSS, JavaScript
<br>
•	Backend: PHP
<br>
•	Database: MySQL (Use any RDBMS like PostgreSQL)
<br>
•	Deployment: Apache Server (My preference)
<br>

### Features Of The Project:
- User: A normal person who wants to park his vehicle.<br>
o Registration: The new users can register by filling some details.<br>
o	Login: The registered users can only login to use the application.<br>
o	Book: The user can book a slot for their vehicle if one is available.<br>
o	Finding Vehicle: The user can find the parking spot of his parked vehicle.<br>
o	Exit: The user can exit the parking. <br>
-	Admin: Special users with some special privileges like seeing other’s details & deleting/banning users.<br>
o	Registration: The new users can register by filling some details.<br>
o	Login: The registered users can only login to use the application.<br>
o	Dashboard: Shows the current status of the parking system.<br>
o	Find Vehicle: The admin can find the parking spot of a registered user.<br>
o	User Info: Gives a tabular data for all the registered users.<br>
o	Delete User: The admin can delete the account for a registered user.<br>

## Create the Tables in SQL Server ##
o Table: Admin<br>
CREATE TABLE admin ( 
username VARCHAR(50) PRIMARY KEY, 
password VARCHAR(25) NOT NULL, 
role ENUM('guard', 'manager') NOT NULL );

o Table: Users<br>
CREATE TABLE users ( 
first_name VARCHAR(30), 
last_name VARCHAR(30), 
mobile_no VARCHAR(10) PRIMARY KEY, 
address VARCHAR(50), 
password VARCHAR(25) NOT NULL );

o Table: Parking_slot<br>
CREATE TABLE parking_slot ( 
slot_no INT PRIMARY KEY, 
status ENUM('Booked', 'Empty') NOT NULL, 
license_no VARCHAR(10), entry_time DATETIME, 
mobile_no VARCHAR(10), 
FOREIGN KEY (mobile_no) REFERENCES users(mobile_no) ON DELETE CASCADE ON UPDATE CASCADE);
