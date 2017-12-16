<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Retur_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListRetur($jenis){
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
		$this->db->select("a.id_retur,a.no_retur,convert(varchar(10),a.tgl,105) as tgl,a.petugas, b.nip,b.full_name as nama");
		$this->db->from("tbl_retur a");
		$this->db->join("v_employee_all b","a.petugas=b.nip");

		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),a.tgl,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}
		else {
			$this->db->where("convert(varchar(10),a.tgl,112)= '".date('Ymd')."'");
		}
		
		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}

	function getListDetail(){
    	$id_retur=$this->input->post('id_retur');
		return $this->db->query("select a.id_dtl_retur,a.id_retur,a.id_dtl_stock,a.qty,a.keterangan,c.nama,c.satuan FROM TBL_DETAIL_RETUR a
		 join TBL_DETAIL_STOCK b on a.id_dtl_stock=b.id_dtl_stock 
		 join TBL_M_OBAT c on b.id_obat=c.id_obat where id_retur = '".$id_retur."'")->result_array();
	}
	function getIDRetur(){
		return $this->db->query("select dbo.getIDRetur() as id_retur")->row_array();
	}

	function getIDDtlRetur(){
		return $this->db->query("select dbo.getIDDtlRetur() as id_dtl_retur")->row_array();
	}
	function getNoRetur(){
		return $this->db->query("select dbo.getNoRetur() as no_retur")->row_array();
	}
	function cekStok($kodeObat=""){
		$query = $this->db->query("
			select c.id_dtl_stock,(z.stok-z.resep-z.retur) as sisa 
			from(
			    select a.id_obat,a.kode_obat,a.nama,a.satuan,isnull(
			    (select sum(b.qty) from TBL_DETAIL_STOCK b where
			    a.id_obat=b.id_obat),0) as stok,
			    isnull(
			    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
			    on x.KODE_OBAT=y.KODE_OBAT where
			    y.id_obat=a.id_obat),0) as resep,
			    isnull(
			    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
			    b.ID_DTL_STOCK=d.ID_DTL_STOCK where 
				a.id_obat=b.id_obat),0) as retur
			    from TBL_M_OBAT a
		    )z join TBL_DETAIL_STOCK c on z.ID_OBAT=c.ID_OBAT  where id_dtl_stock ='$kodeObat'");
		return $query->row()->sisa;
	}

	function cekEditStok($idDetail="",$kodeObat=""){
		$query = $this->db->query("select a.qty,c.id_obat from TBL_DETAIL_RETUR a join TBL_DETAIL_STOCK b on a.ID_DTL_STOCK=b.ID_DTL_STOCK join TBL_M_OBAT c on b.id_obat=c.id_obat where ID_DTL_RETUR = '$idDetail' and c.id_obat ='$kodeObat' ");
		if($query->num_rows()>0){
			return $query->row()->qty;
		}else{
			return 0;
		}
	}
	function simpanRetur(){
		$edit=$this->input->post('edit');
		$id_retur=$this->input->post('id_retur');
		$no_retur=$this->input->post('no_retur');
		$tgl=$this->input->post('tgl');
		$petugas=$this->input->post('petugas');
		
		if($edit==""){
			$data=$this->getNoRetur();
			$arr=array(
				'no_retur'=>$data['no_retur'],
				'tgl'=>date('Y-m-d',strtotime($tgl)),
				'petugas'=>$petugas,
			);
			$r=$this->db->insert('TBL_RETUR',$arr);
		}else{
				$arr=array(
				'tgl'=>date('Y-m-d',strtotime($tgl)),
				'petugas'=>$petugas,
			);
			$this->db->where("id_retur='".$id_retur."'");
			$r=$this->db->update('TBL_RETUR',$arr);
		}
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']="Data berhasil disimpan";
		}else{
			$result['error']=true;
			$result['msg']="Data gagal disimpan";
		}
		return $result;
	}

	function simpanTambahRetur($id_retur=""){
		$edit=$this->input->post('edit');
		$id_dtl_retur=$this->input->post('id_dtl_retur');
		$id_dtl_stock=$this->input->post('id_dtl_stock');
		$qty=abs($this->input->post('qty'));
		$keterangan=$this->input->post('keterangan');
		
		if($edit==''){
			$stok = $this->cekStok($id_dtl_stock);
			$result=array();
			if($stok < $qty){
				$result['error']=true;
				$result['msg']="Maaf Stok Obat Tidak Cukup";
				return $result;
			}else{
				$data=$this->getIDDtlRetur();
				$arr=array(
					'id_retur'=>$id_retur,
					'id_dtl_stock'=>$id_dtl_stock,
					'qty'=>$qty,
					'keterangan'=>$keterangan,
				);
				$r=$this->db->insert('TBL_DETAIL_RETUR',$arr);
			}
		}else{
			$stok = $this->cekStok($id_dtl_stock);
			$stokEdit = $this->cekEditStok($id_dtl_retur, $id_dtl_stock);
			if(($stok+$stokEdit) < $qty){
				$result['error']=true;
				$result['msg']="Maaf Stok Obat Tidak Cukup";
				return $result;
			}else{
			$arr=array(
				'id_dtl_stock'=>$id_dtl_stock,
				'qty'=>$qty,
				'keterangan'=>$keterangan,
				);
				$this->db->where("id_dtl_retur='".$id_dtl_retur."'");
				$r=$this->db->update('TBL_DETAIL_RETUR',$arr);
			}
		}
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']="Data berhasil disimpan";
		}else{
			$result['error']=true;
			$result['msg']="Data gagal disimpan";
		}
		return $result;
	}
	
	
	function removeRetur(){
		$id_retur=$this->input->post('id_retur');
		$this->db->where("id_retur='".$id_retur."'");	
		$r=$this->db->delete('tbl_retur');
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']='Data berhasil dihapus';
		}else{
			$result['error']=true;
			$result['msg']='Data gagal dihapus';
		}
		return $result;
	}
	
	function removeTambahRetur(){
		$id_dtl_retur=$this->input->post('id_dtl_retur');
		$this->db->where("id_dtl_retur='".$id_dtl_retur."'");	
		$r=$this->db->delete('TBL_DETAIL_RETUR');
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']='Data berhasil dihapus';
		}else{
			$result['error']=true;
			$result['msg']='Data gagal dihapus';
		}
		return $result;
	}

	function getDtlStock(){
         return $this->db->query("select * from (select 
			z.id_obat,
			z.kode_obat,
			z.nama,
			z.satuan,
			(z.stok-z.resep-z.retur) as sisa ,
			b.id_dtl_stock,
			convert(varchar(10),b.tgl_expired,105) as tgl_expired
			from(
			    select a.id_obat,a.kode_obat,a.nama,a.satuan,
				isnull(
			    (select sum(b.qty) from TBL_DETAIL_STOCK b where
			    a.id_obat=b.id_obat),0) as stok,
			    isnull(
			    (select sum(x.qty) from TBL_DETAIL_RESEP x join TBL_M_OBAT y
			    on x.KODE_OBAT=y.KODE_OBAT where
			    y.id_obat=a.id_obat),0) as resep,
			    isnull(
			    (select sum(d.qty) from TBL_DETAIL_RETUR d join TBL_DETAIL_STOCK b on 
			    b.ID_DTL_STOCK=d.ID_DTL_STOCK where 
				a.id_obat=b.id_obat),0) as retur
			    from TBL_M_OBAT a 
		    )z inner join TBL_DETAIL_STOCK b on b.ID_OBAT=z.ID_OBAT) a where a.sisa > 0")->result_array();
    }
    function getPetugas(){
    	return $this->db->query("select b.nip, b.full_name from v_employee_all b ")->result_array();
    }public function getLaporan($TGL_MULAI,$TGL_SELESAI){
		$tglMulai = date("Ymd", strtotime($TGL_MULAI));
		$tglSelesai = date("Ymd", strtotime($TGL_SELESAI));
		
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?"CONVERT(varchar(8), a.tgl, 112) ='".date('Ymd')."'":"CONVERT(varchar(8), a.tgl, 112) between '$tglMulai' and '$tglSelesai' ";

		$data = $this->db->query("SELECT a.id_retur,a.no_retur,convert(varchar(10),a.tgl,105) as tgl,a.petugas, b.nip,b.full_name as nama FROM tbl_retur a
		JOIN v_employee_all b ON a.petugas=b.nip
		where ".$tgl."
		ORDER BY a.tgl DESC");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}