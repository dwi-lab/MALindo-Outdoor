<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/basic.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/dropzone.min.js') ?>"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<style type="text/css">
.dropzone {
    margin-top: 0px;
    border: 2px dashed #0087F7;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    jQuery('#blain').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
});
</script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse" data-sortable-id="form-dropzone-1">
            <div class="panel-heading">
                <h4 class="panel-title">Tambahkan Foto Bukti Kondisi Barang-Barang Sebelum Penyerahan ?</h4>
            </div>
            <div class="panel-body">
                <div id="dropzone">
                    <form action="" class="dropzone needsclick" id="demo-upload">
                        <div class="dz-message needsclick">
                            Drop atau Kik Foto Barang - Barang sesuai dengan Barang yang dipinjam.<br />
                            <span class="dz-note needsclick">
                                (File foto - foto berikut digunakan untuk melakukan perbandingan kondisi barang sebelum dan sesudah penyewaan.)
                            </span>
                        </div>
                        
                    </form>
                    <br/>
                    <form class="form-horizontal" method="post" action="<?php echo base_url();?>sewa/proses_add">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3">Keterangan Biaya Lainnya</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" id="blain_detil" minlength="1" name="blain_detil"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3">Biaya Lainnnya</label>
                            <div class="col-md-3 col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input class="form-control" type="text" style="text-align: right;" id="blain" name="blain"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Tambahkan Catatan ?</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="note" placeholder="Masukan Catatan Penyewaan" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-sm btn-success">Simpan Data</button>
                            </div>
                        </div>
                    </form>
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
