<?php
require_once('../model/userModel.php');

$search = isset($_GET['search-bar']) ? $_GET['search-bar'] : '';

$conn = get_connection();

if ($search) {
    $sql = "SELECT id, name, email, username, status FROM users WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param("s", $searchTerm);
} else {
    $sql = "SELECT id, name, email, username, status FROM users";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Username</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['username']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}

$stmt->close();
$conn->close();
?>
