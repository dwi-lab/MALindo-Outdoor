<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Poin_model extends CI_Model {
    var $table         = 'tbl_poin';
    var $column_order  = array('id','nominal_a','nominal_b','jml_poin',null);
    var $column_search = array('nominal','jml_poin'); 
    var $order         = array('lama' => 'desc');
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
    public function get_by_id($id){
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function update($where, $data){
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    public function simpan($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function hapus_by_id($id){
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}