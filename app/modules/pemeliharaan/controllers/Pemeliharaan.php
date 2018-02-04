<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pemeliharaan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('pemeliharaan_model');
		$this->load->model('pemeliharaan_detil_model');
		$submenu = "Pemeliharaan";
		$menu    = "transaksi";
		$this->service->login();
		$this->service->validasi_menu($menu);
		$this->service->validasi_submenu($submenu);
		if($this->session->userdata('level')=='0'){
			return TRUE;
		}else{
			$page = "pemeliharaan";
			$this->service->hak_aksessubmenu($page);
		}
	}
	public function index(){
		$this->_content();
	}
	public function _content(){
		$isi['kelas']            = "transaksi";
		$isi['namamenu']         = "Pemeliharaan";
		$isi['page']             = "pemeliharaan";
		$isi['link']             = 'pemeliharaan';
		$isi['halaman']          = "Data Pemeliharaan";
		$isi['judul']            = "Halaman Data Pemeliharaan";
		$isi['content']          = "pemeliharaan_view";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	function remove_foto(){
		$token = $this->input->post('token');
		$foto  = $this->db->get_where('tbl_pemeliharaan_foto',array('token'=>$token));
		if($foto->num_rows()>0){
			$hasil     = $foto->row();
			$nama_foto = $hasil->nama_foto;
			if(file_exists($file=FCPATH.'/upload-foto/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('tbl_pemeliharaan_foto',array('token'=>$token));
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
        	$this->db->insert('tbl_pemeliharaan_foto',array(
				'kode_transaksi' => $kode,
				'nama_foto'      => $nama,
				'token'          => $token
        	));
        }else{
        	$error = array('error' => $this->upload->display_errors());
        	print_r($error);
        }
	}
	function remove_fotox(){
		$token = $this->input->post('token');
		$foto  = $this->db->get_where('tbl_pemeliharaan_selesai_foto',array('token'=>$token));
		if($foto->num_rows()>0){
			$hasil     = $foto->row();
			$nama_foto = $hasil->nama_foto;
			if(file_exists($file=FCPATH.'/upload-foto/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('tbl_pemeliharaan_selesai_foto',array('token'=>$token));
		}
		echo "{}";
	}
	public function proses_uploadx(){
		$kode                    = $this->session->userdata('kode_transaksi');
		$config['upload_path']   = FCPATH.'/upload-foto/';
		$config['allowed_types'] = 'gif|jpg|png|ico';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        if($this->upload->do_upload('userfile')){
			$token = $this->input->post('token_foto');
			$nama  = $this->upload->data('file_name');
        	$this->db->insert('tbl_pemeliharaan_selesai_foto',array(
				'kode_transaksi' => $kode,
				'nama_foto'      => $nama,
				'token'          => $token
        	));
        }else{
        	$error = array('error' => $this->upload->display_errors());
        	print_r($error);
        }
	}
	public function proses_add(){
		$kode_transaksi   = $this->input->post('kode');
		$tgl_pemeliharaan = date("Y-m-d",strtotime($this->input->post('tglpemeliharaan')));
		$mitra            = $this->input->post('mitra');
		$keterangan       = $this->input->post('note');
		$user             = $this->session->userdata('kode');
		$simpanpemeliharaan = array(
			'kode_transaksi'         =>$kode_transaksi,
			'kode_mitra_pemeliharaan' =>$mitra,
			'keterangan'             =>$keterangan,
			'tgl_pemeliharaan'       =>$tgl_pemeliharaan,
			'biaya'                  =>'0',
			'bukti_pembayaran'       =>'',
			'tgl_selesai'            =>$tgl_pemeliharaan,
			'waktu'                  =>date("H:i:s"),
			'status'                 =>'1',
			'user'                   =>$user
		);
		$this->db->insert('tbl_pemeliharaan',$simpanpemeliharaan);
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
					'qty'            =>$this->input->post('qtyna')[$i]);
				$this->db->insert('tbl_pemeliharaan_detil',$simpandetil);
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
		redirect('pemeliharaan/invoice/' . $kode_transaksi,'refresh');
	}
	public function invoice($kode_transaksi){
		$kode           = $this->service->anti($kode_transaksi);
		$ckpemeliharaan = $this->db->get_where('view_pemeliharaan',array('kode_transaksi'=>$kode));
		if(count($ckpemeliharaan->result())>0){
			$row                     = $ckpemeliharaan->row();
			$isi['nama_mitra']       = $row->nama_mitra;
			$isi['alamat_mitra']     = $row->alamat;
			$isi['tlp_mitra']        = $row->no_kontak;
			$isi['email_mitra']      = $row->email;
			$isi['kode_transaksi']   = $kode;
			$isi['keterangan']       = $row->keterangan;
			$isi['tgl_pemeliharaan'] = date('d-m-Y',strtotime($row->tgl_pemeliharaan));
			$isi['kelas']            = "transaksi";
			$isi['namamenu']         = "Pemeliharaan";
			$isi['page']             = "pemeliharaan";
			$isi['link']             = 'pemeliharaan';
			$isi['halaman']          = "Data Invoice";
			$isi['judul']            = "Halaman Data Invoice";
			$isi['content']          = "invoice_";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
	public function kirim_email($kode_transaksi){
		$kode                  = $this->service->anti($kode_transaksi);
		$isi['kode_transaksi'] = $kode;
		$ckbooking             = $this->db->get_where('tbl_pemeliharaan',array('kode_transaksi'=>$kode));
		if(count($ckbooking->result())>0){
			$row                     = $ckbooking->row();
			$isi['tgl_pemeliharaan'] = date("d-m-Y",strtotime($row->tgl_pemeliharaan));
			$isi['note']             = $row->keterangan;
			$ckmitra                 = $this->db->get_where('view_pemeliharaan',array('kode_transaksi'=>$kode));
			if(count($ckmitra->result())>0){
				$key                    = $ckmitra->row();
				$isi['nama_mitra']      = $key->nama_mitra;
				$isi['email_mitra']     = $key->email;
				$isi['alamat_mitra']    = $key->alamat;
				$isi['tlp_mitra']       = $key->no_kontak;
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
				$subject                = "Nota Pemeliharaan";
				$from_email             = $x->email;
				$ci->email->initialize($config);
				$ci->email->from($from_email, 'MALindo Outdoor - [Nota Pemeliharaan]');
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
	public function cekdata($kode=Null){
		if($this->input->is_ajax_request()){
			$ckdata = $this->db->get_where('view_pemeliharaan',array('kode_transaksi'=>$this->service->anti($kode)))->result();
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
	public function getDataDetilPemeliharaan(){
		if($this->input->is_ajax_request()){
			$list = $this->pemeliharaan_detil_model->get_datatables();
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
				"recordsTotal"    => $this->pemeliharaan_detil_model->count_all(),
				"recordsFiltered" => $this->pemeliharaan_detil_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function proses_update(){
		$kode        = $this->session->userdata('kode_transaksi');
		$kode_barang = $this->input->post('kode_barang');
		$tgl_selesai = date("Y-m-d",strtotime($this->input->post('tgl_selesai')));
		$bayar       = str_replace(".", "", $this->input->post('total'));
		$nmfile      = "file_".time();
		$tmpName     = $_FILES['foto']['tmp_name'];
        if($tmpName!=''){
            $config['file_name']     = $nmfile;
            $config['upload_path']   = 'assets/foto/bukti_pemeliharaan';
            $config['allowed_types'] = 'gif|jpg|png|bmp';
            $config['max_size']      = '1048';
            $config['max_width']     = '0';
            $config['max_height']    = '0';
            $config['overwrite']     = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')){
				$gbr    = $this->upload->data();
				$update = array(
					'tgl_selesai'      =>$tgl_selesai,
					'bukti_pembayaran' =>$gbr['file_name'],
					'biaya'            =>$bayar,
					'status'           =>'0'
				);
				$this->db->where('kode_transaksi',$kode);
				$this->db->update('tbl_pemeliharaan',$update);
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
			        	/*Simpan Pengembalian Pemeliharaan*/
						$simpanpengembalian = array(
							'qty'            => $qtyna
						);
						$this->db->where('kode_transaksi',$kode);
						$this->db->where('kode_barang',$kode_barangna);
						$this->db->where('kode_warna',$idwarna);
			        	$this->db->update('tbl_pemeliharaan_detil',$simpanpengembalian);
					}
		        }
            }else{
                ?>
                <script type="text/javascript">
                    alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 1MB");
                    window.location.href="<?php echo base_url();?>pemeliharaan/cek/<?php echo $this->session->userdata('kode_transaksi');?>";
                </script>
                <?php
            }
        }else{
            ?>
            <script type="text/javascript">
                alert("Pastikan Data Tidak Kosong Type File gif || jpg || bmp || png dan ukuran file maksimal 1MB");
                window.location.href="<?php echo base_url();?>pemeliharaan/cek/<?php echo $this->session->userdata('kode_transaksi');?>";
            </script>
            <?php
        }
        redirect('pemeliharaan','refresh');
	}
	public function cek($kode){
		$cktrans = $this->db->get_where('tbl_pemeliharaan',array('kode_transaksi'=>$kode,'status'=>'1'));
		if(count($cktrans->result())>0){
			$x                                  = $cktrans->row();
			$isi['kode_transaksi']              = $kode;
			$this->session->set_userdata('kode_transaksi',$kode);
			$isi['default']['tgl_pemeliharaan'] = date('d-m-Y',strtotime($x->tgl_pemeliharaan));
			$isi['kelas']                       = "transaksi";
			$isi['namamenu']                    = "Pemeliharaan";
			$isi['page']                        = "pemeliharaan";
			$isi['link']                        = 'pemeliharaan';
			$isi['halaman']                     = "Data Pemeliharaan Barang";
			$isi['judul']                       = "Halaman Data Pemeliharaan Barang";
			$isi['content']                     = "cek_view";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect("_404","refresh");
		}
	}
	public function detil_pemeliharaan($kode){
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
		$ckdata = $this->db->get_where('view_pemeliharaan',array('kode_transaksi'=>$kode));
		if(count($ckdata->result())>0){
			$this->session->set_userdata('kode_pemeliharaan',$kode);
			$row                     = $ckdata->row();
			$isi['kode_transaksi']   = $kode;
			$isi['alamat']           = $row->alamat;
			$isi['nama_mitra']       = $row->nama_mitra;
			$isi['kontak']           = $row->kontak;
			$isi['no_kontak']        = $row->no_kontak;
			$isi['mail']             = $row->email;
			$isi['foto']             = $row->bukti_pembayaran;
			$isi['tglpemeliharaan']  = date("d-m-Y",strtotime($row->tgl_pemeliharaan));
			$isi['tglselesai']       = date("d-m-Y",strtotime($row->tgl_selesai));
			$isi['total_bayar']      = $row->biaya;
			$isi['status_transaksi'] = $row->status;
			$isi['kelas']            = "transaksi";
			$isi['namamenu']         = "Pemeliharaan";
			$isi['page']             = "pemeliharaan";
			$isi['link']             = 'pemeliharaan';
			$isi['actionhapus']      = 'hapus';
			$isi['actionedit']       = 'edit';
			$isi['halaman']          = "Detil Data Pemeliharaan";
			$isi['judul']            = "Halaman Detil Data Pemeliharaan";
			$isi['content']          = "detil_pemeliharaan";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect('_404','refresh');
		}
	}
	public function getDataDetil(){
		if($this->input->is_ajax_request()){
			$list = $this->pemeliharaan_detil_model->get_datatables();
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
				if($rowx->status=='1'){
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Pemeliharaan">InProses</a></center>';
				}elseif($rowx->status=='2'){
/*InProses Barang Sedang dipinjam*/
					$row[]  = '<center><a class="btn btn-xs m-r-5 btn-primary" href="javascript:void(0)" title="Edit Data"
						onclick="edit_data(\'Data Booking Barang\',\'booking\',\'edit_data_barang\','."'".$rowx->id."'".')"><i class="icon-pencil"></i></a><a class="btn btn-xs m-r-5 btn-danger " href="javascript:void(0)" title="Hapus Data"
						onclick="hapus_data_barang(\'Data Pemeliharaan Barang\',\'booking\',\'hapus_data_barang\','."'".$rowx->id."'".')"><i class="icon-remove icon-white"></i></a></center>';
				}elseif($rowx->status=='3'){
/*Cancel Booking*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Pemeliharaan Cancel">Pemeliharaan Cancel</a></center>';
				}elseif($rowx->status=='0'){
/*Booking Selesai Barang Sudah dikembalikan oleh peminjam*/
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-primary" title="Pemeliharaan Finish">Pemeliharaan Selesai</a></center>';
				}
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->pemeliharaan_detil_model->count_all(),
				"recordsFiltered" => $this->pemeliharaan_detil_model->count_filtered(),
				"data"            => $data,
			);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
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
		$isi['namamenu']     = "Pemeliharaan";
		$isi['page']         = "pemeliharaan";
		$isi['link']         = 'pemeliharaan';
		$isi['tombolsimpan'] = 'Simpan';
		$isi['tombolbatal']  = 'Batal';
		$isi['halaman']      = "Add Pemeliharaan";
		$isi['judul']        = "Halaman Add Pemeliharaan";
		$isi['content']      = "form_";
		$isi['action']       = "proses_add";
		$tahun               = date("my");
		$query               = $this->db->query("SELECT MAX(kode_transaksi) as nona FROM tbl_pemeliharaan WHERE RIGHT(kode_transaksi,4) = '$tahun'")->result();
		if(count($query)>0){
			foreach ($query as $zzz) {
	 			$xx = substr($zzz->nona, 1, 3);
	 		}
	 		if($xx==''){
	 			$newID = "001-PL-MAL-" . $tahun;
	 		}else{
	 			$noUrut = (int) substr($xx, 1, 3);
	 			$noUrut++;
	 			$newID = sprintf("%03s", $noUrut) . "-PL-MAL-" . $tahun;
	 		}
		}else{
			$newID = "001-PL-MAL-" . $tahun;
		}
		$isi['default']['kode']  = $newID;
		$this->session->set_userdata('kode_transaksi_temp',$newID);
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function getData(){
		if($this->input->is_ajax_request()){
			$list = $this->pemeliharaan_model->get_datatables();
			$data = array();
			$no   = $_POST['start'];
			foreach ($list as $rowx) {
				$no++;
				$row    = array();
				$row[]  = $no . ".";
				$row[]  = "<right>" . $rowx->kode_transaksi . "</right>";
				$row[]  = date("d-m-Y",strtotime($rowx->tgl_pemeliharaan));
				$row[]  = $rowx->nama_mitra;
				$row[]  = $rowx->kontak;
				$row[]  = $rowx->no_kontak;
				$row[]  = $rowx->email;
				$status = $rowx->status;
				if($status=='1'){
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Pemeliharaan">InProses</a></center>';
				}elseif($status=='0'){
					$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-primary" title="Pemeliharaan Finish">Finish</a></center>';
				}
				$row[] = '<center><div class="btn-group m-r-5 m-b-5">
							<a href="javascript:;" data-toggle="dropdown" class="btn btn-xs m-r-5 btn-info dropdown-toggle">Action <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="javascript:;" onclick="detil_pemeliharaan('."'".$rowx->kode_transaksi."'".',\'Booking\',\'pemeliharaan\','."'".$rowx->kode_transaksi."'".')">Lihat Detil</a></li>
								<li><a href="'.base_url().'pemeliharaan/invoice/'.$rowx->kode_transaksi.'">Lihat Nota</a></li>
								<li class="divider"></li>
								<li><a onclick="kirim('."'".$rowx->email."'".')" href="javascript:;">Kirim Email</a></li>
							</ul>
						</div></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->pemeliharaan_model->count_all(),
				"recordsFiltered" => $this->pemeliharaan_model->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
}
