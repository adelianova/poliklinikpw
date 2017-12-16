<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bulanan extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('bulanan_m'));
    }    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	public function getListLaporanBulanan(){
		$data['rows']=$this->bulanan_m->getListLaporanBulanan('rows');
		$data['total']=$this->bulanan_m->getListLaporanBulanan('total');
		echo json_encode($data);
	}	
	public function cetakLaporan($tgl_awal="",$tgl_akhir="")
	{
		$dataPejabat = $this->bulanan_m->getDataPejabat();
		$tgl_awal = @str_replace("~", "/", $tgl_awal);
		$tgl_akhir = @str_replace("~", "/", $tgl_akhir);

		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Laporan Obat Bulanan , PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';

		if($tgl_awal==''&&$tgl_akhir==''){
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Laporan Obat Bulanan<br/> Periode Bulan(".date('F').")</div>"; 			
		}else{
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Laporan Obat Bulanan<br/> Periode(".$tgl_awal." sampai ".$tgl_akhir.")</div>";
 		}
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>KODE OBAT</strong></td>
			<td width="20%" align="center"><strong>NAMA OBAT</strong></td>
			<td width="10%" align="center"><strong>SATUAN</strong></td>
			<td width="8%" align="center"><strong>STOK AWAL</strong></td>
			<td width="8%" align="center"><strong>MASUK</strong></td>
			<td width="8%" align="center"><strong>RESEP</strong></td>
			<td width="8%" align="center"><strong>EXPIRED</strong></td>
			<td width="8%" align="center"><strong>SALDO</strong></td>
		  </tr>';

		$no=1;
		$data = $this->bulanan_m->getLaporan($tgl_awal,$tgl_akhir);
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->KODE_OBAT.'</td>
			<td>'.$row->NAMA.'</td>
			<td>'.$row->SATUAN.'</td>
			<td>'.$row->STOK_AWAL.'</td>
			<td>'.$row->MASUK.'</td>
			<td>'.$row->RESEP.'</td>
			<td>'.$row->RETUR.'</td>
			<td>'.$row->SALDO.'</td>
		</tr>';
		$no++;
		}
		$html .= '</table>';
		$html .= '<div style="padding-top: 40px; left:0px; position:absolute; font-weight:bold; width:300px; text-align:center">Mengetahui</div>';
		$html .= '<div style="padding-top: 100px; left:0px; position:absolute; font-weight:bold; width:300px; text-align:center">'.$dataPejabat->full_name.'</div>';
		$html .= '<div style="margin-top: 20px; left:0px; position:absolute; font-weight:bold; width:300px; text-align:center">Malang, '.date('d M Y').'</div>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		//echo $html;
	}			
}