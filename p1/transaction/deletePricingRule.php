<?php
require_once('../model/userModel.php');

if (isset($_GET['id'])) {
    $pricingId = $_GET['id'];

    $conn = get_connection();
    $sql = "DELETE FROM pricing_rules WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $pricingId);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Pricing rule deleted successfully.']);
    } else {
        echo json_encode(['message' => 'Error deleting pricing rule.']);
    }

    $stmt->close();
    $conn->close();
}
?>
