<?php
require_once('../model/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];

    if (deleteUser($userId)) {
        echo "User deleted successfully!";
    } else {
        echo "Failed to delete user.";
    }
}
?>
