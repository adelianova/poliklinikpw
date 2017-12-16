<?php
require  'mc_table.php';
class PDF extends PDF_MC_Table {
    //Page header
    function Header() {
        $company_name = 'PDAM KOTA MALANG';
        $company_address = 'Jl. Terusan Danau Sentani No. 100 - Malang';
        $this->SetFont('Times', 'B', 15);
        $this->Cell(100, 6, $company_name, 0, 0, 'L');
        $this->Ln();
        $this->SetFont('Times', 'B', 12);
        $this->Cell(100, 6, $company_address, 0, 0, 'L');
        $this->Ln();
        $y_axis_initial = 30;
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
}
?>