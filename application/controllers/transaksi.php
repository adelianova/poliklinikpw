<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('transaksi_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }	
	public function getListStock(){
		$data['rows']=$this->transaksi_m->getListStock('rows');
		$data['total']=$this->transaksi_m->getListStock('total');
		echo json_encode($data);
	}
	
	public function getListDetail(){
		$data=$this->transaksi_m->getListDetail();
		echo json_encode($data);
	}

	public function getIDObat(){
		$data=$this->transaksi_m->getIDObat();
		echo json_encode($data);
	}
	

	public function simpanTransaksi(){
		$data=$this->transaksi_m->simpanTransaksi();
		echo json_encode($data);
	}

	public function simpanObat($id_stock=""){
		$data=$this->transaksi_m->simpanObat($id_stock);
		echo json_encode($data);
	}
	public function removeTransaksi(){
		$data=$this->transaksi_m->removeTransaksi();
		echo json_encode($data);
	}

	public function removeTambah(){
		$data=$this->transaksi_m->removeTambah();
		echo json_encode($data);
	}
    
    public function getListIDTransaksi(){
    	$data=$this->transaksi_m->getListIDTransaksi();
		echo json_encode($data);
    }

    public function formObat(){
    	$data['data']=$this->transaksi_m->getIDStock();
    	$data['no_faktur']=$this->transaksi_m->getNoFaktur();
		$this->load->view('transaksi/formObat', $data);
	}
	public function formTambahObat($id_stock="",$id_dtl_stock=""){
		$data['id_stock'] = $id_stock;
		$data['id_dtl_stock'] = $id_dtl_stock;
    	$data['data']=$this->transaksi_m->getIDStock();
    	$data['data']=$this->transaksi_m->getIDDtlStock();
		$this->load->view('transaksi/formTambahObat', $data);
	}
	public function getIDSuplier(){
    	$data=$this->transaksi_m->getIDSuplier();
		echo json_encode($data);
    }
    public function cetakStok($tgl_awal="",$tgl_akhir="")
	{
		$dataPejabat = $this->transaksi_m->getDataPejabat();
		$TGL_MULAI = @str_replace("~", "/", $tgl_awal);
		$TGL_SELESAI = @str_replace("~", "/", $tgl_akhir);
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Data Stok Obat , PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		if($TGL_MULAI==''){
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Obat Masuk <br/> Periode(".date('d-m-Y')." sampai ".date('d-m-Y').")</div>";
 			
		}else{
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Obat Masuk <br/> Periode(".$tgl_awal." sampai ".$tgl_akhir.")</div>";
 		}


		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="8%" align="center"><strong>Nama Supplier</strong></td>
			<td width="15%" align="center"><strong>Transaksi</strong></td>
			<td width="10%" align="center"><strong>Tgl Obat Masuk</strong></td>
			<td width="10%" align="center"><strong>No Faktur</strong></td>
			<td width="8%" align="center"><strong>Keterangan</strong></td>
		  </tr>';

		$no=1;
		$data = $this->transaksi_m->getLaporan($TGL_MULAI,$TGL_SELESAI);
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->nama.'</td>
			<td>'.$row->transaksi.'</td>
			<td>'.$row->tgl.'</td>
			<td>'.$row->no_faktur.'</td>
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
		//echo $html;
	}		
}