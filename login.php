<?php
include('connection.php');

$user_name = $_POST['user-name'];
$pass_word = $_POST['pass-word'];

$query = $mysqli->prepare('select id,username,password,first_name,last_name
from users 
where username=?');
$query->bind_param('s', $user_name);
$query->execute();

$query->store_result();
$query->bind_result($id, $username, $hashed_password, $first_name, $last_name);
$query->fetch();

$num_rows = $query->num_rows();
if ($num_rows == 0) {
    $response['status'] = "user not found";
} else {
    if (password_verify($pass_word, $hashed_password)) {
        $response['status'] = 'logged in';
        $response['user_id'] = $id;
        $response['first_name'] = $first_name;
        $response['username'] = $username;
    } else {
        $response['status'] = "wrong password";
    }
}

echo json_encode($response);
