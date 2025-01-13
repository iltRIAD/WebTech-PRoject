<?php
    require_once('../model/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $availability = $_POST['availability'];

    $conn = get_connection();
    $sql = "INSERT INTO charging_stations (location, capacity, availability) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("sis", $location, $capacity, $availability);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        echo json_encode(['message' => 'Charging station added successfully.']);
    } else {
        $stmt->close();
        $conn->close();
        echo json_encode(['message' => 'Failed to add charging station.']);
    }
}
?>
