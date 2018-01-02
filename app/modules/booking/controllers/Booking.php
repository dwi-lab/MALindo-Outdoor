<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Booking extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('booking_model');
		$this->load->model('booking_detil_model');
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
				$row   = array();
				$row[] = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/member/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama."'><img src='".base_url()."assets/foto/member/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[] = "<right>" . $rowx->kode_booking . "</right>";
				$row[] = $rowx->nama;
				$row[] = date("d-m-Y",strtotime($rowx->tgl_booking));
				$row[] = date("d-m-Y",strtotime($rowx->tgl_perencanaan_sewa));
				$row[] = date("d-m-Y",strtotime($rowx->tgl_selesai));
				$row[] = number_format($rowx->lama);
				$row[] = $rowx->status_booking ? '<center><a href="javascript:void(0)"
					data-step         ="4"
					data-intro        ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hint         ="Digunakan untuk mengaktifkan atau menonaktifkan data."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					onclick="rbstatus(\'aktif\',\'Booking\',\'booking\','."'".$rowx->kode_booking."'".')" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Sedang Dalam Proses">InProses</a>' : '<center><a href="javascript:void(0)" onclick="rbstatus(\'inaktif\',\'Booking\',\'booking\','."'".$rowx->kode_booking."'".')" data-toggle="tooltip" class="btn disable btn-xs m-r-5 btn-danger" title="Batal Booking">Batal Booking</a>';
				$row[]  = '<center><div class="btn-group m-r-5 m-b-5">
								<a href="javascript:;" data-toggle="dropdown" class="btn btn-xs m-r-5 btn-info dropdown-toggle">Action <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="javascript:;" onclick="detil_booking('."'".$rowx->kode_booking."'".',\'Booking\',\'booking\','."'".$rowx->kode_booking."'".')">Lihat Detil</a></li>
									<li><a href="javascript:;">Lihat Nota</a></li>
									<li class="divider"></li>
									<li><a href="javascript:;">Hapus Booking</a></li>
								</ul>
							</div></center>';
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
	public function getDataDetil(){
		if($this->input->is_ajax_request()){
			$list = $this->booking_detil_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row   = array();
				$row[] = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/barang/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama_barang."'><img src='".base_url()."assets/foto/barang/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[] = $rowx->kode_barang;
				$row[] = $rowx->nama_barang;
				$row[] = $rowx->warna;
				$row[] = number_format($rowx->hrg_sewa);
				$row[] = number_format($rowx->qty);
				$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data" 
					onclick="edit_data(\'Data Booking Barang\',\'booking\',\'edit_data_barang\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data" 
					onclick="hapus_data(\'Data Booking Barang\',\'booking\',\'hapus_data_barang\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->booking_detil_model->count_all(),
				"recordsFiltered" => $this->booking_detil_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function cekdata($kode=Null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_booking',array('kode_booking'=>$this->service->anti($kode)))->result();
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
	public function detil_booking($kode){
		$ckdata = $this->db->get_where('view_booking',array('kode_booking'=>$kode));
		if(count($ckdata->result())>0){
			$this->session->set_userdata('kode_booking',$kode);
			$cksetpoin             = $this->db->get('tbl_set_poin');
			$x                     = $cksetpoin->row();
			$isi['harga_poin']     = $x->nominal;
			$row                   = $ckdata->row();
			$isi['foto_identitas'] = $row->foto_identitas;
			$isi['foto']           = $row->foto;
			$isi['kode_member']    = $row->kode_member;
			$isi['no_identitas']   = $row->no_identitas;
			$isi['nama']           = $row->nama;
			$isi['almt']           = $row->alamat;
			$isi['mail']           = $row->email;
			$isi['jk']             = $row->jns_kel;
			$isi['kerja']          = $row->kerja;
			$isi['hp']             = $row->no_handphone;
			$isi['tgllahir']       = $row->tgl_lahir;
			$isi['tgldaftar']      = $row->tgl_daftar;
			$isi['provinsi']       = $row->provinsi;
			$isi['kota']           = $row->kota;
			$isi['kecamatan']      = $row->kecamatan;
			$isi['kelurahan']      = $row->kelurahan;
			$isi['umur']           = $this->service->umur(date("d-m-Y",strtotime($row->tgl_lahir)));
			$isi['kelas']          = "transaksi";
			$isi['namamenu']       = "Booking";
			$isi['page']           = "booking";
			$isi['link']           = 'booking';
			$isi['actionhapus']    = 'hapus';
			$isi['actionedit']     = 'edit';
			$isi['halaman']        = "Detil Data Booking";
			$isi['judul']          = "Halaman Detil Data Booking";
			$isi['content']        = "detil_booking";
			$kode                  = $this->service->anti($kode);
			$isi['kode_booking']   = $kode;
			$ckbooking             = $this->db->get_where('tbl_booking',array('kode_booking'=>$kode));
			if(count($ckbooking->result())>0){
				$row                   = $ckbooking->row();
				$isi['lama']           = $row->lama;
				$isi['poin_bayar']     = $row->poin_bayar;
				$isi['poin_bayar']     = $row->poin_bayar;
				$isi['status_booking'] = $row->status_booking;
				$kode_member           = $row->kode_member;
				$jns_bayar             = $row->jns_bayar;
				if($jns_bayar==2){
					$ckhargapoin = $this->db->get('tbl_set_poin');
					$xx = $ckhargapoin->row();
					$isi['jns_bayar']   = "Poin";
					$dibayar            = number_format($row->poin_bayar * $xx->nominal);
					$isi['total_bayar'] = $row->poin_bayar * $xx->nominal + $row->dibayar;
					if($row->dibayar!="" || $row->dibayar!=NULL){
						$isi['status']      = number_format($row->poin_bayar) . " poin" . " + " . number_format($row->dibayar);
					}else{
						$isi['status']      = number_format($row->poin_bayar) . " poin";
					}
				}else{
					$isi['total_bayar'] = $row->dibayar;
					$isi['jns_bayar']   = "Cash";
					$isi['status']      = "";
				}
				$diskon_momen = $row->disc_momen;
				$cekDiskonmomen = $this->db->get_where('tbl_disc_momen',array('id'=>$diskon_momen));
				if(count($cekDiskonmomen->result())>0){
					$rowDisc_m = $cekDiskonmomen->row();
					$disc_m                   = $rowDisc_m->diskon;
					$isi['diskon_momen']      = $rowDisc_m->diskon;
					$isi['nama_diskon_momen'] = $rowDisc_m->nama_diskon;
				}else{
					$disc_m                   = "0";
					$isi['diskon_momen']      = "0";
					$isi['nama_diskon_momen'] = "";
				}
				$diskonpinjam   = $row->disc_pinjam;
				$ckdiskonpinjam = $this->db->get_where('tbl_disc',array('id'=>$diskonpinjam));
				if(count($ckdiskonpinjam->result())>0){
					$rowDisc_p                 = $ckdiskonpinjam->row();
					$disc_p                    = $rowDisc_p->disc;
					$isi['diskon_pinjam']      = $rowDisc_p->disc;
					$isi['nama_diskon_pinjam'] = "Lama Pinjam " . number_format($rowDisc_p->durasi) . " hari";
				}else{
					$isi['diskon_pinjam']      = "0";
					$disc_p                    = "0";
					$isi['nama_diskon_pinjam'] = "";
				}
				$isi['sisa_bayar']        = $row->sisa_bayar;
				$isi['subtotal']          = $row->subtotal;
				$isi['tot_diskon_pinjam'] = $row->subtotal * $disc_p  / 100;
				$isi['tot_diskon_momen']  = $row->subtotal * $disc_m  / 100;
				$isi['tgl_mulai']         = date("d-m-Y",strtotime($row->tgl_perencanaan_sewa));
				$isi['tgl_selesai']       = date("d-m-Y",strtotime($row->tgl_selesai));
				$isi['tgl_booking']       = date("d-m-Y H:i:s",strtotime($row->tgl_booking));
				$ckmember                 = $this->db->get_where('view_member',array('kode_member'=>$kode_member));
				if(count($ckmember->result())>0){
					$key                    = $ckmember->row();
					$isi['nama_member']     = $key->nama;
					$isi['email_member']    = $key->email;
					$isi['alamat_member']   = $key->alamat;
					$isi['tlp_member']      = $key->no_handphone;
					$isi['alamat_detil']    = ucwords($key->kecamatan) . " , " . ucwords($key->kota);
				}else{
					redirect('_404','refresh');
				}
			}else{
				redirect('_404','refresh');
			}
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
	public function cekPoint($id){
		if($this->input->is_ajax_request()){
			$no_identitas = $this->service->anti($id);
			$cekpoin      = $this->db->query("SELECT * FROM tbl_histori_poin WHERE kode_member = '$id'")->result();
			if(count($cekpoin)>0){
				foreach ($cekpoin as $key) {
					echo $key->jml_poin;
				}
			}else{
				echo "NotOk";
			}
		}else{
	    	redirect('_404','refresh');
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
			if($lama >= '8'){
				echo $lama . "|" . "50";
			}else{
				$cklama  = $this->db->get_where('tbl_disc',array('durasi'=>$lama));
				if(count($cklama->result())>0){
					$row = $cklama->row();
					$lamana = $row->durasi;
					$diskon = $row->disc;
					echo $lama . "|" . $diskon . "|" . $row->id;
				}else{
					echo "NotOk";
				}
			}
		}else{
			echo "NotOk";
		}
	}
	public function bayarPoin($kode,$poin){
		if($this->input->is_ajax_request()){
			$ckpoint   = $this->db->get_where('tbl_histori_poin',array('kode_member'=>$kode));
			$key       = $ckpoint->row();
			$jml       = $key->jml_poin;
			$cksetpoin = $this->db->get_where('tbl_set_poin',array('id'=>'1'));
			$row       = $cksetpoin->row();
			$nominal   = $row->nominal;
			if($jml >= $poin){
				$total = 0;
				$total = $nominal * $poin;
				echo $total;
			}else{
				echo "NotOk";
			}
		}else{
			redirect('_404','refresh');
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
					echo $key->diskon . "|" . "Diskon Momen : " . $key->nama_diskon . " dari tanggal " . date("d-m-Y",strtotime($key->tgl_mulai)) . " s/d " . date("d-m-Y",strtotime($key->tgl_selesai)) . "|" . $key->id;
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
		$kode_booking  = $this->input->post('kode');
		$info_member   = $this->input->post('nama');
		$b_point       = "";
		$pch           = explode("|", $info_member);
		$kode_member   = str_replace(" ", "", $pch[1]);
		$jns           = $this->input->post('jns_bayar');
		$now           = date("Y-m-d H:i:s");
		$mulai         = $this->service->anti(date("Y-m-d",strtotime($this->input->post('tglsewa'))));
		$selesai       = $this->service->anti(date("Y-m-d",strtotime($this->input->post('tglselesai'))));
		$total_bayar   = str_replace(".", "", $this->input->post('subtotal_'));
		$lama          = $this->input->post('lama_pinjam');
		$id_disc_lama  = $this->input->post('id_disc_lama');
		$id_disc_momen = $this->input->post('id_disc_momen');
		$subtotal      = str_replace(".", "", $this->input->post('subtotal_x'));
		if($jns==1){
/*Cash*/
			$dibayar       = str_replace(".", "", $this->input->post('b_cash'));
			$sisa          = $total_bayar - $dibayar;
			if($dibayar    >= $total_bayar){
				$sesa          = "0";
			}else{
				$sesa          = $total_bayar - $dibayar;
			}
			if($id_disc_lama !="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'1',
					'status_booking'       =>'1');
			}else if($id_disc_lama !="" && $id_disc_momen ==""){
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'1',
					'status_booking'       =>'1');
			}else if($id_disc_lama =="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'1',
					'status_booking'       =>'1');
			}else{
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'1',
					'status_booking'       =>'1');
			}
			$this->db->insert('tbl_booking',$simpanbooking);
		}else{
/*Poin*/
			$total_bayar = str_replace(".", "", $this->input->post('sisa_bayar_p'));
			$b_point     = $this->input->post('b_point');
			$dibayar     = str_replace(".", "", $this->input->post('b_sisa'));
			$sisa        = $total_bayar - $dibayar;
			if($dibayar >= $total_bayar){
				$sesa = "0";
			}else{
				$sesa = $total_bayar - $dibayar;
			}
			if($id_disc_lama !="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'2',
					'status_booking'       =>'1');
			}else if($id_disc_lama !="" && $id_disc_momen ==""){
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'2',
					'status_booking'       =>'1');
			}else if($id_disc_lama =="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'2',
					'status_booking'       =>'1');
			}else{
				$simpanbooking = array(
					'kode_booking'         =>$kode_booking,
					'kode_member'          =>$kode_member,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'2',
					'status_booking'       =>'1');
			}
			$this->db->insert('tbl_booking',$simpanbooking);
			$ckpointmember      = $this->db->get_where('tbl_histori_poin',array('kode_member'=>$kode_member));
			$rowPoin            = $ckpointmember->row();
			$jml_poin           = $rowPoin->jml_poin;
			$hitungpoin         = $jml_poin - $b_point;
			$update_pointmember = array('jml_poin'=>$hitungpoin);
			$this->db->where('kode_member',$kode_member);
			$this->db->update('tbl_histori_poin',$update_pointmember);
		}
		$nama_barangna      = $this->input->post('nama_barangna');
		$x                  = count($nama_barangna);
		for ($i=0; $i < $x ; $i++) {
			$ckkodebarang = $this->db->get_where('tbl_barang',array('nama_barang'=>$nama_barangna[$i]))->result();
			foreach ($ckkodebarang as $row) {
				$kode_barang  = $row->kode;
				$warna        = $this->input->post('warnana');
				$ckwarna      = $this->db->get_where('view_barang_detil',array('warna'=>$warna[$i],'kode'=>$kode_barang));
				$rowWarna     = $ckwarna->row();
				$kode_warna   = $rowWarna->id_warna;
				$simpandetil = array(
					'kode_booking' =>$kode_booking,
					'kode_barang'  =>$kode_barang,
					'kode_warna'   =>$kode_warna,
					'qty'          =>$this->input->post('qtyna')[$i],
					'status'       =>'1');
				$this->db->insert('tbl_booking_detil',$simpandetil);
				$cekstok = $this->db->get_where('tbl_barang_stok',array('kode_barang'=>$kode_barang,'id_warna'=>$kode_warna))->result();
				foreach ($cekstok as $key) {
					$stok_awal = $key->stok;
					$kurang    = $stok_awal - $this->input->post('qtyna')[$i];
					$update_stok = array('stok'=>$kurang);
					$this->db->where('kode_barang',$kode_barang);
					$this->db->where('id_warna',$kode_warna);
					$this->db->update('tbl_barang_stok',$update_stok);
				}
			}
		}
		redirect('booking/invoice/' . $kode_booking,'refresh');
	}
	public function invoice($kode_booking){
		$kode                = $this->service->anti($kode_booking);
		$isi['kode_booking'] = $kode;
		$ckbooking           = $this->db->get_where('tbl_booking',array('kode_booking'=>$kode));
		if(count($ckbooking->result())>0){
			$row                = $ckbooking->row();
			$kode_member        = $row->kode_member;
			$jns_bayar          = $row->jns_bayar;
			if($jns_bayar==2){
				$ckhargapoin = $this->db->get('tbl_set_poin');
				$xx = $ckhargapoin->row();
				$isi['jns_bayar']   = "Poin";
				$dibayar            = number_format($row->poin_bayar * $xx->nominal);
				$isi['total_bayar'] = $row->poin_bayar * $xx->nominal + $row->dibayar;
				if($row->dibayar!="" || $row->dibayar!=NULL){
					$isi['status']      = number_format($row->poin_bayar) . " poin" . " + " . number_format($row->dibayar);
				}else{
					$isi['status']      = number_format($row->poin_bayar) . " poin";
				}
			}else{
				$isi['total_bayar'] = $row->dibayar;
				$isi['jns_bayar']   = "Cash";
				$isi['status']      = "";
			}
			$diskon_momen = $row->disc_momen;
			$cekDiskonmomen = $this->db->get_where('tbl_disc_momen',array('id'=>$diskon_momen));
			if(count($cekDiskonmomen->result())>0){
				$rowDisc_m = $cekDiskonmomen->row();
				$disc_m                   = $rowDisc_m->diskon;
				$isi['diskon_momen']      = $rowDisc_m->diskon;
				$isi['nama_diskon_momen'] = $rowDisc_m->nama_diskon;
			}else{
				$disc_m                   = "0";
				$isi['diskon_momen']      = "0";
				$isi['nama_diskon_momen'] = "";
			}
			$diskonpinjam   = $row->disc_pinjam;
			$ckdiskonpinjam = $this->db->get_where('tbl_disc',array('id'=>$diskonpinjam));
			if(count($ckdiskonpinjam->result())>0){
				$rowDisc_p                 = $ckdiskonpinjam->row();
				$disc_p                    = $rowDisc_p->disc;
				$isi['diskon_pinjam']      = $rowDisc_p->disc;
				$isi['nama_diskon_pinjam'] = "Lama Pinjam " . number_format($rowDisc_p->durasi) . " hari";
			}else{
				$isi['diskon_pinjam']      = "0";
				$disc_p                    = "0";
				$isi['nama_diskon_pinjam'] = "";
			}
			$isi['sisa_bayar']        = $row->sisa_bayar;
			$isi['subtotal']          = $row->subtotal;
			$isi['tot_diskon_pinjam'] = $row->subtotal * $disc_p  / 100;
			$isi['tot_diskon_momen']  = $row->subtotal * $disc_m  / 100;
			$isi['tgl_mulai']         = date("d-m-Y",strtotime($row->tgl_perencanaan_sewa));
			$isi['tgl_selesai']       = date("d-m-Y",strtotime($row->tgl_selesai));
			$isi['tgl_booking']       = date("d-m-Y H:i:s",strtotime($row->tgl_booking));
			$ckmember                 = $this->db->get_where('view_member',array('kode_member'=>$kode_member));
			if(count($ckmember->result())>0){
				$key                  = $ckmember->row();
				$isi['nama_member']   = $key->nama;
				$isi['email_member']  = $key->email;
				$isi['alamat_member'] = $key->alamat;
				$isi['tlp_member']    = $key->no_handphone;
				$isi['alamat_detil']  = ucwords($key->kecamatan) . " , " . ucwords($key->kota);
				$isi['kelas']         = "transaksi";
				$isi['namamenu']      = "Booking";
				$isi['page']          = "booking";
				$isi['link']          = 'booking';
				$isi['halaman']       = "Data Invoice";
				$isi['judul']         = "Halaman Data Invoice";
				$isi['content']       = "invoice_";
				$this->load->view("dashboard/dashboard_view",$isi);
			}else{
				redirect('_404','refresh');
			}
		}else{
			redirect('_404','refresh');
		}
	}
	public function kirim_email($kode_booking){
		$kode                = $this->service->anti($kode_booking);
		$isi['kode_booking'] = $kode;
		$ckbooking           = $this->db->get_where('tbl_booking',array('kode_booking'=>$kode));
		if(count($ckbooking->result())>0){
			$row                = $ckbooking->row();
			$kode_member        = $row->kode_member;
			$jns_bayar          = $row->jns_bayar;
			if($jns_bayar==2){
				$ckhargapoin = $this->db->get('tbl_set_poin');
				$xx = $ckhargapoin->row();
				$isi['jns_bayar']   = "Poin";
				$dibayar            = number_format($row->poin_bayar * $xx->nominal);
				$isi['total_bayar'] = $row->poin_bayar * $xx->nominal + $row->dibayar;
				if($row->dibayar!="" || $row->dibayar!=NULL){
					$isi['status']      = number_format($row->poin_bayar) . " poin" . " + " . number_format($row->dibayar);
				}else{
					$isi['status']      = number_format($row->poin_bayar) . " poin";
				}
			}else{
				$isi['total_bayar'] = $row->dibayar;
				$isi['jns_bayar']   = "Cash";
				$isi['status']      = "";
			}
			$diskon_momen = $row->disc_momen;
			$cekDiskonmomen = $this->db->get_where('tbl_disc_momen',array('id'=>$diskon_momen));
			if(count($cekDiskonmomen->result())>0){
				$rowDisc_m = $cekDiskonmomen->row();
				$disc_m                   = $rowDisc_m->diskon;
				$isi['diskon_momen']      = $rowDisc_m->diskon;
				$isi['nama_diskon_momen'] = $rowDisc_m->nama_diskon;
			}else{
				$disc_m                   = "0";
				$isi['diskon_momen']      = "0";
				$isi['nama_diskon_momen'] = "";
			}
			$diskonpinjam   = $row->disc_pinjam;
			$ckdiskonpinjam = $this->db->get_where('tbl_disc',array('id'=>$diskonpinjam));
			if(count($ckdiskonpinjam->result())>0){
				$rowDisc_p                 = $ckdiskonpinjam->row();
				$disc_p                    = $rowDisc_p->disc;
				$isi['diskon_pinjam']      = $rowDisc_p->disc;
				$isi['nama_diskon_pinjam'] = "Lama Pinjam " . number_format($rowDisc_p->durasi) . " hari";
			}else{
				$isi['diskon_pinjam']      = "0";
				$disc_p                    = "0";
				$isi['nama_diskon_pinjam'] = "";
			}
			$isi['sisa_bayar']        = $row->sisa_bayar;
			$isi['subtotal']          = $row->subtotal;
			$isi['tot_diskon_pinjam'] = $row->subtotal * $disc_p  / 100;
			$isi['tot_diskon_momen']  = $row->subtotal * $disc_m  / 100;
			$isi['tgl_mulai']         = date("d-m-Y",strtotime($row->tgl_perencanaan_sewa));
			$isi['tgl_selesai']       = date("d-m-Y",strtotime($row->tgl_selesai));
			$isi['tgl_booking']       = date("d-m-Y H:i:s",strtotime($row->tgl_booking));
			$ckmember                 = $this->db->get_where('view_member',array('kode_member'=>$kode_member));
			if(count($ckmember->result())>0){
				$key                    = $ckmember->row();
				$isi['nama_member']     = $key->nama;
				$isi['email_member']    = $key->email;
				$isi['alamat_member']   = $key->alamat;
				$isi['tlp_member']      = $key->no_handphone;
				$isi['alamat_detil']    = ucwords($key->kecamatan) . " , " . ucwords($key->kota);
				$ci                     = get_instance();
				$ci->load->library('email');
				$config['protocol']     = "smtp";
				$config['smtp_host']    = "ssl://smtp.googlemail.com";
				$config['smtp_port']    = "465";
				$config['smtp_timeout'] = "50";
				$config['smtp_user']    = "asnponorogo@gmail.com";
				$config['smtp_pass']    = "Bismillah789";
				$config['charset']      = "ISO-2022-ID";
				$config['mailtype']     = "html";
				$config['newline']      = "\r\n";
				$subject                = "Nota Pesanan";
				$from_email             = "malindooutdoor@gmail.com";
				$ci->email->initialize($config);
				$ci->email->from($from_email, 'MALindo Outdoor - [Nota Pesanan]');
				$email_member           = $key->email;
				$list                   = array($email_member);
				$ci->email->to($list);
				$ci->email->subject($subject);
				$body                   = $this->load->view('email',$isi,TRUE);
		        $ci->email->message($body);
		        if($this->email->send()){
		        	$data['response'] = 'true';
		        }else{
		        	$data['response'] = 'false';
		        }
		        if('IS_AJAX'){
		            echo json_encode($data);
		        }
			}else{
				redirect('_404','refresh');
			}
		}else{
			redirect('_404','refresh');
		}
	}
}
