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
<script src="<?php echo base_url();?>assets/js/sewa_detil_pengembalian.js"></script>
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
        jQuery("#tgl_kembali").change(function(){
            var mulai   = jQuery("#tgl_rkembali").val();
            var selesai = jQuery("#tgl_kembali").val();
            if(mulai != "" && selesai != ""){
                jQuery.post($BASE_URL+"pengembalian/cekLama/"+mulai+"/"+selesai,
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
        <div class="panel panel-inverse" data-sortable-id="form-dropzone-1">
            <div class="panel-heading">
                <h4 class="panel-title">Tambahkan Foto Bukti Kondisi Barang-Barang Sesudah Penyewaan !</h4>
            </div>
            <div class="panel-body">
                <div id="dropzone">
                    <form action="" class="dropzone needsclick" id="demo-upload">
                        <div class="dz-message needsclick">
                            Drop atau Kik Foto Barang - Barang sesuai dengan Barang yang akan dikembalikan.<br />
                            <span class="dz-note needsclick">
                                (File foto - foto berikut digunakan untuk melakukan perbandingan kondisi barang sebelum dan sesudah penyewaan.)
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
       <!--  <div class="alert alert-info fade in m-b-15">
            <strong>Informasi!</strong><br/>
            <b>Ceklis</b> Barang yang akan dikembalikan, untuk barang yang <b>tidak di ceklis</b> secara otomatis akan masuk ke data pemeliharaan barang.
        </div>
 -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Berikut List Barang yang disewa</h4>
            </div>
            <form name="form" id="form" action="<?php echo base_url();?>pengembalian/proses_add" class="form-horizontal form-bordered" method="post" data-parsley-validate="true">
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
                    <label class="control-label col-md-3 col-sm-3">Tanggal Sewa :</label>
                    <div class="col-md-2 col-sm-2">
                        <div class="input-group">
                            <input type="text" class="form-control" style="text-align: right;" readonly="readonly" name="tgl_sewa" id="tgl_sewa" value="<?php echo set_value('tgl_sewa',isset($default['tgl_sewa']) ? $default['tgl_sewa'] : ''); ?>"  />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Rencana Tanggal Pengembalian :</label>
                    <div class="col-md-2 col-sm-2">
                        <div class="input-group">
                            <input type="text" class="form-control" style="text-align: right;" readonly="readonly" name="tgl_rkembali" value="<?php echo set_value('tgl_rkembali',isset($default['tgl_rkembali']) ? $default['tgl_rkembali'] : ''); ?>" id="tgl_rkembali" />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Lama Pinjam :</label>
                    <div class="input-group col-md-2 col-sm-2">
                        <input class="form-control" type="text" style="text-align: right;" readonly="readonly" id="lama" minlength="1" name="lama" value="<?php echo set_value('lama',isset($default['lama']) ? $default['lama'] : ''); ?>" data-type="lama" data-parsley-required="true" data-parsley-minlength="1" />
                        <span class="input-group-addon">Hari</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Tanggal Pengembalian :</label>
                    <div class="col-md-2 col-sm-2">
                        <div class="input-group input-daterange" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" name="tgl_kembali" id="tgl_kembali" />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Lama Keterlambatan :</label>
                    <div class="input-group col-md-2 col-sm-2">
                        <input class="form-control" type="text" style="text-align: right;" readonly="readonly" id="lamat" minlength="1" name="lamat" value="<?php echo set_value('lamat',isset($default['lamat']) ? $default['lamat'] : ''); ?>" data-type="lamat" data-parsley-required="true" data-parsley-minlength="1" />
                        <span class="input-group-addon">Hari</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Sisa Pembayaran</label>
                    <div class="col-md-3 col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input class="form-control" type="text" style="text-align: right;" id="sisa_bayar" readonly="readonly" value="<?php echo $sisa_bayar;?>" minlength="1" name="sisa_bayar" data-parsley-minlength="1" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Denda</label>
                    <div class="col-md-3 col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input class="form-control" type="text" style="text-align: right;" id="denda" minlength="1" name="denda" data-parsley-minlength="1" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Total Pembayaran <br/><small><font color="red">Sisa Pembayaran + Denda</font></small></label>
                    <div class="col-md-3 col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input class="form-control" type="text" style="text-align: right;" readonly="readonly" id="total" minlength="1" name="total" data-parsley-minlength="1" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Dibayar</label>
                    <div class="col-md-3 col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input class="form-control" type="text" style="text-align: right;" id="dibayar" minlength="1" name="dibayar" data-parsley-minlength="1" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3">Catatan</label>
                    <div class="col-md-9">
                        <textarea class="form-control" name="note" placeholder="Masukan Catatan Penyewaan" rows="5"></textarea>
                    </div>
                </div>
                <div id="tombol">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3"></label>
                        <div class="col-md-3 col-sm-3">
                            <button type="submit" class="btn btn-success btn-sm">SIMPAN</button>
                            <button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm">BATAL</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    var foto_upload= new Dropzone(".dropzone",{
        url: "<?php echo base_url('pengembalian/proses_upload') ?>",
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
            url:"<?php echo base_url('pengembalian/remove_foto') ?>",
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