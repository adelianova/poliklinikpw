<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pasien_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListPasien($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_pasien';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		
    	$this->db->select(" a.kode_pasien,a.nama,a.penanggung_jawab,a.alamat,a.telp,a.email,a.bagian,a.id_status_pasien,convert(varchar(10),a.tgl_lahir,105) as tgl_lahir,a.alergi,a.nip,a.gender,b.status_pasien,c.full_name");
		$this->db->from("TBL_M_PASIEN a");
		$this->db->join("TBL_M_STATUS_PASIEN b","a.id_status_pasien = b.id_status_pasien");
		$this->db->join("v_employee_all c","a.penanggung_jawab = c.nip","left");
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
	
	function getKodePasien(){
		return $this->db->query("select dbo.getIDPasien() as kode_pasien")->row_array();
	}
	
	function simpanPasien(){
		$edit=$this->input->post('edit');
		$kode_pasien=$this->input->post('kode_pasien');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$telp=$this->input->post('telp');
		$email=$this->input->post('email');
		$bagian=$this->input->post('bagian');
		$gender=$this->input->post('gender');
		$nip=$this->input->post('nip');
		$alergi=$this->input->post('alergi');
		$id_status_pasien=$this->input->post('id_status_pasien');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$penanggung_jawab=$this->input->post('penanggung_jawab');
		
		if($edit==''){
			$data=$this->getKodePasien();
			$arr=array(
				'kode_pasien'=>$data['kode_pasien'],
				'nama'=>$nama,
				'alamat'=>$alamat,
				'telp'=>$telp,
				'email'=>$email,
				'id_status_pasien'=>$id_status_pasien,
				'bagian'=>$bagian,
				'nip'=>$nip,
				'alergi'=>$alergi,
				'gender'=>$gender,
				'tgl_lahir'=>date('Y-m-d',strtotime($tgl_lahir)),
				'penanggung_jawab'=>$penanggung_jawab,

			);
			
			$r=$this->db->insert('TBL_M_PASIEN',$arr);
			
		}else{
			$arr=array(
				'nama'=>$nama,
				'alamat'=>$alamat,
				'telp'=>$telp,
				'email'=>$email,
				'id_status_pasien'=>$id_status_pasien,
				'bagian'=>$bagian,
				'nip'=>$nip,
				'alergi'=>$alergi,
				'gender'=>$gender,
				'tgl_lahir'=>date('Y-m-d',strtotime($tgl_lahir)),
				'penanggung_jawab'=>$penanggung_jawab,
			);
			$this->db->where("kode_pasien='".$kode_pasien."'");
			$r=$this->db->update('TBL_M_PASIEN',$arr);
		
		}
		
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']="Data Pasien berhasil disimpan";
		}else{
			$result['error']=true;
			$result['msg']="Data Pasien gagal berhasil disimpan";
	
		}
		
		return $result;
	}
	
	
	function hapusPasien(){
		$kode_pasien=$this->input->post('kode_pasien');
		$this->db->where("kode_pasien='".$kode_pasien."'");	
		$r=$this->db->delete('TBL_M_PASIEN');
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']='Data Pasien berhasil dihapus';
		}else{
			$result['error']=true;
			$result['msg']='Data Pasien gagal berhasil dihapus';
		
		}
		
		return $result;
	}
	
	function getStatus(){
        return $this->db->query(" select id_status_pasien, status_pasien FROM TBL_M_STATUS_PASIEN")->result_array();
    }
    function getPenanggung(){
		 return $this->db->query("select full_name,nip from v_employee_all")
		 ->result_array();
	}
	public function getLaporan(){
		$data = $this->db->query("SELECT   a.kode_pasien,a.nama,a.penanggung_jawab,a.alamat,a.telp,a.email,a.bagian,a.id_status_pasien,convert(varchar(10),a.tgl_lahir,105) as tgl_lahir,a.alergi,a.nip,a.gender,b.status_pasien,c.full_name FROM TBL_M_PASIEN a
			JOIN TBL_M_STATUS_PASIEN b ON a.id_status_pasien = b.id_status_pasien
			LEFT JOIN v_employee_all c ON a.penanggung_jawab = c.nip");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}