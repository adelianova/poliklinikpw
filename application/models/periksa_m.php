<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Periksa_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListPeriksa($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_periksa';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		$tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';
		$this->db->select("a.id_periksa,a.kode_registrasi,a.kode_dokter,a.kode_pasien,a.id_penyakit,convert(varchar(10),a.tgl_periksa,105) as tgl_periksa,a.keluhan,a.diagnosa, b.nama_dokter,c.gender,c.bagian,c.nama,datediff (year,c.tgl_lahir,getdate()) as umur,d.penyakit,e.jenis_periksa");
		$this->db->from("TBL_PERIKSA a");
		$this->db->join("TBL_M_DOKTER b","a.kode_dokter = b.kode_dokter");
		$this->db->join("TBL_M_PASIEN c","a.kode_pasien = c.kode_pasien");
		$this->db->join("TBL_M_PENYAKIT d","a.id_penyakit = d.id_penyakit");
		$this->db->join("TBL_M_JENIS_PERIKSA e","a.id_jenis_periksa = e.id_jenis_periksa","left");
		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),a.tgl_periksa,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}
		else {
			$this->db->where("convert(varchar(10),a.tgl_periksa,112)= '".date('Ymd')."'");
		}

		
		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}

	function simpanPeriksa(){
		$edit=$this->input->post('edit');
		$id_periksa=$this->input->post('id_periksa');
		$kode_dokter=$this->input->post('kode_dokter');
		$id_penyakit=$this->input->post('id_penyakit');
		$kode_penyakit=$this->input->post('kode_penyakit');
		$keluhan=$this->input->post('keluhan');
		$diagnosa=$this->input->post('diagnosa');
		$id_status_registrasi=$this->input->post('id_status_registrasi');
		$id_jenis_periksa=$this->input->post('id_jenis_periksa');
		if($edit==''){
			$arr=array(
				'kode_dokter'=>$kode_dokter,
				'id_penyakit'=>$id_penyakit,
				'tgl_periksa'=>date('Y-m-d H:i:s'), 
				'diagnosa'=>$diagnosa,
				'id_status_registrasi'=>$id_status_registrasi,
				'id_jenis_periksa'=>$id_jenis_periksa

			);
			$this->db->where("id_periksa='".$id_periksa."'");
			$r=$this->db->update('TBL_PERIKSA',$arr);
			
		}else{
			$arr=array(
				'kode_dokter'=>$kode_dokter,
				'id_penyakit'=>$id_penyakit,
				'diagnosa'=>$diagnosa,
				'id_status_registrasi'=>$id_status_registrasi,
				'id_jenis_periksa'=>$id_jenis_periksa
			);
			$this->db->where("id_periksa='".$id_periksa."'");
			$r=$this->db->update('TBL_PERIKSA',$arr);
		
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
	
	
	function hapusPeriksa(){
	$id_periksa=$this->input->post('id_periksa');
		$arr=array(
				'kode_dokter'=>null,
				'id_penyakit'=>null,
				'tgl_periksa'=>null,
				'diagnosa'=>null,
				'id_status_registrasi'=>'Antri',
			);
			$this->db->where("id_periksa='".$id_periksa."'");
			$r=$this->db->update('TBL_PERIKSA',$arr);

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
	function getKodePasien(){
        return $this->db->query(" select kode_pasien,nama FROM TBL_M_PASIEN")->result_array();
    }
    function getDokter(){
    	return $this->db->query("select b.nip, b.full_name from v_employee_all b ")->result_array();
    }
    function getIDPenyakit(){
	    $q = $this->input->post("q");	 
		$query="select id_penyakit,kode_penyakit,penyakit FROM TBL_M_PENYAKIT where kode_penyakit like '%$q%' or kode_penyakit like '%$q%'";
		return $this->db->query($query)->result_array();
    }
  	function getIDPeriksa(){
		 return $this->db->query("select a.kode_pasien,a.nama,a.gender,a.alergi,a.bagian,datediff (year,a.tgl_lahir,getdate()) as umur,b.id_periksa,b.keluhan FROM TBL_M_PASIEN a 
		 	JOIN TBL_PERIKSA b ON a.kode_pasien=b.kode_pasien 
		 	where kode_dokter is null and convert(varchar(10),
		 	b.tgl_registrasi,112)= '".date('Ymd')."'(select id_periksa from TBL_PERIKSA) ")
		 ->result_array();
	}
	function getStatus(){
        return $this->db->query(" select id_status_registrasi, status FROM TBL_M_STATUS_REGISTRASI")->result_array();
    }
    function getJenis(){
        return $this->db->query(" select id_jenis_periksa,jenis_periksa FROM TBL_M_JENIS_PERIKSA")->result_array();
    }
     public function getLaporan($TGL_MULAI,$TGL_SELESAI){

		$tglMulai = date("Ymd", strtotime($TGL_MULAI));
		$tglSelesai = date("Ymd", strtotime($TGL_SELESAI));
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?"CONVERT(varchar(8), a.tgl_periksa, 112) ='".date('Ymd')."'":"CONVERT(varchar(8), a.tgl_periksa, 112) between '$tglMulai' and '$tglSelesai'";
		
		$data = $this->db->query("SELECT a.id_periksa,a.kode_registrasi,a.kode_dokter,a.kode_pasien,a.id_penyakit,convert(varchar(10),a.tgl_periksa,105) as tgl_periksa,a.keluhan,a.diagnosa, b.nama_dokter,c.gender,c.bagian,c.nama,datediff (year,c.tgl_lahir,getdate()) as umur,d.penyakit,e.jenis_periksa FROM tbl_periksa a
		JOIN TBL_M_DOKTER b ON a.kode_dokter = b.kode_dokter
		JOIN TBL_M_PASIEN C ON a.kode_pasien = c.kode_pasien
		JOIN TBL_M_PENYAKIT d ON a.id_penyakit = d.id_penyakit
		LEFT JOIN TBL_M_JENIS_PERIKSA e ON a.id_jenis_periksa =e.id_jenis_periksa
		where ".$tgl."
		ORDER BY tgl_periksa DESC");
		return $data->result();
	}

	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}