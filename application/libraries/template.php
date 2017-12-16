<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Parser {
    private $ci;
    private $name;
    private $path;
    private $base;
    private $default = 'default';
    private $css_folder = 'css';
    private $js_folder = 'js';
    private $delimiter = array();
    private $metadata = array('judul'=>'title','metadata'=>'');
    private $script = array();
    private $parsial = array();
    private $prepdata = array();
    
    public function __construct(){
        $this->ci =& get_instance();
        $this->path = $this->ci->config->item('template_base');
        $this->base = $this->path.$this->default.'/';
        //$this->metadata['metadata'] = array();
    }
    
    //USE ON ADMIN AS AN OPTION TO USE ASSET THAN TEMPLATE
    public function use_asset() {
        $this->path = $this->base = $this->ci->config->item('asset_base');
        return $this;
    }
    
    public function get_metadata() {
        $output = '';
        foreach ($this->script as $key => $val){
            $output .= $val;
        }
        return $output;
    }
    
    public function get_judul() {
        return $this->metadata['judul'];
    }
    
    
    public function set_template($name = 'default') {
        $this->base = $this->path.$name.'/';
        $this->name = $name;
        return $this;
    }
    
    public function set_judul($judul = 'title') {
        $this->metadata['judul'] = $judul;
        return $this;
    }
    
    public function set_css($folder='',$file = ''){
        if(func_num_args() < 2) {
            $folder = '';
            $file = func_get_arg(0);
        } else {
            $folder = $folder.'/';
        }
        
        $pre = '<link href="';
        $pre .= base_url().$this->base.$this->css_folder.'/'.$folder;
        $end = '" rel="stylesheet" >';
        
        $this->_delimiter($pre,$end);
        $this->_set_asset($file,'css');
        
        return $this;
    }
    
    public function set_js($folder = '',$file = '') {
        if(func_num_args() < 2) {
            $folder = '';
            $file = func_get_arg(0);
        } else {
            $folder = $folder.'/';
        }
        
        $pre = '<script type="text/javascript" src="';
        $pre .= base_url().$this->base.$this->js_folder.'/'.$folder;
        $end = '"></script>';
        
        $this->_delimiter($pre,$end);
        $this->_set_asset($file,'js');
        
        return $this;
    }
    
    public function set_parsial ($location = '', $view = '', $data = '') {
        if($location != '' && $data != '') {
            $this->parsial[$location] = array ($location.'_data'=>$this->ci->load->view($view,$data,TRUE)); 
        }
        return $this;
    }
    
    //DELETEABLE
    public function view_config(){
        echo $this->base;
    }
    
    private function _cek_file(){
        if(!file_exists($this->base)){
            show_error('File template dengan nama "<b>'.$this->name.'</b>" tidak dapat ditemukan');
        }
    }
    
    public function render($view, $data, $state = FALSE){
        $this->_cek_file();
        $this->prepdata['body'] = $this->ci->load->view($view,$data,TRUE) ;
        
        $this->ci->load->_ci_view_path = $this->base;
        
        foreach ($this->parsial as $key => $val) {
            $this->prepdata[$key] = parent::parse($key,$val,TRUE);
        }
        
        $this->metadata['metadata'] = $this->get_metadata();
        
        //print_r($this->parsial);
        parent::parse('header',$this->metadata,FALSE);
        parent::parse('page', $this->prepdata, FALSE);
        parent::parse('footer', $data, FALSE);
    }
    
    private function _set_asset($file,$ext) {
        $hasil = array();
        if(is_array($file)) {
            foreach($file as $key => $filename) {
                $hasil[] = $this->delimiter['awal'].$filename.'.'.$ext.$this->delimiter['akhir'];
            } 
        } else {
            $hasil[] = $this->delimiter['awal'].$file.'.'.$ext.$this->delimiter['akhir'];
        }
        
        $this->script = array_merge($this->script,$hasil);
    }
    
    private function _delimiter($awal='',$akhir=''){
        $this->delimiter['awal']=$awal;
        $this->delimiter['akhir']=$akhir;
    }
    
}