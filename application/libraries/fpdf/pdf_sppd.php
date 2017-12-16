<?php
require  'mc_table.php';
class Pdf_sppd extends PDF_MC_Table {
    //Page header
    function Header() {
        $this->Image(base_url().'asset/img/header.png', 10, 3, 190);
        $y_axis_initial = 55;
        $this->SetFont('Times', '', 10);
        $this->setFillColor(200, 200, 200);
        $this->SetY($y_axis_initial);
        $this->SetX(10);
    }
    //Page footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 10);
        $this->Cell(0, 10, 'Halaman : ' . $this->PageNo() . ' dari {nb}', 0, 0, 'C');
    }
	function MultiAlignCell($w,$h,$text,$border=0,$ln=0,$align='L',$fill=false)
{
    // Store reset values for (x,y) positions
    $x = $this->GetX() + $w;
    $y = $this->GetY();

    // Make a call to FPDF's MultiCell
    $this->MultiCell($w,$h,$text,$border,$align,$fill);

    // Reset the line position to the right, like in Cell
    if( $ln==0 )
    {
        $this->SetXY($x,$y);
    }
}
}
?>