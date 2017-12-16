<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListStock($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_stock';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';
		$this->db->select("a.id_suplier,a.id_stock,a.id_transaksi,convert(varchar(10),a.tgl,105) as tgl,a.no_faktur,a.keterangan, b.nama,c.transaksi");
		$this->db->from("tbl_stock a");
		$this->db->join("TBL_M_SUPPLIER b","a.id_suplier = b.id_suplier");
		$this->db->join("TBL_M_TRANSAKSI c","a.id_transaksi = c.id_transaksi");
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
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_dtl_stock';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
    	$id_stock=$this->input->post('id_stock');
		 return $this->db->query("select a.id_dtl_stock,a.id_stock,a.id_obat,a.qty,a.harga_satuan,a.total,convert(varchar(10),a.tgl_expired,105) as tgl_expired,b.nama,b.satuan FROM TBL_DETAIL_STOCK a join TBL_M_OBAT b
			    on a.id_obat=b.id_obat and b.satuan=b.satuan where id_stock = '".$id_stock."'")->result_array();
		 $this->db->order_by($sort,$order);
	}

	function getIDObat(){
		 return $this->db->query("select id_obat,nama,satuan FROM TBL_M_OBAT")->result_array();
	}

	function getKodeTransaksi(){
		return $this->db->query("select dbo.getIDTransaksi() as id_transaksi")->row_array();
	}

	function getIDStock(){
		return $this->db->query("select dbo.getIDStock() as id_stock")->row_array();
	}

	function getIDDtlStock(){
		return $this->db->query("select dbo.getIDDtlStock() as id_dtl_stock")->row_array();
	}
	function getNoFaktur(){
		return $this->db->query("select dbo.getNoFaktur() as no_faktur")->row_array();
	}
	function simpanTransaksi(){
		$edit=$this->input->post('edit');
		$id_stock=$this->input->post('id_stock');
		$id_suplier=$this->input->post('id_suplier');
		$id_transaksi=$this->input->post('id_transaksi');
		$tgl=$this->input->post('tgl');
		$no_faktur=$this->input->post('no_faktur');
		$keterangan=$this->input->post('keterangan');
		
		if($edit==""){
			$data=$this->getNoFaktur();
			$arr=array(
				'no_faktur'=>$data['no_faktur'],
				'id_suplier'=>$id_suplier,
				'id_transaksi'=>$id_transaksi,
				'tgl'=>date('Y-m-d',strtotime($tgl)),
				'keterangan'=>$keterangan,
			);
			$r=$this->db->insert('TBL_STOCK',$arr);
		}else{
			$arr=array(
				'id_suplier'=>$id_suplier,
				'id_transaksi'=>$id_transaksi,
				'tgl'=>date('Y-m-d',strtotime($tgl)),
				'keterangan'=>$keterangan,
			);
			$this->db->where("id_stock='".$id_stock."'");
			$r=$this->db->update('TBL_STOCK',$arr);
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

	function simpanObat($id_stock=""){
		$edit=$this->input->post('edit');
		$id_dtl_stock=$this->input->post('id_dtl_stock');
		$id_obat=$this->input->post('id_obat');
		$qty=$this->input->post('qty');
		$harga_satuan=$this->input->post('harga_satuan');
		$total=$this->input->post('total');
		$tgl_expired=$this->input->post('tgl_expired');
		
		if($edit==''){
			$data=$this->getIDDtlStock();
			$arr=array(
				'id_obat'=>$id_obat,
				'id_stock'=>$id_stock,
				'qty'=>$qty,
				'harga_satuan'=>$harga_satuan,
				'total'=>$total,
				'tgl_expired'=>date('Y-m-d',strtotime($tgl_expired)),
			);
			$r=$this->db->insert('TBL_DETAIL_STOCK',$arr);
		}else{
			$arr=array(
				'id_obat'=>$id_obat,
				'qty'=>$qty,
				'harga_satuan'=>$harga_satuan,
				'tgl_expired'=>date('Y-m-d',strtotime($tgl_expired)),
			);
			$this->db->where("id_dtl_stock='".$id_dtl_stock."'");
			$r=$this->db->update('TBL_DETAIL_STOCK',$arr);
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
	
	
	function removeTransaksi(){
		$id_stock=$this->input->post('id_stock');
		$this->db->where("id_stock='".$id_stock."'");	
		$r=$this->db->delete('tbl_stock');
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
	
	function removeTambah(){
		$id_dtl_stock=$this->input->post('id_dtl_stock');
		$this->db->where("id_dtl_stock='".$id_dtl_stock."'");		
		$r=$this->db->delete('tbl_detail_stock');
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

	function getListIDTransaksi(){
         return $this->db->query(" select ID_TRANSAKSI,TRANSAKSI FROM TBL_M_TRANSAKSI")->result_array();
    }
    function getIDSuplier(){
         return $this->db->query(" select * FROM TBL_M_SUPPLIER")->result_array();
    }

    function getHanyaIDStock(){
         return $this->db->query(" select id_stock FROM TBL_STOCK")->result_array();
    }
    public function getLaporan($TGL_MULAI,$TGL_SELESAI){
		$tglMulai = date("Ymd", strtotime($TGL_MULAI));
		$tglSelesai = date("Ymd", strtotime($TGL_SELESAI));
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?"CONVERT(varchar(8), a.TGL, 112) ='".date('Ymd')."'":"CONVERT(varchar(8), a.TGL, 112) between '$tglMulai' and '$tglSelesai' ";
		$data = $this->db->query("SELECT a.id_suplier,a.id_stock,a.id_transaksi,convert(varchar(10),a.tgl,105) as tgl,a.no_faktur,a.keterangan, b.nama,c.transaksi FROM TBL_STOCK a
		JOIN TBL_M_SUPPLIER b ON a.id_suplier = b.id_suplier
		JOIN TBL_M_TRANSAKSI c ON a.id_transaksi = c.id_transaksi
		where ".$tgl."
		ORDER BY a.tgl DESC");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}	