<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();
        parent::default_meta();
        $this->data->metadata = $this->template->get_metadata();
		$this->data->judul=$this->template->get_judul();
		$this->load->model(array('user_m'));
    }
    
    public function index() {

		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		redirect(site_url('main'));
    }
	

	public function login(){
		$this->load->view('admin/login',$this->data);
		
	}
	public function main(){
		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		$this->data->menu=$this->user_m->getDefaultMenu();
		parent::_view($this->data);
	}
	
	public function cekLogin(){
		$username=$this->input->post('pengguna');
		$password=sha1(md5("018691fbba180f0bbd33d28cdb2e0e41a7afae5d:".trim($this->input->post('sandi'))));
		
		$result=$this->autentifikasi->cekLogin($username,$password);
		echo json_encode($result);
		
	}
    
    public function logout() {
        $this->autentifikasi->logout();
        redirect (site_url('login'));
    }
	
	
	public function load_page($page){
		$arr_page=explode('_',$page);
		$str='';
		for($i=0;$i<count($arr_page);$i++){
			$str.=$arr_page[$i];
			if($i<count($arr_page)-1){
				$str.="/";
			}
			
		}
		parent::_loadPage($str);
	}
	
	
	
    
}