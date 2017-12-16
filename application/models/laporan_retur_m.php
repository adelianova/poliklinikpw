<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan_retur_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListLaporanRetur($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_retur';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';
		$this->db->select("
			a.kode_obat,a.nama,b.id_dtl_stock,b.id_obat,c.id_dtl_retur,c.qty,c.keterangan,d.id_retur,d.no_retur,convert(varchar(10),d.tgl,105) as tgl,d.petugas");
		$this->db->from("TBL_M_OBAT a");
		$this->db->join("TBL_DETAIL_STOCK b","a.id_obat = b.id_obat ");
		$this->db->join("TBL_DETAIL_RETUR c","b.id_dtl_stock = c.id_dtl_stock");
		$this->db->join("TBL_RETUR d","c.id_retur = d.id_retur");
		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),d.tgl,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}else {
			$this->db->where("convert(varchar(10),d.tgl,112)= '".date('Ymd')."'");
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
		
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?" and CONVERT(varchar(8), d.tgl, 112) ='".date('Ymd')."'":" and CONVERT(varchar(8), d.tgl, 112) between '$tglMulai' and '$tglSelesai' ";


		$data = $this->db->query("SELECT a.kode_obat,a.nama,b.id_dtl_stock,b.id_obat,c.id_dtl_retur,c.qty,c.keterangan,d.id_retur,d.no_retur,convert(varchar(10),d.tgl,105) as tgl,d.petugas FROM TBL_M_OBAT a
		JOIN TBL_DETAIL_STOCK b ON a.id_obat = b.id_obat
		JOIN TBL_DETAIL_RETUR C ON b.id_dtl_stock = c.id_dtl_stock
		JOIN TBL_RETUR d ON c.id_retur = d.id_retur
		where 1=1 $tgl
		ORDER BY tgl DESC");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}