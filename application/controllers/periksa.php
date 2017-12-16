<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Periksa extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('periksa_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	
	public function formPeriksa(){
		$data['data']=$this->periksa_m->getIDPeriksa();
		$this->load->view('transaksi/formPeriksa',$data);
	}
	
	public function getListPeriksa(){
		$data['rows']=$this->periksa_m->getListPeriksa('rows');
		$data['total']=$this->periksa_m->getListPeriksa('total');
		echo json_encode($data);
		
	}
	
	public function simpanPeriksa(){
		$data=$this->periksa_m->simpanPeriksa();
		echo json_encode($data);
	}
	
	public function hapusPeriksa(){
		$data=$this->periksa_m->hapusPeriksa();
		echo json_encode($data);
	}
	
	 public function getKodePasien(){
        $data=$this->periksa_m->getKodePasien();
		echo json_encode($data);
    }
     public function getIDPeriksa(){
        $data=$this->periksa_m->getIDPeriksa();
		echo json_encode($data);
    }
    public function getDokter(){
        $data=$this->periksa_m->getDokter();
		echo json_encode($data);
    }
    public function getIDPenyakit(){
        $data=$this->periksa_m->getIDPenyakit();
		echo json_encode($data);
    }
    public function getStatus(){
		$data=$this->periksa_m->getStatus();
		echo json_encode($data);
	}
	public function getJenis(){
		$data=$this->periksa_m->getJenis();
		echo json_encode($data);
	}
	public function cetakPeriksa($tgl_awal="",$tgl_akhir="")
	{
		$dataPejabat = $this->periksa_m->getDataPejabat();
		$TGL_MULAI = @str_replace("~", "/", $tgl_awal);
		$TGL_SELESAI = @str_replace("~", "/", $tgl_akhir);
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Data Pemeriksaan, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		if($TGL_MULAI==''&&$TGL_SELESAI==''){
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Pemeriksaan<br/> Periode(".date('d-m-Y')." sampai ".date('d-m-Y').")</div>"; 			
		}else{
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Pemeriksaan<br/> Periode(".$tgl_awal." sampai ".$tgl_akhir.")</div>";
 		}
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="10%" align="center"><strong>Nama Pasien</strong></td>
			<td width="10%" align="center"><strong>Nama Dokter</strong></td>
			<td width="20%" align="center"><strong>Hasil Pemeriksaan</strong></td>
			<td width="9%" align="center"><strong>Diagnosa</strong></td>
			<td width="9%" align="center"><strong>Tanggal Periksa</strong></td>
			<td width="10%" align="center"><strong>Keluhan</strong></td>
			<td width="9%" align="center"><strong>Jenis Pemeriksaan</strong></td>
		  </tr>';

		$no=1;
		$data = $this->periksa_m->getLaporan($TGL_MULAI,$TGL_SELESAI);
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->nama.'</td>
			<td>'.$row->nama_dokter.'</td>
			<td>'.$row->diagnosa.'</td>
			<td>'.$row->penyakit.'</td>
			<td>'.$row->tgl_periksa.'</td>
			<td>'.$row->keluhan.'</td>
			<td>'.$row->jenis_periksa.'</td>
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