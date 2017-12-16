<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Masuk_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListMasuk($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'NAMA';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$this->db->select("a.ID_STOCK,convert(varchar(10),a.TGL,105) as TGL,c.KODE_OBAT,c.NAMA,c.SATUAN,b.HARGA_SATUAN,b.QTY,b.TOTAL");
		$this->db->from("TBL_STOCK a");
		$this->db->join("TBL_DETAIL_STOCK b","a.ID_STOCK = b.ID_STOCK ");
		$this->db->join("TBL_M_OBAT c","b.ID_OBAT = c.ID_OBAT");
		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),a.TGL,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}else {
			$this->db->where("convert(varchar(10),a.TGL,112)= '".date('Ymd')."'");
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
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?" and CONVERT(varchar(8), a.TGL, 112) ='".date('Ymd')."'":" and CONVERT(varchar(8), a.TGL, 112) between '$tglMulai' and '$tglSelesai' ";
		$data = $this->db->query("SELECT a.ID_STOCK,convert(varchar(10),a.TGL,105) as TGL,c.KODE_OBAT,c.NAMA,c.SATUAN,b.HARGA_SATUAN,b.QTY,b.TOTAL FROM TBL_STOCK a
		JOIN TBL_DETAIL_STOCK b ON a.ID_STOCK = b.ID_STOCK
		JOIN TBL_M_OBAT C ON b.ID_OBAT = c.ID_OBAT
		where 1=1 $tgl
		ORDER BY TGL DESC");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}