<?php
require  'mc_table.php';
class PDF_REPORT extends PDF_MC_Table {
    //Page header
    function Header() {
       
    }
    //Page footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 10);
        $this->Cell(0, 10, 'Halaman : ' . $this->PageNo() . ' dari {nb}', 0, 0, 'C');
    }
}
?>