<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Retur extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('retur_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	public function getListRetur(){
		$data['rows']=$this->retur_m->getListRetur('rows');
		$data['total']=$this->retur_m->getListRetur('total');
		echo json_encode($data);
	}
	
	public function getListDetail(){
		$data=$this->retur_m->getListDetail();
		echo json_encode($data);
	}
	

	public function simpanRetur(){
		$data=$this->retur_m->simpanRetur();
		echo json_encode($data);
	}

	public function simpanTambahRetur($id_retur=""){
		$data=$this->retur_m->simpanTambahRetur($id_retur);
		echo json_encode($data);
	}
	public function removeRetur(){
		$data=$this->retur_m->removeRetur();
		echo json_encode($data);
	}

	public function removeTambahRetur(){
		$data=$this->retur_m->removeTambahRetur();
		echo json_encode($data);
	}
    
    public function getListIDRetur(){
    	$data=$this->retur_m->getListIDRetur();
		echo json_encode($data);
    }
    public function formRetur(){
    	$data['data']=$this->retur_m->getIDRetur();
    	$data['no_retur']=$this->retur_m->getNoRetur();
		$this->load->view('transaksi/formRetur', $data);
	}
	public function formTambahRetur($id_retur="",$id_dtl_retur=""){
		$data['id_retur'] = $id_retur;
		$data['id_dtl_retur'] = $id_dtl_retur;
    	$data['data']=$this->retur_m->getIDRetur();
    	$data['data']=$this->retur_m->getIDDtlRetur();
		$this->load->view('transaksi/formTambahRetur', $data);
	}
	public function getDtlStock(){
    	$data=$this->retur_m->getDtlStock();
		echo json_encode($data);
    }
    /*public function getNoRetur(){
    	$data=$this->retur_m->getNoRetur();
		echo json_encode($data);
    }*/
    public function getPetugas()
    {
    	$data=$this->retur_m->getPetugas();
    	echo json_encode($data);
    }
    public function cetakRetur($tgl_awal="",$tgl_akhir="")
	{
		$dataPejabat = $this->retur_m->getDataPejabat();
		$TGL_MULAI = @str_replace("~", "/", $tgl_awal);
		$TGL_SELESAI = @str_replace("~", "/", $tgl_akhir);
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Data Retur, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		if($TGL_MULAI==''){
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Retur Obat <br/> Periode(".date('d-m-Y')." sampai ".date('d-m-Y').")</div>";
 			
		}else{
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Retur Obat <br/> Periode(".$tgl_awal." sampai ".$tgl_akhir.")</div>";
 		}


		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>No Retur</strong></td>
			<td width="10%" align="center"><strong>Tanggal Retur</strong></td>
			<td width="15%" align="center"><strong>Petugas</strong></td>
		  </tr>';
		$no=1;
		$data = $this->retur_m->getLaporan($TGL_MULAI,$TGL_SELESAI);
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->no_retur.'</td>
			<td>'.$row->tgl.'</td>
			<td>'.$row->petugas.'</td>
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