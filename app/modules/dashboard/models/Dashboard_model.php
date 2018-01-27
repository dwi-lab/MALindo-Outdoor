<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getOrderPerbulan(){
        $result = $this->db->query("SELECT YEAR(tgl_booking) as year, MONTH(tgl_booking) as month, COUNT(id) as num FROM tbl_booking GROUP BY YEAR(tgl_booking), MONTH(tgl_booking) ASC");
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
    public function getSewaPerbulan(){
        $result = $this->db->query("SELECT YEAR(tgl_transaksi) as year, MONTH(tgl_transaksi) as month, COUNT(id) as num FROM tbl_trans GROUP BY YEAR(tgl_transaksi), MONTH(tgl_transaksi) ASC");
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
    public function getBalikPerbulan(){
        $result = $this->db->query("SELECT YEAR(tgl_kembali) as year, MONTH(tgl_kembali) as month, COUNT(id) as num FROM tbl_pengembalian GROUP BY YEAR(tgl_kembali), MONTH(tgl_kembali) ASC");
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
    public function getPemeliharaanPerbulan(){
        $result = $this->db->query("SELECT YEAR(tgl_pemeliharaan) as year, MONTH(tgl_pemeliharaan) as month, COUNT(id) as num FROM tbl_pemeliharaan GROUP BY YEAR(tgl_pemeliharaan), MONTH(tgl_pemeliharaan) ASC");
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
    public function getDaftarPerbulan(){
        $result = $this->db->query("SELECT YEAR(tgl_daftar) as year, MONTH(tgl_daftar) as month, COUNT(kode_member) as num FROM tbl_member GROUP BY YEAR(tgl_daftar), MONTH(tgl_daftar) ASC");
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
