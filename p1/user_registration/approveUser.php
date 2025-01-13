<?php
require_once('../model/userModel.php');

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    if (approveUser($userId)) {
        echo json_encode(["message" => "User approved successfully."]);
    } else {
        echo json_encode(["message" => "Failed to approve user."]);
    }
} else {
    echo json_encode(["message" => "User ID is required."]);
}
?>
