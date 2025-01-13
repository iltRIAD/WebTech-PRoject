<?php

function get_connection(){

    $conn = mysqli_connect("127.0.0.1:8888", "root", "", "local" );
    return $conn;
}



function login($username, $password){
    $conn = get_connection();
    $sql = "select * from users where username = '{$username}' and password = '{$password}'";
    $result = mysqli_query($conn, $sql);
    $row_count = mysqli_num_rows($result);
    if($row_count > 0){
        return true;
    }
    else{
        return false;
    }
}


// Add a new user
function addUser($name, $email, $username, $password) {
    $conn = get_connection();

    $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $email, $username, $password);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}








// Fetch all users
function getAllUsers() {
    $conn = get_connection();
    $sql = "SELECT id, name, email, username, status FROM users";
    $result = $conn->query($sql);

    if ($result === false) {
        die("SQL query failed: " . $conn->error);
    }

    $users = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $users;
}

// Update user profile
function updateUser($id, $name, $email, $status) {
    $conn = get_connection();
    $sql = "UPDATE users SET name = ?, email = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssi", $name, $email, $status, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    return true;
}

// Delete user
function deleteUser($id) {
    $conn = get_connection();
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    return true;
}
// Approve user
function approveUser($id) {
    $conn = get_connection();
    $sql = "UPDATE users SET status = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Log approval
    logAction($id, "approved");

    $stmt->close();
    $conn->close();
    return true;
}

// Reject user
function rejectUser($id, $reason) {
    $conn = get_connection();
    $sql = "UPDATE users SET status = 'rejected', rejection_reason = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $reason, $id);
    $stmt->execute();

    // Log rejection
    logAction($id, "rejected", $reason);

    $stmt->close();
    $conn->close();
    return true;
}

// Log action (approve/reject) in logs table
function logAction($userId, $action, $reason = null) {
    $conn = get_connection();
    $actionDetails = $action;
    if ($reason) {
        $actionDetails .= " (Reason: $reason)";
    }

    $sql = "INSERT INTO system_logs (user_id, action, timestamp) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $userId, $actionDetails);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

// Fetch system logs
function getSystemLogs() {
    $conn = get_connection();
    $sql = "SELECT * FROM system_logs ORDER BY timestamp DESC";
    $result = $conn->query($sql);

    if ($result === false) {
        die("SQL query failed: " . $conn->error);
    }

    $logs = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $logs;
}
// Fetch all charging stations (if required in future for user-specific station data)
function getChargingStations() {
    $conn = get_connection();
    $sql = "SELECT * FROM charging_stations";
    $result = $conn->query($sql);

    if ($result === false) {
        die("SQL query failed: " . $conn->error);
    }

    $stations = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $stations;
}
function getEnergyReports() {
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
// Fetch filtered energy reports by date range
function getFilteredEnergyReports($startDate, $endDate) {
    $conn = get_connection();
    $sql = "SELECT date, usage, revenue, performance 
            FROM energy_reports 
            WHERE date BETWEEN ? AND ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $reports = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();
    return $reports;
}