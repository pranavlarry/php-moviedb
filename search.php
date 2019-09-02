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
            $table=display($result,$conn);
            echo $table;
            // $page = array("table"=>$table,"pageno"=>" ");
            // //   echo $pagLink;
            // header("Content-Type: application/json");
            // echo json_encode($page);
        }
    }

?>