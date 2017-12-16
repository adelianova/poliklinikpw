<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');
define('ALLOW', '1');
define('NOT_ALLOW', '0');

Class Autentifikasi {
    private $ci;
    private $error =  array();
    
    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('user_m');
    }
    
    public function cekLogin($username,$password) {
		$result = $this->ci->user_m->cekLogin($username,$password);

		if(isset($result->nip) && $result->nip<>''){
			
				$this->ci->session->set_userdata(array(
							'userid'	=> $result->nip,
							'name'		=>$result->nama,
							'login'=>true
							
							
				));
				 $this->msg = (array('status'=>'','login'=>true));
				
                
        }else{
		  $this->msg = array('status'=>'Username / Password Salah','login'=>false);
		}
                    
              
						
        return $this->msg;
    }
    
    public function logout() {
        $this->ci->session->set_userdata(array('userid' => '','login' => false));
		$this->ci->session->sess_destroy();
		
    }
    
      
    public function sudah_login($activated = TRUE) {
        return $this->ci->session->userdata('login');
    }
    
    public function role($level = array()) {
        foreach ($level as $key=>$val){
            $status = $this->ci->session->userdata('level') == $val ? ALLOW : NOT_ALLOW;
            if ($status == 1){break;}
        }
        return $status;
    }
    
    
}