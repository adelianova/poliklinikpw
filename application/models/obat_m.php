<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Obat_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListObat($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_obat';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$subQuery="select 
			z.id_obat,
			z.kode_obat,
			z.nama,
			z.satuan,
			(z.stok-z.resep-z.retur) as sisa 
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
		    )z";
		$this->db->select("
			a.id_obat,
			a.kode_obat,
			a.nama,
			a.satuan,
			a.sisa ");
		$this->db->from("($subQuery) a");

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
	
	function getKodeObat(){
		return $this->db->query("select dbo.getIDObat() as kode_obat")->row_array();
	}
	
	function simpanObat(){
		$edit=$this->input->post('edit');
		$kode_obat=$this->input->post('kode_obat');
		$nama=$this->input->post('nama');
		$satuan=$this->input->post('satuan');
		
		if($edit==''){
			$data=$this->getKodeObat();
			$arr=array(
				'kode_obat'=>$data['kode_obat'],
				'nama'=>$nama,
				'satuan'=>$satuan
			);
			
			$r=$this->db->insert('TBL_M_OBAT',$arr);
			
		}else{
			$arr=array(
				'nama'=>$nama,
				'satuan'=>$satuan
			);
			$this->db->where("kode_obat='".$kode_obat."'");
			$r=$this->db->update('TBL_M_OBAT',$arr);
		
		}
		
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']="Data Obat berhasil disimpan";
		}else{
			$result['error']=true;
			$result['msg']="Data Obat gagal berhasil disimpan";
	
		}
		
		return $result;
	
	}
	
	
	function hapusObat(){
		$kode_obat=$this->input->post('kode_obat');
		$this->db->where("kode_obat='".$kode_obat."'");	
		$r=$this->db->delete('TBL_M_OBAT');
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']='Data Obat berhasil dihapus';
		}else{
			$result['error']=true;
			$result['msg']='Data Obat gagal berhasil dihapus';
		
		}
		
		return $result;
	}
		
	public function getLaporan(){
		$data = $this->db->query("select 
			z.id_obat,
			z.kode_obat,
			z.nama,
			z.satuan,
			(z.stok-z.resep-z.retur) as sisa 
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
		    )z");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}