<?php
$servername = "localhost:3306";
$username = "root";
$password = "password";
$dbname = "movietest";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//create db


// // Create connection
// $conn = new mysqli($servername, $username, $password);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 

// // Create database
// $sql = "CREATE DATABASE movietest";
// if ($conn->query($sql) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $conn->error;
// }

// $conn->close();



// sql to create table
$sql = "CREATE TABLE movieprop (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
movieproperty VARCHAR(100) NOT NULL,
propertyvalue VARCHAR(500) NOT NULL,
moviename VARCHAR(100) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


// $sql = "INSERT INTO test (firstname, lastname, email)
// VALUES ('Julie', 'Dooley', 'julie@example.com')";
// if ($conn->query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

// $sql = "SELECT firstname FROM test WHERE firstname='julie'";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     $row = $result->fetch_assoc();
//     echo " Name: " . $row["firstname"] ;
// } else {
//     echo "0 results";
// }

$conn->close();

?>
