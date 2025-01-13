<?php
require_once('../model/userModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pricingType = $_POST['pricing-type'];
    $pricingValue = $_POST['pricing-value'];

    // Validate inputs
    if (empty($pricingType) || empty($pricingValue)) {
        echo json_encode(['message' => 'Invalid input data.']);
        exit;
    }

    $conn = get_connection();
    $sql = "INSERT INTO pricing_rules (model, value) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $pricingType, $pricingValue);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Pricing rule saved successfully.']);
    } else {
        echo json_encode(['message' => 'Error saving pricing rule.']);
    }

    $stmt->close();
    $conn->close();
}
?>
