<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct(){
  		parent::__construct();
  		$this->service->login();
		date_default_timezone_set('Asia/Jakarta');
 	}
	public function index(){
		$isi['namamenu'] = "";
		$isi['page']     = "dashboard";
		$isi['kelas']    = "dashboard";
		$isi['link']     = 'dashboard';
		$isi['halaman']  = "Dashboard";
		$isi['judul']    = "Halaman Dashboard";
		$isi['content']  = "welcome";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function log_out(){
		$this->session->sess_destroy();
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
}
