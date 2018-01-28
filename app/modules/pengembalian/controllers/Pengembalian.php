<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengembalian extends CI_Controller {
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('pengembalian_model');
		$this->load->model('sewa/sewa_proses_model');
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
				$row[] = '<center><a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Penyewaan">OnPenyewaan</a></center>';
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
	public function cek($kode){
		$cktrans = $this->db->get_where('tbl_trans',array('kode_transaksi'=>$kode,'status_transaksi'=>'1'));
		if(count($cktrans->result())>0){
			$isi['kode_transaksi'] = $kode;
			$this->session->set_userdata('kode_transaksi',$kode);
			$isi['kelas']          = "transaksi";
			$isi['namamenu']       = "Pengembalian";
			$isi['page']           = "pengembalian";
			$isi['link']           = 'pengembalian';
			$isi['halaman']        = "Data Pengembalian Barang";
			$isi['judul']          = "Halaman Data Pengembalian Barang";
			$isi['content']        = "cek_view";
			$this->load->view("dashboard/dashboard_view",$isi);
		}else{
			redirect("_404","refresh");
		}
	}
}
