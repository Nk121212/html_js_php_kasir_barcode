<?php
// Include the FPDF library
require('fpdf/fpdf.php');

// Create a PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 16);

// Add a cell with text
$pdf->Cell(40, 10, 'Hello, World!');

// Output the PDF to the browser
$pdf->Output();

// If you want to save the PDF to a file, use the following instead:
// $pdf->Output('filename.pdf', 'F');
?>
