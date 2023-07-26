<?php

include('connection.php');

$username = $_POST['username'];
$password = $_POST['password'];

$query = $mysqli->prepare('select first_name, last_name, username, password from users where username = ?');
$query->bind_param('s',$username);
$query->execute();
$query->store_result();
$query->bind_result($first_name, $last_name, $username,$hashed_password);
$query->fetch();

if($query->num_rows() == 1){
    if (password_verify($password, $hashed_password)) {
    $response['status'] = 'success';
    $response['first_name'] =$first_name;
    $response['last_name']= $last_name;
    $response['username'] = $username;
    }
}
else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid username or password';
 }
echo  json_encode($response);