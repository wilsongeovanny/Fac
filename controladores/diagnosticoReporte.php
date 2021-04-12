<?php



      //SI SE ENCUENTRA EN LA BD LA CÉDULA
      $nombres=$_GET['depar'];

require('../fpdf/fpdf.php');

//$a='jj';


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
    $this->Cell(50,10,'GAD MINUCIPAL DE LATACUNGA',0,0,'C');
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
$pdf->Cell(0,5,'INFORME TECNICO DE EQUIPO',0,5,'C');
$pdf->SetX(9);
//datos de usuario
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'holas',0,1,'');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Nombre:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.$nombres.'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Departamento:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("Dirección Administrativa").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Cargo: ',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("Funcionario").'',1,1,'C');
//datos del Equipo






//datos de usuario
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Datos del equipo',0,1,'');


$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Tipo',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(47,5,''.utf8_decode("Mause").'',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Color',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(46,5,''.utf8_decode("HP").'',1,1,'C');


$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Marca:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("n/n").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Modelo: ',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("n/n").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'# Serie:',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("Negro").'',1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(50,5,'Cod. Inventario: ',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(143,5,''.utf8_decode("132 1323 1321 300").'',1,1,'C');
//datos del Equipo




//REPORTE USUARIO
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,'Reporte de Usuario',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,4,''.utf8_decode("MAUS NO ENCIENDE").'',0,'J',0);
//Descripción de Servicio Realizado
$pdf->SetX(9);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(38,18,''.utf8_decode("Descripción del Servicio Realizado").'',0,1,'');
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,5,''.utf8_decode("Realizadas las pruebas descrito anteriormente, se ouede evidenciar que el Pause ha cumplido su vida util, por lo que se recomienda remplazarlo de un Mause Optico USB, dicho dispositivo es esencial para el manejo del equipo como tal, Mause óptico.").'',0,'J',0);
//FECHA-HORA
//FECHA INGRESO
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Fecha Ingreso',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,'02/12/20',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Hora',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,'15:00',1,1,'C');
//FECHA ENTREGA 
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Fecha Entrega',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,'02/12/20',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Hora',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,'15:00',1,1,'C');
//Se entrega Equipo por mostrado
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Se Entrega Equipo Por Mostar',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(49,5,'Si',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->cell(47,5,'Hora',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(48,5,'15:00',1,1,'C');

// firmas--------------------------------
//FECHA INGRESO
$pdf->cell(40,5,'',0,6,'C');
$pdf->SetFont('Arial','',8);
$pdf->cell(40,10,'FIRMAS',0,1,'L');
$pdf->cell(40,10,'',0,6,'C');
$pdf->cell(60,10,'________________________',0,0,'C');
$pdf->cell(60,10,'________________________',0,0,'C');
$pdf->cell(60,10,'________________________',0,1,'C');
$pdf->cell(60,10,'Ing. Fabian Vega',0,0,'C');
$pdf->cell(60,10,'RECIBI CONFORME',0,0,'C');
$pdf->cell(60,10,'Tlgo. Eduardo Jaramillo',0,5,'C');
$pdf->cell(60,10,'Visto Bueno',0,0,'C');
$pdf->Output();
?>
