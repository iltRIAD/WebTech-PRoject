<?php
    require_once('../model/userModel.php');

function getStations() {
    $conn = get_connection();
    $sql = "SELECT id, location, capacity, availability FROM charging_stations";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error fetching stations: " . $conn->error);
    }

    $stations = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();

    echo json_encode($stations);
}

getStations();
?>
