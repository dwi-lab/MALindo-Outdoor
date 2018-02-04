<script type="text/javascript">
function kirim_email($kode_transaksi) {
    jQuery.post($BASE_URL+"pemeliharaan/kirim_email/"+$kode_transaksi,
    function(data){
        if(data.response=='true'){
            $.gritter.add({title:"Informasi Invoice !",text: "Nota Pemeliharaan Terkirim ke e-mail Mitra !"});
        }else{
            $.gritter.add({title:"Informasi Invoice !",text: "Nota Pemeliharaan Gagal Terkirim ke e-mail Mitra !"});
        }
    });
}
</script>
<link href="<?php echo base_url();?>assets/css/invoice-print.min.css" rel="stylesheet" />
<div class="invoice">
    <div class="invoice-company">
        <span class="pull-right hidden-print">
        <a href="javascript:;" onclick="window.print();kirim_email('<?php echo $kode_transaksi;?>');" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</a>
        <a href="javascript:;" onclick="kirim_email('<?php echo $kode_transaksi;?>');" class="btn btn-sm btn-primary m-b-10"><i class="fa fa-envelope m-r-5"></i> Kirim E-mail</a>
        </span>
        <b>MALindo Outdoor</b>
    </div>
    <div class="invoice-header">
        <div class="invoice-from">
            <small>dari</small>
            <address class="m-t-5 m-b-5">
                <strong>MALindo Outdoor.</strong><br />
                JL. DR. Moch. Hatta No. 168 Kel. Sukamanah <br />
                Kec. Cipedes Kota Tasikmalaya<br />
                Tlp : 0813-2014-7000<br />
                e-mail : malindooutdoor@gmail.com<br />
            </address>
        </div>
        <div class="invoice-to">
            <small>ke</small>
            <address class="m-t-5 m-b-5">
                <strong><?php echo $nama_mitra;?></strong><br />
                <?php echo $alamat_mitra;?><br />
                Tlp: <?php echo $tlp_mitra;?><br />
                e-mail: <?php echo $email_mitra;?>
            </address>
        </div>
        <div class="invoice-date">
            <small>Nota Pemeliharaan</small>
            <div class="date m-t-5"><?php echo $tgl_pemeliharaan;?></div>
            <div class="invoice-detail">
                #<?php echo $kode_transaksi;?><br />
                <b>Pemeliharaan</b><br/>
            </div>
        </div>
    </div>
    <div class="invoice-content">
        <div class="table-responsive">
            <table class="table table-invoice">
                    <thead>
                        <tr>
                            <th>Rincian Pemeliharaan</th>
                            <th>QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $detil = $this->db->query("SELECT * FROM view_pemeliharaan_detil WHERE kode_transaksi = '$kode_transaksi'")->result();
                        if(count($detil)>0){
                            foreach ($detil as $row) {
                                $kode_barang  = $row->kode_barang;
                                $cknamabarang = $this->db->get_where('tbl_barang',array('kode'=>$kode_barang));
                                $x            = $cknamabarang->row();
                                $ckwarna      = $this->db->get_where('tbl_warna',array('id'=>$row->kode_warna));
                                $xw           = $ckwarna->row();
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $x->nama_barang;?><br />
                                        <small>Warna Barang : <?php echo $xw->warna;?> </small>
                                    </td>
                                    <td>
                                        <?php echo $row->qty;?><br />
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </div>
    <div class="invoice-note">
        <?php echo "<font color='red'>Note : " . $keterangan . "</font>";?>
    </div>
    <div class="invoice-footer text-muted">
        <p class="text-center m-b-5">
            Terimakasih Atas Kepercayaan Yang Telah Diberikan
        </p>
        <p class="text-center">
            <span class="m-r-10"><i class="fa fa-globe"></i> malindooutdoor.com</span>
            <span class="m-r-10"><i class="fa fa-phone"></i> T:0813-2014-7000</span>
            <span class="m-r-10"><i class="fa fa-envelope"></i> malindooutdoor@gmail.com</span>
        </p>
    </div>
</div>