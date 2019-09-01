<?php
    $servername = "localhost:3306";
    $username = "root";
    $password = "password";
    $dbname = "movietest";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    if($_SERVER['REQUEST_METHOD']=='GET') {
        $value=$_GET['data'];
        $sql="SELECT moviename FROM movieprop WHERE moviename LIKE '$value%' or propertyvalue LIKE '$value%' GROUP BY moviename ";
        $result=$conn->query($sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo $row['moviename']." ";
            }
        }
    }

?>