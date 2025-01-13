<?php
require_once('../model/userModel.php');

// Get system logs
$logs = getSystemLogs();
echo json_encode($logs);
?>

