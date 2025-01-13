<?php
require_once('../model/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pricingId = $_POST['id'];
    $pricingType = $_POST['pricing-type'];
    $pricingValue = $_POST['pricing-value'];

    if (empty($pricingType) || empty($pricingValue)) {
        echo json_encode(['message' => 'Invalid input data.']);
        exit;
    }

    $conn = get_connection();
    $sql = "UPDATE pricing_rules SET model = ?, value = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssi", $pricingType, $pricingValue, $pricingId);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Pricing rule updated successfully.']);
    } else {
        echo json_encode(['message' => 'Error updating pricing rule.']);
    }

    $stmt->close();
    $conn->close();
}
?>
