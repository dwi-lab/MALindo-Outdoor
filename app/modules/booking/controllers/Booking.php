<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Booking extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('booking_model');
		$this->load->library(array('PHPExcel/IOFactory'));
		$submenu = "Booking";
		$menu    = "transaksi";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "booking";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']            = "transaksi";
		$isi['namamenu']         = "Booking";
		$isi['page']             = "booking";
		$isi['link']             = 'booking';
		$isi['halaman']          = "Data Booking";
		$isi['judul']            = "Halaman Data Booking";
		$isi['content']          = "booking_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->booking_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row      = array();
				$row[]    = $no . ".";
				$row[]    = "<right>" . $rowx->kode . "</right>";
				$row[]    = $rowx->nama_booking;
				$row[]    = $rowx->tipe;
				$row[]    = $rowx->merk;
				$row[]    = $rowx->total_stok;
				$row[]    = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
				data-step         ="6"
				data-intro        ="Digunakan untuk mengedit data."
				data-hint         ="Digunakan untuk mengedit data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="edit_booking(\'Booking\',\'booking\',\'edit_data\','."'".$rowx->kode."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
				data-step         ="7"
				data-intro        ="Digunakan untuk menghapus data."
				data-hint         ="Digunakan untuk menghapus data."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="hapus_data(\'Booking\',\'booking\',\'hapus_data\','."'".$rowx->kode."'".')"><i class="icon-remove icon-white"></i></a><a data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" href="javascript:void(0)" title="Lihat Detil"
				data-step         ="8"
				data-intro        ="Digunakan untuk melihat detil booking."
				data-hint         ="Digunakan untuk melihat detil booking."
				data-hintPosition ="top-middle"
				data-position     ="bottom-right-aligned"
				onclick="detil_booking('."'".$rowx->kode."'".',\'booking\',\'booking\','."'".$rowx->kode."'".')"><i class="fa fa-search"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->booking_model->count_all(),
				"recordsFiltered" => $this->booking_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function cekLama($mulai,$selesai){
		if($mulai !="" && $selesai != ""){
			$mulai   = $this->service->anti(date("Y-m-d",strtotime($mulai)));
			$selesai = $this->service->anti(date("Y-m-d",strtotime($selesai)));
			$startx  = new DateTIme($mulai);
			$endx    = new DateTime($selesai);
			$lama    = $endx->diff($startx);
			$lama    = $lama->format("%d")+0;
			$cklama  = $this->db->get_where('tbl_disc',array('durasi'=>$lama));
			if(count($cklama->result())>0){
				$row = $cklama->row();
				$lamana = $row->durasi;
				$diskon = $row->disc;
				echo $lamana . "|" . $diskon;
			}else{
				echo "NotOk";
			}
		}else{
			echo "NotOk";
		}
	}
	public function add(){
		$isi['option_warna'][''] = "Pilih Warna Barang";
		$cwarna                  = $this->db->get('tbl_warna')->result();
		if(count($cwarna)>0){
			foreach ($cwarna as $key) {
				$isi['option_warna'][$key->id] = $key->warna;
			}
		}else{
			$isi['option_warna'][''] = "Data Warna Belum Tersedia";
		}
		$isi['jk']           = "";
		$isi['cek']          = "add";
		$isi['kelas']        = "transaksi";
		$isi['namamenu']     = "Booking";
		$isi['page']         = "barang";
		$isi['link']         = 'barang';
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal']  = 'Batal';
		$isi['halaman']      = "Add Booking";
		$isi['judul']        = "Halaman Add Booking";
		$isi['content']      = "form_";
		$isi['action']       = "proses_add";
		$tahun               = date("my");
		$query               = $this->db->query("SELECT MAX(kode_booking) as nona FROM tbl_booking WHERE RIGHT(kode_booking,4) = '$tahun'")->result();
		if(count($query)>0){
			foreach ($query as $zzz) {
	 			$xx = substr($zzz->nona, 1, 3); 
	 		}
	 		if($xx==''){
	 			$newID = "001-BO-MAL-" . $tahun;
	 		}else{
	 			$noUrut = (int) substr($xx, 1, 3);
	 			$noUrut++;
	 			$newID = sprintf("%03s", $noUrut) . "-BO-MAL-" . $tahun;
	 		}
		}else{
			$newID = "001-BO-MAL-" . $tahun;
		}
		$isi['default']['kode']  = $newID;
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function get_member(){
		if($this->input->is_ajax_request()){
			$keyword          = $this->service->anti($this->input->post('term'));
			$data['response'] = 'false';
			$cari_member      = $this->db->query("SELECT a.kode_member,a.nama,a.foto,a.no_handphone,a.no_identitas,a.alamat FROM view_member a WHERE a.kode_member LIKE '$keyword%' OR a.nama LIKE '$keyword%' OR a.no_identitas LIKE '$keyword%' OR a.no_handphone LIKE '$keyword%' ORDER BY a.nama ASC")->result();
			if( ! empty($cari_member) ){
				$data['response']  = 'true';
				$data['message']   = array();
				foreach ($cari_member as $row) {
					$kode              = $row->kode_member;
					$ckbooking = $this->db->get_where('tbl_booking',array('kode_member'=>$kode))->result();
					if(count($ckbooking)>0){
						foreach ($ckbooking as $xxx) {
							$status_booking = $xxx->status_booking;
							if($status_booking == 1){
								$data['message'][] = array(
										'id'            => $row->kode_member,
										'value'         => $row->nama . " | " . $row->kode_member,
										'dir'           => 'member',
										'nama'          => $row->nama,
										'no_handphone'  => $row->no_handphone,
										'no_identitas'  => $row->no_identitas,
										'kode'          => $row->kode_member,
										'alamat'        => $row->alamat,
										'status_pinjam' => "Member bersangkutan sudah melakukan booking sebelumnya namun belum di proses",
										'status_warna'  =>'3',
										'foto'          => $row->foto);
							}else{
								$data['message'][] = array(
									'id'            => $row->kode_member,
									'value'         => $row->nama . " | " . $row->kode_member,
									'dir'           => 'member',
									'nama'          => $row->nama,
									'no_handphone'  => $row->no_handphone,
									'no_identitas'  => $row->no_identitas,
									'kode'          => $row->kode_member,
									'alamat'        => $row->alamat,
									'status_pinjam' => "Silahkan Masukan Kode Barang yang akan di Booking.",
									'status_warna'  =>'1',
									'foto'          => $row->foto);
							}
						}
					}else{
						$ckbarang          = $this->db->query("SELECT * FROM tbl_transaksi WHERE kode_member = '$kode'")->result();
						if(count($ckbarang)>0){
							foreach ($ckbarang as $key) {
								$status = $key->status;
								if($status==9){
									$data['message'][] = array(
										'id'            => $row->kode_member,
										'value'         => $row->nama . " | " . $row->kode_member,
										'dir'           => 'member',
										'nama'          => $row->nama,
										'no_handphone'  => $row->no_handphone,
										'no_identitas'  => $row->no_identitas,
										'kode'          => $row->kode_member,
										'alamat'        => $row->alamat,
										'status_pinjam' => "Silahkan Masukan Kode Barang yang akan di Booking.",
										'status_warna'  =>'1',
										'foto'          => $row->foto);
								}elseif ($status==1) {
									$data['message'][] = array(
										'id'            => $row->kode_member,
										'value'         => $row->nama . " | " . $row->kode_member,
										'dir'           => 'member',
										'nama'          => $row->nama,
										'no_handphone'  => $row->no_handphone,
										'no_identitas'  => $row->no_identitas,
										'kode'          => $row->kode_member,
										'alamat'        => $row->alamat,
										'status_pinjam' => "Ada Barang yang sudah di pinjam oleh member bersangkutan namun barang tersebut belum diambil.",
										'status_warna'  =>'2',
										'foto'          => $row->foto);
								}else{
									$kode_transaksi = $key->kode_transaksi;
									$ckpengembalian = $this->db->get_where('tbl_pengembalian',array('kode_transaksi'=>$kode_transaksi));
									if(count($ckpengembalian->result())>0){
										$data['message'][] = array(
											'id'            => $row->kode_member,
											'value'         => $row->nama . " | " . $row->kode_member,
											'dir'           => 'member',
											'nama'          => $row->nama,
											'no_handphone'  => $row->no_handphone,
											'no_identitas'  => $row->no_identitas,
											'kode'          => $row->kode_member,
											'alamat'        => $row->alamat,
											'status_pinjam' => "Silahkan Masukan Kode Barang yang akan di Booking.",
											'status_warna'  =>'1',
											'foto'          => $row->foto);
									}else{
										$data['message'][] = array(
											'id'            => $row->kode_member,
											'value'         => $row->nama . " | " . $row->kode_member,
											'dir'           => 'member',
											'nama'          => $row->nama,
											'no_handphone'  => $row->no_handphone,
											'no_identitas'  => $row->no_identitas,
											'kode'          => $row->kode_member,
											'alamat'        => $row->alamat,
											'status_pinjam' => "Ada Barang yang sudah dipinjam oleh member bersangkutan namun barang tersebut belum dikembalikan",
											'status_warna'  =>'3',
											'foto'          => $row->foto);
									}
								}
							}
						}else{
							$data['message'][] = array(
								'id'            => $row->kode_member,
								'value'         => $row->nama . " | " . $row->kode_member,
								'dir'           => 'member',
								'nama'          => $row->nama,
								'no_handphone'  => $row->no_handphone,
								'no_identitas'  => $row->no_identitas,
								'kode'          => $row->kode_member,
								'alamat'        => $row->alamat,
								'status_pinjam' => "Silahkan Masukan Kode Barang yang akan di Booking.",
								'status_warna'  =>'1',
								'foto'          => $row->foto);
						}
					}
				}
			}else{
				$data['response'] = 'false';
			}
			if('IS_AJAX'){
	            echo json_encode($data);
	        }
	    }else{
	    	redirect('_404','refresh');
	    }
	}
	public function getBarang($kode,$warna){
		if($this->input->is_ajax_request()){
			$warna = $this->service->anti($warna);
			$ckinfobarang = $this->db->query("SELECT * FROM view_barang_detil WHERE kode = '$kode' AND id_warna = '$warna'")->result();
			if(count($ckinfobarang)>0){
				foreach ($ckinfobarang as $key) {
					echo $key->stok . "|" . $key->warna . "|" . $key->foto;
				}
			}else{
				echo "NotOk";
			}
		}else{
	    	redirect('_404','refresh');
	    }
	}
	public function cekDiskon(){
		if($this->input->is_ajax_request()){
			$now    = date("Y-m-d");
			$diskon = $this->db->query("SELECT * FROM tbl_disc_momen WHERE tgl_mulai <= '$now' AND tgl_selesai >= '$now'")->result();
			if(count($diskon)>0){
				foreach ($diskon as $key) {
					echo $key->diskon . "|" . "Diskon Momen : " . $key->nama_diskon . " dari tanggal " . date("d-m-Y",strtotime($key->tgl_mulai)) . " s/d " . date("d-m-Y",strtotime($key->tgl_selesai));
				}
			}else{
				echo "NotOk";				
			}
		}else{
	    	redirect('_404','refresh');
	    }
	}
	public function get_barang(){
		if($this->input->is_ajax_request()){
			$keyword          = $this->service->anti($this->input->post('term'));
			$data['response'] = 'false';
			$cari_member      = $this->db->query("SELECT a.kode,a.nama_barang,a.hrg_sewa FROM view_barang a WHERE kode LIKE '$keyword%' OR nama_barang LIKE '$keyword' ORDER BY a.nama_barang ASC")->result();
			if( ! empty($cari_member) ){
				$data['response']  = 'true';
				$data['message']   = array();
				foreach ($cari_member as $row) {
					$data['message'][] = array(
						'id'            => $row->kode,
						'value'         => $row->nama_barang . " | " . $row->kode,
						'nama'          => $row->nama_barang,
						'kode'          => $row->kode,
						'harga'         => number_format($row->hrg_sewa));
				}
			}else{
				$data['response'] = 'false';
			}
			if('IS_AJAX'){
	            echo json_encode($data);
	        }
	    }else{
	    	redirect('_404','refresh');
	    }
	}
	public function proses_add(){
		$kode_booking  = $this->input->post('kode_booking');
		$info_member   = $this->input->post('nama');
		$pch           = explode("|", $info_member);
		$kode_member   = $pch[1];
		$nama_barangna = $this->input->post('nama_barangna');
		for ($i=0; $i < $nama_barangna ; $i++) { 
			$ckkodebarang = $this->db->get_where('tbl_barang',array('nama_barang'=>$nama_barangna[$i]));
			$row          = $ckkodebarang->row();
			$kode_barang  = $row->kode;
			$warna        = $this->input->post('warnana');
			$ckwarna      = $this->db->get_where('view_barang_detil',array('warna'=>$warna[$i],'kode'=>$kode_barang));
			$rowWarna     = $ckwarna->row();
			$kode_warna   = $rowWarna->id_warna;
		}
	}
}
