<?php

include('connection.php');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$password = $_POST['password'];

$check_username = $mysqli->prepare('select username from users where username=?');
$check_username->bind_param('s',$username);
$check_username->execute();
$check_username->store_result();
$username_exists = $check_username->num_rows();

if($username_exists ==0){
    $hashed_password =password_hash($password,PASSWORD_BCRYPT);
    $query = $mysqli->prepare('insert into users(username,password,first_name,last_name) values(?,?,?,?)');
    $query->bind_param('ssss', $username, $hashed_password, $first_name, $last_name);
    $query->execute();

    $response['status'] = "success";
    
} else {
     $response['status'] = "User name already exists";
 }

 
 echo json_encode($response);
