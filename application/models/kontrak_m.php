<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kontrak_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListKontrak($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_kontrak';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		
    	$this->db->select(" a.id_kontrak,a.kode_dokter,a.nomor,convert(varchar(10),a.mulai_kontrak,105) as mulai_kontrak,convert(varchar(10),a.selesai_kontrak,105) as selesai_kontrak,a.keterangan,b.nama_dokter ");
		$this->db->from("tbl_kontrak_dokter a");
		$this->db->join("TBL_M_DOKTER b","a.kode_dokter = b.kode_dokter");
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
	
	function getKodeKontrak(){
		return $this->db->query("select dbo.getIDKontrak() as id_kontrak")->row_array();
	}
	function getNoKontrak(){
		return $this->db->query("select dbo.getNoKontrak() as nomor")->row_array();
	}
	
	function simpanKontrak(){
		$edit=$this->input->post('edit');
		$id_kontrak=$this->input->post('id_kontrak');
		$kode_dokter=$this->input->post('kode_dokter');
		$nomor=$this->input->post('nomor');
		$mulai_kontrak=$this->input->post('mulai_kontrak');
		$selesai_kontrak=$this->input->post('selesai_kontrak');
		$keterangan=$this->input->post('keterangan');
		
		if($edit==''){
			$data=$this->getKodeKontrak();
			$arr=array(
				'kode_dokter'=>$kode_dokter,
				'nomor'=>$nomor,
				'mulai_kontrak'=>date('Y-m-d',strtotime($mulai_kontrak)),
				'selesai_kontrak'=>date('Y-m-d',strtotime($selesai_kontrak)),
				'keterangan'=>$keterangan
			);
			
			$r=$this->db->insert('tbl_kontrak_dokter',$arr);
			
		}else{
			$arr=array(
				'kode_dokter'=>$kode_dokter,
				'nomor'=>$nomor,
				'mulai_kontrak'=>date('Y-m-d',strtotime($mulai_kontrak)),
				'selesai_kontrak'=>date('Y-m-d',strtotime($selesai_kontrak)),
				'keterangan'=>$keterangan
			);
			$this->db->where("id_kontrak='".$id_kontrak."'");
			$r=$this->db->update('tbl_kontrak_dokter',$arr);
		
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
	
	
	function hapusKontrak(){
		$id_kontrak=$this->input->post('id_kontrak');
		$this->db->where("id_kontrak='".$id_kontrak."'");	
		$r=$this->db->delete('tbl_kontrak_dokter');
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
	
		function getKodeDokter(){
		 return $this->db->query("select kode_dokter,nama_dokter from tbl_m_dokter")
		 ->result_array();
	}
	public function getLaporan(){
		$data = $this->db->query("SELECT  a.id_kontrak,a.kode_dokter,a.nomor,convert(varchar(10),a.mulai_kontrak,105) as mulai_kontrak,convert(varchar(10),a.selesai_kontrak,105) as selesai_kontrak,a.keterangan,b.nama_dokter FROM tbl_kontrak_dokter a 
			JOIN TBL_M_DOKTER b ON a.kode_dokter = b.kode_dokter");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}