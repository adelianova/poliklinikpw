<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Obat extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('obat_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	
	public function formObat(){
		$data['data']=$this->obat_m->getKodeObat();
		$this->load->view('admin/master/formObat',$data);
	}
	
	public function getListObat(){
		$data['rows']=$this->obat_m->getListObat('rows');
		$data['total']=$this->obat_m->getListObat('total');
		//print_r($data);exit;
		echo json_encode($data);
		
	}
	
	public function simpanObat(){
		$data=$this->obat_m->simpanObat();
		echo json_encode($data);
	}
	
	public function hapusObat(){
		$data=$this->obat_m->hapusObat();
		echo json_encode($data);
	}
	public function cetakObat()
	{
		$dataPejabat = $this->obat_m->getDataPejabat();
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Obat, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Obat <br/></div>";
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>Kode Obat</strong></td>
			<td width="8%" align="center"><strong>Nama Obat</strong></td>
			<td width="15%" align="center"><strong>Satuan</strong></td>
			<td width="8%" align="center"><strong>Stok</strong></td>
		  </tr>';
		$no=1;
		$data = $this->obat_m->getLaporan();
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->kode_obat.'</td>
			<td>'.$row->nama.'</td>
			<td>'.$row->satuan.'</td>
			<td>'.$row->sisa.'</td>
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