<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	function login($username,$password){
		$ceklogin = $this->db->query("SELECT * FROM tbl_username WHERE username = '$username' AND password = '$password' AND login = '1' LIMIT 1");
		if(count($ceklogin->result())>0){
			$rows  = $ceklogin->row();
			if($rows->level=='0'){
				$newdata = array(
					'level' =>$rows->level,
					'login' =>TRUE,
					'sett_' =>$rows->setting_harga,
					'kode'  =>$rows->kode);
			}else{
				$cekmenu = $this->db->get_where('tbl_usermenu',array('kode'=>$rows->kode))->result();	
				if(!empty($cekmenu)){
					foreach ($cekmenu as $key) {
						$hak = $key->menu;
						$hax = $key->menux;
					}
				}else{
					$hak = "";
					$hax = "";
				}
				$newdata = array(
					'level' =>$rows->level,
					'login' =>TRUE,
					'priv'  =>$hak,
					'sett_' =>$rows->setting_harga,
					'privx' =>$hax,
					'kode'  =>$rows->kode);
			}
			$this->session->set_userdata($newdata);
			return true;
		}
		return false;
	}
}