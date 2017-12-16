<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Penyakit_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListPenyakit($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_penyakit';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		
    	$this->db->select(" id_penyakit,kode_penyakit,penyakit ");
		$this->db->from("tbl_m_penyakit");
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
	
	function getKodePenyakit(){
		return $this->db->query("select dbo.getIDPenyakit() as id_penyakit")->row_array();
	}
	
	function simpanPenyakit(){
		$edit=$this->input->post('edit');
		$id_penyakit=$this->input->post('id_penyakit');
		$kode_penyakit=$this->input->post('kode_penyakit');
		$penyakit=$this->input->post('penyakit');
		
		if($edit==''){
			$data=$this->getKodePenyakit();
			$arr=array(
				'kode_penyakit'=>$kode_penyakit,
				'penyakit'=>$penyakit
			);
			
			$r=$this->db->insert('tbl_m_penyakit',$arr);
			
		}else{
			$arr=array(
				'kode_penyakit'=>$kode_penyakit,
				'penyakit'=>$penyakit
			);
			$this->db->where("kode_penyakit='".$kode_penyakit."'");
			$r=$this->db->update('tbl_m_penyakit',$arr);
		
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
	
	
	function hapusPenyakit(){
		$kode_penyakit=$this->input->post('kode_penyakit');
		$this->db->where("kode_penyakit='".$kode_penyakit."'");	
		$r=$this->db->delete('tbl_m_penyakit');
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
		$data = $this->db->query("SELECT id_penyakit,kode_penyakit,penyakit FROM tbl_m_penyakit");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}