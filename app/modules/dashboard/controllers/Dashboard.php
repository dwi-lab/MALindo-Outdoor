<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct(){
  		parent::__construct();
  		$this->service->login();
		$this->load->model('dashboard_model');
		date_default_timezone_set('Asia/Jakarta');
 	}
	public function index(){
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
		$subject                = "Promo Ulang Tahun";
		$from_email             = $x->email;
		$ci->email->initialize($config);
		$ci->email->from($from_email, 'MALindo Outdoor - [Selamat Ulang Tahun]');
		$email_member     = $this->input->post('email');
		$isi['deskripsi'] = $this->input->post('deskripsi');
		$list             = array($email_member);
		$ci->email->to($list);
		$ci->email->subject($subject);
		$body                   = $this->load->view('email',$isi,TRUE);
        $ci->email->message($body);
        if($this->email->send()){
			echo json_encode(array("status" => TRUE));
        }else{
			echo json_encode(array("status" => FALSE));
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
			$subject                = "Promo Ulang Tahun";
			$from_email             = $x->email;
			$ci->email->initialize($config);
			$ci->email->from($from_email, 'MALindo Outdoor - [Selamat Ulang Tahun]');
			foreach ($ultah as $key) {
				$email_member     = $key->email;
            }
			$isi['deskripsi'] = $this->input->post('deskripsi');
			$list             = array($email_member);
			$ci->email->to($list);
			$ci->email->subject($subject);
			$body                   = $this->load->view('email',$isi,TRUE);
	        $ci->email->message($body);
	        if($this->email->send()){
				echo json_encode(array("status" => TRUE));
	        }else{
				echo json_encode(array("status" => FALSE));
	        }
        }
	}
}
