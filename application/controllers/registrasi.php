<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registrasi extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('registrasi_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	
	public function formRegistrasi($status=""){
		$data['data']=$this->registrasi_m->getKodeRegistrasi();
		$data['antrian']=$this->registrasi_m->getAntrian();
		$data['status']=($status=="")?"new":"edit";
		$this->load->view('transaksi/formRegistrasi',$data);
	}
	
	public function getListRegistrasi(){
		$data['rows']=$this->registrasi_m->getListRegistrasi('rows');
		$data['total']=$this->registrasi_m->getListRegistrasi('total');
		echo json_encode($data);
		
	}
	
	public function simpanRegistrasi(){
		$data=$this->registrasi_m->simpanRegistrasi();
		echo json_encode($data);
	}
	
	public function hapusRegistrasi(){
		$data=$this->registrasi_m->hapusRegistrasi();
		echo json_encode($data);
	}
	public function getStatus(){
		$data=$this->registrasi_m->getStatus();
		echo json_encode($data);
	}
	public function getIDPasien(){
		$data=$this->registrasi_m->getIDPasien();
		echo json_encode($data);
	}
	public function cetakRegistrasi($tgl_awal="",$tgl_akhir="")
	{
		$dataPejabat = $this->registrasi_m->getDataPejabat();
		$TGL_MULAI = @str_replace("~", "/", $tgl_awal);
		$TGL_SELESAI = @str_replace("~", "/", $tgl_akhir);
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Registrasi, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		if($TGL_MULAI==''&&$TGL_SELESAI==''){
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Registrasi<br/> Periode(".date('d-m-Y')." sampai ".date('d-m-Y').")</div>"; 			
		}else{
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Registrasi<br/> Periode(".$tgl_awal." sampai ".$tgl_akhir.")</div>";
 		}
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="15%" align="center"><strong>Nama Pasien</strong></td>
			<td width="9%" align="center"><strong>Tanggal </strong></td>
			<td width="20%" align="center"><strong>Keluhan</strong></td>
			<td width="9%" align="center"><strong>Status</strong></td>
			<td width="5%" align="center"><strong>Antrian</strong></td>
		  </tr>';

		$no=1;
		$data = $this->registrasi_m->getLaporan($TGL_MULAI,$TGL_SELESAI);
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->nama.'</td>
			<td>'.$row->tgl_registrasi.'</td>
			<td>'.$row->keluhan.'</td>
			<td>'.$row->id_status_registrasi.'</td>
			<td>'.$row->antrian.'</td>
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