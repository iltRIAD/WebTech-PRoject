<?php
require_once('../model/userModel.php');

function getReports() {
    $conn = get_connection();
    $sql = "SELECT date, usage, revenue, performance FROM energy_reports";
    $result = $conn->query($sql);
    
    if ($result === false) {
        die("SQL query failed: " . $conn->error);
    }

    $reports = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $reports;
}

header('Content-Type: application/json');
echo json_encode(getReports());
?>
