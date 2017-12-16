<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplier_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListSupplier($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_suplier';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		
    	$this->db->select(" id_suplier,nama,alamat,telp,email ");
		$this->db->from("tbl_m_supplier");
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
	
	function getKodeSupplier(){
		return $this->db->query("select dbo.getIDSuplier() as id_suplier")->row_array();
	}
	
	function simpanSuplier(){
		$edit=$this->input->post('edit');
		$id_suplier=$this->input->post('id_suplier');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$telp=$this->input->post('telp');
		$email=$this->input->post('email');
		
		if($edit==''){
			$data=$this->getKodeSupplier();
			$arr=array(
				'nama'=>$nama,
				'alamat'=>$alamat,
				'telp'=>$telp,
				'email'=>$email
			);
			
			$r=$this->db->insert('tbl_m_supplier',$arr);
			
		}else{
			$arr=array(
				'nama'=>$nama,
				'alamat'=>$alamat,
				'telp'=>$telp,
				'email'=>$email
			);
			$this->db->where("id_suplier='".$id_suplier."'");
			$r=$this->db->update('tbl_m_supplier',$arr);
		
		}
		
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']="Data berhasil disimpan";
		}else{
			$result['error']=true;
			$result['msg']="Data gagal berhasil disimpan";
	
		}
		
		return $result;
	
	}
	
	function hapusSupplier(){
		$id_suplier=$this->input->post('id_suplier');
		$this->db->where("id_suplier='".$id_suplier."'");	
		$r=$this->db->delete('tbl_m_supplier');
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']='Data berhasil dihapus';
		}else{
			$result['error']=true;
			$result['msg']='Data gagal berhasil dihapus';
		
		}
		
		return $result;
	}
	
	public function getLaporan(){
		$data = $this->db->query("SELECT nama,alamat,telp,email FROM tbl_m_supplier");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}