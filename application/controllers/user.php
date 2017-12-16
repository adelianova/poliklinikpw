<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('user_m'));
    }
    
    
	function getDefaultMenu(){
		$user=$this->session->userdata('userid');
		if(substr($user,0,2)=='DR'){
			echo $this->user_m->getDefaultDokter();
		}else{
		echo $this->user_m->getDefaultMenu();
		}
	}
	
	public function getListUser(){
		$result['rows']=$this->user_m->getListUser('rows');
		$result['total']=$this->user_m->getListUser('total');
		echo json_encode($result);
		
	}

	public function getKontrak(){
		$data['rows']=$this->user_m->getKontrak('rows');
		$data['total']=$this->user_m->getKontrak('total');
		echo json_encode($data);
		
	}
/*
	public function getExpired(){
		$data['rows']=$this->user_m->getExpired('rows');
		$data['total']=$this->user_m->getExpired('total');
		echo json_encode($data);
		
	}*/
	
	function getAllKaryawan(){
		$result=$this->user_m->getAllKaryawan();
		echo json_encode($result);
	}
	
	function getAllKaryawanByVendor(){
		$result=$this->user_m->getAllKaryawanByVendor();
		echo json_encode($result);
	}
	
	function isLogin(){
		echo $this->session->userdata('login');
	}
	
	function isTerdaftar(){
		$result=$this->user_m->isTerdaftar();
		echo json_encode($result);
	}
	
	function getLevel(){
		$result=$this->user_m->getLevel();
		echo json_encode($result);
	}
	
	function simpanUser(){
		if (!$this->autentifikasi->sudah_login()){
		$result['error']=true;
		$result['msg']='Session anda telah habis silahkan refresh browser anda';
		
		}else{
		$result=$this->user_m->simpanUser();
		}
		echo json_encode($result);
	}
	
	function hapusUser(){
		if (!$this->autentifikasi->sudah_login()){
		$result['error']=true;
		$result['msg']='Session anda telah habis silahkan refresh browser anda';
		}else{
		$result=$this->user_m->hapusUser();
		}
		echo json_encode($result);
	
	}
	
	function getKaryawanByID(){
		$result=$this->user_m->getKaryawanByID();
		echo json_encode($result);
	
	}
	
	function getVendor(){
		$result=$this->user_m->getVendor();
		echo json_encode($result);
	}
	
	function getPetugasVendor(){
		$result=$this->user_m->getPetugasVendor();
		echo json_encode($result);
	}
	
	
    
}