<?php
$db_host="localhost";
$db_username="root";
$db_password="";
$db_name="jqajax";

$conn= new mysqli($db_host,$db_username,$db_password,$db_name);

if ($conn->connect_error) { 

    echo "Failed Connection To Mysql". $conn->connect_error;
    exit();

}



?>