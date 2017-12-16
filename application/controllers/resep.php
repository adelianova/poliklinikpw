<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Resep extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('resep_m'));
		$this->load->model(array('obat_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	
	public function formResep(){
		$data['data']=$this->resep_m->getKodeResep();
		$data['tbl']=$this->resep_m->getKodeResep();
		$this->load->view('transaksi/formResep',$data);
	}
	public function coba(){
		$data['data']=$this->resep_m->getKodeResep();
		$data['tbl']=$this->resep_m->getKodeResep();
		$this->load->view('transaksi/coba',$data);
	}
	public function getListResep(){
		$data['rows']=$this->resep_m->getListResep('rows');
		$data['total']=$this->resep_m->getListResep('total');
		echo json_encode($data);
		
	}

	public function getListDetail(){
		$data=$this->resep_m->kodeResep();
		echo json_encode($data);
		
	}
	public function getListObat(){
		$data['rows']=$this->obat_m->getListObat('rows');
		$data['total']=$this->obat_m->getListObat('total');
		echo json_encode($data);
	}
    public function getKodeObat(){
        $data=$this->resep_m->getIDObat();
		echo json_encode($data);
    }
     public function getIDRegistrasi(){
        $data=$this->resep_m->getIDRegistrasi();
		echo json_encode($data);
    }
	public function simpanResep($id_periksa="", $kode_dokter=""){
		$data=$this->resep_m->simpanResep($id_periksa, $kode_dokter);
		echo json_encode($data);
	}

	public function simpanTambah($id_resep=""){
		$data=$this->resep_m->simpanTambah($id_resep);
		echo json_encode($data);
	}
	
	public function hapusResep(){
		$data=$this->resep_m->hapusResep();
		echo json_encode($data);
	}

	public function hapusTambah(){
		$data=$this->resep_m->hapusTambah();
		echo json_encode($data);
	}
	public function getIDPeriksa(){
        $data=$this->resep_m->getIDPeriksa();
		echo json_encode($data);
    }
    public function getIDObat(){
        $data=$this->resep_m->getIDObat();
		echo json_encode($data);
    }
	public function getIDDokter(){
        $data=$this->resep_m->getIDDokter();
		echo json_encode($data);
    }
    public function formTambah($id_resep="",$id_detail_resep=""){
    	$data['id_resep'] = $id_resep; 
    	$data['id_detail_resep'] = $id_detail_resep;
    	$data['dataResep']=$this->resep_m->getDetailResep();
        $data['dataRegis']=$this->resep_m->getIDRegistrasi();
		$this->load->view('transaksi/formTambah', $data);
	}

	public function kodeResep(){
		$data=$this->resep_m->kodeResep();
		echo json_encode($data);
	}
	public function getNamaDokter()
	{
		$data=$this->resep_m->getNamaDokter();
		echo json_encode($data);
	}
	public function cetakResep($tgl_awal="",$tgl_akhir="")
	{
		$dataPejabat = $this->resep_m->getDataPejabat();
		$TGL_MULAI = @str_replace("~", "/", $tgl_awal);
		$TGL_SELESAI = @str_replace("~", "/", $tgl_akhir);
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - Data Resep, PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		if($TGL_MULAI==''){
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Resep Obat <br/> Periode(".date('d-m-Y')." sampai ".date('d-m-Y').")</div>";
 			
		}else{
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center'>Data Resep Obat <br/> Periode(".$tgl_awal." sampai ".$tgl_akhir.")</div>";
 		}


		$html .='
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="10%" align="center"><strong>Kode Periksa</strong></td>
			<td width="15%" align="center"><strong>Nama Pasien</strong></td>
			<td width="15%" align="center"><strong>Nama Dokter</strong></td>\
			<td width="10%" align="center"><strong>Tanggal Keluar</strong></td>
		  </tr>';

		$no=1;
		$data = $this->resep_m->getLaporan($TGL_MULAI,$TGL_SELESAI);
		foreach($data as $row){
		$html .='  
		  <tr>
			<td>'.$row->id_periksa.'</td>
			<td>'.$row->nama.'</td>
			<td>'.$row->nama_dokter.'</td>
			<td>'.$row->tgl_periksa.'</td>
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