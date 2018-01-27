<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barang_model extends CI_Model {
    var $table         = 'view_barang';
    var $table_        = 'tbl_barang';
    var $column_order  = array('kode','nama_barang','tipe','merk','total_stok',null);
    var $column_search = array('kode','nama_barang','tipe','merk','total_stok'); 
    var $order         = array('kode' => 'desc');
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query(){
        if($this->input->post('tipe')){
            $this->db->where("id_tipe=",$this->input->post('tipe'));
        }
        if($this->input->post('warna')){
            $this->db->where("id_warna=",$this->input->post('warna'));
        }
        if($this->input->post('merk')){
            $this->db->where("id_merk=",$this->input->post('merk'));
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
    public function update($where, $data){
        $this->db->update($this->table_, $data, $where);
        return $this->db->affected_rows();
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
    public function get_by_id($id){
        $this->db->from($this->table);
        $this->db->where('kode',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function count_all(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function hapus_by_kode($kode){
        $this->db->where('kode', $kode);
        $this->db->delete($this->table_);
    }
    public function getBarangPerbulan($kode){
        $result = $this->db->query("SELECT YEAR(tgl_transaksi) as year, MONTH(tgl_transaksi) as month, SUM(lama) as num FROM tbl_trans GROUP BY YEAR(tgl_transaksi), MONTH(tgl_transaksi) ASC");
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