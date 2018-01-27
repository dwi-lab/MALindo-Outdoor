<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Member_model extends CI_Model {
    var $table         = 'view_member';
    var $table_        = 'tbl_member';
    var $column_order  = array('foto','kode_member','nama','alamat','email','jns_kel','kerja','no_identitas','no_handphone',null);
    var $column_search = array('kode_member','nama','alamat','email','jns_kel','kerja','no_identitas','no_handphone','tgl_lahir'); 
    var $order         = array('kode_member' => 'desc');
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query(){
        if($this->input->post('kerja')){
            $this->db->where("id_kerja=",$this->input->post('kerja'));
        }
        if($this->input->post('jns_kel')){
            $this->db->where("jns_kel=",$this->input->post('jns_kel'));
        }
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if(isset($_POST['order'])){
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables(){
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function hapus_by_kode_member($kode_member){
        $this->db->where('kode_member', $kode_member);
        $this->db->delete($this->table_);
    }
    public function getOrderPerbulan($kode){
        $result = $this->db->query("SELECT YEAR(tgl_booking) as year, MONTH(tgl_booking) as month, COUNT(id) as num FROM tbl_booking WHERE kode_member = '$kode' GROUP BY YEAR(tgl_booking), MONTH(tgl_booking) ASC");
        $result = $result->result_array();
        $orders = array();
        $years  = array();
        foreach ($result as $res) {
            if (!isset($orders[$res['year']])) {
                for ($i = 1; $i <= 12; $i++) {
                    $orders[$res['year']][$i] = 0;
                }
            }
            $years[]                             = $res['year'];
            $orders[$res['year']][$res['month']] = $res['num'];
        }
        return array(
            'years'  => array_unique($years),
            'orders' => $orders
        );
    }
    public function getSewaPerbulan($kode){
        $result = $this->db->query("SELECT YEAR(tgl_transaksi) as year, MONTH(tgl_transaksi) as month, COUNT(id) as num FROM tbl_trans WHERE kode_member = '$kode' GROUP BY YEAR(tgl_transaksi), MONTH(tgl_transaksi) ASC");
        $result = $result->result_array();
        $orders = array();
        $years  = array();
        foreach ($result as $res) {
            if (!isset($orders[$res['year']])) {
                for ($i = 1; $i <= 12; $i++) {
                    $orders[$res['year']][$i] = 0;
                }
            }
            $years[]                             = $res['year'];
            $orders[$res['year']][$res['month']] = $res['num'];
        }
        return array(
            'years'  => array_unique($years),
            'orders' => $orders
        );
    }
}