<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }

    public function count_pasien()
    {
    	$query = "SELECT COUNT(*) as pasien from TBL_PERIKSA where convert(varchar(10),tgl_periksa,112)='".date('Ymd')."'";
    	return $this->db->query($query)
    					->row();
    }public function count_admin()
    {
    	$query = "SELECT COUNT(*) as admin from v_employee_all where position_code = '2.04.02.00.03'";
    	return $this->db->query($query)
    					->row();
    }public function count_dokter()
    {
    	$query = "SELECT COUNT(*) as dokter from v_employee_all where position_code = '24.0001'";
    	return $this->db->query($query)
    					->row();
    }
    function cekLogin($username,$password) {
		$query=$this->db->query(
		"select b.nip,
		 b.full_name as nama,
         b.passwd as password
         from v_employee_all b
		 where b.nip='".$username."' and b.passwd='".$password."'"
		)->row();
		
        return $query;
    }
	/*function getExpired($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_dtl_stock';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';

    	$this->db->select("a.id_dtl_stock,a.id_stock,a.id_obat,a.qty,a.tgl_expired,DATEDIFF (MONTH,GETDATE(),a.tgl_expired) as sisa_waktu,b.nama");
		$this->db->from("TBL_DETAIL_STOCK a");
		$this->db->join("TBL_M_OBAT b","b.id_obat = a.id_obat");
		$this->db->where("DATEDIFF (MONTH,GETDATE(),a.tgl_expired) <= '2' and DATEDIFF (MONTH,GETDATE(),a.tgl_expired) > '0'");

		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}
		
		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}*/
	function getDefaultMenu(){
		return '
				[{
					"id":11,
					"text":"Master",
					 "iconCls":"icon-key",
					"children":[{
						"id":111,
						"text":"Dokter",
						"iconCls":"icon-mini-add",
						"url":"admin_master_dokter",
						"akses":true
						
					},{
						"id":112,
						"text":"Surat Kontrak Dokter",
						"iconCls":"icon-mini-add",
						"url":"admin_master_kontrak",
						"akses":true
						
					},{
						"id":113,
						"text":"Obat",
						"iconCls":"icon-mini-add",
						"url":"admin_master_obat",
						"akses":true
					},{
						"id":114,
						"text":"Pasien",
						"iconCls":"icon-mini-add",
						"url":"admin_master_pasien",
						"akses":true
						
					},{
						"id":115,
						"text":"Supplier",
						"iconCls":"icon-mini-add",
						"url":"admin_master_supplier",
						"akses":true
						
					},{
						"id":116,
						"text":"Penyakit",
						"iconCls":"icon-mini-add",
						"url":"admin_master_penyakit",
						"akses":true
					}
					]
					},{
					"id":12,
					"text":"Transaksi",
					"iconCls":"icon-file",
					"state":"open",
					"children":[{
						"id":121,
						"text":"Registrasi",
						"iconCls":"icon-mini-add",
						"url":"transaksi_registrasi",
						"akses":true
					},{
						"id":122,
						"text":"Pemeriksaan",
						"iconCls":"icon-mini-add",
						"url":"transaksi_periksa",
						"akses":true
					},{
						"id":123,
						"text":"Resep",
						"iconCls":"icon-mini-add",
						"url":"transaksi_resep",
						"akses":true
					},{
						"id":124,
						"text":"Obat",
						"iconCls":"icon-paper",
						"state":"open",
						"children":[{
							"id":1242,
							"text":"Stok Obat",
							"iconCls":"icon-mini-add",
							"url":"transaksi_obat",
							"akses":true
						},{
							"id":1241,
							"text":"Retur Obat",
							"iconCls":"icon-mini-add",
							"url":"transaksi_retur",
							"akses":true
					}]
					}]
					
					},
					{
					"id":13,
					"text":"Laporan",
					"iconCls":"icon-report",
					"state":"open",
					"children":
					[{
						"id":131,
						"text":"Stock",
						"iconCls":"icon-paper",
						"state":"open",
						"children":[{
							"id":1311,
							"text":"Masuk",
							"iconCls":"icon-mini-add",
							"url":"laporan_masuk",
							"akses":true
						},{
							"id":1312,
							"text":"Resep",
							"iconCls":"icon-mini-add",
							"url":"laporan_keluar",
							"akses":true
							
						},{
							"id":1313,
							"text":"Retur",
							"iconCls":"icon-mini-add",
							"url":"laporan_retur",
							"akses":true
					},{
							"id":1314,
							"text":"Bulanan",
							"iconCls":"icon-mini-add",
							"url":"laporan_bulanan",
							"akses":true
					}]
					},
					{
						"id":14,
						"text":"Pemeriksaan",
						"iconCls":"icon-paper",
						"url":"laporan_pemeriksaan",
						"akses":true				
					}]
				}]
					

		';
	}
	function getDefaultDokter(){
		return '[{
					"id":11,
					"text":"Master",
					 "iconCls":"icon-key",
					"state":"open",
					"children":[{
						"id":111,
						"text":"Pasien",
						"url":"admin_master_pasien",
						"akses":true
						
							}]
					},{
					"id":12,
					"text":"Transaksi",
					"iconCls":"icon-file",
					"state":"open",
					"children":[{
						"id":121,
						"iconCls":"icon-mini-add",
						"text":"Pemeriksaan",
						"url":"transaksi_periksa",
						"akses":true
						
					},{
						"id":122,
						"iconCls":"icon-mini-add",
						"text":"Resep",
						"url":"transaksi_resep",
						"akses":true
						
							}]
					
				}]';
	}	
	
    function getKontrak($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_kontrak';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		
    	$this->db->select("a.id_kontrak,a.kode_dokter,a.nomor,convert(varchar(10),a.mulai_kontrak,105) as mulai_kontrak,convert(varchar(10),a.selesai_kontrak,105) as selesai_kontrak,a.keterangan,b.nama_dokter,
			DateDiff (MONTH,GETDATE(),a.SELESAI_KONTRAK) as 'sisa_kontrak'");
		$this->db->from("tbl_kontrak_dokter a");
		$this->db->join("TBL_M_DOKTER b","a.kode_dokter = b.kode_dokter");
		$this->db->where("DateDiff (MONTH,GETDATE(),a.SELESAI_KONTRAK)<='2' and DateDiff (MONTH,GETDATE(),a.SELESAI_KONTRAK)>0");

		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}
		
		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}
}