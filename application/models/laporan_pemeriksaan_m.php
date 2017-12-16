<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan_pemeriksaan_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListLaporanPemeriksaan($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_periksa';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $status = isset($_POST['status_pasien']) ? strval($_POST['status_pasien']) : '';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';
		$this->db->select("a.id_periksa,a.kode_dokter,a.kode_pasien,convert(varchar(10),a.tgl_periksa,105) as tgl_periksa,a.diagnosa,d.penyakit, b.nama_dokter, c.nama,c.bagian,c.nip,c.gender,e.status_pasien,f.jenis_periksa");
		$this->db->from("tbl_periksa a");
		$this->db->join("tbl_m_dokter b","a.kode_dokter = b.kode_dokter");
		$this->db->join("TBL_M_PASIEN c","a.kode_pasien = c.kode_pasien");
		$this->db->join("TBL_M_PENYAKIT d","a.id_penyakit = d.id_penyakit");
		$this->db->join("TBL_M_STATUS_PASIEN e","c.id_status_pasien= e.id_status_pasien");
		$this->db->join("TBL_M_JENIS_PERIKSA f","a.id_jenis_periksa= f.id_jenis_periksa","left");
		$this->db->where("a.id_status_registrasi = 'Selesai'");
		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}else if($tgl_awal<>''&&$tgl_akhir<>''&&$status<>''){
			$this->db->where("convert(varchar(10),a.tgl_periksa,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
			$this->db->where("c.id_status_pasien","$status");
		}else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),a.tgl_periksa,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}
		else if($tgl_awal==''&&$tgl_akhir==''&&$status<>''){
			$this->db->where("c.id_status_pasien","$status");
		}else {
			$this->db->where("convert(varchar(10),a.tgl_periksa,112)= '".date('Ymd')."'");
		}



		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}

	function getKodePasien(){
        return $this->db->query(" select kode_pasien,nama FROM TBL_M_PASIEN")->result_array();
    }
    function getStatus(){
        return $this->db->query(" select id_status_pasien,status_pasien FROM TBL_M_STATUS_PASIEN")->result_array();
    }
    function getKodeDokter(){
        return $this->db->query(" select kode_dokter,nama_dokter FROM TBL_M_DOKTER")->result_array();
    }
    public function getLaporan($TGL_MULAI,$TGL_SELESAI,$STATUS){

		$tglMulai = date("Ymd", strtotime($TGL_MULAI));
		$tglSelesai = date("Ymd", strtotime($TGL_SELESAI));
		$status = ($STATUS == "")?"":" and c.id_status_pasien = '$STATUS' ";
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?" and CONVERT(varchar(8), a.tgl_periksa, 112) ='".date('Ymd')."'":" and CONVERT(varchar(8), a.tgl_periksa, 112) between '$tglMulai' and '$tglSelesai'";
		
		$data = $this->db->query("SELECT a.id_periksa,a.kode_pasien,convert(varchar(10),a.tgl_periksa,105) as tgl_periksa,a.diagnosa, b.nama_dokter, c.nama,c.bagian,c.nip,c.gender,c.id_status_pasien,d.penyakit,e.jenis_periksa FROM tbl_periksa a
		JOIN TBL_M_DOKTER b ON a.kode_dokter = b.kode_dokter
		JOIN TBL_M_PASIEN C ON a.kode_pasien = c.kode_pasien
		JOIN TBL_M_PENYAKIT d ON a.id_penyakit = d.id_penyakit
		LEFT JOIN TBL_M_JENIS_PERIKSA e ON a.id_jenis_periksa =e.id_jenis_periksa
		where id_status_registrasi = 'selesai' ".$tgl." ".$status."
		ORDER BY tgl_periksa DESC");
		return $data->result();
	}

	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}