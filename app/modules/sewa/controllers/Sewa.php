<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sewa extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('sewa_model');
		$this->load->model('sewa_proses_model');
		$this->load->model('sewa_detil_model');
		$submenu = "Penyewaan";
		$menu    = "transaksi";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "sewa";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']            = "transaksi";
		$isi['namamenu']         = "Penyewaan";
		$isi['page']             = "sewa";
		$isi['link']             = 'sewa';
		$isi['halaman']          = "Data Penyewaan";
		$isi['judul']            = "Halaman Data Penyewaan";
		$isi['content']          = "sewa_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->sewa_model->get_datatables();
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
				$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Booking">OnBooking</a></center>';
				$row[] = '<center><div class="btn-group m-r-5 m-b-5">
							<a href="javascript:;" data-toggle="dropdown" class="btn btn-xs m-r-5 btn-info dropdown-toggle">Action <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="javascript:;" onclick="detil_sewa('."'".$rowx->kode_booking."'".',\'Booking\',\'sewa\','."'".$rowx->kode_booking."'".')">Lihat Detil</a></li>
								<li><a href="'.base_url().'sewa/invoice/'.$rowx->kode_booking.'">Lihat Nota</a></li>
								<li class="divider"></li>
								<li><a onclick="kirim('."'".$rowx->email."'".')" href="javascript:;">Kirim Email</a></li>
							</ul>
						</div></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->sewa_model->count_all(),
				"recordsFiltered" => $this->sewa_model->count_filtered(),
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
								<li><a href="javascript:;" onclick="detil_sewax('."'".$rowx->kode_transaksi."'".',\'Sewa\',\'sewa\','."'".$rowx->kode_transaksi."'".')">Lihat Detil</a></li>
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
	public function getDataDetil(){
		if($this->input->is_ajax_request()){
			$list = $this->sewa_detil_model->get_datatables();
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
				"recordsTotal"    => $this->sewa_detil_model->count_all(),
				"recordsFiltered" => $this->sewa_detil_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function invoice_sewa($kode_transaksi){
		$kode                  = $this->service->anti($kode_transaksi);
		$isi['kode_transaksi'] = $kode;
		$ckbooking             = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode));
		if(count($ckbooking->result())>0){
			$row               = $ckbooking->row();
			$user              = $row->user;
			$ckuser = $this->db->get_where('tbl_username',array('kode'=>$user));
			if(count($ckuser->result())){
				$xu           = $ckuser->row();
				$isi['kasir'] = $xu->nama;
			}else{
				$isi['kasir'] = "Not Found";
			}
			$kode_member       = $row->kode_member;
			$jns_bayar         = $row->jns_bayar;
			$isi['jnsx_bayar'] = $row->jns_bayar;
			if($jns_bayar==2){
/*				$ckhargapoin = $this->db->get('tbl_set_poin');
				$xx = $ckhargapoin->row();*/
				$isi['tot_diskon_pinjam'] = "0";
				$isi['tot_diskon_momen']  = "0";
				$isi['subtotal']          = $row->subtotal_poin;
				$isi['jns_bayar']         = "Poin";
				$dibayar                  = number_format($row->poin_bayar);
				$isi['total_bayar']       = $row->subtotal_poin;
				// if($row->dibayar!="" || $row->dibayar!=NULL){
					// $isi['status']      = number_format($row->poin_bayar) . " poin" . " + " . number_format($row->dibayar);
				// }else{
				// 	$isi['status']      = number_format($row->poin_bayar) . " poin";
				// }
				$cksisapoin       = $this->db->get_where('tbl_histori_poin',array('kode_member'=>$kode_member));
				$xxxx             = $cksisapoin->row();
				$isi['sisa_poin'] = $xxxx->jml_poin;
			}else{
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
				$isi['tot_diskon_pinjam'] = $row->subtotal_x * $disc_p  / 100;
				$isi['tot_diskon_momen']  = $row->subtotal_x * $disc_m  / 100;
				$isi['potongan']          = $row->potongan;
				$isi['subtotal']          = $row->subtotal_x;
				$isi['total_bayar']       = $row->dibayar;
				$isi['jns_bayar']         = "Cash";
				$isi['status']            = "";
				$isi['sisa_bayar']        = $row->sisa_bayar;
			}
			$isi['tgl_mulai']     = date("d-m-Y",strtotime($row->tgl_perencanaan_sewa));
			$isi['tgl_selesai']   = date("d-m-Y",strtotime($row->tgl_selesai));
			$isi['tgl_transaksi'] = date("d-m-Y H:i:s",strtotime($row->tgl_transaksi));
			$ckmember             = $this->db->get_where('view_member',array('kode_member'=>$kode_member));
			if(count($ckmember->result())>0){
				$key                  = $ckmember->row();
				$isi['nama_member']   = $key->nama;
				$isi['email_member']  = $key->email;
				$isi['alamat_member'] = $key->alamat;
				$isi['tlp_member']    = $key->no_handphone;
				$isi['alamat_detil']  = ucwords($key->kecamatan) . " , " . ucwords($key->kota);
				$isi['kelas']         = "transaksi";
				$isi['namamenu']      = "Penyewaan";
				$isi['page']          = "sewa";
				$isi['link']          = 'sewa';
				$isi['halaman']       = "Data Invoice Penyewaan";
				$isi['judul']         = "Halaman Data Invoice Penyewaan";
				$isi['content']       = "invoice_";
				$this->load->view("dashboard/dashboard_view",$isi);
			}else{
				redirect('_404','refresh');
			}
		}else{
			redirect('_404','refresh');
		}
	}
	function remove_foto(){
		$token = $this->input->post('token');
		$foto  = $this->db->get_where('tbl_trans_foto',array('token'=>$token));
		if($foto->num_rows()>0){
			$hasil     = $foto->row();
			$nama_foto = $hasil->nama_foto;
			if(file_exists($file=FCPATH.'/upload-foto/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('tbl_trans_foto',array('token'=>$token));
		}
		echo "{}";
	}
	public function proses_upload(){
		$kode                    = $this->session->userdata('kode_transaksi_temp');
		$config['upload_path']   = FCPATH.'/upload-foto/';
		$config['allowed_types'] = 'gif|jpg|png|ico';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        if($this->upload->do_upload('userfile')){
			$token = $this->input->post('token_foto');
			$nama  = $this->upload->data('file_name');
			if($kode!=""){
	        	$this->db->insert('tbl_trans_foto',array(
					'kode_transaksi' => $kode,
					'nama_foto'      => $nama,
					'token'          => $token
	        	));
			}else{
				$this->db->insert('tbl_trans_foto',array(
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
	public function invoice($kode_booking){
		$kode                = $this->service->anti($kode_booking);
		$isi['kode_booking'] = $kode;
		$ckbooking           = $this->db->get_where('tbl_booking',array('kode_booking'=>$kode));
		if(count($ckbooking->result())>0){
			$row               = $ckbooking->row();
			$user              = $row->user;
			$ckuser = $this->db->get_where('tbl_username',array('kode'=>$user));
			if(count($ckuser->result())){
				$xu           = $ckuser->row();
				$isi['kasir'] = $xu->nama;
			}else{
				$isi['kasir'] = "Not Found";
			}
			$kode_member       = $row->kode_member;
			$jns_bayar         = $row->jns_bayar;
			$isi['jnsx_bayar'] = $row->jns_bayar;
			if($jns_bayar==2){
/*				$ckhargapoin = $this->db->get('tbl_set_poin');
				$xx = $ckhargapoin->row();*/
				$isi['tot_diskon_pinjam'] = "0";
				$isi['tot_diskon_momen']  = "0";
				$isi['subtotal']          = $row->subtotal_poin;
				$isi['jns_bayar']         = "Poin";
				$dibayar                  = number_format($row->poin_bayar);
				$isi['total_bayar']       = $row->subtotal_poin;
				// if($row->dibayar!="" || $row->dibayar!=NULL){
					// $isi['status']      = number_format($row->poin_bayar) . " poin" . " + " . number_format($row->dibayar);
				// }else{
				// 	$isi['status']      = number_format($row->poin_bayar) . " poin";
				// }
				$cksisapoin       = $this->db->get_where('tbl_histori_poin',array('kode_member'=>$kode_member));
				$xxxx             = $cksisapoin->row();
				$isi['sisa_poin'] = $xxxx->jml_poin;
			}else{
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
				$isi['tot_diskon_pinjam'] = $row->subtotal_x * $disc_p  / 100;
				$isi['tot_diskon_momen']  = $row->subtotal_x * $disc_m  / 100;
				$isi['potongan']          = $row->potongan;
				$isi['subtotal']          = $row->subtotal_x;
				$isi['total_bayar']       = $row->dibayar;
				$isi['jns_bayar']         = "Cash";
				$isi['status']            = "";
				$isi['sisa_bayar']        = $row->sisa_bayar;
			}
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
				$isi['namamenu']      = "Penyewaan";
				$isi['page']          = "sewa";
				$isi['link']          = 'sewa';
				$isi['halaman']       = "Data Invoice";
				$isi['judul']         = "Halaman Data Invoice";
				$isi['content']       = "booking/invoice_";
				$this->load->view("dashboard/dashboard_view",$isi);
			}else{
				redirect('_404','refresh');
			}
		}else{
			redirect('_404','refresh');
		}
	}
	private function uploadImage(){
		$config['upload_path']   = './foto/foto_penyerahan/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	public function detil_sewa($kode){
		$isi['option_warnaX'][''] = "Pilih Warna Barang";
		$cwarna                   = $this->db->get('tbl_warna')->result();
		if(count($cwarna)>0){
			foreach ($cwarna as $key) {
				$isi['option_warna'][$key->id]  = $key->warna;
				$isi['option_warnaX'][$key->id] = $key->warna;
			}
		}else{
			$isi['option_warna']['']  = "Data Warna Belum Tersedia";
			$isi['option_warnaX'][''] = "Data Warna Belum Tersedia";
		}
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
			$isi['namamenu']       = "Penyewaan";
			$isi['page']           = "sewa";
			$isi['link']           = 'sewa';
			$isi['actionhapus']    = 'hapus';
			$isi['actionedit']     = 'edit';
			$isi['halaman']        = "Detil Data Booking";
			$isi['judul']          = "Halaman Detil Data Booking";
			$isi['content']        = "detil_booking";
			$kode                  = $this->service->anti($kode);
			$isi['subtotal_x']     = $row->subtotal_x;
			$isi['subtotal']       = $row->subtotal;
			$isi['kode_booking']   = $kode;
			$ckbooking             = $this->db->get_where('tbl_booking',array('kode_booking'=>$kode));
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
	public function detil_cek_sewa($kode){
		$isi['option_warnaX'][''] = "Pilih Warna Barang";
		$cwarna                   = $this->db->get('tbl_warna')->result();
		if(count($cwarna)>0){
			foreach ($cwarna as $key) {
				$isi['option_warna'][$key->id]  = $key->warna;
				$isi['option_warnaX'][$key->id] = $key->warna;
			}
		}else{
			$isi['option_warna']['']  = "Data Warna Belum Tersedia";
			$isi['option_warnaX'][''] = "Data Warna Belum Tersedia";
		}
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
			$isi['namamenu']       = "Penyewaan";
			$isi['page']           = "sewa";
			$isi['link']           = 'sewa';
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
	
	public function detil_sewa_proses($kode){
		$isi['option_warnaX'][''] = "Pilih Warna Barang";
		$cwarna                   = $this->db->get('tbl_warna')->result();
		if(count($cwarna)>0){
			foreach ($cwarna as $key) {
				$isi['option_warna'][$key->id]  = $key->warna;
				$isi['option_warnaX'][$key->id] = $key->warna;
			}
		}else{
			$isi['option_warna']['']  = "Data Warna Belum Tersedia";
			$isi['option_warnaX'][''] = "Data Warna Belum Tersedia";
		}
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
			$isi['namamenu']       = "Penyewaan";
			$isi['page']           = "sewa";
			$isi['link']           = 'sewa';
			$isi['actionhapus']    = 'hapus';
			$isi['actionedit']     = 'edit';
			$isi['halaman']        = "Detil Data Penyewaan";
			$isi['judul']          = "Halaman Detil Data Penyewaan";
			$isi['content']        = "detil_sewa";
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
	public function cekdata_sewa($kode=Null){
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
	public function cek($kode){
		$cktrans = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode,'status_transaksi'=>'1'));
		if(count($cktrans->result())>0){
			$this->session->set_userdata('kode_transaksi',$kode);
			$isi['kelas']     = "transaksi";
			$isi['namamenu']  = "Penyewaan";
			$isi['page']      = "sewa";
			$isi['link']      = 'sewa';
			$isi['halaman']   = "Data Penyewaan";
			$isi['judul']     = "Halaman Data Penyewaan";
			$isi['content']   = "cek_view_langsung";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			$ckdata = $this->db->get_where('tbl_booking',array('kode_booking'=>$kode,'status_booking'=>'1'));
			if(count($ckdata->result())>0){
				$tahun = date("my");
				$query = $this->db->query("SELECT MAX(kode_transaksi) as nona FROM tbl_trans WHERE RIGHT(kode_transaksi,4) = '$tahun'")->result();
				if(count($query)>0){
					foreach ($query as $zzz) {
			 			$xx = substr($zzz->nona, 1, 3);
			 		}
			 		if($xx==''){
			 			$newID = "001-TR-MAL-" . $tahun;
			 		}else{
			 			$noUrut = (int) substr($xx, 1, 3);
			 			$noUrut++;
			 			$newID = sprintf("%03s", $noUrut) . "-TR-MAL-" . $tahun;
			 		}
				}else{
					$newID = "001-TR-MAL-" . $tahun;
				}
				$this->session->set_userdata('kode_transaksi_temp',$newID);
				$isi['kelas']     = "transaksi";
				$isi['namamenu']  = "Penyewaan";
				$isi['page']      = "sewa";
				$isi['link']      = 'sewa';
				$isi['halaman']   = "Data Penyewaan";
				$isi['judul']     = "Halaman Data Penyewaan";
				$isi['content']   = "cek_view";
				$this->load->view("dashboard/dashboard_view",$isi);
			}else{
				redirect("_404","refresh");
			}
		}
	}
	public function proses_add(){
		$kode_transaksi = $this->session->userdata('kode_transaksi_temp');
		if($kode_transaksi!=""){
			$ckdata         = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode_transaksi));
			if(count($ckdata->result())==""){
				$ckdatabook = $this->db->get_where('tbl_trans',array('kode_booking'=>$this->session->userdata('kode_booking')));
				if(count($ckdatabook->result())==""){
					$ckdatabooking = $this->db->get_where('tbl_booking',array('kode_booking'=>$this->session->userdata('kode_booking'),'status_booking'=>'1'));
					if(count($ckdatabooking->result())>0){
						$row                  = $ckdatabooking->row();
						$blain                = str_replace(".", "", $this->input->post('blain'));
						if($blain!=""){
							$subtotal   = $row->subtotal + $blain;
							$sisa_bayar = $row->sisa_bayar + $blain;
						}else{
							$subtotal   = $row->subtotal;
							$sisa_bayar = $row->sisa_bayar;
						}
						$kode_member          = $row->kode_member;
						$tgl_booking          = $row->tgl_booking;
						$tgl_perencanaan_sewa = $row->tgl_perencanaan_sewa;
						$tgl_selesai          = $row->tgl_selesai;
						$lama                 = $row->lama;
						$subtotal_poin        = $row->subtotal_poin;
						$poin_bayar           = $row->poin_bayar;
						$subtotal_x           = $row->subtotal_x;
						$disc_pinjam          = $row->disc_pinjam;
						$disc_momen           = $row->disc_momen;
						$total_bayar          = $row->total_bayar;
						$dibayar              = $row->dibayar;
						$potongan             = $row->potongan;
						$sisa_bayar           = $row->sisa_bayar;
						$status_booking       = $row->status_booking;
						$jns_bayar            = $row->jns_bayar;
						$user                 = $row->user;
						$simpantransaksi      = array(
							'kode_transaksi'       =>$this->session->userdata('kode_transaksi_temp'),
							'kode_booking'         =>$this->session->userdata('kode_booking'),
							'kode_member'          =>$kode_member,
							'tgl_transaksi'        =>date("Y-m-d H:i:s"),
							'tgl_perencanaan_sewa' =>$tgl_perencanaan_sewa,
							'tgl_selesai'          =>$tgl_selesai,
							'lama'                 =>$lama,
							'subtotal_poin'        =>$subtotal_poin,
							'poin_bayar'           =>$poin_bayar,
							'subtotal_x'           =>$subtotal_x,
							'subtotal'             =>$subtotal,
							'disc_pinjam'          =>$disc_pinjam,
							'disc_momen'           =>$disc_momen,
							'total_bayar'          =>$total_bayar,
							'dibayar'              =>$dibayar,
							'potongan'             =>$potongan,
							'sisa_bayar'           =>$sisa_bayar,
							'status_transaksi'     =>'1',
							'jns_bayar'            =>$jns_bayar,
							'user'                 =>$this->session->userdata('kode'),
							'biaya_lainnya'        =>$blain,
							'keterangan'           =>$this->input->post('blain_detil'),
							'note'                 =>$this->input->post('note')
						);
						$this->db->insert('tbl_trans',$simpantransaksi);
						$ckdetilbooking = $this->db->get_where('tbl_booking_detil',array('kode_booking'=>$this->session->userdata('kode_booking')))->result();
						foreach ($ckdetilbooking as $key) {
							$kode_barang          = $key->kode_barang;
							$kode_warna           = $key->kode_warna;
							$qty                  = $key->qty;
							$status               = $key->status;
							$simpantransaksidetil = array(
								'kode_transaksi' =>$this->session->userdata('kode_transaksi_temp'),
								'kode_barang'    =>$kode_barang,
								'kode_warna'     =>$kode_warna,
								'qty'            =>$qty,
								'status'         =>$status
							);
							$this->db->insert('tbl_trans_detil',$simpantransaksidetil);
						}
						/*Update Status Booking*/
						$updatebooking = array('status_booking'=>'0');
						$this->db->where('kode_booking',$this->session->userdata('kode_booking'));
						$this->db->update('tbl_booking',$updatebooking);
						$this->kirim_email($this->session->userdata('kode_transaksi_temp'));
						$this->session->unset_userdata('kode_booking');
						$this->session->unset_userdata('kode_transaksi_temp');
						redirect('sewa','refresh');
					}else{
						redirect("_err_sewa","refresh");
					}
				}else{
					redirect("_err_sewa","refresh");
				}
			}else{
				redirect("_err_sewa","refresh");
			}
		}else{
			$kode_transaksi = $this->session->userdata('kode_transaksi');
			$ckdata = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode_transaksi));
			if(count($ckdata->result())>0){
				$updatenote = array('note'=>$this->input->post('note'));
				$this->db->where('kode_transaksi',$kode_transaksi);
				$this->db->update('tbl_trans',$updatenote);
				$this->session->unset_userdata('kode_booking');
				$this->session->unset_userdata('kode_transaksi_temp');
				$this->session->unset_userdata('kode_transaksi');
				redirect('sewa','refresh');
			}else{
				redirect('_404','refresh');
			}
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
		$isi['namamenu']     = "Penyewaan";
		$isi['page']         = "sewa";
		$isi['link']         = 'sewa';
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal']  = 'Batal';
		$isi['halaman']      = "Add Penyewaan";
		$isi['judul']        = "Halaman Add Penyewaan";
		$isi['content']      = "form_";
		$isi['action']       = "proses_add_sewa";
		$tahun               = date("my");
		$query               = $this->db->query("SELECT MAX(kode_transaksi) as nona FROM tbl_trans WHERE RIGHT(kode_transaksi,4) = '$tahun'")->result();
		if(count($query)>0){
			foreach ($query as $zzz) {
	 			$xx = substr($zzz->nona, 1, 3);
	 		}
	 		if($xx==''){
	 			$newID = "001-TR-MAL-" . $tahun;
	 		}else{
	 			$noUrut = (int) substr($xx, 1, 3);
	 			$noUrut++;
	 			$newID = sprintf("%03s", $noUrut) . "-TR-MAL-" . $tahun;
	 		}
		}else{
			$newID = "001-TR-MAL-" . $tahun;
		}
		$isi['default']['kode']  = $newID;
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function proses_add_sewa(){
		$kode_transaksi = $this->input->post('kode');
		$info_member    = $this->input->post('nama');
		$b_point        = "";
		$pch            = explode("|", $info_member);
		$kode_member    = str_replace(" ", "", $pch[1]);
		$jns            = $this->input->post('jns_bayar');
		$now            = date("Y-m-d H:i:s");
		$mulai          = $this->service->anti(date("Y-m-d",strtotime($this->input->post('tglsewa'))));
		$selesai        = $this->service->anti(date("Y-m-d",strtotime($this->input->post('tglselesai'))));
		$total_bayar    = str_replace(".", "", $this->input->post('subtotal_'));
		$lama           = $this->input->post('lama_pinjam');
		$id_disc_lama   = $this->input->post('id_disc_lama');
		if($id_disc_lama!=""){
			$id_disc_lama = $id_disc_lama;
		}else{
			$id_disc_lama = $this->input->post('disc_lama_pinjam');
		}
		$id_disc_momen = $this->input->post('id_disc_momen');
		// $subtotal   = str_replace(".", "", $this->input->post('subtotal_x'));
		$subtotal      = str_replace(".", "", $this->input->post('subtotal_'));
		$subtotal_x    = str_replace(".", "", $this->input->post('subtotal_x'));
		if($jns==1){
/*Cash*/	
			$blain    = str_replace(".", "", $this->input->post('blain'));
			$ketblain = $this->input->post('blain_detil');
			$dibayar  = str_replace(".", "", $this->input->post('b_cash'));
			$sisa     = $total_bayar - $dibayar;
			if($dibayar    >= $total_bayar){
				$sesa          = "0";
			}else{
				$sesa          = $total_bayar - $dibayar;
			}
			$potongan = str_replace(".", "", $this->input->post('potongan'));
			if($potongan!=""){
				$pot = $potongan;
			}else{
				$pot = NULL;
			}
			if($id_disc_lama !="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_transaksi'        =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal_x'           =>$subtotal_x,
					'subtotal'             =>$subtotal + $potongan,
					'potongan'             =>$pot,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'1',
					'user'                 =>$this->session->userdata('kode'),
					'status_transaksi'     =>'1');
			}else if($id_disc_lama !="" && $id_disc_momen ==""){
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_transaksi'        =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal_x'           =>$subtotal_x,
					'subtotal'             =>$subtotal + $potongan,
					'potongan'             =>$pot,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'jns_bayar'            =>'1',
					'user'                 =>$this->session->userdata('kode'),
					'status_transaksi'     =>'1');
			}else if($id_disc_lama =="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_transaksi'        =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal_x'           =>$subtotal_x,
					'subtotal'             =>$subtotal + $potongan,
					'potongan'             =>$pot,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'user'                 =>$this->session->userdata('kode'),
					'jns_bayar'            =>'1',
					'status_transaksi'     =>'1');
			}else{
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_transaksi'        =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal_x'           =>$subtotal_x,
					'subtotal'             =>$subtotal + $potongan,
					'potongan'             =>$pot,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>NULL,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'user'                 =>$this->session->userdata('kode'),
					'jns_bayar'            =>'1',
					'status_transaksi'     =>'1');
			}
			$this->db->insert('tbl_trans',$simpanbooking);
		}else{
/*Poin*/
			$total_bayar   = str_replace(".", "", $this->input->post('sisa_bayar_p'));
			$b_point       = $this->input->post('b_point');
			$dibayar       = "0";
			$subtotal_poin = $this->input->post('subtotal_poin');
			/*$dibayar     = str_replace(".", "", $this->input->post('b_sisa'));
			$sisa          = $total_bayar - $dibayar;
			if($dibayar    >= $total_bayar){*/
			$sesa          = "0";
			/*}else{
			$sesa        = $total_bayar - $dibayar;
			}*/
			if($id_disc_lama !="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'subtotal_x'           =>$subtotal_x,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'subtotal_poin'        =>$subtotal_poin,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'user'                 =>$this->session->userdata('kode'),
					'jns_bayar'            =>'2',
					'status_transaksi'       =>'1');
			}else if($id_disc_lama !="" && $id_disc_momen ==""){
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'subtotal_x'           =>$subtotal_x,
					'subtotal_poin'        =>$subtotal_poin,
					'disc_pinjam'          =>$id_disc_lama,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'user'                 =>$this->session->userdata('kode'),
					'jns_bayar'            =>'2',
					'status_transaksi'       =>'1');
			}else if($id_disc_lama =="" && $id_disc_momen !=""){
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'subtotal_x'           =>$subtotal_x,
					'subtotal_poin'        =>$subtotal_poin,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>$id_disc_momen,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'user'                 =>$this->session->userdata('kode'),
					'jns_bayar'            =>'2',
					'status_transaksi'       =>'1');
			}else{
				$simpanbooking = array(
					'kode_transaksi'       =>$kode_transaksi,
					'kode_booking'         =>NULL,
					'kode_member'          =>$kode_member,
					'keterangan'           =>$ketblain,
					'biaya_lainnya'        =>$blain,
					'tgl_booking'          =>date('Y-m-d H:i:s'),
					'tgl_perencanaan_sewa' =>$mulai,
					'tgl_selesai'          =>$selesai,
					'lama'                 =>$lama,
					'subtotal'             =>$subtotal,
					'subtotal_x'           =>$subtotal_x,
					'subtotal_poin'        =>$subtotal_poin,
					'disc_pinjam'          =>NULL,
					'disc_momen'           =>NULL,
					'total_bayar'          =>$total_bayar,
					'poin_bayar'           =>$b_point,
					'dibayar'              =>$dibayar,
					'sisa_bayar'           =>$sesa,
					'user'                 =>$this->session->userdata('kode'),
					'jns_bayar'            =>'2',
					'status_transaksi'       =>'1');
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
				$kode_barang = $row->kode;
				$warna       = $this->input->post('warnana');
				$ckwarna     = $this->db->get_where('view_barang_detil',array('warna'=>$warna[$i],'kode'=>$kode_barang));
				$rowWarna    = $ckwarna->row();
				$kode_warna  = $rowWarna->id_warna;
				$simpandetil = array(
					'kode_transaksi' =>$kode_transaksi,
					'kode_barang'    =>$kode_barang,
					'kode_warna'     =>$kode_warna,
					'qty'            =>$this->input->post('qtyna')[$i],
					'status'         =>'1');
				$this->db->insert('tbl_trans_detil',$simpandetil);
				$cekstok = $this->db->get_where('tbl_barang_stok',array('kode_barang'=>$kode_barang,'id_warna'=>$kode_warna))->result();
				foreach ($cekstok as $key) {
					$stok_awal   = $key->stok;
					$kurang      = $stok_awal - $this->input->post('qtyna')[$i];
					$update_stok = array('stok'=>$kurang);
					$this->db->where('kode_barang',$kode_barang);
					$this->db->where('id_warna',$kode_warna);
					$this->db->update('tbl_barang_stok',$update_stok);
				}
			}
		}
		redirect('sewa/detil_cek_sewa/' . $kode_transaksi,'refresh');
	}
	public function kirim_email($kode){
		$kode                  = $this->service->anti($kode);
		$isi['kode_transaksi'] = $kode;
		$ckbooking             = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode));
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
			$kode_member       = $row->kode_member;
			$jns_bayar         = $row->jns_bayar;
			$isi['jnsx_bayar'] = $row->jns_bayar;
			if($jns_bayar==2){
				$isi['tot_diskon_pinjam'] = "0";
				$isi['tot_diskon_momen']  = "0";
				$isi['subtotal']          = $row->subtotal_poin;
				$isi['jns_bayar']         = "Poin";
				$dibayar                  = number_format($row->poin_bayar);
				$isi['total_bayar']       = $row->subtotal_poin;
				$cksisapoin               = $this->db->get_where('tbl_histori_poin',array('kode_member'=>$kode_member));
				$xxxx                     = $cksisapoin->row();
				$isi['sisa_poin']         = $xxxx->jml_poin;
			}else{
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
				$isi['tot_diskon_pinjam'] = $row->subtotal_x * $disc_p  / 100;
				$isi['tot_diskon_momen']  = $row->subtotal_x * $disc_m  / 100;
				$isi['potongan']          = $row->potongan;
				$isi['subtotal']          = $row->subtotal_x;
				$isi['total_bayar']       = $row->dibayar;
				$isi['jns_bayar']         = "Cash";
				$isi['status']            = "";
				$isi['sisa_bayar']        = $row->sisa_bayar;
			}
			$isi['tgl_mulai']     = date("d-m-Y",strtotime($row->tgl_perencanaan_sewa));
			$isi['tgl_selesai']   = date("d-m-Y",strtotime($row->tgl_selesai));
			$isi['tgl_transaksi'] = date("d-m-Y H:i:s",strtotime($row->tgl_transaksi));
			$ckmember             = $this->db->get_where('view_member',array('kode_member'=>$kode_member));
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
				$subject                = "Nota Penyewaan";
				$from_email             = $x->email;
				$ci->email->initialize($config);
				$ci->email->from($from_email, 'MALindo Outdoor - [Nota Penyewaan]');
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
}
