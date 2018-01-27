<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ganti_bg extends CI_Controller {
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $menu    = "tools";
        $submenu = "Background Login";
        $this->service->login();
        $this->service->validasi_menu($menu);
        $this->service->validasi_submenu($submenu);
        if($this->session->userdata('level')=='0'){
            return TRUE;
        }else{
            $page = "ganti_bg";
            $this->service->hak_aksessubmenu($page);
        }
    }
    public function index(){
        $this->_content();
    }
    public function _content(){
        $isi['kelas']        = "tools";
        $isi['namamenu']     = "Background Login";
        $isi['page']         = "ganti_bg";
        $isi['link']         = 'ganti_bg';
        $isi['actionhapus']  = 'hapus';
        $isi['actionedit']   = 'edit';
        $isi['tombolsimpan'] = "Edit";
        $isi['tombolbatal']  = "Batal";
        $isi['action']       = 'proses_edit';
        $isi['halaman']      = "Data Background Login";
        $isi['judul']        = "Halaman Data Background Login";
        $isi['content']      = "ganti_bg_view";
        $this->load->view("dashboard/dashboard_view",$isi);
    }
    public function edit($kode){
        $isi['kelas']        = "tools";
        $isi['namamenu']     = "Background Login";
        $isi['page']         = "ganti_bg";
        $isi['link']         = 'ganti_bg';
        $isi['actionhapus']  = 'hapus';
        $isi['actionedit']   = 'edit';
        $isi['cek']          = 'edit';
        $isi['tombolsimpan'] = "Edit";
        $isi['tombolbatal']  = "Batal";
        $isi['action']       = '../proses_edit';
        $isi['halaman']      = "Edit Data Background Login";
        $isi['judul']        = "Halaman Data Background Login";
        $isi['content']      = "form_ganti_bg";
        $this->session->set_userdata('kodena',$kode);
        $umenu = $this->db->get_where('tbl_bglogin',array('id'=>$kode))->result();
        foreach ($umenu as $key) {
            $isi['foto'] = $key->logo;
        }
        $this->load->view("dashboard/dashboard_view",$isi);
    }
    public function cekdata($kode=Null){
        $data['say'] = "ok";
        if('IS_AJAX'){
            echo json_encode($data); 
        }   
    }
    public function hapus($id=null){
        $ckdata = $this->db->get_where('tbl_bglogin',array('id'=>$id))->result();
        if(count($ckdata)>0){
            $data['say'] = "ok";
            $this->hapusfotox($id);
            $this->db->where('id',$id);
            if($this->db->delete('tbl_bglogin')){
                $data['say'] = "ok";
            }else{
                $data['say'] = "NotOk";
            }
            if('IS_AJAX'){
                echo json_encode($data);
            }   
        }else{
            redirect('_404','refresh');
        }
    }
    public function proses_edit(){
        $nmfile = "file_".time();
        $tmpName = $_FILES['foto']['tmp_name'];
        if($tmpName!=''){
            $config['file_name']     = $nmfile;
            $config['upload_path']   = 'assets/img/login-bg';
            $config['allowed_types'] = 'gif|jpg|png|bmp';
            $config['max_size']      = '1048';
            $config['max_width']     = '0';
            $config['max_height']    = '0';
            $config['overwrite']     = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')){
                $this->hapusfoto();
                $gbr    = $this->upload->data();
                $simpan = array('logo'=>$gbr['file_name']);
                $this->db->where('id',$this->session->userdata('kodena'));
                $this->db->update('tbl_bglogin',$simpan);
            }else{
                ?>
                <script type="text/javascript">
                    alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 1MB");
                    window.location.href="<?php echo base_url();?>ganti_bg";
                </script>
                <?php
            }
        }else{
            ?>
            <script type="text/javascript">
                alert("Pastikan Data Tidak Kosong Type File gif || jpg || bmp || png dan ukuran file maksimal 1MB");
                window.location.href="<?php echo base_url();?>ganti_bg";
            </script>
            <?php
        }
        $this->session->unset_userdata('kodena');
        redirect('ganti_bg','refresh');
    }
    function hapusfoto(){
        $ckdata = $this->db->get_where('tbl_bglogin',array('id'=>$this->session->userdata('kodena')))->result();
        foreach ($ckdata as $hehe) {
            $fotona = $hehe->logo;
        }
        if($fotona!="no.jpg"){
            unlink('./assets/img/login-bg/' . $fotona);
        }
    }
    function hapusfotox($id=null){
        $ckdata = $this->db->get_where('tbl_bglogin',array('id'=>$id))->result();
        foreach ($ckdata as $hehe) {
            $fotona = $hehe->logo;
        }
        if($fotona!="no.jpg"){
            unlink('./assets/img/login-bg/' . $fotona);
        }
    }
    public function add(){
        $isi['kelas']        = "tools";
        $isi['namamenu']     = "Background Login";
        $isi['page']         = "ganti_bg";
        $isi['link']         = 'ganti_bg';
        $isi['cek']          = 'ad';
        $isi['actionhapus']  = 'hapus';
        $isi['actionedit']   = 'edit';
        $isi['tombolsimpan'] = "Simpan";
        $isi['tombolbatal']  = "Batal";
        $isi['action']       = 'proses_add';
        $isi['halaman']      = "Add Data Background Login";
        $isi['judul']        = "Halaman Data Background Login";
        $isi['content']      = "form_ganti_bg";
        $this->load->view("dashboard/dashboard_view",$isi);
    }
    public function proses_add(){
        $nmfile = "file_".time();
        $tmpName = $_FILES['foto']['tmp_name'];
        if($tmpName!=''){
            $config['file_name']     = $nmfile;
            $config['upload_path']   = 'assets/img/login-bg';
            $config['allowed_types'] = 'gif|jpg|png|bmp';
            $config['max_size']      = '0';
            $config['max_width']     = '0';
            $config['max_height']    = '0';
            $config['overwrite']     = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')){
                $gbr    = $this->upload->data();
                $simpan = array('logo'=>$gbr['file_name']);
                $this->db->insert('tbl_bglogin',$simpan);
            }else{
                ?>
                <script type="text/javascript">
                    alert("Pastikan Type File gif || jpg || bmp || png dan ukuran file maksimal 1MB");
                    window.location.href="<?php echo base_url();?>ganti_bg/add";
                </script>
                <?php
            }
        }else{
            ?>
            <script type="text/javascript">
                alert("Pastikan Data Tidak Kosong Type File gif || jpg || bmp || png dan ukuran file maksimal 1MB");
                window.location.href="<?php echo base_url();?>ganti_bg/add";
            </script>
            <?php
        }
        redirect('ganti_bg','refresh');
    }
}
