<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Barang extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('barang_model');
		$this->load->model('barang_detil_model');
		$this->load->library(array('PHPExcel/IOFactory'));
		$submenu = "Data Barang";
		$menu    = "master";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "barang";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']            = "master";
		$isi['namamenu']         = "Data Barang";
		$isi['page']             = "barang";
		$isi['link']             = 'barang';
		$isi['actionhapus']      = 'hapus';
		$isi['actionedit']       = 'edit';
		$isi['halaman']          = "Data Barang";
		$isi['judul']            = "Halaman Data Barang";
		$isi['content']          = "barang_view";
		$isi['option_warna'][''] = "Pilih Warna Barang";
		$cwarna                  = $this->db->get('tbl_warna')->result();
		if(count($cwarna)>0){
			foreach ($cwarna as $key) {
				$isi['option_warna'][$key->id] = $key->warna;
			}
		}else{
			$isi['option_warna'][''] = "Data Warna Belum Tersedia";
		}
		$isi['option_tipe'][''] = "Pilih Tipe Barang";
		$cktipe = $this->db->get('tbl_tipe')->result();
		if(count($cktipe)>0){
			foreach ($cktipe as $row) {
				$isi['option_tipe'][$row->id] = $row->tipe;
			}
		}else{
			$isi['option_tipe'][''] = "Data Tipe Barang Belum Tersedia";
		}
		$isi['option_merk'][''] = "Pilih Data Merk";
		$ckmerk = $this->db->get('tbl_merk')->result();
		if(count($ckmerk)>0){
			foreach ($ckmerk as $roww) {
				$isi['option_merk'][$roww->id] = $roww->merk;
			}
		}else{
			$isi['option_merk'][''] = "Data Merk Belum Tersedia";
		}
		$cktipeX = $this->db->get('tbl_tipe')->result();
		if(count($cktipeX)>0){
			foreach ($cktipeX as $row) {
				$isi['option_tipeX'][$row->id] = $row->tipe;
			}
		}else{
			$isi['option_tipeX'][''] = "Data Tipe Barang Belum Tersedia";
		}
		$ckmerkX = $this->db->get('tbl_merk')->result();
		if(count($ckmerkX)>0){
			foreach ($ckmerkX as $roww) {
				$isi['option_merkX'][$roww->id] = $roww->merk;
			}
		}else{
			$isi['option_merkX'][''] = "Data Merk Belum Tersedia";
		}
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->barang_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row      = array();
				$row[]    = $no . ".";
				$row[]    = "<right>" . $rowx->kode . "</right>";
				$row[]    = $rowx->nama_barang;
				$row[]    = $rowx->tipe;
				$row[]    = $rowx->merk;
				$row[]    = $rowx->total_stok;
				$row[]    = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
				data-step         ="6"
				data-intro        ="Digunakan untuk mengedit data."
				data-hint         ="Digunakan untuk mengedit data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="edit_barang(\'Data Barang\',\'barang\',\'edit_data\','."'".$rowx->kode."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
				data-step         ="7"
				data-intro        ="Digunakan untuk menghapus data."
				data-hint         ="Digunakan untuk menghapus data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="hapus_data(\'Data Barang\',\'barang\',\'hapus_data\','."'".$rowx->kode."'".')"><i class="icon-remove icon-white"></i></a><a data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" href="javascript:void(0)" title="Lihat Detil"
				data-step         ="8"
				data-intro        ="Digunakan untuk melihat detil barang."
				data-hint         ="Digunakan untuk melihat detil barang."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="detil_barang('."'".$rowx->kode."'".',\'barang\',\'barang\','."'".$rowx->kode."'".')"><i class="fa fa-search"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->barang_model->count_all(),
				"recordsFiltered" => $this->barang_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function edit_data($id){
		if($this->input->is_ajax_request()){
			$data = $this->barang_model->get_by_id($id);
			echo json_encode($data);
		}else{
			redirect("_404","refresh");
		}
	}
	public function import(){
		$isi['option_tipe'][''] = "Pilih Tipe Barang";
		$cktipe                 = $this->db->get('tbl_tipe')->result();
		if(count($cktipe)>0){
			foreach ($cktipe as $row) {
				$isi['option_tipe'][$row->id] = $row->tipe;
			}
		}else{
			$isi['option_tipe'][''] = "Data Tipe Barang Belum Tersedia";
		}
		$isi['option_merk'][''] = "Pilih Data Merk";
		$ckmerk                 = $this->db->get('tbl_merk')->result();
		if(count($ckmerk)>0){
			foreach ($ckmerk as $roww) {
				$isi['option_merk'][$roww->id] = $roww->merk;
			}
		}else{
			$isi['option_merk'][''] = "Data Merk Belum Tersedia";
		}
		$isi['kelas']    = "master";
		$isi['namamenu'] = "Data Barang";
		$isi['page']     = "barang";
		$isi['link']     = 'barang';
		$isi['halaman']  = "Import Data Barang";
		$isi['judul']    = "Halaman Import Data Barang";
		$isi['content']  = "form_import";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function add(){
		$isi['jk']           = "";
		$isi['cek']          = "add";
		$isi['kelas']        = "master";
		$isi['namamenu']     = "Data Barang";
		$isi['page']         = "barang";
		$isi['link']         = 'barang';
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal']  = 'Batal';
		$isi['halaman']      = "Add Data Barang";
		$isi['judul']        = "Halaman Add Data Barang";
		$isi['content']      = "form_";
		$isi['action']       = "proses_add";
		$ahhhhhh             = $this->db->query("SELECT SUBSTR(MAX(kode),-6) as nona FROM tbl_barang")->result();
		foreach ($ahhhhhh as $zzz) {
			$xx = substr($zzz->nona, 4, 6);
		}
		if($xx==''){
			$newID = 'B-0001';
		}else{
			$noUrut = (int) substr($xx, 1, 4);
			$noUrut++;
			$newID  = "B-" . sprintf("%04s", $noUrut);
		}
		$isi['default']['kode']  = $newID;
		$isi['option_warna'][''] = "Pilih Warna Barang";
		$cwarna                  = $this->db->get('tbl_warna')->result();
		if(count($cwarna)>0){
			foreach ($cwarna as $key) {
				$isi['option_warna'][$key->id] = $key->warna;
			}
		}else{
			$isi['option_warna'][''] = "Data Warna Belum Tersedia";
		}
		$isi['option_tipe'][''] = "Pilih Tipe Barang";
		$cktipe                 = $this->db->get('tbl_tipe')->result();
		if(count($cktipe)>0){
			foreach ($cktipe as $row) {
				$isi['option_tipe'][$row->id] = $row->tipe;
			}
		}else{
			$isi['option_tipe'][''] = "Data Tipe Barang Belum Tersedia";
		}
		$isi['option_merk'][''] = "Pilih Data Merk";
		$ckmerk                 = $this->db->get('tbl_merk')->result();
		if(count($ckmerk)>0){
			foreach ($ckmerk as $roww) {
				$isi['option_merk'][$roww->id] = $roww->merk;
			}
		}else{
			$isi['option_merk'][''] = "Data Merk Belum Tersedia";
		}
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function proses_add(){
		$this->form_validation->set_rules('kode', 'Kode Barang', 'htmlspecialchars|trim|required|min_length[1]|max_length[20]|is_unique[tbl_barang.kode]');
		$this->form_validation->set_rules('nama', 'Nama Barang', 'htmlspecialchars|trim|required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('tipe', 'Tipe Barang', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('merk', 'Merk Barang', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('tglbeli', 'Tanggal Beli', 'htmlspecialchars|trim|required|min_length[10]|max_length[10]');
		$this->form_validation->set_rules('hrgbeli', 'Harga Beli', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('hrgsusut', 'Biaya Penyusutan', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('hrgsewa', 'Harga Sewa', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_rules('poin', 'Harga Poin', 'htmlspecialchars|trim|required|min_length[1]');
		$this->form_validation->set_message('is_unique', '%s sudah ada sebelumnya');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('min_length', '%s minimal %s karakter');
		$this->form_validation->set_message('max_length', '%s maximal %s karakter');
		$this->form_validation->set_message('valid_email', '%s penulisan email tidak valid');
		if ($this->form_validation->run() == TRUE){
			$kode     = $this->service->anti(str_replace(" ", "", $this->input->post('kode')));
			$nama     = $this->service->anti($this->input->post('nama'));
			$tipe     = $this->service->anti($this->input->post('tipe'));
			$merk     = $this->service->anti($this->input->post('merk'));
			$warna    = $this->service->anti($this->input->post('warna'));
			$tgl      = $this->service->anti($this->input->post('tglbeli'));
			$poin     = $this->service->anti($this->input->post('poin'));
			$tgla     = $this->service->anti(date("Y-m-d",strtotime($tgl)));
			$hrgbeli  = $this->service->anti(str_replace(".", "", $this->input->post('hrgbeli')));
			$hrgsusut = $this->service->anti(str_replace(".", "", $this->input->post('hrgsusut')));
			$hrgsewa  = $this->service->anti(str_replace(".", "", $this->input->post('hrgsewa')));
			$simpan   = array(
				'kode'             =>$kode,
				'poin'             =>$poin,
				'nama_barang'      =>$nama,
				'hrg_sewa'         =>$hrgsewa,
				'id_tipe'          =>$tipe,
				'id_merk'          =>$merk,
				'tgl_beli'         =>$tgla,
				'hrg_beli'         =>$hrgbeli,
				'biaya_penyusutan' =>$hrgsusut,
				'total_stok'       =>'1');
			$this->db->insert('tbl_barang',$simpan);
			if($_FILES["fotona"]["tmp_name"]) {
				$path   = "assets/foto/barang";
				$files  = $_FILES['fotona'];
				$config = array(
					'upload_path'   => $path,
					'allowed_types' =>'jpg',
					'overwrite'     => NULL,
				);
				$this->load->library('upload', $config);
				$images   = array();
				foreach ($files['name'] as $key => $image) {
					$_FILES['multi_images[]']['name']     = $files['name'][$key];
					$_FILES['multi_images[]']['type']     = $files['type'][$key];
					$_FILES['multi_images[]']['tmp_name'] = $files['tmp_name'][$key];
					$_FILES['multi_images[]']['error']    = $files['error'][$key];
					$_FILES['multi_images[]']['size']     = $files['size'][$key];
					$fileName            = $image;
					$images[]            = $fileName;
					$config['file_name'] = $fileName;
					$this->upload->initialize($config);
					if ($this->upload->do_upload('multi_images[]')) {
						$namafoto = str_replace(" ", "_", $files['name'][$key]);
						$warnax   = $this->input->post('warnana')[$key];
						$ckwarna  = $this->db->get_where('tbl_warna',array('warna'=>$warnax))->result();
						foreach ($ckwarna as $keyWarna) {
							$simpanstokbarang = array(
								'kode_barang' =>$kode,
								'id_warna'    =>$keyWarna->id,
								'stok'        =>$this->input->post('stokna')[$key],
								'foto'        =>$namafoto);
							$this->db->insert('tbl_barang_stok',$simpanstokbarang);
						}
						$hitung_stok  = $this->db->query("SELECT SUM(stok) as total_stok FROM tbl_barang_stok WHERE kode_barang = '$kode' GROUP BY kode_barang WITH ROLLUP");
						$rowStok      = $hitung_stok->row();
						$total_stokna = $rowStok->total_stok;
						$update_stok  = array('total_stok'=>$total_stokna);
						$this->db->where('kode',$kode);
						$this->db->update('tbl_barang',$update_stok);
					}
				}
			}
			redirect('barang','refresh');
		}else{
			$this->add();
		}
	}
	public function hapus_data($kode){
		if($this->input->is_ajax_request()){
			$this->barang_model->hapus_by_kode($kode);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	public function hapus_data_detil($id){
		if($this->input->is_ajax_request()){
			$ckkode       = $this->db->get_where('tbl_barang_stok',array('id'=>$id));
			$rowKode      = $ckkode->row();
			$stok_barang  = $rowKode->stok;
			$kode_barang  = $rowKode->kode_barang;
			$hitung_stok  = $this->db->query("SELECT SUM(stok) as total_stok FROM tbl_barang_stok WHERE kode_barang = '$kode_barang' GROUP BY kode_barang WITH ROLLUP");
			$rowStok      = $hitung_stok->row();
			$total_stokna = $rowStok->total_stok - $stok_barang;
			$update_stok  = array('total_stok'=>$total_stokna);
			$this->db->where('kode',$kode_barang);
			$this->db->update('tbl_barang',$update_stok);
			$this->barang_detil_model->hapus_by_id($id);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	function hapusfoto($x=null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('tbl_barang_stok',array('id'=>$x));
			$row    = $ckdata->row();
			$fotona = $row->foto;
			if($fotona!='no.jpg'){
				unlink('./assets/foto/barang/' . $fotona);
			}
		}else{
			redirect("_404","refresh");
		}
	}
	public function cekbarang_all(){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get('view_barang')->result();
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
	public function cekdata($kode=NULL){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_barang',array('kode'=>$kode))->result();
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
	public function cekbarang($tipe,$merk){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_barang',array('id_tipe'=>$tipe,'id_merk'=>$merk))->result();
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
	public function cekbarang_merk($merk){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_barang',array('id_merk'=>$merk))->result();
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
	public function cekbarang_tipe($tipe){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_barang',array('id_tipe'=>$tipe))->result();
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
	public function download_format_stok($tipe=NULL,$merk=NULL){
		$objPHPExcel = new PHPExcel();
		$data   = $this->db->query("
			SELECT
			a.kode as KODE_BARANG,
			a.nama_barang as NAMA_BARANG,
			a.merk as MERK_BARANG,
			a.tipe as TIPE_BARANG,
			a.warna as WARNA_BARANG,
			a.stok as STOK_BARANG
			FROM view_barang_detil a WHERE a.id_merk = '$merk' AND a.id_tipe = '$tipe'");
		$fields = $data->list_fields();
		$col    = 0;
		foreach ($fields as $field){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
        // Mengambil Data
		$row = 2;
		foreach($data->result() as $data){
			$col = 0;
			foreach ($fields as $field){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
				$col++;
			}
			$row++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Form Pengisian Stok Barang');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$nfile = "Form Pengisian Stok Barang.xlsx";
		header('Content-Disposition: attachment;filename="' . $nfile . '"');
		$objWriter->save("php://output");
	}
	public function download_format_stok_tipe($tipe=NULL){
		$objPHPExcel = new PHPExcel();
		$data   = $this->db->query("
			SELECT
			a.kode as KODE_BARANG,
			a.nama_barang as NAMA_BARANG,
			a.merk as MERK_BARANG,
			a.tipe as TIPE_BARANG,
			a.warna as WARNA_BARANG,
			a.stok as STOK_BARANG
			FROM view_barang_detil a WHERE a.id_tipe = '$tipe'");
		$fields = $data->list_fields();
		$col    = 0;
		foreach ($fields as $field){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
        // Mengambil Data
		$row = 2;
		foreach($data->result() as $data){
			$col = 0;
			foreach ($fields as $field){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
				$col++;
			}
			$row++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Form Pengisian Stok Barang');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$nfile = "Form Pengisian Stok Barang.xlsx";
		header('Content-Disposition: attachment;filename="' . $nfile . '"');
		$objWriter->save("php://output");
	}
	public function download_format_stok_merk($merk=NULL){
		$objPHPExcel = new PHPExcel();
		$data   = $this->db->query("
			SELECT
			a.kode as KODE_BARANG,
			a.nama_barang as NAMA_BARANG,
			a.merk as MERK_BARANG,
			a.tipe as TIPE_BARANG,
			a.warna as WARNA_BARANG,
			a.stok as STOK_BARANG
			FROM view_barang_detil a WHERE a.id_merk = '$merk'");
		$fields = $data->list_fields();
		$col    = 0;
		foreach ($fields as $field){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
        // Mengambil Data
		$row = 2;
		foreach($data->result() as $data){
			$col = 0;
			foreach ($fields as $field){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
				$col++;
			}
			$row++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Form Pengisian Stok Barang');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$nfile = "Form Pengisian Stok Barang.xlsx";
		header('Content-Disposition: attachment;filename="' . $nfile . '"');
		$objWriter->save("php://output");
	}
	public function download_format_stok_all(){
		$objPHPExcel = new PHPExcel();
		$data   = $this->db->query("
			SELECT
			a.kode as KODE_BARANG,
			a.nama_barang as NAMA_BARANG,
			a.merk as MERK_BARANG,
			a.tipe as TIPE_BARANG,
			a.warna as WARNA_BARANG,
			a.stok as STOK_BARANG
			FROM view_barang_detil a ");
		$fields = $data->list_fields();
		$col    = 0;
		foreach ($fields as $field){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
        // Mengambil Data
		$row = 2;
		foreach($data->result() as $data){
			$col = 0;
			foreach ($fields as $field){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
				$col++;
			}
			$row++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Form Pengisian Stok Barang');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$nfile = "Form Pengisian Stok Barang.xlsx";
		header('Content-Disposition: attachment;filename="' . $nfile . '"');
		$objWriter->save("php://output");
	}
	public function proses_edit(){
		if($this->input->is_ajax_request()){
			$data = array(
				'id_tipe'          =>$this->input->post('tipeX'),
				'id_merk'          =>$this->input->post('merkX'),
				'poin'             =>$this->input->post('hrgpoin'),
				'tgl_beli'         =>date("Y-m-d",strtotime($this->input->post('tgl_beli'))),
				'hrg_beli'         =>str_replace(".", "", $this->input->post('hrgbeli')),
				'biaya_penyusutan' =>str_replace(".", "", $this->input->post('hrgsusut')),
				'hrg_sewa'         =>str_replace(".", "", $this->input->post('hrgsewa')),
				'nama_barang'      =>$this->service->anti(htmlspecialchars($this->input->post('nama'))));
			$this->barang_model->update(array('kode' => $this->service->anti($this->input->post('id'))), $data);
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	function hapus_foto($x=null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('tbl_barang_stok',array('id'=>$x));
			$row    = $ckdata->row();
			$fotona = $row->foto;
			if($fotona!='no.jpg'){
				unlink('./assets/foto/barang/' . $fotona);
			}
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_edit_stok(){
		if($this->input->is_ajax_request()){
			$data         = array('stok'=>$this->input->post('stokna'),'id_warna' => $this->service->anti(htmlspecialchars($this->input->post('warna'))));
			if(!empty($_FILES['foto']['name'])){
				$this->hapus_foto($this->input->post('id'));
				$upload       = $this->_do_upload();
				$data['foto'] = $upload;
			}
			$this->barang_detil_model->update(array('id' => $this->service->anti($this->input->post('id'))), $data);
			$ckkode       = $this->db->get_where('tbl_barang_stok',array('id'=>$this->input->post('id')));
			$rowKode      = $ckkode->row();
			$kode_barang  = $rowKode->kode_barang;
			$hitung_stok  = $this->db->query("SELECT SUM(stok) as total_stok FROM tbl_barang_stok WHERE kode_barang = '$kode_barang' GROUP BY kode_barang WITH ROLLUP");
			$rowStok      = $hitung_stok->row();
			$total_stokna = $rowStok->total_stok;
			$update_stok  = array('total_stok'=>$total_stokna);
			$this->db->where('kode',$kode_barang);
			$this->db->update('tbl_barang',$update_stok);
			/*Update Stok Barang di Table Barang*/
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_add_stok(){
		if($this->input->is_ajax_request()){
			$kode_barang  = $this->session->userdata('kode_barang');
			$data         = array('kode_barang'=>$kode_barang,'stok'=>$this->input->post('stokna'),'id_warna' => $this->service->anti(htmlspecialchars($this->input->post('warna'))));
			if(!empty($_FILES['foto']['name'])){
				$upload       = $this->_do_upload();
				$data['foto'] = $upload;
			}
			$this->barang_detil_model->simpan($data);
			$hitung_stok  = $this->db->query("SELECT SUM(stok) as total_stok FROM tbl_barang_stok WHERE kode_barang = '$kode_barang' GROUP BY kode_barang WITH ROLLUP");
			$rowStok      = $hitung_stok->row();
			$total_stokna = $rowStok->total_stok;
			$update_stok  = array('total_stok'=>$total_stokna);
			$this->db->where('kode',$kode_barang);
			$this->db->update('tbl_barang',$update_stok);
			/*Update Stok Barang di Table Barang*/
			echo json_encode(array("status" => TRUE));
		}else{
			redirect("_404","refresh");
		}
	}
	private function _do_upload(){
		$pathfile                = $_SERVER['DOCUMENT_ROOT'];
		$config['upload_path']   = $pathfile.'/assets/foto/barang';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = 2000;
		$config['max_width']     = 2000;
		$config['max_height']    = 2000;
		$config['file_name']     = round(microtime(true) * 1000);
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('foto')) {
			$data['inputerror'][]   = 'foto';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('','');
			$data['status']         = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
	public function detil_barang($kode){
		$ckdata = $this->db->get_where('view_barang',array('kode'=>$kode));
		if(count($ckdata->result())>0){
			$this->session->set_userdata('kode_barang',$kode);
			$isi['option_warna'][''] = "Pilih Warna Barang";
			$cwarna                  = $this->db->get('tbl_warna')->result();
			if(count($cwarna)>0){
				foreach ($cwarna as $key) {
					$isi['option_warna'][$key->id] = $key->warna;
				}
			}else{
				$isi['option_warna'][''] = "Data Warna Belum Tersedia";
			}
			$isi['pinjamBulan'] = $this->barang_model->getBarangPerbulan($kode);
			$row                = $ckdata->row();
			$isi['kode']        = $kode;
			$isi['nama']        = $row->nama_barang;
			$isi['tipe']        = $row->tipe;
			$isi['merk']        = $row->merk;
			$isi['poin']        = $row->poin;
			$isi['tglbeli']     = $row->tgl_beli;
			$isi['hrgbeli']     = $row->hrg_beli;
			$isi['hrgsewa']     = $row->hrg_sewa;
			$isi['hrgsusut']    = $row->biaya_penyusutan;
			$isi['stoktot']     = $row->total_stok;
			$isi['kelas']       = "master";
			$isi['namamenu']    = "Data Barang";
			$isi['page']        = "barang";
			$isi['link']        = 'barang';
			$isi['actionhapus'] = 'hapus';
			$isi['actionedit']  = 'edit';
			$isi['halaman']     = "Detil Data Barang";
			$isi['judul']       = "Halaman Detil Data Barang";
			$isi['content']     = "detil_barang";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
	public function getDataDetil(){
		if($this->input->is_ajax_request()){
			$list = $this->barang_detil_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row   = array();
				$row[] = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/barang/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->warna."'><img src='".base_url()."assets/foto/barang/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[] = "<right>" . $rowx->warna . "</right>";
				$row[] = '<center>' . number_format($rowx->stok) . '</center>';
				$row[] = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
				data-step         ="5"
				data-intro        ="Digunakan untuk mengedit data."
				data-hint         ="Digunakan untuk mengedit data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="edit_barang_detil(\'Data Barang\',\'barang\',\'edit_data_detil\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
				data-step         ="6"
				data-intro        ="Digunakan untuk menghapus data."
				data-hint         ="Digunakan untuk menghapus data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="hapus_data(\'Data barang\',\'barang\',\'hapus_data_detil\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->barang_detil_model->count_all(),
				"recordsFiltered" => $this->barang_detil_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function download_format(){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "FORMAT PENGISIAN DATA BARANG ");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Untuk Pengisian Data Tipe Barang, Merk dan Warna di Sesuaikan dengan data yang sudah tersimpan di database");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Format Pengisian Tanggal Beli dd-mm-yyyy ");
		$data_barang  = $this->db->query("SELECT
			a.nama_barang as NAMA_BARANG,
			a.tgl_beli as TGL_BELI,
			a.hrg_beli as HARGA_BELI,
			a.hrg_sewa as HARGA_SEWA,
			a.biaya_penyusutan as BIAYA_SUSUT,
			a.id_tipe as TIPE_BARANG,
			a.id_merk as MERK_BARANG,
			a.poin as POIN
			FROM view_barang a");
		$fields      = $data_barang->list_fields();
		$col         = 0;
		foreach ($fields as $field){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
			$col++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('FORM PENGISIAN DATA BARANG');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$nfile = "FORM PENGISIAN DATA BARANG-MALindoOutdoor.xlsx";
		header('Content-Disposition: attachment;filename="' . $nfile . '"');
		$objWriter->save("php://output");
	}
	public function proses_import(){
		$fileName                = $this->input->post('file', TRUE);
		$config['upload_path']   = './dokumen/';
		$config['file_name']     = $fileName;
		$config['allowed_types'] = 'xlsx';
		$config['max_size']      = 100000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg',
				'<br/><div class=\"alert alert-warning fade in\">
				<font color="red"><b>Ada Kesalahan Dalam Import Data Barang</b></font></div>');
			redirect($_SERVER['HTTP_REFERER']);
		}else {
			$media         = $this->upload->data();
			$inputFileName = 'dokumen/'.$media['file_name'];
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader     = IOFactory::createReader($inputFileType);
				$objPHPExcel   = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			$sheet         = $objPHPExcel->getSheet(0);
			$highestRow    = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			for ($row = 5; $row <= $highestRow; $row++){
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
					NULL,
					TRUE,
					FALSE);
				$cktipe = $this->db->get_where('tbl_tipe',array('tipe'=>$rowData[0][5]));
				if(count($cktipe->result())>0){
					$rowtipe = $cktipe->row();
					$id_tipe = $rowtipe->id;
					$ckmerk  = $this->db->get_where('tbl_merk',array('merk'=>$rowData[0][6]));
					if(count($ckmerk->result())>0){
						$rowMerk = $ckmerk->row();
						$id_merk = $rowMerk->id;
						$ahhhhhh             = $this->db->query("SELECT SUBSTR(MAX(kode),-6) as nona FROM tbl_barang")->result();
						foreach ($ahhhhhh as $zzz) {
							$xx = substr($zzz->nona, 1, 6);
						}
						if($xx==''){
							$newID = 'B-0001';
						}else{
							$noUrut = (int) substr($xx, 1, 4);
							$noUrut++;
							$newID  = "B-" . sprintf("%04s", $noUrut);
						}
						$simpan_barang = array(
							'kode'             =>$newID,
							'nama_barang'      =>$rowData[0][0],
							'tgl_beli'         =>date("Y-m-d",strtotime($rowData[0][1])),
							'hrg_beli'         =>str_replace(".", "", $rowData[0][2]),
							'hrg_sewa'         =>$rowData[0][3],
							'biaya_penyusutan' =>str_replace(".", "", $rowData[0][4]),
							'id_tipe'          =>$id_tipe,
							'id_merk'          =>$id_merk,
							'poin'             =>$rowData[0][7]
						);
						$this->db->insert('tbl_barang',$simpan_barang);
						$ckwarna = $this->db->get('tbl_warna')->result();
						foreach ($ckwarna as $rowWarna) {
							$simpan_stok = array(
								'kode_barang' =>$newID,
								'id_warna'    =>$rowWarna->id,
								'stok'        =>'0',
								'foto'        =>'no.jpg'
							);
							$this->db->insert('tbl_barang_stok',$simpan_stok);
						}
						$this->session->set_flashdata('msg',
							'<br/><div class=\"alert alert-warning fade in\">
							<font color="red"><b>Import Data Barang Berhasil.</b></font></div>');
					}else{
						$this->session->set_flashdata('msg',
							'<br/><div class=\"alert alert-warning fade in\">
							<font color="red"><b>Pengisian Merk Barang tidak ditemukan di database, silahkan edit terlebih dahulu file import Data Barang .</b></font></div>');
					}
				}else{
					$this->session->set_flashdata('msg',
						'<br/><div class=\"alert alert-warning fade in\">
						<font color="red"><b>Pengisian Tipe Barang tidak ditemukan di database, silahkan edit terlebih dahulu file import Data Barang .</b></font></div>');
				}
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function proses_import_stok(){
		$fileName                = $this->input->post('file', TRUE);
		$config['upload_path']   = './dokumen/';
		$config['file_name']     = $fileName;
		$config['allowed_types'] = 'xlsx';
		$config['max_size']      = 100000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg',
				'<br/><div class=\"alert alert-warning fade in\">
				<font color="red"><b>Ada Kesalahan Dalam Import Data Barang</b></font></div>');
			redirect($_SERVER['HTTP_REFERER']);
		}else {
			$media         = $this->upload->data();
			$inputFileName = 'dokumen/'.$media['file_name'];
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader     = IOFactory::createReader($inputFileType);
				$objPHPExcel   = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			$sheet         = $objPHPExcel->getSheet(0);
			$highestRow    = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			for ($row = 1; $row <= $highestRow; $row++){
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
					NULL,
					TRUE,
					FALSE);
				$update_stok = array(
					'stok'          =>$rowData[0][5]
				);
				$ckwarna = $this->db->get_where('tbl_warna',array('warna'=>$rowData[0][4]))->result();
				foreach ($ckwarna as $keyWarna) {
					$idWarna     = $keyWarna->id;
					$kode_barang = $rowData[0][0];
					$this->db->where('kode_barang',$kode_barang);
					$this->db->where('id_warna',$idWarna);
					$this->db->update('tbl_barang_stok',$update_stok);
					$hitung_stok = $this->db->query("SELECT SUM(stok) as total_stok FROM tbl_barang_stok WHERE kode_barang = '$kode_barang' GROUP BY kode_barang WITH ROLLUP");
					$rowStok = $hitung_stok->row();
					$total_stokna = $rowStok->total_stok;
					$update_stok = array('total_stok'=>$total_stokna);
					$this->db->where('kode',$kode_barang);
					$this->db->update('tbl_barang',$update_stok);
				}
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function edit_data_detil($id){
		if($this->input->is_ajax_request()){
			$data = $this->barang_detil_model->get_by_id($id);
			echo json_encode($data);
		}else{
			redirect("_404","refresh");
		}
	}
}
