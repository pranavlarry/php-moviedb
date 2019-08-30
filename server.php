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

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $sql = "SELECT * FROM movie";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $id=0;
            echo "<tr>
                    <th>Image</th>
                    <th>Film Name</th> 
                    <th>Actors</th>
                    <th>year</th>
                    <th>Ratings</th>
                    <th>Genre</th>
                    <th></th>
                </tr>";
            while($row = $result->fetch_assoc()) {
                $mname=$row['movie'];
                $rating=getval($mname,'rating',$conn);
                $img=getval($mname,'image',$conn);
                $year=getval($mname,'year',$conn);
                $sql1= "SELECT propertyvalue FROM movieprop WHERE moviename='$mname' AND movieproperty='actor'";
                $result1 = $conn->query($sql1);
                $sql2= "SELECT propertyvalue FROM movieprop WHERE moviename='$mname' AND movieproperty='genre'";
                $result2 = $conn->query($sql2);
                $id=$id+1;
                echo "<tr id='parent'>";
                echo "<td><img src='".$img."' width='50px' /></td>";
                echo "<td id='mname'>".$mname."</td>";
                echo "<td id='".$id."a'>";
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()) {
                        echo $row1["propertyvalue"]."<br>";
                    }
                } 
                echo "</td>";
                echo "<td id='".$id."y'>".$year. "</td>";
                echo "<td id='".$id."r'>".$rating. "</td>";
                echo "<td id='".$id."g'>";
                if($result2->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()) {
                        echo  $row2["propertyvalue"]."<br>";
                    }
                }  
                echo "</td>";
                echo "<td id=".$id.">
                        <button value='".$id."' onclick=\"edit(this)\">Edit Movie</button>
                         <button onclick=\"del(this)\">Delete Movie</button>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // echo $_POST['name'];
        $req= $_REQUEST["req"];
        if($req=='edit') {
            $name=$_POST["name"];
            $year=$_POST["year"];
            $rating=$_POST["rating"];
            $sql1 = " DELETE FROM movieprop WHERE moviename='$name' AND movieproperty<>'image'";
            $conn->query($sql1);
            insert('year',$year,$name,$conn);
            $check=insert('rating',$rating,$name,$conn);
            foreach ($_POST['actor'] as $actor){
                insert('actor',$actor,$name,$conn);
            }
            foreach ($_POST['genre'] as $genre){
                // echo $genre."\n";
                insert('genre',$genre,$name,$conn);
            }
            if ($check === TRUE) {
                echo "successfull";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        else {
            echo "hello";
            $name=$_POST["name"];
            $sql = "INSERT INTO movie (movie)
                VALUES ('$name');";
            if($conn->query($sql)===TRUE){
                echo "done";
            }else{
                echo "error";
            }
            // echo $name;
            $yr=$_POST["year"];
            $img=$_POST["img"];
            // $genre=$_POST["genreselect"];
            $rating=$_POST["rating"];
            insert('year',$yr,$name,$conn);
            insert('image',$img,$name,$conn);
            insert('rating',$rating,$name,$conn);

            // $actor=$_POST["actorselect"];
            foreach ($_POST['actorselect'] as $actor){
                // echo $actor."\n";
                insert('actor',$actor,$name,$conn);
                // if ($conn->query($sql) === TRUE) {
                //     echo "New record created successfully";
                // } else {
                //     echo "Error: " . $sql . "<br>" . $conn->error;
                // }
            }
            foreach ($_POST['genreselect'] as $genre){
                insert('genre', $genre, $name,$conn);
                // if ($conn->query($sql) === TRUE) {
                //     echo "New record created successfully";
                // } else {
                //     echo "Error: " . $sql . "<br>" . $conn->error;
                // }
            }
            // $sql = "INSERT INTO movie (moviename, yr, img, rating)
            // VALUES ('$name', '$yr', '$img', '$rating')";
            // $conn->query($sql);
            // $conn->close();
            header('Location: /movie.html');
        }

    }

    else if ($_SERVER["REQUEST_METHOD"]== "DELETE") {
        $data =file_get_contents('php://input');
        parse_str($data, $name);
        $del_id=$name['name'];
        $sql = "DELETE FROM movie WHERE movie='$del_id'";
        $sql1 = " DELETE FROM movieprop WHERE moviename='$del_id'";    
        if ($conn->query($sql) === TRUE && $conn->query($sql1)===TRUE) {
            echo "successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }


    function getval($mname,$propname,$conn){
        $sql1= "SELECT propertyvalue FROM movieprop WHERE moviename='$mname' AND movieproperty='$propname'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        return $row1['propertyvalue'];
    }

    function insert($propname,$propval,$mname,$conn){
        $sql = "INSERT INTO movieprop (movieproperty, propertyvalue, moviename)
        VALUES ('$propname', '$propval', '$mname');";
        return $conn->query($sql);
    }


?>