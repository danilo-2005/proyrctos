<?php

require('./fpdf.php');

class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color

      // Ancho total de la subtabla
      $subTableWidth = 40 + 40 + 140 + 50;

      // Posición de inicio para centrar la subtabla
      $startX = ($this->GetPageWidth() - $subTableWidth) / 2;

      $this->SetFillColor(251, 251, 251); //colorFondo
      $this->SetTextColor(7, 6, 6); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);

      // Mover el cursor a la posición de inicio calculada
      $this->SetX($startX);

      $this->Cell(40, 10, utf8_decode('CODIGO:'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('SGC-AAF09-A'), 1, 0, 'C', 1);
      $this->Cell(140, 10, utf8_decode('SISTEMA DE GESTION DE LA CALIDAD'), 1, 0, 'C', 1);
      $this->Cell(50, 24, '', 1, 0, 'C', 1); // Celda vacía para el logo
      $this->Image('logo.png', $this->GetX() - 43, $this->GetY() + 4, 38); // Ajusta las coordenadas y el tamaño según sea necesario


      $this->Ln(8); // Salto de línea para la siguiente tabla

      // Segunda tabla justo debajo de la primera
      $this->SetX($startX); // Asegurar que la siguiente tabla también esté centrada
      $this->Cell(40, 8, utf8_decode('VERSION:'), 1, 0, 'C', 1);
      $this->Cell(40, 8, utf8_decode('3'), 1, 0, 'C', 1);
      $this->Cell(140, 16, utf8_decode('HOJA DE VIDA EQUIPOS'), 1, 0, 'C', 1);
      $this->Ln(8);
      $this->SetX($startX); // Asegurar que la siguiente tabla también esté centrada
      $this->Cell(40, 8, utf8_decode('PAGINA:'), 1, 0, 'C', 1);
      $this->Cell(40, 8, utf8_decode('') . $this->PageNo() . ' DE {nb}', 1, 0, 'C',1);


      $this->Ln(10); // Salto de línea


      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 0, 0);
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      /*$this->Cell(100, 10, utf8_decode("HOJA DE VIDA "), 0, 1, 'C', 0);
      $this->Ln(2);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(251, 251, 251); //colorFondo
      $this->SetTextColor(7, 6, 6); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);

      // Ancho total de la tabla
      $tableWidth = 30 + 60 + 60 + 30 + 60 + 30 ; // Suma de los anchos de las celdas
      // Posición de inicio para centrar la tabla
      $startX = ($this->GetPageWidth() - $tableWidth) / 2;

      $this->SetX($startX); // Mover a la posición de inicio calculada

      $this->Cell(30, 10, utf8_decode('EQUIPO:'), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode(''), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('SERIE #:'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode(''), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('PROVEEDOR:'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode(''), 1, 0, 'C', 1);
      $this->Ln(10);
      $this->SetX($startX); // Mover a la posición de inicio calculada

      $this->Cell(30, 10, utf8_decode('UBICACION:'), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode(''), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('F. INICIO GARANTIA:'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode(''), 1, 0, 'C', 1);
      $this->Cell(60, 10, utf8_decode('F. FINAL GARANTIA:'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode(''), 1, 0, 'C', 1);
      $this->Ln(12);
      
       // Encabezados de la tabla
       // Ancho total de la tabla
   $tableWidth = 30 + 30 + 30 + 80 + 50 + 40 + 25; // 8 celdas de 30 de ancho
   $starty = ($this->GetPageWidth() - $tableWidth) / 2; // Posición de inicio para centrar la tabla

   $this->SetX($starty); // Mover a la posición de inicio calculada
   $this->Cell(30, 10, utf8_decode('CONSECUTIVO'), 1, 0, 'C', 1);
   $this->Cell(30, 10, utf8_decode('FECHA'), 1, 0, 'C', 1);
   $this->Cell(30, 10, utf8_decode('TIPO'), 1, 0, 'C', 1);
   $this->Cell(80, 10, utf8_decode('DESCRIPCION DEL MANTENIMIENTO'), 1, 0, 'C', 1);
   $this->Cell(50, 10, utf8_decode('PERSONA O EMPRESA'), 1, 0, 'C', 1);
   $this->Cell(40, 10, utf8_decode('FIRMA'), 1, 0, 'C', 1);
   $this->Cell(25, 10, utf8_decode('COSTO'), 1, 0, 'C', 1);
   $this->Ln(10); // Salto de línea para los datos

   }
// Cuerpo de la página
function Body()
{
   // Configuración de la fuente para los campos de la tabla
   $this->SetFont('Arial', 'B', 8);
   $this->SetFillColor(251, 251, 251); // color del fondo
   $this->SetTextColor(7, 6, 6); // color del texto
   $this->SetDrawColor(163, 163, 163); // color del borde

   $tableWidth = 30 + 30 + 30 + 80 + 50 + 40 + 25; // 8 celdas de 30 de ancho
   $startX = ($this->GetPageWidth() - $tableWidth) / 2; 
  
   // Ejemplo de datos ficticios
   $datos = array(
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "CORRECTIVO", "INSTALACION DE S.O Y PROGRAMAS", "AGENTE EXTERNO", "AGENTE EXTERNO", "$150.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "CORRECTIVO", "INSTALACION DE S.O Y PROGRAMAS", "AGENTE EXTERNO", "AGENTE EXTERNO", "$150.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "CORRECTIVO", "INSTALACION DE S.O Y PROGRAMAS", "AGENTE EXTERNO", "AGENTE EXTERNO", "$150.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "CORRECTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "CORRECTIVO", "INSTALACION DE S.O Y PROGRAMAS", "AGENTE EXTERNO", "AGENTE EXTERNO", "$250.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "CORRECTIVO", "INSTALACION DE S.O Y PROGRAMAS", "AGENTE EXTERNO", "AGENTE EXTERNO", "$250.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "CORRECTIVO", "INSTALACION DE S.O Y PROGRAMAS", "AGENTE EXTERNO", "AGENTE EXTERNO", "$250.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000"),
      array("0001","26/06/2024", "PREVENTIVO", "INSTALACION DE S.O Y PROGRAMAS", "SAN AGUSTIN", "DANILO DORIA", "$50.000")
   );

   // Mostrar los datos en la tabla
   foreach ($datos as $fila) {
      $this->SetX($startX); // Mover a la posición de inicio calculada
      $this->Cell(30, 10, utf8_decode($fila[0]), 1, 0, 'C', 0);
      $this->Cell(30, 10, utf8_decode($fila[1]), 1, 0, 'C', 0);
      $this->Cell(30, 10, utf8_decode($fila[2]), 1, 0, 'C', 0);
      $this->Cell(80, 10, utf8_decode($fila[3]), 1, 0, 'C', 0);
      $this->Cell(50, 10, utf8_decode($fila[4]), 1, 0, 'C', 0);
      $this->Cell(40, 10, utf8_decode($fila[5]), 1, 0, 'C', 0);
      $this->Cell(25, 10, utf8_decode($fila[6]), 1, 0, 'C', 0);
      $this->Ln(10); // Salto de línea para la siguiente fila
   }
}
   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

// Agregar el cuerpo del documento
$pdf->Body();

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$pdf->Output('HOJADEVIDA.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>



