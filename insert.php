<?php
include("dbConnection.php");


$data=stripcslashes(file_get_contents("php://input"));
$mydata=json_decode($data,true);

if(isset($mydata["name"]) && isset($mydata["email"]) &&  isset($mydata["password"]) )
{

    $id=$mydata['id'];
    $name=$mydata['name'];
    $email=$mydata['email'];
    $password=$mydata['password'];


    
    if(!empty($name) && !empty($email) && !empty($password)){
        $sql = "INSERT INTO student (id,name, email, password) VALUES ('$id','$name', '$email', '$password') ON DUPLICATE KEY UPDATE name='$name',email='$email',password='$password'";

       if($conn->query($sql)==TRUE){
        echo "Student saved successfully";
       }else{
        echo "unable to save student".$conn->error;
       }
    }else{
            echo "fill all fileds";
    }


}else{
        echo "Invalidat data format";
}
$conn->close();                      

?>