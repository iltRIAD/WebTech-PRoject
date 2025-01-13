<?php
require_once('../model/userModel.php');

function exportToPDF($data) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    
    // Title
    $pdf->Cell(200, 10, 'Energy Usage Report', 0, 1, 'C');
    
    // Table headers
    $pdf->Cell(40, 10, 'Date', 1);
    $pdf->Cell(40, 10, 'Usage (kWh)', 1);
    $pdf->Cell(40, 10, 'Revenue ($)', 1);
    $pdf->Cell(40, 10, 'Performance (%)', 1);
    $pdf->Ln();
    
    // Data rows
    foreach ($data as $row) {
        $pdf->Cell(40, 10, $row['date'], 1);
        $pdf->Cell(40, 10, $row['usage'], 1);
        $pdf->Cell(40, 10, $row['revenue'], 1);
        $pdf->Cell(40, 10, $row['performance'], 1);
        $pdf->Ln();
    }
    
    // Output the PDF
    $pdf->Output();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    exportToPDF($data);
}
?>
