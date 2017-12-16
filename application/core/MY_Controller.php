<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Controller extends CI_Controller {
    private $default_view ;
    private $judul ;
    
    public function __construct(){
        parent::__construct();
		$this->clear_cache();
		$this->load->config('config_app');
		$this->judul=$this->config->item('title');
		$this->template->use_asset();
	
    }
    
    public function default_meta() {
        $this->template->set_css(array('admin/default/easyui','admin/fonts/stylesheet','admin/icon','admin/login','admin/dashboard','admin/uploadfile','admin/lightbox'))
        ->set_js(array('admin/jquery.min','admin/jquery.easyui.min','admin/detail_view','admin/jloader','admin/datagrid-groupview','admin/accounting','admin/ext','admin/uploadfile','admin/lightbox','admin/jqueryrotate.min','admin/printarea'))
        ->set_judul($this->judul);
        return $this;
    }
	
	function clear_cache(){
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
	}
    
    public function set_judul($judul = '') {
        $this->judul = $this->judul;
        return $this;
    }
	
	
	
    protected function _view($data) {
	
		$this->load->view('admin/content',$data);
		
    }
	
	protected function _loadPage($data) {
		if (!$this->autentifikasi->sudah_login()) redirect (site_url('login'));
		$this->load->view($data);
		
    }
	 
    function _modal($view,$data='') {
	    $this->load->view($view,$data);
    }
	
	function loadModal($dir,$file){
		$this->_modal($dir.'/'.$file,'');
	}
	
	function loadModalByDir($file){
		$this->_modal($file,'');
	}
	
	
	
	
}
