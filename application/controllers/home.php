<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_m');
    }
    
    public function index() {
    	$data['pasien'] = $this->user_m->count_pasien();
    	$data['admin'] = $this->user_m->count_admin();
    	$data['dokter'] = $this->user_m->count_dokter();
		$this->load->view('landing_page', $data);
    }
}
	