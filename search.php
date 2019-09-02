<?php
    
    if($_SERVER['REQUEST_METHOD']=='GET' ) {
        if(isset($_REQUEST['req'])&& $_REQUEST['req']=='search'){
            $value=$_GET['data'];
            $mname=null;
            $actor=[];
            $genre=[];
            $sql="SELECT * FROM movietest.movie
            WHERE movie in
            (SELECT moviename FROM movietest.movieprop 
            WHERE moviename LIKE '$value%' OR propertyvalue LIKE '$value%' );";
            $result=$conn->query($sql);
            display($result,$conn);
        }

    

    }

    // function getval($conn,$mname){
    //     $sql="SELECT movieprop.movieproperty,movieprop.propertyvalue
    //     FROM movieprop
    //     WHERE moviename = '$mname'";
    //     return $conn->query($sql);
 
    // }


    // function display($result,$conn) {
    //     if ($result->num_rows > 0) {
    //         // output data of each row
    //         while($row = $result->fetch_assoc()) {
    //             $id=$row['id'];
    //             $mname=$row['movie']; 
    //             $actor=[];
    //             $genre=[];
    //             $result1 = getval($conn,$mname);
    //             if ($result1->num_rows > 0){
    //                 while($row1 = $result1->fetch_assoc()){
    //                     switch($row1["movieproperty"]){

    //                         case 'image': $img=$row1['propertyvalue'];
    //                             break;
    //                         case 'rating': $rating=$row1['propertyvalue'];
    //                             break;
    //                         case 'year': $year=$row1['propertyvalue'];
    //                             break;
    //                         case 'actor':array_push($actor,$row1['propertyvalue']);
    //                             break;
    //                         case 'genre':array_push($genre,$row1['propertyvalue']);
    //                             break;
    //                     }
    //                 }
    //                     echo "<tr id='parent'>";
    //                     echo "<td><img src='".$img."' width='50px' /></td>";
    //                     echo "<td id='mname'>".$mname."</td>";
    //                     echo "<td id='".$id."a'>";
    //                     foreach ($actor as $val){
    //                         echo $val."<br>";
    //                     }
    //                     echo "</td>";
    //                     echo "<td id='".$id."y'>".$year. "</td>";
    //                     echo "<td id='".$id."r'>".$rating. "</td>";
    //                     echo "<td id='".$id."g'>";
    //                     foreach ($genre as $val){
    //                         echo $val."<br>";
    //                     }
    //                     echo "</td>";
    //                     echo "<td id=".$id.">
    //                             <button value='".$id."' onclick=\"edit(this)\">Edit Movie</button>
    //                             <button onclick=\"del(this)\">Delete Movie</button>
    //                         </td>";
    //                     echo "</tr>";
    //             }     
    //         }
    //     }
    //     else {
    //         echo "0 results";
    //     }
    // }
    

?>