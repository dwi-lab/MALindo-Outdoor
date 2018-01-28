<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone.min.css') ?>">
<link href="<?php echo base_url();?>assets/plugins/isotope/isotope.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/basic.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/dropzone.min.js') ?>"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/barang.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/sewa_detil_proses.js"></script>
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
.dropzone {
    margin-top: 0px;
    border: 2px dashed #0087F7;
}
</style>
<div class="row"> 
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
</div>
<div class="row">
    <div class="col-md-12"> 
        <div class="alert alert-info fade in m-b-15">
            <strong>Informasi!</strong><br/>
            <b>Ceklis</b> Barang yang akan dikembalikan, untuk barang yang <b>tidak di ceklis</b> secara otomatis akan masuk ke data pemeliharaan barang.
        </div>
        <div class="panel panel-inverse"> 
            <div class="panel-heading"> 
                <h4 class="panel-title">Berikut List Barang yang disewa</h4>
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
    </div>
</div>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    var foto_upload= new Dropzone(".dropzone",{
        url: "<?php echo base_url('sewa/proses_upload') ?>",
        maxFilesize: 2,
        method:"post",
        acceptedFiles:"image/*",
        paramName:"userfile",
        dictInvalidFileType:"Type file ini tidak dizinkan",
        addRemoveLinks:true,
    });
    foto_upload.on("sending",function(a,b,c){
        a.token=Math.random();
        c.append("token_foto",a.token); 
    });
    foto_upload.on("removedfile",function(a){
        var token=a.token;
        $.ajax({
            type:"post",
            data:{token:token},
            url:"<?php echo base_url('sewa/remove_foto') ?>",
            cache:false,
            dataType: 'json',
            success: function(){
                console.log("Foto terhapus");
            },
            error: function(){
                console.log("Error");
            }
        });
    });
</script>
