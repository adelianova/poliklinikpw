<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pasien extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('pasien_m'));
    }
    
    /*public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }*/
	
	public function formPasien(){
		//$data['data']=$this->pasien_m->getKodePasien();
		$this->load->view('admin/master/formPasien');
	}
	
	public function getListPasien(){
		$data['rows']=$this->pasien_m->getListPasien('rows');
		$data['total']=$this->pasien_m->getListPasien('total');
		echo json_encode($data);
		
	}
	
	public function simpanPasien(){
		$data=$this->pasien_m->simpanPasien();
		echo json_encode($data);
	}
	
	public function hapusPasien(){
		$data=$this->pasien_m->hapusPasien();
		echo json_encode($data);
	}
	
    public function getStatus(){
        $data=$this->pasien_m->getStatus();
		echo json_encode($data);
    }
	 public function getPenanggung(){
        $data=$this->pasien_m->getPenanggung();
		echo json_encode($data);
    }

	public function cetakPasien()
	{
		$dataPejabat = $this->pasien_m->getDataPejabat();
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Pasien, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Pasien<br/></div>";
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>NIP</strong></td>
			<td width="10%" align="center"><strong>Nama</strong></td>
			<td width="8%" align="center"><strong>Gender</strong></td>
			<td width="10%" align="center"><strong>Tanggal Lahir</strong></td>
			<td width="15%" align="center"><strong>Alamat</strong></td>
			<td width="8%" align="center"><strong>Telp</strong></td>
			<td width="13%" align="center"><strong>Email</strong></td>
			<td width="10%" align="center"><strong>Bagian</strong></td>
			<td width="8%" align="center"><strong>Alergi</strong></td>
			<td width="15%" align="center"><strong>Penanggung Jawab</strong></td>
			<td width="10%" align="center"><strong>Status Pasien</strong></td>
		  </tr>';
		$no=1;
		$data = $this->pasien_m->getLaporan();
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->nip.'</td>
			<td>'.$row->nama.'</td>
			<td>'.$row->gender.'</td>
			<td>'.$row->tgl_lahir.'</td>
			<td>'.$row->alamat.'</td>
			<td>'.$row->telp.'</td>
			<td>'.$row->email.'</td>
			<td>'.$row->bagian.'</td>
			<td>'.$row->alergi.'</td>
			<td>'.$row->full_name.'</td>
			<td>'.$row->status_pasien.'</td>
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