<?php

include('dbConnection.php');

$data=stripcslashes(file_get_contents("php://input"));
$mydata=json_decode($data,true);
$id=$mydata['sid'];

if(!empty($id)){
  
    $sql="DELETE FROM  student WHERE id={$id}";
    if($conn->query($sql)){
        echo 1;
}else{
    echo 0;
}
}



?>