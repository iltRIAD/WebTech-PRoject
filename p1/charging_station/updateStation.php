<?php
    require_once('../model/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stationId = $_GET['id'];
    $newLocation = $_POST['location'];
    $newCapacity = $_POST['capacity'];
    $newAvailability = $_POST['availability'];

    $conn = get_connection();
    $sql = "UPDATE charging_stations SET location = ?, capacity = ?, availability = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sisi", $newLocation, $newCapacity, $newAvailability, $stationId);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        echo json_encode(['message' => 'Charging station updated successfully.']);
    } else {
        $stmt->close();
        $conn->close();
        echo json_encode(['message' => 'Failed to update charging station.']);
    }
}
?>
