<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kontrak extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('kontrak_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	
	public function formKontrak(){
		$data['data']=$this->kontrak_m->getKodeKontrak();
		$this->load->view('admin/master/formKontrak',$data);
	}
	
	public function getListKontrak(){
		$data['rows']=$this->kontrak_m->getListKontrak('rows');
		$data['total']=$this->kontrak_m->getListKontrak('total');
		echo json_encode($data);
		
	}
	
	public function simpanKontrak(){
		$data=$this->kontrak_m->simpanKontrak();
		echo json_encode($data);
	}
	
	public function hapusKontrak(){
		$data=$this->kontrak_m->hapusKontrak();
		echo json_encode($data);
	}
	 public function getKodeDokter(){
        $data=$this->kontrak_m->getKodeDokter();
		echo json_encode($data);
    }
    public function cetakKontrak()
	{
		$dataPejabat = $this->kontrak_m->getDataPejabat();
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Kontrak Dokter, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Surat Kontrak Dokter <br/></div>";
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>Kode Dokter</strong></td>
			<td width="8%" align="center"><strong>Nama Dokter</strong></td>
			<td width="15%" align="center"><strong>Nomor Kontrak</strong></td>
			<td width="8%" align="center"><strong>Mulai Kontrak</strong></td>
			<td width="10%" align="center"><strong>Selesai Kontrak</strong></td>
			<td width="10%" align="center"><strong>Keterangan</strong></td>
		  </tr>';
		$no=1;
		$data = $this->kontrak_m->getLaporan();
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->kode_dokter.'</td>
			<td>'.$row->nama_dokter.'</td>
			<td>'.$row->nomor.'</td>
			<td>'.$row->mulai_kontrak.'</td>
			<td>'.$row->selesai_kontrak.'</td>
			<td>'.$row->keterangan.'</td>
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