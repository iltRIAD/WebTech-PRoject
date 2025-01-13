<?php
require_once('../model/userModel.php');

if (isset($_GET['id']) && isset($_GET['reason'])) {
    $userId = $_GET['id'];
    $reason = $_GET['reason'];
    
    if (rejectUser($userId, $reason)) {
        echo json_encode(["message" => "User rejected successfully."]);
    } else {
        echo json_encode(["message" => "Failed to reject user."]);
    }
} else {
    echo json_encode(["message" => "User ID and reason are required."]);
}
?>
