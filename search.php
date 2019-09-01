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
        $mname=null;
        $actor=[];
        $genre=[];
        $sql="SELECT * FROM movietest.movieprop
        WHERE moviename in
        (SELECT moviename FROM movietest.movieprop 
        WHERE moviename LIKE '$value%' OR propertyvalue LIKE '$value%' );";
        $result=$conn->query($sql);
        $id=0;
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $id=$id+1;
                switch($row["movieproperty"]){

                    case 'image': $img=$row['propertyvalue'];
                        break;
                    case 'rating': $rating=$row['propertyvalue'];
                        break;
                    case 'year': $year=$row['propertyvalue'];
                        break;
                    case 'actor':array_push($actor,$row['propertyvalue']);
                        break;
                    case 'genre':array_push($genre,$row ['propertyvalue']);
                        break;
                }
                // echo $mname ."!=". $row['moviename'] ."||".$id."==".mysqli_num_rows($result);
                if(($mname!=$row['moviename'] && $id!=1)||$id==mysqli_num_rows($result)){
                    echo "<tr id='parent'>";
                    echo "<td><img src='".$img."' width='50px' /></td>";
                    echo "<td id='mname'>".$mname."</td>";
                    echo "<td id='".$id."a'>";
                    foreach ($actor as $val){
                        echo $val."<br>";
                    }
                    echo "</td>";
                    echo "<td id='".$id."y'>".$year. "</td>";
                    echo "<td id='".$id."r'>".$rating. "</td>";
                    echo "<td id='".$id."g'>";
                    foreach ($genre as $val){
                        echo $val."<br>";
                    }
                    echo "</td>";
                    echo "<td id=".$id.">
                            <button value='".$id."' onclick=\"edit(this)\">Edit Movie</button>
                            <button onclick=\"del(this)\">Delete Movie</button>
                        </td>";
                    echo "</tr>";
                    $actor=[];
                    $genre=[];
                }
                
                $mname=$row['moviename'];
                

                
            }

        }
        else{
            echo "none";
        }
    }

?>