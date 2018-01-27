<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Set_email extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('set_email_model');
		$submenu = "Setting Email";
		$menu     = "tools";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "set_email";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']       = "tools";
		$isi['namamenu']    = "Setting Email";
		$isi['page']        = "set_email";
		$isi['link']        = 'set_email';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit']  = 'edit';
		$isi['halaman']     = "Setting Email";
		$isi['judul']       = "Halaman Setting Email";
		$isi['content']     = "set_email_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->set_email_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[]  = $rowx->email;
				$row[]  = "********";
				$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data" 
					data-step         ="5" 
					data-intro        ="Digunakan untuk mengedit data."  
					data-hint         ="Digunakan untuk mengedit data." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned" 
					onclick="edit_data(\'Setting Email\',\'set_email\',\'edit_data\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->set_email_model->count_all(),
				"recordsFiltered" => $this->set_email_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function edit_data($id){
		if($this->input->is_ajax_request()){
			$data = $this->set_email_model->get_by_id($id);
			echo json_encode($data);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_edit(){
		if($this->input->is_ajax_request()){
			$method = "edit";
			$data = array(
				'password' =>$this->service->anti($this->input->post('password')),
				'email'    => $this->service->anti(htmlspecialchars($this->input->post('nama')))
			);
			$this->set_email_model->update(array('id' => $this->service->anti($this->input->post('id'))), $data);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
}
