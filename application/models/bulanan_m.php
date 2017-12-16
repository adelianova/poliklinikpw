<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bulanan_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListLaporanBulanan($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_obat';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';

		if($tgl_awal=="" || $tgl_akhir==""){
			$tgl_awal='1-'.date("m-Y");
			$tgl_akhir=date("Y-m-d");
		}else{
			$tgl_awal=$tgl_awal;
			$tgl_akhir=$tgl_akhir;
		}


		$tgl_awal = date("Ymd", strtotime($tgl_awal));
		$tgl_akhir = date("Ymd", strtotime($tgl_akhir));


		$subQuery="select xx.ID_OBAT, xx.KODE_OBAT, yy.NAMA, yy.SATUAN, xx.stok-xx.resep-xx.retur as STOK_AWAL, yy.stok as MASUK, yy.RESEP,yy.RETUR, (xx.stok-xx.resep-xx.retur)+(yy.stok-yy.resep-yy.retur) SALDO from (
				select a.id_obat,a.kode_obat,a.nama,a.satuan,isnull(
			    (select sum(b.qty) from TBL_DETAIL_STOCK b join TBL_STOCK c on b.ID_STOCK = c.ID_STOCK where
			    a.id_obat=b.id_obat and convert(varchar(8), c.tgl, 112) < convert(varchar(8), '$tgl_awal', 112)),0) as stok,
			    isnull(
			    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
			    on x.KODE_OBAT=y.KODE_OBAT join TBL_RESEP i on x.ID_RESEP = i.ID_RESEP join TBL_PERIKSA j ON i.ID_PERIKSA = j.ID_PERIKSA where
			    y.id_obat=a.id_obat and convert(varchar(8), j.TGL_PERIKSA, 112) < convert(varchar(8), '$tgl_awal', 112)),0) as resep,
			    isnull(
			    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
			    b.ID_DTL_STOCK=d.ID_DTL_STOCK join TBL_RETUR k on d.ID_RETUR = k.ID_RETUR where 
				a.id_obat=b.id_obat and convert(varchar(8), k.TGL, 112) < convert(varchar(8), '$tgl_awal', 112)),0) as retur
			    from TBL_M_OBAT a) xx
				join (select a.id_obat,a.kode_obat,a.nama,a.satuan,isnull(
			    (select sum(b.qty) from TBL_DETAIL_STOCK b join TBL_STOCK c on b.ID_STOCK = c.ID_STOCK where
			    a.id_obat=b.id_obat and convert(varchar(8), c.tgl, 112) >= '$tgl_awal' and convert(varchar(8), c.tgl, 112) <= '$tgl_akhir'),0) as stok,
			    isnull(
			    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
			    on x.KODE_OBAT=y.KODE_OBAT join TBL_RESEP i on x.ID_RESEP = i.ID_RESEP join TBL_PERIKSA j ON i.ID_PERIKSA = j.ID_PERIKSA where
			    y.id_obat=a.id_obat and convert(varchar(8), j.TGL_PERIKSA, 112) >= '$tgl_awal' and convert(varchar(8), j.tgl_periksa, 112) <= '$tgl_akhir'),0) as resep,
			    isnull(
			    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
			    b.ID_DTL_STOCK=d.ID_DTL_STOCK join TBL_RETUR k on d.ID_RETUR = k.ID_RETUR where 
				a.id_obat=b.id_obat and convert(varchar(8), k.TGL, 112) >= '$tgl_awal' and convert(varchar(8), k.tgl, 112) <= '$tgl_akhir'),0) as retur
			    from TBL_M_OBAT a) yy on xx.ID_OBAT = yy.ID_OBAT";
		$this->db->select("
			a.id_obat,
			a.kode_obat,
			a.nama,
			a.satuan,
			a.stok_awal,
			a.masuk,
			a.resep,a.retur,
			a.saldo ");
		$this->db->from("($subQuery) a");
		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}/*else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),a.tgl_periksa,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}else {
			$this->db->where("convert(varchar(10),a.tgl_periksa,112)= '".date('Ymd')."'");
		}*/
		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}
    public function getLaporan($tgl_awal,$tgl_akhir){
	/*	$tglMulai = date("Ymd", strtotime($TGL_MULAI));
		$tglSelesai = date("Ymd", strtotime($TGL_SELESAI));
		
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?" and CONVERT(varchar(8), a.tgl_periksa, 112) ='".date('Ymd')."'":" and CONVERT(varchar(8), a.tgl_periksa, 112) between '$tglMulai' and '$tglSelesai' ";

		$data = $this->db->query("
			select xx.ID_OBAT, xx.KODE_OBAT, yy.NAMA, yy.SATUAN, xx.stok-xx.resep-xx.retur as STOK_AWAL, yy.stok as MASUK, yy.resep+yy.retur as KELUAR, (xx.stok-xx.resep-xx.retur)+(yy.stok-yy.resep-yy.retur) SALDO from (
					select a.id_obat,a.kode_obat,a.nama,a.satuan,isnull(
				    (select sum(b.qty) from TBL_DETAIL_STOCK b join TBL_STOCK c on b.ID_STOCK = c.ID_STOCK where
				    a.id_obat=b.id_obat and convert(varchar(6), c.tgl, 112) < convert(varchar(6), getdate(), 112)),0) as stok,
				    isnull(
				    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
				    on x.KODE_OBAT=y.KODE_OBAT join TBL_RESEP i on x.ID_DETAIL_RESEP = i.ID_RESEP join TBL_PERIKSA j ON i.ID_PERIKSA = j.ID_PERIKSA where
				    y.id_obat=a.id_obat and convert(varchar(6), j.TGL_PERIKSA, 112) < convert(varchar(6), getdate(), 112)),0) as resep,
				    isnull(
				    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
				    b.ID_DTL_STOCK=d.ID_DTL_STOCK join TBL_RETUR k on d.ID_RETUR = k.ID_RETUR where 
					a.id_obat=b.id_obat and convert(varchar(6), k.TGL, 112) < convert(varchar(6), getdate(), 112)),0) as retur
				    from TBL_M_OBAT a) xx
							join (select a.id_obat,a.kode_obat,a.nama,a.satuan,isnull(
						    (select sum(b.qty) from TBL_DETAIL_STOCK b join TBL_STOCK c on b.ID_STOCK = c.ID_STOCK where
						    a.id_obat=b.id_obat and convert(varchar(6), c.tgl, 112) >= convert(varchar(6), getdate(), 112)),0) as stok,
						    isnull(
						    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
						    on x.KODE_OBAT=y.KODE_OBAT join TBL_RESEP i on x.ID_DETAIL_RESEP = i.ID_RESEP join TBL_PERIKSA j ON i.ID_PERIKSA = j.ID_PERIKSA where
						    y.id_obat=a.id_obat and convert(varchar(6), j.TGL_PERIKSA, 112) >= convert(varchar(6), getdate(), 112)),0) as resep,
						    isnull(
						    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
						    b.ID_DTL_STOCK=d.ID_DTL_STOCK join TBL_RETUR k on d.ID_RETUR = k.ID_RETUR where 
							a.id_obat=b.id_obat and convert(varchar(6), k.TGL, 112) >= convert(varchar(6), getdate(), 112)),0) as retur
						    from TBL_M_OBAT a) yy on xx.ID_OBAT = yy.ID_OBAT");
		return $data->result();
*/
		if($tgl_awal=="" || $tgl_akhir==""){
			$tgl_awal='1-'.date("m-Y");
			$tgl_akhir=date("Y-m-d");
		}else{
			$tgl_awal=$tgl_awal;
			$tgl_akhir=$tgl_akhir;
		}


		$tgl_awal = date("Ymd", strtotime($tgl_awal));
		$tgl_akhir = date("Ymd", strtotime($tgl_akhir));

		$data = $this->db->query("select xx.ID_OBAT, xx.KODE_OBAT, yy.NAMA, yy.SATUAN, xx.stok-xx.resep-xx.retur as STOK_AWAL, yy.stok as MASUK, yy.RESEP,yy.RETUR, (xx.stok-xx.resep-xx.retur)+(yy.stok-yy.resep-yy.retur) SALDO from (
				select a.id_obat,a.kode_obat,a.nama,a.satuan,isnull(
			    (select sum(b.qty) from TBL_DETAIL_STOCK b join TBL_STOCK c on b.ID_STOCK = c.ID_STOCK where
			    a.id_obat=b.id_obat and convert(varchar(8), c.tgl, 112) < convert(varchar(8), '$tgl_awal', 112)),0) as stok,
			    isnull(
			    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
			    on x.KODE_OBAT=y.KODE_OBAT join TBL_RESEP i on x.ID_RESEP = i.ID_RESEP join TBL_PERIKSA j ON i.ID_PERIKSA = j.ID_PERIKSA where
			    y.id_obat=a.id_obat and convert(varchar(8), j.TGL_PERIKSA, 112) < convert(varchar(8), '$tgl_awal', 112)),0) as resep,
			    isnull(
			    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
			    b.ID_DTL_STOCK=d.ID_DTL_STOCK join TBL_RETUR k on d.ID_RETUR = k.ID_RETUR where 
				a.id_obat=b.id_obat and convert(varchar(8), k.TGL, 112) < convert(varchar(8), '$tgl_awal', 112)),0) as retur
			    from TBL_M_OBAT a) xx
				join (select a.id_obat,a.kode_obat,a.nama,a.satuan,isnull(
			    (select sum(b.qty) from TBL_DETAIL_STOCK b join TBL_STOCK c on b.ID_STOCK = c.ID_STOCK where
			    a.id_obat=b.id_obat and convert(varchar(8), c.tgl, 112) >= '$tgl_awal' and convert(varchar(8), c.tgl, 112) <= '$tgl_akhir'),0) as stok,
			    isnull(
			    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
			    on x.KODE_OBAT=y.KODE_OBAT join TBL_RESEP i on x.ID_RESEP = i.ID_RESEP join TBL_PERIKSA j ON i.ID_PERIKSA = j.ID_PERIKSA where
			    y.id_obat=a.id_obat and convert(varchar(8), j.TGL_PERIKSA, 112) >= '$tgl_awal' and convert(varchar(8), j.tgl_periksa, 112) <= '$tgl_akhir'),0) as resep,
			    isnull(
			    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
			    b.ID_DTL_STOCK=d.ID_DTL_STOCK join TBL_RETUR k on d.ID_RETUR = k.ID_RETUR where 
				a.id_obat=b.id_obat and convert(varchar(8), k.TGL, 112) >= '$tgl_awal' and convert(varchar(8), k.tgl, 112) <= '$tgl_akhir'),0) as retur
			    from TBL_M_OBAT a) yy on xx.ID_OBAT = yy.ID_OBAT");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}