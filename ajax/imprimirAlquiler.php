
<?php
require '../assets/includes/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf as PdfWriter;
use Mpdf\Mpdf;

// Load your template spreadsheet
$templateFilePath = '../assets/xlsx/planilla-alquiler.xlsx';
$spreadsheet = IOFactory::load($templateFilePath);

// Modify the spreadsheet
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('D9', 'asd');

// Convert the modified spreadsheet to PDF
$pdfWriter = new PdfWriter($spreadsheet);
$tempFilePath = tempnam(sys_get_temp_dir(), 'pdf');
$pdfWriter->save($tempFilePath);

// Return the PDF content as a response
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="output.pdf"');
header('Cache-Control: max-age=0');
readfile($tempFilePath);

// Delete the temporary file
unlink($tempFilePath);
exit;
