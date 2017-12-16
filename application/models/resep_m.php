<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Resep_m extends MY_Model {
    public $limit;
	public $offset;
	
    function __construct(){
        parent::__construct();
    }
	
	function getListResep($jenis){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$this->limit = $rows;
		$this->offset = $offset;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_resep';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $tgl_awal=isset($_POST['tgl_awal']) ? strval($_POST['tgl_awal']) : '';
		$tgl_akhir=isset($_POST['tgl_akhir']) ? strval($_POST['tgl_akhir']) : '';
		$searchKey=isset($_POST['searchKey']) ? strval($_POST['searchKey']) : '';
		$searchValue=isset($_POST['searchValue']) ? strval($_POST['searchValue']) : '';
		
    	$this->db->select("a.id_resep,a.id_periksa,convert(varchar(10),b.tgl_periksa,105) as tgl_periksa,b.kode_dokter, c.nama_dokter,d.nama");
		$this->db->from("tbl_resep a");
		$this->db->join("TBL_PERIKSA b","a.id_periksa = b.id_periksa");
		$this->db->join("TBL_M_DOKTER c","b.kode_dokter = c.kode_dokter");
		$this->db->join("TBL_M_PASIEN d","b.kode_pasien = d.kode_pasien");
		if($searchKey<>''){
		$this->db->where($searchKey." like '%".$searchValue."%'");	
		}else if($tgl_awal<>''&&$tgl_akhir<>''){
			$this->db->where("convert(varchar(10),b.tgl_periksa,112) between '".date('Ymd',strtotime($tgl_awal))."' AND '".date('Ymd',strtotime($tgl_akhir))."'");
		}
		else {
			$this->db->where("convert(varchar(10),b.tgl_periksa,112)= '".date('Ymd')."'");
		}
		
		$this->db->order_by($sort,$order);
		
		if($jenis=='total'){
		$hasil=$this->db->get ('')->num_rows();
		}else{
		$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
		}
		
	    return $hasil;	
	}	
	function getKodeResep(){
		return $this->db->query("select dbo.getIDResep() as id_resep")->row_array();
	}
	function getDetailResep(){
		return $this->db->query("select dbo.getIDDetailResep() as id_detail_resep")->row_array();
	}
	function simpanResep($id_periksa=""){
		$edit=$this->input->post('edit');
		$id_resep=$this->input->post('id_resep');
		$id_periksa=$this->input->post('id_periksa');
		
		if($edit==''){
			$data=$this->getKodeResep();
			$arr=array(
				'id_periksa'=>$id_periksa,
			);

			$r=$this->db->insert('TBL_RESEP',$arr);		
		}else{
			$arr=array(
				'id_periksa'=>$id_periksa,
			);
			$this->db->where("id_resep='".$id_resep."'");
			$r=$this->db->update('TBL_RESEP',$arr);
		
		}
		
		$result=array();
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']="Data Resep Berhasil disimpan";
			
		}else{
			$result['error']=true;
			$result['msg']="Data Resep Gagal disimpan";
		}
		
		return $result;
	}

	function cekStok($kodeObat=""){
		$query = $this->db->query("select (z.stok-z.resep-z.retur) as sisa 
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
		    )z where kode_obat = '$kodeObat'");
		return $query->row()->sisa;
	}

	function cekEditStok($idDetail="", $kodeObat=""){
		$query = $this->db->query("select qty from TBL_DETAIL_RESEP where ID_DETAIL_RESEP = '$idDetail' and KODE_OBAT = '$kodeObat'");
		if($query->num_rows()>0){
			return $query->row()->qty;
		}else{
			return 0;
		}
		
	}
	
	function simpanTambah($id_resep=""){
		$edit=$this->input->post('edit');
		$id_detail_resep=$this->input->post('ID_DETAIL_RESEP');
		$kode_obat=$this->input->post('KODE_OBAT');
		$qty=abs($this->input->post('QTY'));
		$dosis=$this->input->post('DOSIS');

		if($edit==''){
			$stok = $this->cekStok($kode_obat);
			$result=array();
			if($stok < $qty){
				$result['error']=true;
				$result['msg']="Maaf Stok Obat Tidak Cukup";
				return $result;
			}else{
				$data=$this->getDetailResep();
				$arr=array(
					'ID_RESEP'=>$id_resep,
					'KODE_OBAT'=>$kode_obat,
					'QTY'=>$qty,
					'DOSIS'=>$dosis,
				);
				$z=$this->db->insert('TBL_DETAIL_RESEP',$arr);	
			}	
		}else{
			$stok = $this->cekStok($kode_obat);
			$stokEdit = $this->cekEditStok($id_detail_resep, $kode_obat);
			if(($stok+$stokEdit) < $qty){
				$result['error']=true;
				$result['msg']="Maaf Stok Obat Tidak Cukup";
				return $result;
			}else{
				$arr=array(
					'KODE_OBAT'=>$kode_obat,
					'QTY'=>$qty,
					'DOSIS'=>$dosis,
				);
				$this->db->where("id_detail_resep='".$id_detail_resep."'");
				$z=$this->db->update('TBL_DETAIL_RESEP',$arr);
			}
			
		}
		
		if($this->db->affected_rows()>0){
			$result['error']=false;
			$result['msg']="Data Resep berhasil disimpan";
		}else{
			$result['error']=true;
			$result['msg']="Data Resep gagal disimpan";
	
		}
		return $result;
	}
	function hapusResep(){
		$id_resep=$this->input->post('id_resep');
		$this->db->where("id_resep='".$id_resep."'");	
		$r=$this->db->delete('tbl_resep');
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
	function hapusTambah(){
		$id_detail_resep=$this->input->post('id_detail_resep');
		$this->db->where("ID_DETAIL_RESEP='".$id_detail_resep."'");	
		$z=$this->db->delete('tbl_detail_resep');
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

	function getIDPeriksa(){
		 return $this->db->query("select a.kode_pasien,a.nama,b.id_periksa,b.kode_dokter, c.nama_dokter FROM TBL_M_PASIEN a JOIN TBL_PERIKSA b ON a.kode_pasien=b.kode_pasien join TBL_M_DOKTER c on c.kode_dokter = b.kode_dokter where convert(varchar(10),
		 		b.tgl_periksa,112)= '".date('Ymd')."' and b.kode_dokter is not null and id_periksa not in (select id_periksa from TBL_RESEP)")
		 ->result_array();
	}
    function getIDObat(){
         return $this->db->query("select 
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
		    )z")->result_array();
    }
	function getIDDokter(){
         return $this->db->query(" select kode_dokter,nama_dokter FROM TBL_M_DOKTER")->result_array();
    }
	function getIDRegistrasi(){
         return $this->db->query(" select kode_registrasi FROM TBL_PERIKSA")->result_array();
    }
    function kodeResep(){
    	$id_resep=$this->input->post('id_resep');
		 return $this->db->query("select a.KODE_OBAT,a.QTY,a.DOSIS,a.ID_DETAIL_RESEP,b.NAMA,b.SATUAN FROM TBL_DETAIL_RESEP a JOIN TBL_M_OBAT b ON a.KODE_OBAT=b.KODE_OBAT where a.id_resep = '".$id_resep."'")->result_array();
    }
    function getNamaDokter(){
    	return $this->db->query('select a.*,b.kode_dokter,c.nama_dokter from TBL_RESEP a join TBL_PERIKSA b on b.KODE_DOKTER = b.KODE_DOKTER join TBL_M_DOKTER c on b.KODE_DOKTER = c.KODE_DOKTER')->result_array();
    }
    public function getLaporan($TGL_MULAI,$TGL_SELESAI){
		$tglMulai = date("Ymd", strtotime($TGL_MULAI));
		$tglSelesai = date("Ymd", strtotime($TGL_SELESAI));
		$tgl = ($TGL_MULAI == '' || $TGL_SELESAI == '')?"CONVERT(varchar(8), b.tgl_periksa, 112) ='".date('Ymd')."'":"CONVERT(varchar(8), b.tgl_periksa, 112) between '$tglMulai' and '$tglSelesai' ";
		$data = $this->db->query("SELECT a.id_resep,a.id_periksa,convert(varchar(10),b.tgl_periksa,105) as tgl_periksa,b.kode_dokter, c.nama_dokter,d.nama FROM tbl_resep a
		JOIN TBL_PERIKSA b ON a.id_periksa = b.id_periksa
		JOIN TBL_M_DOKTER c ON b.kode_dokter = c.kode_dokter
		JOIN TBL_M_PASIEN d ON b.kode_pasien = d.kode_pasien
		WHERE ".$tgl." 
		ORDER BY tgl_periksa DESC");
		return $data->result();
	}
	function getDataPejabat(){
		$query = $this->db->query("SELECT  full_name from v_employee_all where position_code = '2.04.00.00.00'");
		return $query->row();
	}
}