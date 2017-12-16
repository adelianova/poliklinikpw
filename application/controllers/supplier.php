<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplier extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('supplier_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	
	public function formSupplier(){
		$data['data']=$this->supplier_m->getKodeSupplier();
		$this->load->view('admin/master/formSupplier',$data);
	}
	
	public function getListSupplier(){
		$data['rows']=$this->supplier_m->getListSupplier('rows');
		$data['total']=$this->supplier_m->getListSupplier('total');
		echo json_encode($data);
		
	}
	
	public function simpanSuplier(){
		$data=$this->supplier_m->simpanSuplier();
		echo json_encode($data);
	}
	
	public function hapusSupplier(){
		$data=$this->supplier_m->hapusSupplier();
		echo json_encode($data);
	}
	public function cetakSupplier()
	{
		$dataPejabat = $this->supplier_m->getDataPejabat();
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Supplier, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Supplier <br/></div>";
		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>Nama Supplier</strong></td>
			<td width="15%" align="center"><strong>Alamat</strong></td>
			<td width="8%" align="center"><strong>Telepon</strong></td>\
			<td width="10%" align="center"><strong>Email</strong></td>
		  </tr>';
		$no=1;
		$data = $this->supplier_m->getLaporan();
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->nama.'</td>
			<td>'.$row->alamat.'</td>
			<td>'.$row->telp.'</td>
			<td>'.$row->email.'</td>
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