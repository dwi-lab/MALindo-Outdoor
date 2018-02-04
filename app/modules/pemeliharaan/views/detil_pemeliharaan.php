<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/isotope/isotope.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/form-plugins.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/pemeliharaan_detil.js"></script>
<script src="<?php echo base_url();?>assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/lightbox/js/lightbox.min.js"></script>
<script src="<?php echo base_url();?>assets/js/gallery.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script>
    $(document).ready(function() {
        App.init();
        Gallery.init();
    });
</script>
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
                    $buktix = "no.jpg";
                }else{
                    $buktix = $foto;
                }
                ?>
                <img src="<?php echo base_url();?>assets/foto/bukti_pemeliharaan/<?php echo $buktix;?>" style="width:200px;text-align:center;height:180px;">
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
                                    <h4><?php echo $nama_mitra;?> </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="highlight">
                                <td class="field">Kode Transaksi</td>
                                <td><?php echo $kode_transaksi;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Alamat</td>
                                <td><?php echo $alamat;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kontak</td>
                                <td><?php echo $kontak;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">No Kontak</td>
                                <td><?php echo $no_kontak;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">E-mail</td>
                                <td><?php echo $mail;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tanggal Pemeliharaan</td>
                                <td><?php echo date("d-m-Y",strtotime($tglpemeliharaan));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tanggal Selesai</td>
                                <td><?php echo date("d-m-Y",strtotime($tglselesai));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Total Pembayaran</td>
                                <td><?php echo "<b>" . number_format($total_bayar) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <tr class="highlight">
                                    <td class="field">Status Transaksi</td>
                                    <td>
                                        <?php 
                                        if($status_transaksi==1){
                                            ?>
                                            <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Pemeliharaan">InProses</a>
                                            <?php
                                        }elseif($status_transaksi=='0'){
                                            ?>
                                            <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-primary" title="Pemeliharaan Finish">Pemeliharaan Selesai</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
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
                <h4 class="panel-title">Data Pemeliharaan Barang</h4> 
            </div> 
            <div class="panel-body"> 
                <div class="table-responsive"> 
                    <table id="data-pemeliharaan-detil" 
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
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Kondisi Barang Sebelum Pemeliharaan</h4>
            </div>
            <div class="panel-body">
                <div id="gallery" class="gallery">
                    <?php
                    $ckfoto = $this->db->get_where('tbl_pemeliharaan_foto',array('kode_transaksi'=>$kode_transaksi))->result();
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
</div>
<?php
if($status_transaksi==1){
    ?>
    <div style="text-align: center;">
        <a href="<?php echo base_url();?>pemeliharaan/cek/<?php echo $kode_transaksi;?>" class="btn btn-primary btn-block">Pemeliharaan Selesai ?</a>
    </div>
    <?php
}else{
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Kondisi Barang Sesudah Pemeliharaan</h4>
                </div>
                <div class="panel-body">
                    <div id="gallery2" class="gallery">
                        <?php
                        $ckfoto = $this->db->get_where('tbl_pemeliharaan_selesai_foto',array('kode_transaksi'=>$kode_transaksi))->result();
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
    </div>
    <?php
}
?>