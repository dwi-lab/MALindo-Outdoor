<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>MALindo Outdoor</title>
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 12px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    .rtl table {
        text-align: right;
    }
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="http://oi64.tinypic.com/n1b3fp.jpg" style="width:100%; max-width:300px;">
                            </td>
                            <td>
                                Kode Transaksi <b>#<?php echo $kode_transaksi;?></b><br>
                                Tanggal Transaksi: <?php echo $tgl_transaksi;?><br>
                                <small><font color="red"><?php echo $tgl_mulai;?> s/d <?php echo $tgl_selesai;?></font></small><br/>
                                <b>Jenis Bayar : <font color="red"><?php echo $jns_bayar;?></font></b><br/>
                                <?php
                                if($jnsx_bayar=='2'){
                                    ?>
                                        <b><font color="red">* Pembayaran dengan poin diskon tidak berlaku.</font></b>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>MALindo Outdoor.</strong><br />
                                JL. DR. Moch. Hatta No. 168 Kel. Sukamanah <br />
                                Kec. Cipedes Kota Tasikmalaya<br />
                                Tlp : 0813-2014-7000<br />
                                e-mail : malindooutdoor@gmail.com<br/>
                                user : <?php echo "<b>".$kasir."</b>";?>
                            </td>
                            <td>
                                <strong><?php echo $nama_member;?></strong><br />
                                <?php echo $alamat_member;?><br />
                                <?php echo $alamat_detil;?><br />
                                Tlp: <?php echo $tlp_member;?><br />
                                e-mail: <?php echo $email_member;?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <?php
                if($jnsx_bayar=='2'){
                    ?>
                    <td>
                        Rincian Peminjaman
                    </td>
                    <td>
                        Harga Sewa #
                    </td>
                    <td>
                        Harga Poin #
                    </td>
                    <td>
                        Lama Pinjam
                    </td>
                    <td>
                        Total
                    </td>
                    <?php
                }else{
                    ?>
                    <td>
                        Rincian Peminjaman
                    </td>
                    <td>
                        Harga Sewa #
                    </td>
                    <td>
                        Lama Pinjam
                    </td>
                    <td>
                        Total
                    </td>
                    <?php
                }
                ?>
                
            </tr>
            <tr class="details">
                <?php
                if($jnsx_bayar=='2'){
                    $detil = $this->db->query("SELECT * FROM tbl_trans a JOIN tbl_trans_detil b ON a.kode_transaksi = b.kode_transaksi JOIN view_barang_detil c ON b.kode_barang = c.kode JOIN tbl_warna d ON b.kode_warna = d.id WHERE a.kode_transaksi = '$kode_transaksi'  GROUP BY b.kode_barang,b.kode_warna")->result();
                    if(count($detil)>0){
                        foreach ($detil as $row) {
                            $ckpoin = $this->db->get_where('tbl_barang',array('kode'=>$row->kode_barang));
                            $xx     = $ckpoin->row();
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row->nama_barang;?><br />
                                    <small>Warna Barang : <?php echo $row->warna;?> </small>
                                    <!-- <small>Tipe Barang <?php echo $row->tipe;?> Merk Barang : <?php echo $row->merk;?> Warna Barang : <?php echo $row->warna;?> </small> -->
                                </td>
                                <td><?php echo number_format($row->hrg_sewa);?></td>
                                <td><?php echo number_format($xx->poin);?></td>
                                <td><?php echo number_format($row->lama) . " hari";?></td>
                                <td><?php echo number_format($row->hrg_sewa * $row->lama);?></td>
                            </tr>
                            <?php
                        }
                    }
                }else{
                    $detil = $this->db->query("SELECT * FROM tbl_trans a JOIN tbl_trans_detil b ON a.kode_transaksi = b.kode_transaksi JOIN view_barang_detil c ON b.kode_barang = c.kode JOIN tbl_warna d ON b.kode_warna = d.id WHERE a.kode_transaksi = '$kode_transaksi' GROUP BY b.kode_barang,b.kode_warna")->result();
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
                }?>
            </tr>
            <tr class="heading">
                <td>
                    Subtotal
                </td>
                <td>
                    Diskon Tetap ( <?php echo number_format($diskon_pinjam);?> %)
                </td>
                <td>
                    Diskon Khusus ( <?php echo number_format($diskon_momen);?> %)
                </td>
                <td>
                    Total Bayar
                </td>
                <?php
                if($jnsx_bayar!='2'){
                    echo '<td>
                        Sisa Bayar
                    </td>';
                }else{
                    echo '<td>
                        Sisa Poin Anda
                    </td>';
                }
                ?>
            </tr>
            <tr class="details">
                <?php
                if($jnsx_bayar=='2'){
                    ?>
                        <tr>
                          <td>
                            <?php echo number_format($subtotal) . " Poin";?>
                          </td>
                          <td>
                            <?php echo number_format(0);?><br/>
                            <small><font color="red"><?php echo "";?></font></small>
                          </td>
                          <td>
                            <?php echo number_format(0);?><br/>
                            <small><font color="red"><?php echo "";?></font></small>
                          </td>
                          <td>
                            <?php echo number_format($total_bayar) . " Poin";?><br/>
                          </td>
                          <td>
                            <font color="red"><b><?php echo number_format($sisa_poin) . " Poin";?></b></font>
                          </td>
                        </tr> 
                    <?php
                }else{
                    ?>
                        <tr>
                          <td>
                            <?php echo number_format($subtotal);?><br/>
                            <?php
                            if($potongan!=""){
                                ?>
                                    <small><font color="red"><?php echo "Potongan : Rp. " . number_format($potongan);?></font></small>
                                <?php
                            }
                            ?>
                          </td>
                          <td>
                            <?php echo number_format($tot_diskon_pinjam);?><br/>
                            <small><font color="red"><?php echo $nama_diskon_pinjam;?></font></small>
                          </td>
                          <td>
                            <?php echo number_format($tot_diskon_momen);?><br/>
                            <small><font color="red"><?php echo $nama_diskon_momen;?></font></small>
                          </td>
                          <td>
                            <?php echo number_format($total_bayar);?><br/>
                            <small><font color="red"><?php echo $status;?></font></small>
                          </td>
                          <td>
                            <font color="red"><b><?php echo number_format($sisa_bayar);?></b></font>
                          </td>
                        </tr> 
                    <?php
                }
                ?>
            </tr>
        </table>
        <br/>
        <?php echo "<font size='2' color='red'>" . " * " . $note . "</small><br/>";?>
        <br/>
        <?php
        $syarat = $this->db->get_where('tbl_syarat',array('status'=>'1'))->result();
        if(count($syarat)>0){
            foreach ($syarat as $xx) {
                echo "<font size='1' color='red'>" . " * " . $xx->ket . "</small><br/>";
            }
        }
        ?>
    </div>
</body>
</html>