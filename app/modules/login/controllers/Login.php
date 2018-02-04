<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('login_model');
	}
	public function index(){
		if($this->session->userdata('login')==TRUE){
			redirect('dashboard','refresh');
		}else{
			$this->load->view('login_view');
		}
	}
	public function do_login(){
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('txtuser','Username','htmlspecialchars|trim|required|min_length[1]|max_length[30]');
			$this->form_validation->set_rules('txtpass','Password','htmlspecialchars|trim|required|min_length[1]|max_length[30]');
			if ($this->form_validation->run()==TRUE){
				$data['response'] = 'false';
				$username = $this->service->anti(trim($this->input->post('txtuser')));
				$password = $this->service->anti(trim($this->input->post('txtpass')));
				$result   = $this->login_model->login($username,md5($password));
				if($result==TRUE){
					$data['response'] = 'true';
				}
			}else{
				$data['response'] = 'false';
			}
			if('IS_AJAX'){
				echo json_encode($data);
			}
		}else{
			redirect("login",'refresh');
		}
	}
	public function acmilan(){
		$this->load->view('milan');
	}
	public function getContent(){
		if($this->input->is_ajax_request()){
			$html         =	"";
			$html         .='<div class="news-image">';
			$gal          = $this->db->query("SELECT * FROM tbl_bglogin ORDER BY RAND()");
			$row          = $gal->row();
			$bgna         = $row->logo;
			$html         .='<img src="'.base_url().'assets/img/login-bg/'.$bgna.'" data-id="login-cover-image" alt="" />';
			$html         .='</div>';
			$html         .='<div class="news-caption">';
			$html         .='<h4 class="caption-title"><i class="fa fa-edit text-success"></i> MALindo Outdoor </h4>';
			$html         .= "JL. DR. Moch. Hatta No. 168 Kel. Sukamanah Kec. Cipedes Kota Tasikmalaya <br/>" . "TELEPON : 085 220 296 494 <br/>" . "E-MAIL : malindooutdoor@gmail.com  WEBSITE : http://malindooutdoor.blogspot.co.id";
			$data         =	array('html'=>$html);
			echo json_encode($data);
		}else{
			redirect("_404",'refresh');
		}
	}
	public function generate($user, $pass){
		$user = addslashes($user);
		$pass = addslashes($pass);
		$pass = md5(crypt($pass,md5($user)));

		echo "Usernamena : " . $user . "</br>" . "Passwordna : " . $pass;

	}
	public function getRight(){
		if($this->input->is_ajax_request()){
			$html      =	"";
			$html      .='<div class="login-header">';
			$html      .='<p class="text-center text-inverse">';
			$html      .='<span class=""><img style="text-align:right" src="'.base_url().'logo/logo1.png" width="60%"></span>';
			$html      .='</p>';
			$html      .='<p class="text-center text-inverse">';
			$html      .='<br/>';
			$html      .='</p>';
			$html      .='</div>';
			$html      .='<div class="login-content">';
			$html      .='<form action=\'javascript:doLogin()\' autocomplete=\'off\' method="POST" class="margin-bottom-0">';
			$html      .='<div class="form-group m-b-15">';
			$html      .='<input type="text" class="form-control input-lg" name="username" id="username" placeholder="Masukan Username" />';
			$html      .='</div>';
			$html      .='<div class="form-group m-b-15">';
			$html      .='<input type="password" class="form-control input-lg" name="password" id="password" placeholder="Masukan Password" />';
			$html      .='</div>';
			$html      .='<div class="login-buttons">';
			$html      .='<button type="submit" class="btn btn-success btn-block btn-lg">LOGIN</button>';
			$html      .='</div>';
			$html      .='<hr />';
			$html      .='<p class="text-center text-inverse">';
			$html      .='MALindo Outdoor &copy; 2017';
			$html      .='</p>';
			$html      .='</form>';
			$html      .='</div>';
			$data      =	array('html'=>$html);
			echo json_encode($data);
		}else{
			redirect("_404",'refresh');
		}
	}
	public function tester(){
		$currip = $_SERVER["REMOTE_ADDR"];
		echo "string" . $currip;
	}
	
}
