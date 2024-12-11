# Vehicle_Parking_Management_System
A Database Management System Project
<h3>This is a basic database management system for vehicle parking management.<h3>

Technical Requirement For The Project: 
•	Front-End: HTML, CSS, JavaScript
•	Backend: PHP
•	Database: MySQL (Use any RDBMS like PostgreSQL)
•	Deployment: Apache Server (My preference)

Features Of The Project:
•	User: A normal person who wants to park his vehicle.
o	Registration: The new users can register by filling some details.
o	Login: The registered users can only login to use the application.
o	Book: The user can book a slot for their vehicle if one is available.
o	Finding Vehicle: The user can find the parking spot of his parked vehicle.
o	Exit: The user can exit the parking. 
•	Admin: Special users with some special privileges like seeing other’s details & deleting/banning users.
o	Registration: The new users can register by filling some details.
o	Login: The registered users can only login to use the application.
o	Dashboard: Shows the current status of the parking system.
o	Find Vehicle: The admin can find the parking spot of a registered user.
o	User Info: Gives a tabular data for all the registered users.
o	Delete User: The admin can delete the account for a registered user.

-- Create the Tables in SQL Server --
Table: Admin
CREATE TABLE admin ( 
username VARCHAR(50) PRIMARY KEY, 
password VARCHAR(25) NOT NULL, 
role ENUM('guard', 'manager') NOT NULL );

Table: Users
CREATE TABLE users ( 
first_name VARCHAR(30), 
last_name VARCHAR(30), 
mobile_no VARCHAR(10) PRIMARY KEY, 
address VARCHAR(50), 
password VARCHAR(25) NOT NULL );

Table: Parking_slot
CREATE TABLE parking_slot ( 
slot_no INT PRIMARY KEY, 
status ENUM('Booked', 'Empty') NOT NULL, 
license_no VARCHAR(10), entry_time DATETIME, 
mobile_no VARCHAR(10), 
FOREIGN KEY (mobile_no) REFERENCES users(mobile_no) ON DELETE CASCADE ON UPDATE CASCADE);
