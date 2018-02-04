<link href="<?php echo base_url();?>assets/plugins/isotope/isotope.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script src="<?php echo base_url();?>assets/js/barang.js"></script>
<script src="<?php echo base_url();?>assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/lightbox/js/lightbox.min.js"></script>
<script src="<?php echo base_url();?>assets/js/gallery.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/form-plugins.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/sewa_detil_proses.js"></script>
<script>
    $(document).ready(function() {
        App.init();
        Gallery.init();
    });
</script>
<?php
    $ckdatapengembalian = $this->db->get_where('view_pengembalian',array('kode_transaksi'=>$kode_transaksi));
    if(count($ckdatapengembalian->result())>0){
        ?>
        <script src="<?php echo base_url();?>assets/js/barang_kembali.js"></script>
        <?php
    };
?>
<style type="text/css">
    .ui-autocomplete {
        z-index: 5000;
    }
</style>
<div class="profile-container">
    <div class="profile-section">
        <div class="profile-left">
            <div class="profile-image" title="Foto Profile">
                <?php
                if($foto==""){
                    $fotox = "no.jpg";
                }else{
                    $fotox = $foto;
                }
                ?>
                <img src="<?php echo base_url();?>assets/foto/member/<?php echo $fotox;?>" style="width:200px;text-align:center;height:180px;">
                <i class="fa fa-user hide"></i>
            </div>
            <br/>
            <div class="profile-image" title="Foto Identitas">
                <?php
                if($foto_identitas==""){
                    $foto_identitas = "no.jpg";
                }else{
                    $foto_identitas = $foto_identitas;
                }
                ?>
                <img src="<?php echo base_url();?>assets/foto/identitas/<?php echo $foto_identitas;?>" style="width:200px;text-align:center;height:180px;">
                <i class="fa fa-user hide"></i>
            </div>
        </div>
        <div class="profile-right">
            <div class="profile-info">
                <div class="table-responsive">
                    <table class="table table-profile">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h4><?php echo $nama;?> <small><?php echo $no_identitas;?></small></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="highlight">
                                <td class="field">Kode Member</td>
                                <td><?php echo $kode_member;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Jenis Kelamin</td>
                                <td><?php if($jk=='1'){echo 'Laki-Laki';}else{echo 'Perempuan';};?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tanggal Lahir</td>
                                <td><?php echo date("d-m-Y",strtotime($tgllahir));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Provinsi</td>
                                <td><?php echo $provinsi;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kota</td>
                                <td><?php echo $kota;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kecamatan</td>
                                <td><?php echo $kecamatan;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kelurahan</td>
                                <td><?php echo $kelurahan;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Alamat</td>
                                <td><?php echo $almt;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Umur</td>
                                <td><?php echo $umur;?> Tahun</td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Pekerjaan</td>
                                <td><?php echo $kerja;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">No Handphone</td>
                                <td><?php echo $hp;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">E-mail</td>
                                <td><?php echo $mail;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tanggal Daftar</td>
                                <td><?php echo date("d-m-Y",strtotime($tgldaftar));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kode Transaksi</td>
                                <td><?php echo "<b>" . $kode_transaksi . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tgl Transaksi</td>
                                <td><?php echo date("d-m-Y",strtotime($tgl_transaksi));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tgl Sewa</td>
                                <td><?php echo date("d-m-Y",strtotime($tgl_mulai));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tgl Selesai</td>
                                <td><?php echo date("d-m-Y",strtotime($tgl_selesai));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Lama Sewa</td>
                                <td><?php echo "<b><font color='red'>" . number_format($lama) . " hari </font></b>" ;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Poin Bayar</td>
                                <td><?php echo "<b>" . number_format($poin_bayar) . "</b>";?></td>
                            </tr>
                           <!--  <tr class="highlight">
                                <td class="field">Harga Poin</td>
                                <td><?php echo "<b>Rp. " . number_format($harga_poin) . "</b>";?></td>
                            </tr> -->
                            <tr class="highlight">
                                <td class="field">Subtotal</td>
                                <td><?php echo "<b>Rp. " . number_format($subtotal_x) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Potongan</td>
                                <td><?php echo "<b>Rp. " . number_format($potongan) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Diskon Tetap</td>
                                <td><?php echo "<b>" . number_format($diskon_pinjam) . " % = Rp. " . number_format($subtotal_x * $diskon_pinjam / 100) . " </b>&nbsp;dari Subtotal";?>&nbsp;&nbsp;<small><font color="red"><?php echo $nama_diskon_pinjam;?></small></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Diskon Khusus</td>
                                <td><?php echo "<b>" . number_format($diskon_momen) . " % = Rp. " . number_format($subtotal_x * $diskon_momen / 100) . "</b>&nbsp;dari Subtotal";?>&nbsp;&nbsp;<small><font color="red"><?php echo $nama_diskon_momen;?></font></small></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Total</td>
                                <td><?php echo "<b>Rp. " . number_format($subtotal) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Dibayar</td>
                                <td><?php echo "<b>Rp. " . number_format($total_bayar) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Sisa</td>
                                <td><?php echo "<b><font color='red'>Rp. " . number_format($sisa_bayar) . "</font></b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Jenis Bayar</td>
                                <td>
                                    <b><font color="red"><?php echo $jns_bayar;?></font></b>
                                </td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">User</td>
                                <td>
                                    <b><?php echo $kasir;?></b>
                                </td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Status Transaksi</td>
                                <td>
                                    <?php 
                                    if($status_transaksi==1){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Pengecekan">OnProses</a>
                                        <?php
                                    }else if($status_transaksi==2){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Sedang Proses Peminjaman">InProses</a>
                                        <?php
                                    }else if($status_transaksi==3){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Penyewaan Cancel">Penyewaan Cancel</a>
                                        <?php
                                    }elseif($status_transaksi=='0'){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-primary" title="Penyewaan Finish">Penyewaan Selesai</a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $ckdatapengembalian = $this->db->get_where('view_pengembalian',array('kode_transaksi'=>$kode_transaksi));
                            if(count($ckdatapengembalian->result())>0){
                                ?>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                            <h4>Informasi Pengembalian <small><?php echo $kode_transaksi;?></small></h4>
                                        </th>
                                    </tr>
                                </thead>
                                <?php
                                $xa                 = $ckdatapengembalian->row();
                                $lama_keterlambatan = $xa->lama_keterlambatan;
                                $userna             = $xa->user;
                                $ckuser             = $this->db->get_where('tbl_username',array('kode'=>$userna));
                                $xx                 = $ckuser->row();
                                $namauser           = $xx->nama;
                                if($sisa_bayar=='0'){
                                    ?>
                                    <tr class="highlight">
                                        <td class="field">Status Pembayaran</td>
                                        <td><?php echo "<b><font color='red'>LUNAS</font></b>";?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr class="highlight">
                                    <td class="field">Tgl Pengembalian</td>
                                    <td><?php echo "<b>" . date("d-m-Y",strtotime($xa->tgl_kembali)) . "</b>" ;?></td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">Lama Keterlambatan</td>
                                    <td><?php echo "<b><font color='red'>" . number_format($lama_keterlambatan) . " hari </font></b>" ;?></td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">Waktu Pengembalian</td>
                                    <td><?php echo "<b><font color='red'>" . date("H:i:s",strtotime($xa->waktu)) . "</font></b>" ;?></td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">Denda</td>
                                    <td><?php echo "<b>Rp. " . number_format($xa->denda) . "</b>";?></td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">User</td>
                                    <td>
                                        <b><?php echo $namauser;?></b>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
<div class="row"> 
    <div class="col-md-12"> 
        <div class="panel panel-inverse"> 
            <div class="panel-heading"> 
                <h4 class="panel-title">Detil Barang Yang di Pinjam</h4> 
            </div> 
            <div class="panel-body"> 
                <div class="table-responsive"> 
                    <table id="data-sewa-detil" 
                    data-step         ="4" 
                    data-intro        ="List Data yang tersimpan pada database."  
                    data-hint         ="List Data yang tersimpan pada database." 
                    data-hintPosition ="top-middle" 
                    data-position     ="bottom-right-aligned"
                    class="table table-striped table-bordered nowrap" width="100%"> 
                        <thead> 
                            <tr> 
                                <th style="text-align:center" width="1%">No.</th> 
                                <th style="text-align:center" width="10%">Foto Barang</th> 
                                <th style="text-align:center" width="10%">Kode Barang</th> 
                                <th style="text-align:center" width="40%">Nama Barang</th> 
                                <th style="text-align:center" width="10%">Warna Barang</th> 
                                <th style="text-align:center" width="10%">Harga Sewa</th> 
                                <th style="text-align:center" width="7%">Qty</th> 
                                <th style="text-align:center" width="10%">Action</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                        </tbody> 
                    </table> 
                </div> 
            </div>
        </div> 
        <?php
        if($status_transaksi==1){
            ?>
            <div style="text-align: center;">
                <a href="<?php echo base_url();?>pengembalian/cek/<?php echo $kode_transaksi;?>" class="btn btn-primary btn-block">Next</a>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    $ckdatapengembalian = $this->db->get_where('view_pengembalian',array('kode_transaksi'=>$kode_transaksi));
    if(count($ckdatapengembalian->result())>0){
        ?>
        <div class="col-md-12"> 
            <div class="panel panel-inverse"> 
                <div class="panel-heading"> 
                    <h4 class="panel-title">Detil Barang Yang di Kembalikan</h4> 
                </div> 
                <div class="panel-body"> 
                    <div class="table-responsive"> 
                        <table id="data-barangkembali" 
                        data-step         ="4" 
                        data-intro        ="List Data yang tersimpan pada database."  
                        data-hint         ="List Data yang tersimpan pada database." 
                        data-hintPosition ="top-middle" 
                        data-position     ="bottom-right-aligned"
                        class="table table-striped table-bordered nowrap" width="100%"> 
                            <thead> 
                                <tr> 
                                    <th style="text-align:center" width="1%">No.</th> 
                                    <th style="text-align:center" width="10%">Foto Barang</th> 
                                    <th style="text-align:center" width="10%">Kode Barang</th> 
                                    <th style="text-align:center" width="40%">Nama Barang</th> 
                                    <th style="text-align:center" width="10%">Warna Barang</th> 
                                    <th style="text-align:center" width="10%">Harga Sewa</th> 
                                    <th style="text-align:center" width="7%">Qty</th> 
                                    <th style="text-align:center" width="10%">Action</th> 
                                </tr> 
                            </thead> 
                            <tbody> 
                            </tbody> 
                        </table> 
                    </div> 
                </div>
            </div> 
        </div>
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Kondisi Barang Sebelum Pengembalian</h4>
                    </div>
                    <div class="panel-body">
                        <div id="gallery" class="gallery">
                            <?php
                            $ckfoto = $this->db->get_where('tbl_trans_foto',array('kode_transaksi'=>$kode_transaksi))->result();
                            if(count($ckfoto)>0){
                                foreach ($ckfoto as $key) {
                                    $nama_foto = $key->nama_foto;
                                    ?>
                                    <div class="image gallery-group-1">
                                        <div class="image-inner">
                                            <a href="<?php echo base_url();?>upload-foto/<?php echo $nama_foto;?>" data-lightbox="gallery-group-1">
                                                <img src="<?php echo base_url();?>upload-foto/<?php echo $nama_foto;?>" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }else{
                                ?>
                                <div class="alert alert-danger fade in col-md-12">
                                    <strong>Informasi!</strong>
                                    Foto Kondisi Barang Tidak ditemukan untuk Kode Transaksi <b><?php echo $kode_transaksi;?></b>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Kondisi Barang Sesudah Pengembalian</h4>
                    </div>
                    <div class="panel-body">
                        <div id="gallery2" class="gallery">
                            <?php
                            $ckfoto = $this->db->get_where('tbl_pengembalian_foto',array('kode_transaksi'=>$kode_transaksi))->result();
                            if(count($ckfoto)>0){
                                foreach ($ckfoto as $key) {
                                    $nama_foto = $key->nama_foto;
                                    ?>
                                    <div class="image gallery-group-1">
                                        <div class="image-inner">
                                            <a href="<?php echo base_url();?>upload-foto/<?php echo $nama_foto;?>" data-lightbox="gallery-group-1">
                                                <img src="<?php echo base_url();?>upload-foto/<?php echo $nama_foto;?>" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }else{
                                ?>
                                <div class="alert alert-danger fade in col-md-12">
                                    <strong>Informasi!</strong>
                                    Foto Kondisi Barang Tidak ditemukan untuk Kode Transaksi <b><?php echo $kode_transaksi;?></b>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    };?>
</div>
