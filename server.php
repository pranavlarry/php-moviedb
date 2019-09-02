<?php
    include 'config.php';

    


    $limit = 5;

    if (isset($_GET["page"])) {  
        $pn  = $_GET["page"];  
    }  
    else {  
        $pn=1;  
    };

    $start = ($pn-1) * $limit;  

    include 'search.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // echo "hello";
        if(!isset($_REQUEST['req'])){
            $table='';
            $sql1="SELECT * FROM movie";
            $result1=$conn->query($sql1);
            // if(isset($_REQUEST['req'])&&$_REQUEST['req']=='getmovie') {
                $sql="SELECT * FROM movie LIMIT $start,$limit";
                $result=$conn->query($sql);
                $total_records = mysqli_num_rows($result1); 
                $tp = ceil($total_records / $limit);
                $table.= "<tr>
                        <th>Image</th>
                        <th>Film Name</th> 
                        <th>Actors</th>
                        <th>year</th>
                        <th>Ratings</th>
                        <th>Genre</th>
                        <th></th>
                    </tr>";
                $table.=display($result,$conn);
                
                $conn->close();
            // }
            $pagLink="";
            for($i=1; $i<=$tp; $i++) { 
                if($i==$pn)
                $pagLink .= "<li class='page-item active'><a class='page-link' onclick=getMovie(".$i.") href='#'>".$i."</a></li>"; 
                else
                $pagLink .= "<li class='page-item'><a class='page-link' onclick=getMovie(".$i.") href='#'>".$i."</a></li>";   
            }
            $page = array("table"=>$table,"pageno"=>$pagLink);
            //   echo $pagLink;
            header("Content-Type: application/json");
            echo json_encode($page);
        }
        // echo $table;


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
            $yr=$_POST["year"];
            $img=$_POST["img"];
            $rating=$_POST["rating"];
            insert('year',$yr,$name,$conn);
            $check=insert('image',$img,$name,$conn);{
                if ($check === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "<br>" . $conn->error;
                }
            }
            insert('rating',$rating,$name,$conn);
            foreach ($_POST['actorselect'] as $actor){
                insert('actor',$actor,$name,$conn);
            }
            foreach ($_POST['genreselect'] as $genre){
                insert('genre', $genre, $name,$conn);
            }
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


    function getval($conn,$mname){
        $sql="SELECT movieprop.movieproperty,movieprop.propertyvalue
        FROM movieprop
        WHERE moviename = '$mname'";
        return $conn->query($sql);
 
    }

    function insert($propname,$propval,$mname,$conn){
        $sql = "INSERT INTO movieprop (movieproperty, propertyvalue, moviename)
        VALUES ('$propname', '$propval', '$mname');";
        return $conn->query($sql);
    }

    function display($result,$conn) {
        $display="";
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id=$row['id'];
                $mname=$row['movie']; 
                $actor=[];
                $genre=[];
                $result1 = getval($conn,$mname);
                if ($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){
                        switch($row1["movieproperty"]){

                            case 'image': $img=$row1['propertyvalue'];
                                break;
                            case 'rating': $rating=$row1['propertyvalue'];
                                break;
                            case 'year': $year=$row1['propertyvalue'];
                                break;
                            case 'actor':array_push($actor,$row1['propertyvalue']);
                                break;
                            case 'genre':array_push($genre,$row1['propertyvalue']);
                                break;
                        }
                    }
                        $display.= "<tr id='parent'>";
                        $display.= "<td><img src='".$img."' width='50px' /></td>";
                        $display.= "<td id='mname'>".$mname."</td>";
                        $display.= "<td id='".$id."a'>";
                        foreach ($actor as $val){
                            $display.= $val."<br>";
                        }
                        $display.= "</td>";
                        $display.= "<td id='".$id."y'>".$year. "</td>";
                        $display.= "<td id='".$id."r'>".$rating. "</td>";
                        $display.= "<td id='".$id."g'>";
                        foreach ($genre as $val){
                            $display.= $val."<br>";
                        }
                        $display.= "</td>";
                        $display.= "<td id=".$id."><button value='".$id."' onclick=\"edit(this)\">Edit Movie</button>
                                <button onclick=\"del(this)\">Delete Movie</button>
                            </td>";
                        $display.= "</tr>";
                }     
            }
        }
        else {
            $display= "0 results";
        }
        return $display;
    }

?>