<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
    private $table;
    private $pk;
    
    public function __construct() {
        parent::__construct();
    }
    
	//set tabel
    public function set_table($table = '',$pk ='') {
        $this->table = $table;
        $this->pk = $pk;
        return $this;
    }
    
    public function get_all(){
        return $this->_get()->result();
    }
    
    public function get_array(){
        return $this->_get()->result_array();
    }
    
    public function get($id = '0') {
        $this->db->where($this->pk,$id);
        return $this->_get()->row();
    }
    
    public function get_by($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->_get()->row();
        }
        return FALSE;
    }
    
    public function get_many_by($param) {
        if (is_array($param)) {
            $this->db->where($param);
            return $this->get_all();
        }
        return FALSE;
    }
    
    public function insert($data = array()) {
        if($this->db->insert($this->table,$data)) {
            return $this->db->insert_id();
        }
        return false;
    }
	
	public function insert_data($data = array()) {
        if($this->db->insert($this->table,$data)) {
            return true;
        }
        return false;
    }
    
    public function delete($id = 0) {
        if ($this->db->delete($this->table,array($this->pk => $id))) {
            return true;
        }
        return false;
    }
    
    public function update($id = 0 ,$data = array()) {
        $this->db->where(array($this->pk => $id));
        if ($this->db->update($this->table,$data)){
            return true;
        }
        return false;
    }
    
    public function update_by($where = array(), $data = array()) {
        $this->db->where($where);
        if ($this->db->update($this->table,$data)){
            return true;
        }
        return false;
    }
    
    protected function _get() {
        return $this->db->get($this->table);
    }
	
	public function ms_escape_string($data) {
		if ( !isset($data) or empty($data) ) return '';
		if ( is_numeric($data) ) return $data;

		$non_displayables = array(
				'/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
				'/%1[0-9a-f]/',             // url encoded 16-31
				'/[\x00-\x08]/',            // 00-08
				'/\x0b/',                   // 11
				'/\x0c/',                   // 12
				'/[\x0e-\x1f]/'             // 14-31
		);
		foreach ( $non_displayables as $regex )
			$data = preg_replace( $regex, '', $data );
		$data = str_replace("'", "''", $data );
		return $data;
	}
	
	//cek tabel ada atau tidak
	function cek_tabel($nama,$periode){
		$s_tbl="select * from sys.tables where name like '".$nama."_".$periode."'";
		$q_tbl=$this->db->query($s_tbl)->result_array();
		if(count($q_tbl)>0){
			return "_".$periode;
		}else{
			return '';
		}
	}
	
	
	/*public function menu_action($menu,$level){
		$s="select * from siwo_menu_detail where id_menu='".$menu."' and id_level='".$level."'";
		$q=$this->db->query($s);
		return $q->row();
	}*/
}

?>