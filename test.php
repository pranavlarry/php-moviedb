<?php
    $php ="<h3>hello</h3>";
    $php.="<h4>hi</h4>";
    $hello="<p>hiii</p>";
    $person = array("name"=>$php,"mmm"=>$hello);
    header("Content-Type: application/json");
    echo json_encode($person);

?>