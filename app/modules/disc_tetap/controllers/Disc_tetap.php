<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Disc_tetap extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('disc_tetap_model');
		$submenu  = "Setting Diskon";
		$submenux = "Set. Diskon Tetap";
		$menu     = "tools";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		$this->service->validasi_submenux($submenux);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "disc_tetap";
			$this->service->hak_aksessubmenux($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']       = "tools";
		$isi['namamenu']    = "Setting Diskon";
		$isi['page']        = "disc_tetap";
		$isi['link']        = 'disc_tetap';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit']  = 'edit';
		$isi['halaman']     = "Set. Diskon Tetap";
		$isi['judul']       = "Halaman Set. Diskon Tetap";
		$isi['content']     = "disc_tetap_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->disc_tetap_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[]  = $rowx->durasi;
				$row[]  = $rowx->disc;
				$row[]  = $rowx->status ? '<center><a href="javascript:void(0)"
					data-step         ="4"
					data-intro        ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hint         ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="rbstatus(\'aktif\',\'Diskon Tetap\',\'disc_tetap\','."'".$rowx->id."'".')" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Status Aktif"><i class="fa fa-unlock icon-white"></i></a>' : '<center><a href="javascript:void(0)" onclick="rbstatus(\'inaktif\',\'Diskon Tetap\',\'disc_tetap\','."'".$rowx->id."'".')" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Status NonAktif"><i class="fa fa-lock icon-white"></i></a>';
				$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
					data-step         ="5"
					data-intro        ="Digunakan untuk mengedit data."
					data-hint         ="Digunakan untuk mengedit data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="edit_data(\'Diskon Tetap\',\'disc_tetap\',\'edit_data\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
					data-step         ="6"
					data-intro        ="Digunakan untuk menghapus data."
					data-hint         ="Digunakan untuk menghapus data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="hapus_data(\'Diskon Tetap\',\'disc_tetap\',\'hapus_data\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->disc_tetap_model->count_all(),
				"recordsFiltered" => $this->disc_tetap_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function edit_data($id){
		if($this->input->is_ajax_request()){
			$data = $this->disc_tetap_model->get_by_id($id);
			echo json_encode($data);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_edit(){
		if($this->input->is_ajax_request()){
			$method = "edit";
			$data                           = array(
				'status' =>'1',
				'disc'   => $this->input->post('diskon'),
				'durasi' => $this->service->anti(htmlspecialchars($this->input->post('lama')))
			);
			$this->disc_tetap_model->update(array('id' => $this->service->anti($this->input->post('id'))), $data);
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
				'status' => '1',
				'disc'   => $this->input->post('diskon'),
				'durasi' => $this->service->anti(htmlspecialchars($this->input->post('lama'))));
			$this->disc_tetap_model->simpan($data);
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
		if($this->input->post('lama') == ''){
			$data['inputerror'][]   = 'lama';
			$data['error_string'][] = 'lama pinjam harus di isi.';
			$data['status']         = FALSE;
		}
		if($method=="save"){
			$ckdata = $this->db->get_where('tbl_disc',array('durasi'=>$this->service->anti($this->input->post('lama'))))->result();
			if(count($ckdata)>0){
				$data['inputerror'][]   = 'lama';
				$data['error_string'][] = 'lama pinjam sudah ada sebelumnya.';
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
			$this->disc_tetap_model->hapus_by_id($id);
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
			$this->db->update('tbl_disc',$data);
		}else{
			redirect("_404",'refresh');
		}
	}
}
