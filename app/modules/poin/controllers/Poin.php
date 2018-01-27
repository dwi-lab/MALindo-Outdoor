<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Poin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('poin_model');
		$submenu  = "Setting Diskon";
		$submenux = "Set. Poin";
		$menu     = "tools";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		$this->service->validasi_submenux($submenux);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "poin";
			$this->service->hak_aksessubmenux($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']       = "tools";
		$isi['namamenu']    = "Setting Diskon";
		$isi['page']        = "poin";
		$isi['link']        = 'poin';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit']  = 'edit';
		$isi['halaman']     = "Set. Poin";
		$isi['judul']       = "Halaman Set. Poin";
		$isi['content']     = "poin_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->poin_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[]  = number_format($rowx->nominal_a) . " - " . number_format($rowx->nominal_b);
				$row[]  = number_format($rowx->jml_poin);
				$row[]  = $rowx->status ? '<center><a href="javascript:void(0)"
					data-step         ="4"
					data-intro        ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hint         ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="rbstatus(\'aktif\',\'Setting Poin\',\'poin\','."'".$rowx->id."'".')" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Status Aktif"><i class="fa fa-unlock icon-white"></i></a>' : '<center><a href="javascript:void(0)" onclick="rbstatus(\'inaktif\',\'Setting Poin\',\'poin\','."'".$rowx->id."'".')" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Status NonAktif"><i class="fa fa-lock icon-white"></i></a>';
				$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
					data-step         ="5"
					data-intro        ="Digunakan untuk mengedit data."
					data-hint         ="Digunakan untuk mengedit data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="edit_data(\'Setting Poin\',\'poin\',\'edit_data\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
					data-step         ="6"
					data-intro        ="Digunakan untuk menghapus data."
					data-hint         ="Digunakan untuk menghapus data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="hapus_data(\'Setting Poin\',\'poin\',\'hapus_data\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->poin_model->count_all(),
				"recordsFiltered" => $this->poin_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function edit_data($id){
		if($this->input->is_ajax_request()){
			$data = $this->poin_model->get_by_id($id);
			echo json_encode($data);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_edit(){
		if($this->input->is_ajax_request()){
			$method = "edit";
			$data                           = array(
				'nominal_a' => str_replace(".", "", $this->input->post('nominal_a')),
				'nominal_b' => str_replace(".", "", $this->input->post('nominal_b')),
				'jml_poin'  => $this->input->post('poin')
			);
			$this->poin_model->update(array('id' => $this->service->anti($this->input->post('id'))), $data);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_add(){
		if($this->input->is_ajax_request()){
			$method                         = "save";
			$this->_validasi($method);
			$data                           = array(
				'nominal_a' => str_replace(".", "", $this->input->post('nominal_a')),
				'nominal_b' => str_replace(".", "", $this->input->post('nominal_b')),
				'jml_poin'  => $this->input->post('poin'),
				'status'    => "1"
			);
			$this->poin_model->simpan($data);
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
		if($this->input->post('nominal_a') == ''){
			$data['inputerror'][]   = 'nominal_a';
			$data['error_string'][] = 'range nominal harus di isi.';
			$data['status']         = FALSE;
		}
		if($this->input->post('nominal_b') == ''){
			$data['inputerror'][]   = 'nominal_b';
			$data['error_string'][] = 'range nominal harus di isi.';
			$data['status']         = FALSE;
		}
		if($this->input->post('poin') == ''){
			$data['inputerror'][]   = 'poin';
			$data['error_string'][] = 'poin harus di isi.';
			$data['status']         = FALSE;
		}
		if($data['status'] === FALSE){
			echo json_encode($data);
			exit();
		}
	}
	public function hapus_data($id){
		if($this->input->is_ajax_request()){
			$this->poin_model->hapus_by_id($id);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	
	public function ubah_status($jns=Null,$id=Null){
		if($this->input->is_ajax_request()){
			if($jns=="aktif"){
				$data = array('status'=>'0');
			}else{
				$data = array('status'=>'1');
			}
			$this->db->where('id',$this->service->anti($id));
			$this->db->update('tbl_poin',$data);
		}else{
			redirect("_404",'refresh');
		}
	}
}
