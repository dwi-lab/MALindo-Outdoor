<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Service{
    protected $CI;
    function __construct(){
      $this->CI =& get_instance();
      date_default_timezone_set('Asia/Jakarta');
    }
    function keurlogin(){
      if($this->CI->session->userdata('login') == FALSE){
         return FALSE;
      }
      return TRUE;
    }
    function login(){
      if($this->keurlogin() == FALSE){
         redirect('login','refresh');
      }
    }
    function anti($inp) {
      if(is_array($inp))
         return array_map(__METHOD__, $inp);
      if(!empty($inp) && is_string($inp)) {
         return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
      }
      return $inp;
    } 
    function do_logout(){
      $this->CI->session->sess_destroy();
    }
    function validasi_menu($menu){
      $cekmenu = $this->CI->db->get_where('tbl_menu',array('kelas'=>$menu,'status'=>'1'))->result();
      if(count($cekmenu)>0){
         return TRUE;
      }else{
         redirect('_404','refresh');
      }
    }
    function validasi_submenu($submenu){
      $cekmenu = $this->CI->db->get_where('tbl_submenu',array('nama_smenu'=>$submenu,'sstatus'=>'1'))->result();
      if(count($cekmenu)>0){
         return TRUE;
      }else{
         redirect('_404','refresh');
      }
    }
    function validasi_submenux($submenux){
      $cekmenux = $this->CI->db->get_where('tbl_submenux',array('nama_smenux'=>$submenux,'sstatusx'=>'1'))->result();
      if(count($cekmenux)>0){
         return TRUE;
      }else{
         redirect('_404','refresh');
      }
    }
    public function cekmenu($namamenu){
      $smenu = $this->CI->db->get_where('tbl_submenu',array('slink'=>$namamenu,'sstatus'=>'1'))->result();
      foreach ($smenu as $key ) {
         $menuid = trim($key->smenu_id);
      }
      $hak = explode("|",$this->CI->session->userdata('priv'));
      $out = "";
      for($i=0;$i<count($hak);$i++){
         if($hak[$i]===$menuid){
            $out .= "TRUE|";
         }else{
            $out .= "FALSE|";
         }
      } 
      if(strpos($out,'TRUE') === FALSE) {
         return FALSE;
      }
      return TRUE;
    }
    public function hak_aksessubmenu($namamenu){
      if($this->cekmenu($namamenu) == FALSE){
         redirect('_404','refresh');
      }
    }
    public function hak_aksessubmenux($namamenu){
      if($this->cekmenux($namamenu) == FALSE){
         redirect('_404','refresh');
      }
    }
    public function cekmenux($namamenu){
      $smenu = $this->CI->db->get_where('tbl_submenux',array('slinkx'=>$namamenu,'sstatusx'=>'1'));
      foreach ($smenu->result() as $key ) {
         $menuidx = trim($key->smenu_id);
      }
      $hakx = explode("|",$this->CI->session->userdata('privx'));
      $out = "";
      for($i=0;$i<count($hakx);$i++){
         if($hakx[$i]===$menuidx){
            $out .= "TRUE|";
         }else{
            $out .= "FALSE|";
         }
      } 
      if(strpos($out,'TRUE') === FALSE) {
         return FALSE;
      }
      return TRUE;
    }
    function now(){
      return date('Y-m-d H:i:s');
    }
    function log_aktivitas($ket,$link){
      $this->CI->load->database();
      return $this->CI->db->insert('tbl_tracking', array(
         'ip'           =>$_SERVER['REMOTE_ADDR'],
         'kode_pegawai' =>$this->CI->session->userdata('kode'),
         'tgl'          =>date('Y-m-d'),
         'waktu'        =>date('H:i:s'),
         'link'         =>$link,
         'ket'          =>$ket));
    }
    function umur($tgl_lahir,$delimiter='-') {
      list($hari,$bulan,$tahun) = explode($delimiter, $tgl_lahir);
      $selisih_hari             = date('d') - $hari;
      $selisih_bulan            = date('m') - $bulan;
      $selisih_tahun            = date('Y') - $tahun;
      if ($selisih_hari < 0 || $selisih_bulan < 0) {
         $selisih_tahun--;
      }
      return $selisih_tahun;
    }
}