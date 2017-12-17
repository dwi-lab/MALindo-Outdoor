<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kerja extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('kerja_model');
		$submenu = "Data Pekerjaan";
		$menu     = "ref_data";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "kerja";
			$this->service->hak_aksessubmenux($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']       = "ref_data";
		$isi['namamenu']    = "Data Pekerjaan";
		$isi['page']        = "kerja";
		$isi['link']        = 'kerja';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit']  = 'edit';
		$isi['halaman']     = "Data Pekerjaan";
		$isi['judul']       = "Halaman Data Pekerjaan";
		$isi['content']     = "kerja_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->kerja_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[]  = $rowx->kerja;
				$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
					data-step         ="5"
					data-intro        ="Digunakan untuk mengedit data."
					data-hint         ="Digunakan untuk mengedit data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="edit_data(\'Data Pekerjaan\',\'kerja\',\'edit_data\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
					data-step         ="6"
					data-intro        ="Digunakan untuk menghapus data."
					data-hint         ="Digunakan untuk menghapus data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="hapus_data(\'Data Pekerjaan\',\'kerja\',\'hapus_data\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->kerja_model->count_all(),
				"recordsFiltered" => $this->kerja_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_add(){
		if($this->input->is_ajax_request()){
			$method                         = "save";
			$this->_validasi($method);
			$data                           = array('kerja' => $this->service->anti(htmlspecialchars($this->input->post('nama'))));
			$insert                         = $this->kerja_model->simpan($data);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	private function _validasi($method){
		$data                 = array();
		$data['error_string'] = array();
		$data['inputerror']   = array();
		$data['status']       = TRUE;
		if($this->input->post('nama') == ''){
			$data['inputerror'][]   = 'nama';
			$data['error_string'][] = 'nama pekerjaan harus di isi.';
			$data['status']         = FALSE;
		}
		if($method=="save"){
			$ckdata = $this->db->get_where('tbl_pekerjaan',array('kerja'=>$this->service->anti($this->input->post('nama'))))->result();
			if(count($ckdata)>0){
				$data['inputerror'][]   = 'nama';
				$data['error_string'][] = 'nama pekerjaan sudah ada sebelumnya.';
				$data['status']         = FALSE;
			}
		}
		if($data['status'] === FALSE){
			echo json_encode($data);
			exit();
		}
	}
	public function hapus_data($id){
		if($this->input->is_ajax_request()){
			$this->kerja_model->hapus_by_id($id);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	public function edit_data($id){
		if($this->input->is_ajax_request()){
			$data = $this->kerja_model->get_by_id($id);
			echo json_encode($data);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_edit(){
		if($this->input->is_ajax_request()){
			$method = "edit";
			$this->_validasi($method);
			$data = array('kerja' => $this->service->anti(htmlspecialchars($this->input->post('nama'))));
			$this->kerja_model->update(array('id' => $this->service->anti($this->input->post('id'))), $data);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
}
