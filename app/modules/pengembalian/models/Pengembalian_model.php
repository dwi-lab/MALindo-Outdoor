<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengembalian_model extends CI_Model {
    var $table         = 'view_pengembalian';
    var $table_        = 'tbl_pengembalian';
    var $column_order  = array('kode_transaksi','foto','nama','tgl_sewa','tgl_selesai','tgl_selesai','lama','tgl_kembali','keterlambatan',null);
    var $column_search = array('kode_transaksi','nama','tgl_sewa','tgl_selesai','tgl_selesai','lama','keterlambatan'); 
    var $order         = array('kode_transaksi' => 'desc');
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query(){
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
        $this->db->where('kode_transaksi',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function count_all(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function hapus_by_kode_transaksi($kode_transaksi){
        $this->db->where('kode_transaksi', $kode_transaksi);
        $this->db->delete($this->table_);
    }
}