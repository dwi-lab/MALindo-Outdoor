<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class news extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('news_model');
		$submenu = "Papan Informasi";
		$menu    = "ref_data";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "news";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']       = "ref_data";
		$isi['namamenu']    = "Papan Informasi";
		$isi['page']        = "news";
		$isi['link']        = 'news';
		$isi['actionhapus'] = 'hapus';
		$isi['actionedit']  = 'edit';
		$isi['halaman']     = "Papan Informasi";
		$isi['judul']       = "Halaman Papan Informasi";
		$isi['content']     = "news_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->news_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/pegawai/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama."'><img src='".base_url()."assets/foto/pegawai/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[]  = $rowx->nama;
				$row[]  = $rowx->berita;
				$row[]  = date("d-m-Y",strtotime($rowx->tgl_dibuat));
				$row[]  = date("d-m-Y",strtotime($rowx->tgl_selesai));
				$row[]  = $rowx->publish ? '<center><a href="javascript:void(0)"
					data-step         ="4"
					data-intro        ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hint         ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="rbstatus(\'aktif\',\'Papan Informasi\',\'news\','."'".$rowx->id."'".')" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Status Aktif"><i class="fa fa-unlock icon-white"></i></a>' : '<center><a href="javascript:void(0)" onclick="rbstatus(\'inaktif\',\'Papan Informasi\',\'news\','."'".$rowx->id."'".')" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Status NonAktif"><i class="fa fa-lock icon-white"></i></a>';
				$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
					data-step         ="5"
					data-intro        ="Digunakan untuk mengedit data."
					data-hint         ="Digunakan untuk mengedit data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="edit_data(\'Papan Informasi\',\'news\',\'edit_data\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
					data-step         ="6"
					data-intro        ="Digunakan untuk menghapus data."
					data-hint         ="Digunakan untuk menghapus data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="hapus_data(\'Papan Informasi\',\'news\',\'hapus_data\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->news_model->count_all(),
				"recordsFiltered" => $this->news_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_add(){
		if($this->input->is_ajax_request()){
			$method = "save";
			$this->_validasi($method);
			$data   = array(
				'oleh'        => $this->session->userdata('kode'),
				'publish'     => '1',
				'tgl_dibuat'  => date("Y-m-d",strtotime($this->input->post('tgl_dibuat'))),
				'tgl_selesai' => date("Y-m-d",strtotime($this->input->post('tgl_selesai'))),
				'berita'      => $this->service->anti(htmlspecialchars($this->input->post('deskripsi')))
			);
			$this->news_model->simpan($data);
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
		if($this->input->post('deskripsi') == ''){
			$data['inputerror'][]   = 'deskripsi';
			$data['error_string'][] = 'deskripsi berita harus di isi.';
			$data['status']         = FALSE;
		}
		if($method=="save"){
			$ckdata = $this->db->get_where('tbl_news',array('berita'=>$this->service->anti($this->input->post('deskripsi'))))->result();
			if(count($ckdata)>0){
				$data['inputerror'][]   = 'deskripsi';
				$data['error_string'][] = 'deskripsi berita sudah ada sebelumnya.';
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
			$this->news_model->hapus_by_id($id);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	public function edit_data($id){
		if($this->input->is_ajax_request()){
			$data = $this->news_model->get_by_id($id);
			echo json_encode($data);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_edit(){
		if($this->input->is_ajax_request()){
			$method = "edit";
			$this->_validasi($method);
			$data   = array(
				'oleh'        => $this->session->userdata('kode'),
				'publish'     => '1',
				'tgl_dibuat'  => date("Y-m-d",strtotime($this->input->post('tgl_dibuat'))),
				'tgl_selesai' => date("Y-m-d",strtotime($this->input->post('tgl_selesai'))),
				'berita'      => $this->service->anti(htmlspecialchars($this->input->post('deskripsi')))
			);
			$this->news_model->update(array('id' => $this->service->anti($this->input->post('id'))), $data);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	public function ubah_status($jns=Null,$id=Null){
		if($this->input->is_ajax_request()){
			if($jns=="aktif"){
				$data = array('publish'=>'0');
			}else{
				$data = array('publish'=>'1');
			}
			$this->db->where('id',$this->service->anti($id));
			$this->db->update('tbl_news',$data);
		}else{
			redirect("_404",'refresh');
		}
	}
}
