<?php
require_once('../model/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (addUser($name, $email, $username, $password)) {
        echo "User added successfully!";
    } else {
        echo "Failed to add user.";
    }
}
?>
