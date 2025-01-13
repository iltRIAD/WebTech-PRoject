<?php
    require_once('../model/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stationId = $_GET['id'];

    $conn = get_connection();
    $sql = "DELETE FROM charging_stations WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $stationId);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        echo json_encode(['message' => 'Charging station deleted successfully.']);
    } else {
        $stmt->close();
        $conn->close();
        echo json_encode(['message' => 'Failed to delete charging station.']);
    }
}
?>
