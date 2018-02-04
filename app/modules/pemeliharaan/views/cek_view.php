<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/basic.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/dropzone.min.js') ?>"></script>
<link href="<?php echo base_url();?>assets/plugins/isotope/isotope.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/detil_pemeliharaan.js"></script>
<script src="<?php echo base_url();?>assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/lightbox/js/lightbox.min.js"></script>
<script src="<?php echo base_url();?>assets/js/gallery.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<style type="text/css">
.dropzone {
    margin-top: 0px;
    border: 2px dashed #0087F7;
}
</style>
<script>
    $(document).ready(function() {
        App.init();
        Gallery.init();
        $(".datepicker").datepicker({
            todayHighlight: !0
        });
        jQuery('#denda').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
        jQuery('#sisa_bayar').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
        jQuery("#tombol").hide('');
        jQuery('#dibayar').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
        jQuery('#total').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });
        jQuery("#tgl_selesai").change(function(){
            var mulai   = jQuery("#tgl_rkembali").val();
            var selesai = jQuery("#tgl_selesai").val();
            if(mulai != "" && selesai != ""){
                jQuery.post($BASE_URL+"pemeliharaan/cekLama/"+mulai+"/"+selesai,
                function(data){
                    var dt        = data.split("|");
                    jQuery("#lamat").val(dt[0]);
                    return false;
                });
            }else{
                $.gritter.add({title:"Informasi !",text: "Pastikan Tanggal Pinjam dan Tanggal Selesai Pinjam Sudah Terisi"});
            }
        });
        jQuery("#dibayar").change(function(){
            var sisa_bayar = jQuery("#sisa_bayar").unmask();
            var dibayar    = jQuery("#dibayar").unmask();
            var denda      = jQuery("#denda").unmask();
            var total      = parseInt(sisa_bayar) + parseInt(denda);
            if(parseInt(dibayar) < parseInt(total)){
                $.gritter.add({title:"Informasi !",text: "Pembayaran Masih Kurang !"});
                jQuery("#dibayar").val(0);
                document.getElementById('dibayar').focus();
                jQuery("#tombol").hide('');
                return false;
            }else{
                $.gritter.add({title:"Informasi !",text: "Silahkan Masukan Nominal Denda !"});
                jQuery('#sisa_bayar').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                jQuery("#tombol").show('');
                return false;
            }
        });
        jQuery("#denda").change(function(){
            var denda      = jQuery("#denda").unmask();
            var sisa_bayar = jQuery("#sisa_bayar").unmask();
            jQuery("#total").val(parseInt(denda)+parseInt(sisa_bayar));
            jQuery('#total').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
        });
    });
</script>
<style type="text/css">
.datepicker{z-index:1151 !important;}
.dropzone {
    margin-top: 0px;
    border: 2px dashed #0087F7;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Kondisi Barang Sebelum pemeliharaan</h4>
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
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse" data-sortable-id="form-dropzone-1">
            <div class="panel-heading">
                <h4 class="panel-title">Tambahkan Foto Bukti Kondisi Barang-Barang Sesudah Pemeliharaan !</h4>
            </div>
            <div class="panel-body">
                <div id="dropzone">
                    <form action="" class="dropzone needsclick" id="demo-upload">
                        <div class="dz-message needsclick">
                            Drop atau Kik Foto Barang - Barang sesuai dengan Barang yang sudah dilakukan Pemeliharaan.<br />
                            <span class="dz-note needsclick">
                                (File foto - foto berikut digunakan untuk melakukan perbandingan kondisi barang sebelum dan sesudah Pemeliharaan.)
                            </span>
                        </div>
                    </form>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Berikut List Barang yang sedang dilakukan Pemeliharaan</h4>
            </div>
            <form name="form" id="form" action="<?php echo base_url();?>pemeliharaan/proses_update" class="form-horizontal form-bordered" enctype="multipart/form-data"  method="post" data-parsley-validate="true">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="data-list"
                        data-step         ="4"
                        data-intro        ="List Data yang tersimpan pada database."
                        data-hint         ="List Data yang tersimpan pada database."
                        data-hintPosition ="top-middle"
                        data-position     ="bottom-right-aligned"
                        class="table table-striped table-bordered nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th width="1%" style="text-align:center">
                                        <input type="checkbox" name="select_all" value="1" style="text-align:center" id="select-all">
                                    </th>
                                    <th style="text-align:center" width="10%">Foto Barang</th>
                                    <th style="text-align:center" width="10%">Kode Barang</th>
                                    <th style="text-align:center" width="40%">Nama Barang</th>
                                    <th style="text-align:center" width="10%">Warna Barang</th>
                                    <th style="text-align:center" width="10%">Harga Sewa</th>
                                    <th style="text-align:center" width="7%">Qty</th>
                                    <th style="text-align:center" width="10%">Jml Dikembalikan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Tanggal Pemeliharaan :</label>
                    <div class="col-md-2 col-sm-2">
                        <div class="input-group">
                            <input type="text" class="form-control" style="text-align: right;" readonly="readonly" name="tgl_pemeliharaan" id="tgl_pemeliharaan" value="<?php echo set_value('tgl_pemeliharaan',isset($default['tgl_pemeliharaan']) ? $default['tgl_pemeliharaan'] : ''); ?>"  />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Tanggal Selesai :</label>
                    <div class="col-md-2 col-sm-2">
                        <div class="input-group input-daterange" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" name="tgl_selesai" id="tgl_selesai" />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Total Pembayaran </label>
                    <div class="col-md-3 col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input class="form-control" type="text" style="text-align: right;" id="total" minlength="1" name="total" data-parsley-minlength="1" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Bukti Pembayaran </label>
                    <div class="col-md-3 col-sm-3">
                        <input name="MAX_FILE_SIZE" value="9999999999" type="hidden">
                        <input type="file" id="foto" name="foto" />  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3"></label>
                    <div class="col-md-3 col-sm-3">
                        <button type="submit" class="btn btn-success btn-sm">SIMPAN</button>
                        <button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm">BATAL</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    var foto_upload= new Dropzone(".dropzone",{
        url: "<?php echo base_url('pemeliharaan/proses_uploadx') ?>",
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
            url:"<?php echo base_url('pemeliharaan/remove_fotox') ?>",
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