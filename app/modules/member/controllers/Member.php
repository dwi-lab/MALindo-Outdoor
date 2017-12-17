<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('member_model');
		$submenu = "Data Member";
		$menu    = "master";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "member";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']            = "master";
		$isi['namamenu']         = "Data Member";
		$isi['page']             = "member";
		$isi['link']             = 'member';
		$isi['actionhapus']      = 'hapus';
		$isi['actionedit']       = 'edit';
		$isi['halaman']          = "Data Member";
		$isi['judul']            = "Halaman Data Member";
		$isi['content']          = "member_view";
		$isi['option_kerja'][''] = "Pilih Pekerjaan";
		$ckerja                  = $this->db->get_where('tbl_pekerjaan')->result();
		if(count($ckerja)>0){
			foreach ($ckerja as $key) {
				$isi['option_kerja'][$key->id] = $key->kerja;
			}
		}else{
			$isi['option_kerja'][''] = "Data Pekerjaan Belum Tersedia";
		}
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->member_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row   = array();
				$row[] = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/member/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama."'><img src='".base_url()."assets/foto/member/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[] = "<right>" . $rowx->kode_member . "</right>";
				$row[] = $rowx->nama;
				$row[] = $rowx->alamat;
				$row[] = $rowx->no_handphone;
				$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
				data-step         ="5"
				data-intro        ="Digunakan untuk mengedit data."
				data-hint         ="Digunakan untuk mengedit data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="edit_member('."'".$rowx->kode_member."'".',\'Data Member\',\'member\')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
				data-step         ="6"
				data-intro        ="Digunakan untuk menghapus data."
				data-hint         ="Digunakan untuk menghapus data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="hapus_data(\'Data Member\',\'member\',\'hapus_data\','."'".$rowx->kode_member."'".')"><i class="icon-remove icon-white"></i></a><a data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" href="javascript:void(0)" title="Lihat Detil"
				data-step         ="7"
				data-intro        ="Digunakan untuk melihat detil member."
				data-hint         ="Digunakan untuk melihat detil member."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="detil_member('."'".$rowx->kode_member."'".',\'Member\',\'member\','."'".$rowx->kode_member."'".')"><i class="fa fa-search"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->member_model->count_all(),
				"recordsFiltered" => $this->member_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function add(){
		$isi['jk']           = "";
		$isi['cek']          = "add";
		$isi['kelas']        = "master";
		$isi['namamenu']     = "Data Member";
		$isi['page']         = "member";
		$isi['link']         = 'member';
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal']  = 'Batal';
		$isi['halaman']      = "Add Data Member";
		$isi['judul']        = "Halaman Add Data Member";
		$isi['content']      = "form_";
		$isi['action']       = "proses_add";
		$ahhhhhh             = $this->db->query("SELECT SUBSTR(MAX(kode_member),-6) as nona FROM tbl_member")->result();
 		foreach ($ahhhhhh as $zzz) {
 			$xx = substr($zzz->nona, 3, 6);
 		}
 		if($xx==''){
 			$newID = 'M-0001';
 		}else{
			$noUrut = (int) substr($xx, 1, 4);
			$noUrut++;
			$newID  = "M-" . sprintf("%04s", $noUrut);
 		}
		$isi['default']['kode']  = $newID;
		$isi['option_kerja'][''] = "Pilih Pekerjaan";
		$ckpekerjaan             = $this->db->get('tbl_pekerjaan')->result();
 		if(count($ckpekerjaan)>0){
 			foreach ($ckpekerjaan as $Xxx) {
 				$isi['option_kerja'][$Xxx->id] = $Xxx->kerja;
 			}
 		}else{
 			$isi['option_kerja'][''] = "Data Pekerjaan Belum Tersedia";
 		}
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function proses_foto($kode){
		$filename  = 'assets/foto/member/' . $kode . '.jpg';
		$input_con = file_get_contents('php://input');
		$result    = file_put_contents($filename,$input_con);
		$url       = base_url()  . $filename;
	}
	public function proses_add(){
		$this->form_validation->set_rules('kode', 'Kode Member', 'htmlspecialchars|trim|required|min_length[1]|max_length[20]|is_unique[tbl_member.kode_member]');
		$this->form_validation->set_rules('no_identitas', 'No Identitas', 'htmlspecialchars|trim|required|min_length[1]|max_length[20]|is_unique[tbl_member.no_identitas]');
		$this->form_validation->set_rules('nama', 'Nama Member', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'htmlspecialchars|trim|required|min_length[10]|max_length[10]');
		$this->form_validation->set_rules('almt', 'Alamat', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('kerja', 'Pekerjaan', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('hp', 'No Handphone', 'htmlspecialchars|trim|required|min_length[1]|max_length[15]|is_natural');
		$this->form_validation->set_rules('mail', 'Email', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]|valid_email|is_unique[tbl_member.email]');
		$this->form_validation->set_message('is_unique', '%s sudah ada sebelumnya');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('min_length', '%s minimal %s karakter');
		$this->form_validation->set_message('max_length', '%s maximal %s karakter');
		$this->form_validation->set_message('valid_email', '%s penulisan email tidak valid');
		if ($this->form_validation->run() == TRUE){
			$kode         = $this->service->anti(str_replace(" ", "", $this->input->post('kode')));
			$nama         = $this->service->anti($this->input->post('nama'));
			$tgl          = $this->service->anti($this->input->post('tgllahir'));
			$tgla         = $this->service->anti(date("Y-m-d",strtotime($tgl)));
			$alamat       = $this->service->anti($this->input->post('almt'));
			$jk           = $this->service->anti($this->input->post('jk'));
			$hp           = $this->service->anti($this->input->post('hp'));
			$mail         = $this->service->anti($this->input->post('mail'));
			$kerja        = $this->service->anti($this->input->post('kerja'));
			$no_identitas = $this->service->anti($this->input->post('no_identitas'));
			$simpan       = array(
				'kode_member'  =>$kode,
				'no_identitas' =>$no_identitas,
				'nama'         =>$nama,
				'tgl_lahir'    =>$tgla,
				'jns_kel'      =>$jk,
				'alamat'       =>$alamat,
				'no_handphone' =>$hp,
				'email'        =>$mail,
				'id_kerja'     =>$kerja,
				'tgl_daftar'   =>date("Y-m-d"),
				'foto'         =>$kode . ".jpg");
			$this->db->insert('tbl_member',$simpan);
			redirect('member','refresh');
		}else{
			$this->add();
		}
	}
	public function hapus_data($kode){
		if($this->input->is_ajax_request()){
			$this->hapusfoto($kode);
			$this->member_model->hapus_by_kode_member($kode);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	function hapusfoto($x=null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('tbl_member',array('kode_member'=>$x));
			$row    = $ckdata->row();
			$fotona = $row->foto;
			if($fotona!='no.jpg'){
				unlink('./assets/foto/member/' . $fotona);
			}
		}else{
			redirect("_404","refresh");
		}
	}
	public function cekdata($kode=Null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_member',array('kode_member'=>$this->service->anti($kode)))->result();
			if(count($ckdata)>0){
				$data['say'] = "ok";
			}else{
				$data['say'] = "NotOk";
			}
			if('IS_AJAX'){
				echo json_encode($data);
			}
		}else{
			redirect("_404","refresh");
		}
	}
	public function edit($kode){
		$ckdata = $this->db->get_where('view_member',array('kode_member'=>$kode));
		if(count($ckdata->result())>0){
			$row                                 = $ckdata->row();
			$isi['default']['kode']              = $row->kode_member;
			$isi['default']['nama']              = $row->nama;
			$isi['default']['no_identitas']      = $row->no_identitas;
			$isi['default']['hp']                = $row->no_handphone;
			$isi['default']['almt']              = $row->alamat;
			$isi['default']['mail']              = $row->email;
			$isi['default']['tgllahir']          = date("d-m-Y",strtotime($row->tgl_lahir));
			$isi['jk']                           = $row->jns_kel;
			$isi['option_kerja'][$row->id_kerja] = $row->kerja;
			$isi['foto']                         = $row->foto;
			$isi['cek']                          = "edit";
			$isi['kelas']                        = "master";
			$isi['namamenu']                     = "Data Member";
			$isi['page']                         = "member";
			$isi['link']                         = 'member';
			$isi['tombolsimpan']                 = 'Simpan';
			$isi['tombolbatal']                  = 'Batal';
			$isi['halaman']                      = "Edit Data Member";
			$isi['judul']                        = "Halaman Edit Data Member";
			$isi['content']                      = "form_";
			$isi['action']                       = "../proses_edit";
			$ckpekerjaan                         = $this->db->get('tbl_pekerjaan')->result();
			if(count($ckpekerjaan)>0){
				foreach ($ckpekerjaan as $Xxx) {
					$isi['option_kerja'][$Xxx->id] = $Xxx->kerja;
				}
			}else{
				$isi['option_kerja'][''] = "Data Pekerjaan Belum Tersedia";
			}
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('kode', 'Kode Member', 'htmlspecialchars|trim|required|min_length[1]|max_length[20]');
		$this->form_validation->set_rules('no_identitas', 'No Identitas', 'htmlspecialchars|trim|required|min_length[1]|max_length[20]');
		$this->form_validation->set_rules('nama', 'Nama Member', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'htmlspecialchars|trim|required|min_length[10]|max_length[10]');
		$this->form_validation->set_rules('almt', 'Alamat', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('kerja', 'Pekerjaan', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('hp', 'No Handphone', 'htmlspecialchars|trim|required|min_length[1]|max_length[15]|is_natural');
		$this->form_validation->set_rules('mail', 'Email', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]|valid_email');
		$this->form_validation->set_message('is_unique', '%s sudah ada sebelumnya');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('min_length', '%s minimal %s karakter');
		$this->form_validation->set_message('max_length', '%s maximal %s karakter');
		$this->form_validation->set_message('valid_email', '%s penulisan email tidak valid');
		if ($this->form_validation->run() == TRUE){
			$kode         = $this->service->anti(str_replace(" ", "", $this->input->post('kode')));
			$nama         = $this->service->anti($this->input->post('nama'));
			$tgl          = $this->service->anti($this->input->post('tgllahir'));
			$tgla         = $this->service->anti(date("Y-m-d",strtotime($tgl)));
			$alamat       = $this->service->anti($this->input->post('almt'));
			$jk           = $this->service->anti($this->input->post('jk'));
			$hp           = $this->service->anti($this->input->post('hp'));
			$mail         = $this->service->anti($this->input->post('mail'));
			$kerja        = $this->service->anti($this->input->post('kerja'));
			$no_identitas = $this->service->anti($this->input->post('no_identitas'));
			$simpan       = array(
				'no_identitas' =>$no_identitas,
				'nama'         =>$nama,
				'tgl_lahir'    =>$tgla,
				'jns_kel'      =>$jk,
				'alamat'       =>$alamat,
				'no_handphone' =>$hp,
				'email'        =>$mail,
				'id_kerja'     =>$kerja,
				'tgl_daftar'   =>date("Y-m-d"),
				'foto'         =>$kode . ".jpg");
			$this->db->where('kode_member',$kode);
			$this->db->update('tbl_member',$simpan);
			redirect('member','refresh');
		}else{
			$this->edit($this->input->post('kode'));
		}
	}
	public function detil_member($kode){
		$ckdata = $this->db->get_where('view_member',array('kode_member'=>$kode));
		if(count($ckdata->result())>0){
			$row                 = $ckdata->row();
			$isi['foto']         = $row->foto;
			$isi['kode_member']  = $kode;
			$isi['no_identitas'] = $row->no_identitas;
			$isi['nama']         = $row->nama;
			$isi['almt']         = $row->alamat;
			$isi['mail']         = $row->email;
			$isi['jk']           = $row->jns_kel;
			$isi['kerja']        = $row->kerja;
			$isi['hp']           = $row->no_handphone;
			$isi['tgllahir']     = $row->tgl_lahir;
			$isi['tgldaftar']    = $row->tgl_daftar;
			$isi['umur']         = $this->service->umur(date("d-m-Y",strtotime($row->tgl_lahir)));
			$isi['kelas']        = "master";
			$isi['namamenu']     = "Data Member";
			$isi['page']         = "member";
			$isi['link']         = 'member';
			$isi['actionhapus']  = 'hapus';
			$isi['actionedit']   = 'edit';
			$isi['halaman']      = "Detil Data Member";
			$isi['judul']        = "Halaman Detil Data Member";
			$isi['content']      = "detil_member";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
}
