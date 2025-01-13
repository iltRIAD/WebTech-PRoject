<?php
require_once('../model/userModel.php');

function getPricingRules() {
    $conn = get_connection();
    $sql = "SELECT * FROM pricing_rules"; // Assume 'pricing_rules' is the table name
    $result = $conn->query($sql);

    if ($result === false) {
        die("SQL query failed: " . $conn->error);
    }

    $pricingRules = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    echo json_encode($pricingRules); // Return pricing rules as JSON
}

getPricingRules();
?>
