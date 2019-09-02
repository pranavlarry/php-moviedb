<?php
    include 'config.php';

    //add new actor or genre
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $req= $_REQUEST["req"];
        if($req=='a'){
            $name=$_POST["aname"];
            $sql = "INSERT INTO actor (actor)
            VALUES ('$name')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
        else if($req== 'g') {
            $name=$_POST["aname"];
            $sql = "INSERT INTO genre (genre)
            VALUES ('$name')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    //display actor or genre
    else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $req= $_REQUEST["req"];
        if($req=='a') {
            $sql = "SELECT * FROM actor";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['actor']."'>".$row['actor']."</option>";
                }
            } else {
                echo "0 results";
            }
        }
        else if($req=='g'){
            $sql = "SELECT * FROM genre";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['genre']."'>".$row['genre']."</option>";
                }
            } else {
                echo "0 results";
            }
        }
    }
?>