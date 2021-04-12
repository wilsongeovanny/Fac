<?php
$empleado=$_POST['empleado'];
$departamento=trim($_POST['departamento']);
$cargo=trim($_POST['cargo']);
$hora=trim($_POST['hora']);
$telefono=trim($_POST['telefono']);
$fecha=trim($_POST['fecha']);


$tipo=trim($_POST['tipo']);
$marca=trim($_POST['marca']);
$modelo=trim($_POST['modelo']);
$color=trim($_POST['color']);
$serie=trim($_POST['serie']);
$inventario=trim($_POST['inventario']);


$reporte=trim($_POST['reporte']);
$informe=trim($_POST['informe']);

$responsable=$_POST['responsable'];

require('../fpdf/fpdf.php');
class PDF extends FPDF
{
// Cabecera de página
public function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Image('logo.jpg', 190, 5, 23,23, 'jpg');
    // Título
    $this->SetFont('Arial','B',9);
    $this->SetY(10);
    $this->Cell(50,10,'MUNICIPALIDAD DE LATACUNGA',0,0,'C');
    $this->SetX(5);

    $this->SetY(15);
    $this->Cell(50,10,'JEFATURA DE INFORMATICA',0,0,'C');
    $this->SetX(5);
    // Salto de línea
    $this->Ln(5);

}

// Pie de página
public function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AddPage('portrait', 'letter');
$pdf->SetFont('Arial','B',12);
$pdf->SetY(26);
$pdf->Cell(0,5,'HOJA DE DIAGNOSTICO DEL EQUIPO',0,5,'C');
$pdf->SetX(9);


//
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(29,10,'Datos del usuario',0,0,'C');
$pdf->Cell(185,10,'Datos del ingreso',0,1,'C');
$pdf->cell(40,5,'',0,6,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Usuario',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(71,5,''.utf8_decode($empleado).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Hora',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($hora).'',1,1,'C');
//FECHA ENTREGA 
$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Departamento',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(71,5,''.utf8_decode($departamento).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,''.utf8_decode("Teléfono").'',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($telefono).'',1,1,'C');
//Se entrega Equipo por mostrado
$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Cargo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(71,5,''.utf8_decode($cargo).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(36,5,'Fecha',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($fecha).'',1,1,'C');
//







//datos de usuario
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Datos del equipo',0,1,'');


$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Tipo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode($tipo).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Marca',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($marca).'',1,1,'C');
//FECHA ENTREGA 
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Modelo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode($modelo).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,''.utf8_decode("Color").'',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($color).'',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'# Serie',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,''.utf8_decode($serie).'',1,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Cod. Inventario',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,''.utf8_decode($inventario).'',1,1,'C');
//Se entrega Equipo por mostrado
//Se entrega Equipo por mostrado
//


//REPORTE USUARIO
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Reporte de Usuario',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode($reporte).'',0,'J',0);
//Descripción de Servicio Realizado
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,''.utf8_decode("Informe Técnico").'',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,5,''.utf8_decode($informe).'',0,'J',0);
//FECHA-HORA


// firmas--------------------------------
//FECHA INGRESO
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(40,10,'FIRMA',0,1,'L');
$pdf->cell(40,10,'',0,6,'C');

$pdf->cell(190,10,'________________________________',0,1,'C');

$pdf->cell(190,10,''.utf8_decode("".$responsable."").'',0,5,'C');
$pdf->cell(190,10,''.utf8_decode("Técnico Responsable").'',0,0,'C');
$pdf->Output();
?>
