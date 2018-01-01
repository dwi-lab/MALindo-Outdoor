<script type="text/javascript">
function kirim_email($kode_booking) {
    jQuery.post($BASE_URL+"booking/kirim_email/"+$kode_booking,
    function(data){
        if(data.response!='true'){
            $.gritter.add({title:"Informasi Invoice !",text: "Nota Pesanan Terkirim ke e-mail member !"});
            return false;
        }else{
            $.gritter.add({title:"Informasi Invoice !",text: "Nota Pesanan Gagal Terkirim ke e-mail member !"});
            return false;
        }
    });
}
</script>
<link href="<?php echo base_url();?>assets/css/invoice-print.min.css" rel="stylesheet" />
<div class="invoice">
    <div class="invoice-company">
        <span class="pull-right hidden-print">
        <a href="javascript:;" onclick="window.print();kirim_email('<?php echo $kode_booking;?>');" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</a>
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
                e-mail : malindooutdoor@gmail.com
            </address>
        </div>
        <div class="invoice-to">
            <small>ke</small>
            <address class="m-t-5 m-b-5">
                <strong><?php echo $nama_member;?></strong><br />
                <?php echo $alamat_member;?><br />
                <?php echo $alamat_detil;?><br />
                Tlp: <?php echo $tlp_member;?><br />
                e-mail: <?php echo $email_member;?>
            </address>
        </div>
        <div class="invoice-date">
            <small>Nota Pesanan</small>
            <div class="date m-t-5"><?php echo $tgl_booking;?></div>
            <div class="invoice-detail">
                #<?php echo $kode_booking;?><br />
                <b>Pesanan</b><br/>
                <small><font color="red"><?php echo $tgl_mulai;?> s/d <?php echo $tgl_selesai;?></font></small><br/>
                <b>Jenis Bayar : <font color="red"><?php echo $jns_bayar;?></font></b>
            </div>
        </div>
    </div>
    <div class="invoice-content">
        <div class="table-responsive">
            <table class="table table-invoice">
                <thead>
                    <tr>
                        <th>Rincian Pesanan</th>
                        <th>Harga Sewa</th>
                        <th>Lama Pinjam</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $detil = $this->db->query("SELECT * FROM tbl_booking a JOIN tbl_booking_detil b ON a.kode_booking = b.kode_booking JOIN view_barang_detil c ON b.kode_barang = c.kode WHERE a.kode_booking = '$kode_booking' GROUP BY b.kode_barang,b.kode_warna")->result();
                    if(count($detil)>0){
                        foreach ($detil as $row) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row->nama_barang;?><br />
                                    <small>Warna Barang : <?php echo $row->warna;?> </small>
                                    <!-- <small>Tipe Barang <?php echo $row->tipe;?> Merk Barang : <?php echo $row->merk;?> Warna Barang : <?php echo $row->warna;?> </small> -->
                                </td>
                                <td><?php echo number_format($row->hrg_sewa);?></td>
                                <td><?php echo number_format($row->lama) . " hari";?></td>
                                <td><?php echo number_format($row->hrg_sewa * $row->lama);?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="invoice-price">
            <div class="invoice-price-left">
                <div class="invoice-price-row">
                    <div class="sub-price">
                        <small>Subtotal</small>
                        <?php echo number_format($subtotal);?>
                    </div>
                    <div class="sub-price">
                        <i class="fa fa-minus"></i>
                    </div>
                    <div class="sub-price">
                        <small>Diskon Tetap (<?php echo number_format($diskon_pinjam);?> %)</small>
                        <?php echo number_format($tot_diskon_pinjam);?>
                        <small><font color="red"><?php echo $nama_diskon_pinjam;?></font></small>
                    </div>
                    <div class="sub-price">
                        <i class="fa fa-minus"></i>
                    </div>
                    <div class="sub-price">
                        <small>Diskon Khusus (<?php echo number_format($diskon_momen);?> %)</small>
                        <?php echo number_format($tot_diskon_momen);?>
                        <small><font color="red"><?php echo $nama_diskon_momen;?></font></small>
                    </div>
                    <div class="sub-price">
                        <i class="fa fa-minus"></i>
                    </div>
                    <div class="sub-price">
                        <small>Dibayar</small>
                        <?php echo number_format($total_bayar);?>
                        <small><font color="red"><?php echo $status;?></font></small>
                    </div>
                </div>
            </div>
            <div class="invoice-price-right">
                <small>SISA PEMBAYARAN</small> <?php echo number_format($sisa_bayar);?>
            </div>
        </div>
    </div>
    <div class="invoice-note">
        <?php
        $syarat = $this->db->get_where('tbl_syarat',array('status'=>'1'))->result();
        if(count($syarat)>0){
            foreach ($syarat as $xx) {
                echo " * " . $xx->ket;
            }
        }
        ?>
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