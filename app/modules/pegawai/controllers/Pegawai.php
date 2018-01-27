<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pegawai extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('pegawai_model');
		$submenu = "Data Pegawai";
		$menu    = "master";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "pegawai";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']            = "master";
		$isi['namamenu']         = "Data Pegawai";
		$isi['page']             = "pegawai";
		$isi['link']             = 'pegawai';
		$isi['actionhapus']      = 'hapus';
		$isi['actionedit']       = 'edit';
		$isi['halaman']          = "Data Pegawai";
		$isi['judul']            = "Halaman Data Pegawai";
		$isi['content']          = "pegawai_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->pegawai_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row   = array();
				$row[] = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/pegawai/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama."'><img src='".base_url()."assets/foto/pegawai/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[] = "<right>" . $rowx->kode . "</right>";
				$row[] = $rowx->nama;
				$row[] = $rowx->email;
				$row[] = $rowx->no_handphone;
				$row[] = '<center><a class="btn btn-xs m-r-5 btn-primary" href="'.base_url().'pegawai/edit/'.$rowx->kode.'" title="Edit Data"
				data-step         ="5"
				data-intro        ="Digunakan untuk mengedit data."
				data-hint         ="Digunakan untuk mengedit data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
				data-step         ="6"
				data-intro        ="Digunakan untuk menghapus data."
				data-hint         ="Digunakan untuk menghapus data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="hapus_data(\'Data Pegawai\',\'pegawai\',\'hapus_data\','."'".$rowx->kode."'".')"><i class="icon-remove icon-white"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->pegawai_model->count_all(),
				"recordsFiltered" => $this->pegawai_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function add(){
		$isi['cek']          = "add";
		$isi['set_pot']      = "";
		$isi['kelas']        = "master";
		$isi['namamenu']     = "Data Pegawai";
		$isi['page']         = "pegawai";
		$isi['link']         = 'pegawai';
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal']  = 'Batal';
		$isi['halaman']      = "Add Data Pegawai";
		$isi['judul']        = "Halaman Add Data Pegawai";
		$isi['content']      = "form_";
		$isi['action']       = "proses_add";
		$ahhhhhh             = $this->db->query("SELECT SUBSTR(MAX(kode),-6) as nona FROM tbl_username")->result();
 		foreach ($ahhhhhh as $zzz) {
 			$xx = substr($zzz->nona, 3, 6);
 		}
 		if($xx==''){
 			$newID = 'P-0001';
 		}else{
			$noUrut = (int) substr($xx, 1, 4);
			$noUrut++;
			$newID  = "P-" . sprintf("%04s", $noUrut);
 		}
		$isi['default']['kode']  = $newID;
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function proses_foto($kode){
		$filename  = 'assets/foto/pegawai/' . $kode . '.jpg';
		$input_con = file_get_contents('php://input');
		$result    = file_put_contents($filename,$input_con);
		$url       = base_url()  . $filename;
	}
	public function proses_add(){
		$this->form_validation->set_rules('kode', 'Kode pegawai', 'htmlspecialchars|trim|required|min_length[1]|max_length[20]|is_unique[tbl_username.kode]');
		$this->form_validation->set_rules('nama', 'Nama pegawai', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('hp', 'No Handphone', 'htmlspecialchars|trim|required|min_length[1]|max_length[15]|is_natural');
		$this->form_validation->set_rules('mail', 'Email', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]|valid_email|is_unique[tbl_username.email]');
		$this->form_validation->set_message('is_unique', '%s sudah ada sebelumnya');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('min_length', '%s minimal %s karakter');
		$this->form_validation->set_message('max_length', '%s maximal %s karakter');
		$this->form_validation->set_message('valid_email', '%s penulisan email tidak valid');
		if ($this->form_validation->run() == TRUE){
			$kode       = $this->service->anti(str_replace(" ", "", $this->input->post('kode')));
			$nama       = $this->service->anti($this->input->post('nama'));
			$hp         = $this->service->anti($this->input->post('hp'));
			$mail       = $this->service->anti($this->input->post('mail'));
			$acak       = rand(00,99);
			$bersih     = $_FILES['foto']['name'];
			$nm         = str_replace(" ","_","$bersih");
			$pisah      = explode(".",$nm);
			$nama_murni = $pisah[0];
			$ubah       = $acak.$nama_murni;
			$nama_fl    = $acak.$nm;
			$tmpName    = $this->service->anti(str_replace(" ", "_", $_FILES['foto']['name']));
			$nmfile     = "file_".time();
			if($tmpName!=''){
				$config['file_name']     = $nmfile;
				$config['upload_path']   = 'assets/foto/pegawai';
				$config['allowed_types'] = 'jpg';
				$config['max_size']      = '1024';
				$config['max_width']     = '0';
				$config['max_height']    = '0';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('foto')){
					$gbr  = $this->upload->data();
					$simpan       = array(
						'kode'          =>$kode,
						'nama'          =>$nama,
						'username'      =>$kode,
						'password'      =>md5($kode),
						'login'         =>'1',
						'level'         =>'1',
						'setting_harga' =>$this->input->post('set_pot'),
						'no_handphone'  =>$hp,
						'email'         =>$mail,
						'foto'          =>$gbr['file_name']
					);
				}else{
					?>
					<script type="text/javascript">
						alert("Pastikan Type File jpg dan ukuran file maksimal 1mb");
						window.location.href="<?php echo base_url();?>pegawai/add";
					</script>
					<?php
				}
			}else{
				$simpan       = array(
					'kode'          =>$kode,
					'nama'          =>$nama,
					'no_handphone'  =>$hp,
					'email'         =>$mail,
					'username'      =>$kode,
					'password'      =>md5($kode),
					'login'         =>'1',
					'level'         =>'1',
					'setting_harga' =>$this->input->post('set_pot'),
					'foto'          =>$kode . ".jpg"
				);
			}
			$this->db->insert('tbl_username',$simpan);
			$out   ="";
	        $smenu = $this->input->post('submenu');
	        for ($i=0; $i < count($smenu) ; $i++) { 
	            $out .= $smenu[$i] . "|";
	        }
	        $in     = "";
	        $smenux = $this->input->post('submenux');
	        for ($ix=0; $ix < count($smenux) ; $ix++) { 
	            $in .= $smenux[$ix] . "|";
	        }
            $dt = array(
                'kode'  =>$kode,
                'menu'  =>$out,
                'menux' =>$in);
            $this->db->insert('tbl_usermenu', $dt);
			redirect('pegawai','refresh');
		}else{
			$this->add();
		}
	}
	public function hapus_data($kode){
		if($this->input->is_ajax_request()){
			$this->hapusfoto($kode);
			$this->pegawai_model->hapus_by_kode($kode);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	function hapusfoto($x=null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('tbl_username',array('kode'=>$x));
			$row    = $ckdata->row();
			$fotona = $row->foto;
			if($fotona!='no.jpg'){
				unlink('./assets/foto/pegawai/' . $fotona);
			}
		}else{
			redirect("_404","refresh");
		}
	}
	public function cekdata($kode=Null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('tbl_username',array('kode'=>$this->service->anti($kode)))->result();
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
		$this->session->set_userdata('kodex',$kode);
		$ckdata = $this->db->get_where('tbl_username',array('kode'=>$kode));
		if(count($ckdata->result())>0){
			$umenu = $this->db->get_where('tbl_usermenu',array('kode'=>$kode))->result();
	        if(count($umenu)>0){
	            foreach ($umenu as $key) {
	                $isi['menunya'] = $key->menu;
	                $isi['submenu'] = $key->menux;
	            }
	        }else{
	            $isi['menunya'] = "";
	            $isi['submenu'] = "";
	        }
			$row                    = $ckdata->row();
			$isi['default']['kode'] = $row->kode;
			$isi['default']['nama'] = $row->nama;
			$isi['default']['mail'] = $row->email;
			$isi['default']['hp']   = $row->no_handphone;
			$isi['foto']            = $row->foto;
			$isi['cek']             = "edit";
			$isi['set_pot']         = $row->setting_harga;
			$isi['kelas']           = "master";
			$isi['namamenu']        = "Data Pegawai";
			$isi['page']            = "pegawai";
			$isi['link']            = 'pegawai';
			$isi['tombolsimpan']    = 'Simpan';
			$isi['tombolbatal']     = 'Batal';
			$isi['halaman']         = "Edit Data Pegawai";
			$isi['judul']           = "Halaman Edit Data Pegawai";
			$isi['content']         = "form_";
			$isi['action']          = "../proses_edit";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
	public function proses_edit(){
		$this->form_validation->set_rules('kode', 'Kode pegawai', 'htmlspecialchars|trim|required|min_length[1]|max_length[20]');
		$this->form_validation->set_rules('nama', 'Nama pegawai', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('hp', 'No Handphone', 'htmlspecialchars|trim|required|min_length[1]|max_length[15]|is_natural');
		$this->form_validation->set_rules('mail', 'Email', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]|valid_email');
		$this->form_validation->set_message('is_unique', '%s sudah ada sebelumnya');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('min_length', '%s minimal %s karakter');
		$this->form_validation->set_message('max_length', '%s maximal %s karakter');
		$this->form_validation->set_message('valid_email', '%s penulisan email tidak valid');
		if ($this->form_validation->run() == TRUE){
			$kode       = $this->service->anti(str_replace(" ", "", $this->input->post('kode')));
			$nama       = $this->service->anti($this->input->post('nama'));
			$hp         = $this->service->anti($this->input->post('hp'));
			$mail       = $this->service->anti($this->input->post('mail'));
			$acak       = rand(00,99);
			$bersih     = $_FILES['foto']['name'];
			$nm         = str_replace(" ","_","$bersih");
			$pisah      = explode(".",$nm);
			$nama_murni = $pisah[0];
			$ubah       = $acak.$nama_murni;
			$nama_fl    = $acak.$nm;
			$set        = $this->input->post('set_pot');
			if($set=='on'){
				$setx = '1';
			}else{
				$setx = '0';
			}
			$tmpName    = $this->service->anti(str_replace(" ", "_", $_FILES['foto']['name']));
			$nmfile     = "file_".time();
			if($tmpName!=''){
				$config['file_name']     = $nmfile;
				$config['upload_path']   = 'assets/foto/pegawai';
				$config['allowed_types'] = 'jpg';
				$config['max_size']      = '1024';
				$config['max_width']     = '0';
				$config['max_height']    = '0';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('foto')){
					$gbr    = $this->upload->data();
					$this->hapusfoto($kode);
					$simpan = array(
						'kode'          =>$kode,
						'nama'          =>$nama,
						'no_handphone'  =>$hp,
						'email'         =>$mail,
						'setting_harga' =>$setx,
						'foto'          =>$gbr['file_name']
					);
				}else{
					?>
					<script type="text/javascript">
						alert("Pastikan Type File jpg dan ukuran file maksimal 1mb");
						window.location.reload();
					</script>
					<?php
				}
			}else{
				$simpan       = array(
					'kode'          =>$kode,
					'nama'          =>$nama,
					'no_handphone'  =>$hp,
					'email'         =>$mail,
					'setting_harga' =>$setx
					// 'foto'          =>$kode . ".jpg"
				);
			}
			$this->db->where('kode',$kode);
			$this->db->update('tbl_username',$simpan);
			$out   ="";
	        $smenu = $this->input->post('submenu');
	        for ($i=0; $i < count($smenu) ; $i++) { 
	            $out .= $smenu[$i] . "|";
	        }
	        $in     = "";
	        $smenux = $this->input->post('submenux');
	        for ($ix=0; $ix < count($smenux) ; $ix++) { 
	            $in .= $smenux[$ix] . "|";
	        }
            $ckdata = $this->db->get_where('tbl_usermenu',array('kode'=>$kode));
	        if(count($ckdata->result())>0){
	            $dt = array(
	                'menu'  =>$out,
	                'menux' =>$in);
	            $this->db->where('kode',$kode);
	            $this->db->update('tbl_usermenu', $dt);     
	        }else{
	            $dt = array(
	                'kode'  =>$kode,
	                'menu'  =>$out,
	                'menux' =>$in);
	            $this->db->insert('tbl_usermenu', $dt);
	        }
			redirect('pegawai','refresh');
		}else{
			$this->add();
		}
	}
	public function detil_pegawai($kode){
		$ckdata = $this->db->get_where('tbl_username',array('kode'=>$kode));
		if(count($ckdata->result())>0){
			$row                 = $ckdata->row();
			$isi['foto']         = $row->foto;
			$isi['kode']  = $kode;
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
			$isi['namamenu']     = "Data Pegawai";
			$isi['page']         = "pegawai";
			$isi['link']         = 'pegawai';
			$isi['actionhapus']  = 'hapus';
			$isi['actionedit']   = 'edit';
			$isi['halaman']      = "Detil Data Pegawai";
			$isi['judul']        = "Halaman Detil Data Pegawai";
			$isi['content']      = "detil_pegawai";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
}
