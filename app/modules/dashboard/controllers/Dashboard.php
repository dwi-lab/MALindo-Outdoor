<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct(){
  		parent::__construct();
  		$this->service->login();
		$this->load->model('dashboard_model');
		$this->load->model('dashboard_booking');
		date_default_timezone_set('Asia/Jakarta');
 	}
	public function index(){
		/*Update Booking Lewat Dari Perencanaan Tanggal Booking*/
		$now                      = date("Y-m-d");
		$ckbooking                = $this->db->query("SELECT * FROM tbl_booking WHERE tgl_perencanaan_sewa > '$now' AND status_booking = '1'")->result();
		if(count($ckbooking)>0){
			$isi['aya'] = "y";
			$this->session->set_flashdata('info', 'Ada Beberapa Data Booking yang dibatalkan secara otomatis oleh sistem pada hari ini tanggal : <b>' .date("d-m-Y") . '</b> dikarenakan tidak ada informasi lanjut dari pihak penyewa.', 300);
			foreach ($ckbooking as $key) {
				$kode_booking = $key->kode_booking;
				$updatecancel = array('status_booking'=>'3');
				$this->db->update('tbl_booking',$updatecancel);
			}
		}else{
			$isi['aya'] = "";
		}
		$isi['namamenu']          = "";
		$isi['orderBulan']        = $this->dashboard_model->getOrderPerbulan();
		$isi['sewaBulan']         = $this->dashboard_model->getSewaPerbulan();
		$isi['balikBulan']        = $this->dashboard_model->getBalikPerbulan();
		$isi['pemeliharaanBulan'] = $this->dashboard_model->getPemeliharaanPerbulan();
		$isi['pendaftaranBulan']  = $this->dashboard_model->getDaftarPerbulan();
		$isi['page']              = "dashboard";
		$isi['kelas']             = "dashboard";
		$isi['link']              = 'dashboard';
		$isi['halaman']           = "Dashboard";
		$isi['judul']             = "Halaman Dashboard";
		$isi['content']           = "welcome";
		$this->load->view("dashboard/dashboard_view",$isi);
	}
	public function log_out(){
		$this->session->sess_destroy();
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	public function kirim_email(){
		$cksetemail = $this->db->get('tbl_email');
		$x          = $cksetemail->row();
		$smtp_user  = $x->email;
		$smtp_pass  = $x->password;
		$config     = Array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => $smtp_user, 
			'smtp_pass' => $smtp_pass,
			'mailtype'  => 'html',
			'charset'   => 'iso-8859-1',
			'wordwrap'  => TRUE
		);
		$message = $this->input->post('deskripsi');
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from($smtp_user, 'MALindo Outdoor - ['.$this->input->post('judul').']');
		$this->email->to($this->input->post('email'));
		$this->email->subject($this->input->post('judul'));
		$this->email->message($message);
		if($this->email->send()){
			echo json_encode(array("status" => TRUE));
        }else{
			echo json_encode(array("status" => FALSE));
        }
	}
	public function getBookingNow(){
		if($this->input->is_ajax_request()){
			$list = $this->dashboard_booking->get_datatables();
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
								<li><a href="javascript:;" onclick="rbstatus(\'aktif\',\'Data Booking Barang\',\'booking\','."'".$rowx->kode_booking."'".')">Cancel Booking</a></li>
								<li><a href="javascript:;" onclick="hapus_data(\'Data Booking Barang\',\'booking\',\'hapus_booking\','."'".$rowx->kode_booking."'".')">Hapus Booking</a></li>
								<li><a onclick="kirim('."'".$rowx->email."'".')" href="javascript:;">Kirim Email</a></li>
							</ul>
						</div></center>';
				$data[] = $row;
			}
			$output = array(
				"draw"            => $_POST['draw'],
				"recordsTotal"    => $this->dashboard_booking->count_all(),
				"recordsFiltered" => $this->dashboard_booking->count_filtered(),
				"data"            => $data,
				);
			echo json_encode($output);
		}else{
			redirect("_404","refresh");
		}
	}
	public function kirim_email_all(){
		date_default_timezone_set('Asia/Jakarta');
	    $bln    = date("m");
	    $cekbln = $this->db->query("SELECT bulan FROM tbl_bulan WHERE kode = '$bln'");
	    if(count($cekbln->result())>0){
			$ju   = $cekbln->row();
			$blnx = $ju->bulan;
	    }else{
	        $blnx = "";
	    }
	    $bln   = date("m");
        $ultah = $this->db->query("SELECT * FROM view_member WHERE MONTH(tgl_lahir) = '$bln' ORDER BY tgl_lahir ASC")->result();
        if(count($ultah)>0){
        	$cksetemail = $this->db->get('tbl_email');
			$x          = $cksetemail->row();
			$smtp_user  = $x->email;
			$smtp_pass  = $x->password;
			$config     = Array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => $smtp_user, 
				'smtp_pass' => $smtp_pass,
				'mailtype'  => 'html',
				'charset'   => 'iso-8859-1',
				'wordwrap'  => TRUE
			);
			$this->load->library('email', $config);
		    $message = $this->input->post('deskripsi');
			foreach ($ultah as $key) {
				$email_member     = $key->email;
				$this->email->clear();
				$this->email->set_newline("\r\n");
				$this->email->from($smtp_user, 'MALindo Outdoor - ['.$this->input->post('judul').']');
				$this->email->to($email_member);
				$this->email->subject($this->input->post('judul'));
				$this->email->message($message);
			    $this->email->send();
			    if($this->email->send()){
					echo json_encode(array("status" => TRUE));
		        }else{
					echo json_encode(array("status" => FALSE));
		        }
            }
        }
	}
}
