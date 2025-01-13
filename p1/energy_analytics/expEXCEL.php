<?php
require_once('../model/userModel.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function exportToExcel($data) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set headers
    $sheet->setCellValue('A1', 'Date')
          ->setCellValue('B1', 'Usage (kWh)')
          ->setCellValue('C1', 'Revenue ($)')
          ->setCellValue('D1', 'Performance (%)');
    
    // Insert data
    $rowNum = 2;
    foreach ($data as $row) {
        $sheet->setCellValue('A' . $rowNum, $row['date'])
              ->setCellValue('B' . $rowNum, $row['usage'])
              ->setCellValue('C' . $rowNum, $row['revenue'])
              ->setCellValue('D' . $rowNum, $row['performance']);
        $rowNum++;
    }
    
    // Create Excel file
    $writer = new Xlsx($spreadsheet);
    $fileName = 'energy_usage_report.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    $writer->save('php://output');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    exportToExcel($data);
}
?>
