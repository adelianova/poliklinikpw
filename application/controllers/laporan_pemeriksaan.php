<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan_pemeriksaan extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('laporan_pemeriksaan_m'));
    }    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	public function getListLaporanPemeriksaan(){	
		$data['rows']=$this->laporan_pemeriksaan_m->getListLaporanPemeriksaan('rows');
		$data['total']=$this->laporan_pemeriksaan_m->getListLaporanPemeriksaan('total');
		echo json_encode($data);
	}	
	  public function getStatus(){
        $data=$this->laporan_pemeriksaan_m->getStatus();
		echo json_encode($data);
    }
	public function cetakLaporan($tgl_awal="",$tgl_akhir="",$status="")
	{
		$dataPejabat = $this->laporan_pemeriksaan_m->getDataPejabat();
		$TGL_MULAI = @str_replace("~", "/", $tgl_awal);
		$TGL_SELESAI = @str_replace("~", "/", $tgl_akhir);
		$STATUS = @str_replace("~", "/", $status);
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Laporan Pemeriksaan, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		if($TGL_MULAI==''&&$TGL_SELESAI==''){
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Laporan Pemeriksaan<br/> Periode(".date('d-m-Y')." sampai ".date('d-m-Y').")</div>"; 			
		}else{
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Laporan Pemeriksaan<br/> Periode(".$tgl_awal." sampai ".$tgl_akhir.")</div>";
 		}
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>NIP</strong></td>
			<td width="10%" align="center"><strong>Nama Pasien</strong></td>
			<td width="10%" align="center"><strong>Bagian</strong></td>
			<td width="7%" align="center"><strong>Gender</strong></td>
			<td width="9%" align="center"><strong>Tanggal Periksa</strong></td>
			<td width="20%" align="center"><strong>Hasil Pemeriksaan</strong></td>
			<td width="9%" align="center"><strong>Diagnosa</strong></td>
			<td width="9%" align="center"><strong>Jenis Pemeriksaan</strong></td>
			<td width="10%" align="center"><strong>Nama Dokter</strong></td>
		  </tr>';

		$no=1;
		$data = $this->laporan_pemeriksaan_m->getLaporan($TGL_MULAI,$TGL_SELESAI,$STATUS);
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->nip.'</td>
			<td>'.$row->nama.'</td>
			<td>'.$row->bagian.'</td>
			<td>'.$row->gender.'</td>
			<td>'.$row->tgl_periksa.'</td>
			<td>'.$row->diagnosa.'</td>
			<td>'.$row->penyakit.'</td>
			<td>'.$row->jenis_periksa.'</td>
			<td>'.$row->nama_dokter.'</td>
		</tr>';
		$no++;
		}
		$html .= '</table>';
		$html .= '<div style="padding-top: 40px; left:0px; position:absolute; font-weight:bold; width:300px; text-align:center">Mengetahui</div>';
		$html .= '<div style="padding-top: 100px; left:0px; position:absolute; font-weight:bold; width:300px; text-align:center">'.$dataPejabat->full_name.'</div>';
		$html .= '<div style="margin-top: 20px; left:0px; position:absolute; font-weight:bold; width:300px; text-align:center">Malang, '.date('d M Y').'</div>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}			
}