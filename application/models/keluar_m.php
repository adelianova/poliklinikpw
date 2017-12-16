<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Keluar_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListKeluar($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_obat';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';
		$this->db->select("a.kode_obat,a.nama,a.satuan,b.qty,c.id_resep,convert(varchar(10),d.tgl_periksa,105) as tgl_periksa,d.id_periksa");
		$this->db->from("TBL_M_OBAT a");
		$this->db->join("TBL_DETAIL_RESEP b","a.kode_obat = b.kode_obat ");
		$this->db->join("TBL_RESEP c","b.id_resep = c.id_resep");
		$this->db->join("TBL_PERIKSA d","c.id_periksa = d.id_periksa");
		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),d.tgl_periksa,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}else {
			$this->db->where("convert(varchar(10),d.tgl_periksa,112)= '".date('Ymd')."'");
		}



		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}
	public function getLaporan($TGL_MULAI,$TGL_SELESAI){
		$tglMulai = date("Ymd", strtotime($TGL_MULAI));
		$tglSelesai = date("Ymd", strtotime($TGL_SELESAI));
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?" and CONVERT(varchar(8), d.tgl_periksa, 112) ='".date('Ymd')."'":" and CONVERT(varchar(8), d.tgl_periksa, 112) between '$tglMulai' and '$tglSelesai' ";
		$data = $this->db->query("SELECT a.kode_obat,a.nama,a.satuan,b.qty,c.id_resep,convert(varchar(10),d.tgl_periksa,105) as tgl_periksa,d.id_periksa FROM TBL_M_OBAT a
		JOIN TBL_DETAIL_RESEP b ON a.kode_obat = b.kode_obat
		JOIN TBL_RESEP C ON b.id_resep = c.id_resep
		JOIN TBL_PERIKSA d ON c.id_periksa = d.id_periksa
		WHERE 1=1 $tgl 
		ORDER BY tgl_periksa DESC");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}