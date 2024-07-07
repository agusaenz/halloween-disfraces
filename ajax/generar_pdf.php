<?php
require ('../assets/includes/FDPF/fpdf.php');
require ('../assets/includes/FPDI/vendor/setasign/fpdi/src/autoload.php');

$documento = $_POST['documento'];
$nombre = utf8_decode($_POST['nombre']);
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$direccion = utf8_decode($_POST['direccion']);

$disfraz = utf8_decode($_POST['disfraz']);
$fechaAlq = $_POST['fechaAlq'];
$fechaDev = $_POST['fechaDev'];
$escuela = utf8_decode($_POST['escuela']);
$bolsas = $_POST['bolsas'];
$total = $_POST['total'];
$deposito = $_POST['deposito'];
$formaPago = $_POST['formaPago'];
$detalle = utf8_decode($_POST['detalle']);

$dateTime = new DateTime($fechaAlq);
$fechaAlqForm = $dateTime->format('d/m/Y');
$dateTime = new DateTime($fechaDev);
$fechaDevForm = $dateTime->format('d/m/Y');

if ($total)
    $totalForm = '$' . number_format($total, 0, '', '.');
else
    $totalForm = '';
if ($deposito)
    $depositoForm = '$' . number_format($deposito, 0, '', '.');
else
    $depositoForm = '';

$detalleFormat = str_replace(array("\r", "\n"), ', ', $detalle);

switch ($formaPago) {
    case 'efectivo':
        $formaPago = "Efectivo";
        break;
    case 'debito':
        $formaPago = utf8_decode('Débito');
        break;
    case 'credito':
        $formaPago = utf8_decode('Crédito');
        break;
    case 'transferencia':
        $formaPago = "Transferencia";
        break;
    default:
        $formaPago = "Efectivo";
        break;
}

use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();
$pdf->AddPage();

$pdf->setSourceFile('../assets/planilla-alquiler.pdf'); // Path to the existing PDF
$tplId = $pdf->importPage(1); // Import the first page
$pdf->useTemplate($tplId, 0, 0, 210); // Use the imported page as a template

$pdf->AddFont('Calibri', 'B', 'calibrib.php');
$pdf->AddFont('Calibri', '', 'calibri.php');

// logo
$pdf->Image('../assets/img/logo-pdf.png', 20, 20, 110, 0);
$pdf->Image('../assets/img/logo-pdf.png', 20, 141, 110, 0);

$pdf->SetFont('Calibri', '', 10);

$pdf->SetXY(171, 16.2);
$pdf->Cell(10, 10, $fechaAlqForm); // FECHA ALQUILER

$pdf->SetFont('Calibri', 'B', 15);

$pdf->SetXY(148, 33);
$pdf->Cell(10, 10, $fechaDevForm); // FECHA DEVOLUCION

$pdf->SetFont('Calibri', 'B', 13);

$pdf->SetXY(65, 55.9);
$pdf->Cell(10, 10, $nombre); // APELLIDO Y NOMBRE

$pdf->SetFont('Calibri', '', 10);

$pdf->SetXY(36, 61.4);
$pdf->Cell(10, 10, $direccion); // DIRECCION

$pdf->SetXY(32, 65.7);
$pdf->Cell(10, 10, $correo); // CORREO

$pdf->SetXY(110, 65.7);
$pdf->Cell(10, 10, $documento); // DNI

$pdf->SetXY(149, 65.7);
$pdf->Cell(10, 10, $telefono); // TELEFONO

$pdf->SetXY(34.5, 70.4);
$pdf->Cell(10, 10, $disfraz); // DISFRACES

$pdf->SetXY(145, 70.4);
$pdf->Cell(10, 10, $escuela); // ESCUELA

$pdf->SetXY(32, 78.3);
$pdf->MultiCell(158, 4.5, $detalleFormat); //DETALLE

$pdf->SetFont('Calibri', 'B', 11);

$pdf->SetXY(46, 89.7);
$pdf->Cell(10, 10, $totalForm); // TOTAL

$pdf->SetFont('Calibri', '', 10);

$pdf->SetXY(122, 89.5);
$pdf->Cell(10, 10, $formaPago); // FORMA DE PAGO

$pdf->SetXY(163, 89.7);
$pdf->Cell(10, 10, $bolsas); // BOLSAS

$pdf->SetFont('Calibri', 'BU', 9);

$pdf->SetXY(88, 95.3);
$pdf->Cell(10, 10, $depositoForm); // DEPOSITO




// ##############################################################




$pdf->SetFont('Calibri', '', 10);

$pdf->SetXY(171, 137.5);
$pdf->Cell(10, 10, $fechaAlqForm); // FECHA ALQUILER

$pdf->SetFont('Calibri', 'B', 15);

$pdf->SetXY(148, 154);
$pdf->Cell(10, 10, $fechaDevForm); // FECHA DEVOLUCION

$pdf->SetFont('Calibri', 'B', 13);

$pdf->SetXY(65, 177);
$pdf->Cell(10, 10, $nombre); // APELLIDO Y NOMBRE

$pdf->SetFont('Calibri', '', 10);

$pdf->SetXY(36, 182.4);
$pdf->Cell(10, 10, $direccion); // DIRECCION

$pdf->SetXY(32, 187.1);
$pdf->Cell(10, 10, $correo); // CORREO

$pdf->SetXY(110, 187.1);
$pdf->Cell(10, 10, $documento); // DNI

$pdf->SetXY(149, 187.1);
$pdf->Cell(10, 10, $telefono); // TELEFONO

$pdf->SetXY(34.5, 191.9);
$pdf->Cell(10, 10, $disfraz); // DISFRACES

$pdf->SetXY(145, 191.9);
$pdf->Cell(10, 10, $escuela); // ESCUELA

$pdf->SetXY(32, 199.3);
$pdf->MultiCell(158, 4.5, $detalleFormat); //DETALLE

$pdf->SetFont('Calibri', 'B', 11);

$pdf->SetXY(46, 211.15);
$pdf->Cell(10, 10, $totalForm); // TOTAL

$pdf->SetFont('Calibri', '', 10);

$pdf->SetXY(122, 210.85);
$pdf->Cell(10, 10, $formaPago); // FORMA DE PAGO

$pdf->SetXY(163, 211);
$pdf->Cell(10, 10, $bolsas); // BOLSAS

$pdf->SetFont('Calibri', 'BU', 9);

$pdf->SetXY(88, 216.3);
$pdf->Cell(10, 10, $depositoForm); // DEPOSITO


$pdf->Output('I', 'nuevopdf.pdf');
