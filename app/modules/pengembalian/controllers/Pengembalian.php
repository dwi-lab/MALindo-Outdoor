<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengembalian extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('pengembalian_model');
		$this->load->model('pengembalian/sewa_proses_model');
		$this->load->model('pengembalian_model');
		$this->load->model('pengembalian_detil_model');
		$this->load->model('sewa/sewa_detil_model');
		$submenu = "Pengembalian";
		$menu    = "transaksi";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "pengembalian";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']            = "transaksi";
		$isi['namamenu']         = "Pengembalian";
		$isi['page']             = "pengembalian";
		$isi['link']             = 'pengembalian';
		$isi['halaman']          = "Data Pengembalian";
		$isi['judul']            = "Halaman Data Pengembalian";
		$isi['content']          = "pengembalian_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getPengembalianDetil(){
		if($this->input->is_ajax_request()){
			$list = $this->pengembalian_detil_model->get_datatables();
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
				if($rowx->status_transaksi=='1'){
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Penyewaan">OnPenyewaan</a></center>';
				}elseif($rowx->status_transaksi=='2'){
/*InProses Barang Sedang dipinjam*/
					$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
						onclick="edit_data(\'Data Booking Barang\',\'booking\',\'edit_data_barang\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
						onclick="hapus_data_barang(\'Data Penyewaan Barang\',\'booking\',\'hapus_data_barang\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				}elseif($rowx->status_transaksi=='3'){
/*Cancel Booking*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Penyewaan Cancel">Penyewaan Cancel</a></center>';
				}elseif($rowx->status_transaksi=='0'){
/*Booking Selesai Barang Sudah dikembalikan oleh peminjam*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-primary" title="Penyewaan Finish">Penyewaan Selesai</a></center>';
				}
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->pengembalian_detil_model->count_all(),
				"recordsFiltered" => $this->pengembalian_detil_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function getDataDetil(){
		if($this->input->is_ajax_request()){
			$list = $this->sewa_detil_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[]  = "<center><a class='fancybox' href='".base_url()."assets/foto/barang/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama_barang."'><img src='".base_url()."assets/foto/barang/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[]  = $rowx->kode_barang;
				$row[]  = $rowx->nama_barang;
				$row[]  = $rowx->warna;
				$row[]  = number_format($rowx->hrg_sewa);
				$row[]  = number_format($rowx->qty);
				$row[]  = "<center><input style='width:80px' class='form-control' type='text' value='' name='qtyna[]' /></center>";
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->sewa_detil_model->count_all(),
				"recordsFiltered" => $this->sewa_detil_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function getDataPengembalian(){
		if($this->input->is_ajax_request()){
			$list = $this->pengembalian_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/member/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama."'><img src='".base_url()."assets/foto/member/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[]  = $rowx->kode_transaksi;
				$row[]  = $rowx->nama;
				$row[]  = date("d-m-Y",strtotime($rowx->tgl_perencanaan_sewa));
				$row[]  = date("d-m-Y",strtotime($rowx->tgl_selesai));
				$row[]  = number_format($rowx->lama);
				$row[]  = date("d-m-Y",strtotime($rowx->tgl_kembali));
				$row[]  = number_format($rowx->denda);
				$row[] = '<center><div class="btn-group m-r-5 m-b-5">
							<a href="javascript:;" data-toggle="dropdown" class="btn btn-xs m-r-5 btn-info dropdown-toggle">Action <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="javascript:;" onclick="detil_kembali('."'".$rowx->kode_transaksi."'".',\'Pengembalian\',\'pengembalian\','."'".$rowx->kode_transaksi."'".')">Lihat Detil</a></li>
								<li><a onclick="kirim('."'".$rowx->email."'".')" href="javascript:;">Kirim Email</a></li>
							</ul>
						</div></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->pengembalian_model->count_all(),
				"recordsFiltered" => $this->pengembalian_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}

	public function getDataSewa(){
		if($this->input->is_ajax_request()){
			$list = $this->sewa_proses_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row   = array();
				$row[] = $no . ".";
				$row[] = "<center><a class='fancybox' href='".base_url()."assets/foto/member/$rowx->foto' style='width:100px;text-align:center;height:102px;' data-fancybox-group='gallery' title='".$rowx->nama."'><img src='".base_url()."assets/foto/member/$rowx->foto' style='width:71px;' alt=''/></a></center>";
				$row[] = "<right>" . $rowx->kode_transaksi . "</right>";
				$row[] = $rowx->nama;
				$row[] = date("d-m-Y",strtotime($rowx->tgl_transaksi));
				$row[] = date("d-m-Y",strtotime($rowx->tgl_perencanaan_sewa));
				$row[] = date("d-m-Y",strtotime($rowx->tgl_selesai));
				$row[] = number_format($rowx->lama);
				$status = $rowx->status_transaksi;
				if($status=='1'){
/*Onbooking Belum Jadi Peminjaman*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Penyewaan">OnSewa</a></center>';
				}elseif($status=='2'){
/*InProses Barang Sedang dipinjam*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Sedang Proses Peminjaman">InProses</a></center>';
				}elseif($status=='3'){
/*Cancel Booking*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Penyewaan Cancel">Sewa Cancel</a></center>';
				}elseif($status=='0'){
/*Booking Selesai Barang Sudah dikembalikan oleh peminjam*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-primary" title="Penyewaan Finish">Penyewaan Selesai</a></center>';
				}
				$row[] = '<center><div class="btn-group m-r-5 m-b-5">
							<a href="javascript:;" data-toggle="dropdown" class="btn btn-xs m-r-5 btn-info dropdown-toggle">Action <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="javascript:;" onclick="detil_sewa('."'".$rowx->kode_transaksi."'".',\'Sewa\',\'pengembalian\','."'".$rowx->kode_transaksi."'".')">Lihat Detil</a></li>
								<li><a href="'.base_url().'sewa/invoice_sewa/'.$rowx->kode_transaksi.'">Lihat Nota</a></li>
							</ul>
						</div></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->sewa_proses_model->count_all(),
				"recordsFiltered" => $this->sewa_proses_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_add(){
		/*Setpoin*/
		$sisa      = str_replace(".", "", $this->input->post('sisa_bayar'));
		$denda     = str_replace(".", "", $this->input->post('denda'));
		$dibayarna = str_replace(".", "", $this->input->post('dibayar'));
		$kode      = $this->session->userdata('kode_transaksi');
		if($dibayarna < $sisa ){
			?>
			<script type="text/javascript">
				alert("Pembayaran Masih Kurang, Silahkan masukan nonimal Pembayaranx !");
				window.location.href = '<?php echo base_url();?>pengembalian/cek/<?php echo $kode;?>'
			</script>
			<?php
		}else{
			/*bayar sisa pembayaran*/
			$cksisa = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode));
			if(count($cksisa->result())>0){
				$xa          = $cksisa->row();
				$dibayar     = $xa->dibayar;
				$total_bayar = $xa->total_bayar;
				$totalx      = $dibayar + $dibayarna - $denda;
				/*if($totalx < $total_bayar){
					?>
					<script type="text/javascript">
						alert("Pembayaran Masih Kurang, Silahkan masukan nonimal Pembayaran !");
						window.location.href = '<?php echo base_url();?>pengembalian/cek/<?php echo $kode;?>'
					</script>
					<?php
				}else{*/
					/*Update Total Pembayran Transaksi*/
					$updatetransaksi = array('dibayar'=>$total_bayar,'sisa_bayar'=>'0');
					$this->db->where('kode_transaksi',$kode);
					$this->db->update('tbl_trans',$updatetransaksi);
					$cksub       = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode,'status_transaksi'=>'1'));
					$keyx        = $cksub->row();
					$subtotal    = $keyx->subtotal_x;
					$kode_member = $keyx->kode_member;
					$ckpoin      = $this->db->query("SELECT * FROM tbl_poin WHERE nominal_a <= '$subtotal' AND nominal_b >= '$subtotal'");
					if(count($ckpoin->result())>0){
						$xx           = $ckpoin->row();
						$jml_poin     = $xx->jml_poin;
						$ckpoinmember = $this->db->get_where('tbl_histori_poin',array('kode_member'=>$kode_member));
						if(count($ckpoinmember->result())>0){
							$xa         = $ckpoinmember->row();
							$jml_poinx  = $xa->jml_poin;
							$updatepoin = array('jml_poin'=>$jml_poinx + $jml_poin);
							$this->db->where('kode_member',$kode_member);
							$this->db->update('tbl_histori_poin',$updatepoin);
						}else{
							$simpanpoin = array(
								'kode_member'    =>$kode_member,
								'jml_poin'       =>$jml_poin
							);
							$this->db->insert('tbl_histori_poin',$simpanpoin);
						}
						/*Simpan Poin Detil*/
						$simpanpoindetil = array(
							'kode_transaksi' =>$kode,
							'kode_member'    =>$kode_member,
							'jml_poin'       =>$jml_poin);
						$this->db->insert('tbl_histori_poin_detil',$simpanpoindetil);
					}else{
						$simpanpoindetil = array(
							'kode_transaksi' =>$kode,
							'kode_member'    =>$kode_member,
							'jml_poin'       =>'0');
						$this->db->insert('tbl_histori_poin_detil',$simpanpoindetil);
						echo "string";
					}
					$simpanxx = array(
						'kode_transaksi'     =>$this->session->userdata('kode_transaksi'),
						'tgl_kembali'        =>date("Y-m-d",strtotime($this->input->post('tgl_kembali'))),
						'lama_keterlambatan' =>$this->input->post('lamat'),
						'note'               =>$this->input->post('note'),
						'waktu'              =>date("H:i:s"),
						'user'               =>$this->session->userdata('kode'),
						'denda'              =>str_replace(".", "", $this->input->post('denda'))
					);
			        $this->db->insert('tbl_pengembalian',$simpanxx);
					$simpanstatustransaksi = array('status_transaksi'=>'0');
					$this->db->where('kode_transaksi',$this->session->userdata('kode_transaksi'));
					$this->db->update('tbl_trans',$simpanstatustransaksi);
					$kode_barang = $this->input->post('kode_barang');
					for ($i=0; $i < count($kode_barang); $i++) { 
						$pecah         = explode("|", $kode_barang[$i]);
						$qtyna         = $this->input->post('qtyna')[$i];
						$kode_barangna = $pecah[0];
						$warna         = $pecah[1];
						$ckwarna       = $this->db->get_where('tbl_warna',array('warna'=>$warna))->result();
						foreach ($ckwarna as $key) {
							$idwarna    = $key->id;
							/*Update Stok barang*/
							$ckstokawal = $this->db->get_where('tbl_barang_stok',array('kode_barang'=>$kode_barangna,'id_warna'=>$idwarna));
							$rowx       = $ckstokawal->row();
							$stok       = $rowx->stok;
							$updatestok = array('stok'=>$qtyna + $stok);
							$this->db->where('kode_barang',$kode_barangna);
							$this->db->where('id_warna',$idwarna);
							$this->db->update('tbl_barang_stok',$updatestok);
				        	/*Simpan Pengembalian*/
							$simpanpengembalian = array(
								'kode_transaksi' => $this->session->userdata('kode_transaksi'),
								'kode_barang'    => $kode_barangna,
								'id_warna'       => $idwarna,
								'qty'            => $qtyna,
								'status'         => '0'
							);
				        	$this->db->insert('tbl_pengembalian_detil',$simpanpengembalian);
				        	$kode = $this->session->userdata('kode_transaksi');
						}
			        }
			        $this->kirim_email($kode);
			        redirect('pengembalian','refresh');
				// }
			}else{
				redirect('_404','refresh');
			}
		}
	}
	public function cekdata($kode=Null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_transaksi',array('kode_transaksi'=>$this->service->anti($kode)))->result();
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
	public function kirim_email($kode){
		$kode                  = $this->service->anti($kode);
		$isi['kode_transaksi'] = $kode;
		$ckbooking             = $this->db->get_where('view_pengembalian',array('kode_transaksi'=>$kode));
		if(count($ckbooking->result())>0){
			$row         = $ckbooking->row();
			$user        = $row->user;
			$isi['note'] = $row->note;
			$ckuser      = $this->db->get_where('tbl_username',array('kode'=>$user));
			if(count($ckuser->result())){
				$xu           = $ckuser->row();
				$isi['kasir'] = $xu->nama;
			}else{
				$isi['kasir'] = "Not Found";
			}
			$kode_member               = $row->kode_member;
			$jns_bayar                 = $row->jns_bayar;
			$isi['jnsx_bayar']         = $row->jns_bayar;
			$isi['tgl_mulai']          = date("d-m-Y",strtotime($row->tgl_perencanaan_sewa));
			$isi['tgl_selesai']        = date("d-m-Y",strtotime($row->tgl_selesai));
			$isi['tgl_kembali']        = date("d-m-Y",strtotime($row->tgl_kembali));
			$isi['waktu']              = date("H:i:s",strtotime($row->waktu));
			$isi['lama_keterlambatan'] = number_format($row->lama_keterlambatan);
			$isi['denda']              = number_format($row->denda);
			$isi['tgl_transaksi']      = date("d-m-Y H:i:s",strtotime($row->tgl_transaksi));
			$ckmember                  = $this->db->get_where('view_member',array('kode_member'=>$kode_member));
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
				$cksetemail             = $this->db->get('tbl_email');
				$x                      = $cksetemail->row();
				$config['smtp_user']    = $x->email;
				$config['smtp_pass']    = $x->password;
				$config['charset']      = "ISO-2022-ID";
				$config['mailtype']     = "html";
				$config['newline']      = "\r\n";
				$config['crlf']         = "\r\n";
				$subject                = "Nota Pengembalian Barang";
				$from_email             = $x->email;
				$ci->email->initialize($config);
				$ci->email->from($from_email, 'MALindo Outdoor - [Nota Pengembalian Barang]');
				$email_member           = $key->email;
				$list                   = array($email_member);
				$ci->email->to($list);
				$ci->email->subject($subject);
				$body                   = $this->load->view('email',$isi,TRUE);
		        $ci->email->message($body);
		        if($this->email->send()){
					$data['response']  = 'true';
		        }else{
					$data['response']  = 'false';
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
	public function detil_pengembalian($kode){
		$ckdata = $this->db->get_where('view_transaksi',array('kode_transaksi'=>$kode));
		if(count($ckdata->result())>0){
			$this->session->set_userdata('kode_transaksi',$kode);
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
			$isi['namamenu']       = "Pengembalian";
			$isi['page']           = "pengembalian";
			$isi['link']           = 'pengembalian';
			$isi['actionhapus']    = 'hapus';
			$isi['actionedit']     = 'edit';
			$isi['halaman']        = "Detil Data Penyewaan";
			$isi['judul']          = "Halaman Detil Data Penyewaan";
			$isi['content']        = "detil_cek_sewa";
			$kode                  = $this->service->anti($kode);
			$isi['subtotal_x']     = $row->subtotal_x;
			$isi['subtotal']       = $row->subtotal;
			$isi['kode_transaksi'] = $kode;
			$ckbooking             = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode));
			if(count($ckbooking->result())>0){
				$row                   = $ckbooking->row();
				$user   = $row->user;
				$ckuser = $this->db->get_where('tbl_username',array('kode'=>$user));
				if(count($ckuser->result())){
					$xu           = $ckuser->row();
					$isi['kasir'] = $xu->nama;
				}else{
					$isi['kasir'] = "Not Found";
				}
				$isi['lama']             = $row->lama;
				$isi['poin_bayar']       = $row->poin_bayar;
				$isi['poin_bayar']       = $row->poin_bayar;
				$isi['status_transaksi'] = $row->status_transaksi;
				$kode_member             = $row->kode_member;
				$jns_bayar               = $row->jns_bayar;
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
				$diskon_momen   = $row->disc_momen;
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
					if($diskonpinjam==""){
						$isi['diskon_pinjam']      = "0";
						$disc_p                    = "0";
						$isi['nama_diskon_pinjam'] = "";
					}else{
						$isi['diskon_pinjam']      = $diskonpinjam;
						$disc_p                    = $diskonpinjam;
						$isi['nama_diskon_pinjam'] = "";
					}
				}
				$isi['sisa_bayar']        = $row->sisa_bayar;
				$isi['potongan']          = $row->potongan;
				$isi['tot_diskon_pinjam'] = $row->subtotal * $disc_p  / 100;
				$isi['tot_diskon_momen']  = $row->subtotal * $disc_m  / 100;
				$isi['tgl_mulai']         = date("d-m-Y",strtotime($row->tgl_perencanaan_sewa));
				$isi['tgl_selesai']       = date("d-m-Y",strtotime($row->tgl_selesai));
				$isi['tgl_transaksi']     = date("d-m-Y H:i:s",strtotime($row->tgl_transaksi));
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
	function remove_foto(){
		$token = $this->input->post('token');
		$foto  = $this->db->get_where('tbl_pengembalian_foto',array('token'=>$token));
		if($foto->num_rows()>0){
			$hasil     = $foto->row();
			$nama_foto = $hasil->nama_foto;
			if(file_exists($file=FCPATH.'/upload-foto/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('tbl_pengembalian_foto',array('token'=>$token));
		}
		echo "{}";
	}
	public function proses_upload(){
		$kode                    = $this->session->userdata('kode_transaksi');
		$config['upload_path']   = FCPATH.'/upload-foto/';
		$config['allowed_types'] = 'gif|jpg|png|ico';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        if($this->upload->do_upload('userfile')){
			$token = $this->input->post('token_foto');
			$nama  = $this->upload->data('file_name');
			if($kode!=""){
	        	$this->db->insert('tbl_pengembalian_foto',array(
					'kode_transaksi' => $kode,
					'nama_foto'      => $nama,
					'token'          => $token
	        	));
			}else{
				$this->db->insert('tbl_pengembalian_foto',array(
					'kode_transaksi' => $this->session->userdata('kode_transaksi'),
					'nama_foto'      => $nama,
					'token'          => $token
	        	));
			}
        }else{
        	$error = array('error' => $this->upload->display_errors());
        	print_r($error);
        }
	}
	public function cek($kode){
		$cktrans = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode,'status_transaksi'=>'1'));
		if(count($cktrans->result())>0){
			$x                              = $cktrans->row();
			$isi['kode_transaksi']          = $kode;
			$this->session->set_userdata('kode_transaksi',$kode);
			$isi['default']['tgl_sewa']     = date('d-m-Y',strtotime($x->tgl_perencanaan_sewa));
			$isi['default']['tgl_rkembali'] = date('d-m-Y',strtotime($x->tgl_selesai));
			$isi['default']['lama']         = $x->lama;
			$isi['sisa_bayar']              = $x->sisa_bayar;
			$this->session->set_userdata('kode_transaksi',$kode);
			$isi['kelas']                   = "transaksi";
			$isi['namamenu']                = "Pengembalian";
			$isi['page']                    = "pengembalian";
			$isi['link']                    = 'pengembalian';
			$isi['halaman']                 = "Data Pengembalian Barang";
			$isi['judul']                   = "Halaman Data Pengembalian Barang";
			$isi['content']                 = "cek_view";
			$this->load->view("dashboard/dashboard_view",$isi);
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
			echo $lama;
		}else{
			echo "NotOk";
		}
	}
}
