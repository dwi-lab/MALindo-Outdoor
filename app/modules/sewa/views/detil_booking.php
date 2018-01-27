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
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/form-plugins.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/booking_detil.js"></script>
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
                                <td class="field">Kode Booking</td>
                                <td><?php echo "<b>" . $kode_booking . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tgl Booking</td>
                                <td><?php echo date("d-m-Y",strtotime($tgl_booking));?></td>
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
                                <td class="field">Status Booking</td>
                                <td>
                                    <?php 
                                    if($status_booking==1){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Sedang Proses Booking">OnBooking</a>
                                        <?php
                                    }else if($status_booking==2){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Sedang Proses Peminjaman">InProses</a>
                                        <?php
                                    }else if($status_booking==3){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Booking Cancel">Booking Cancel</a>
                                        <?php
                                    }elseif($status_booking=='0'){
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-primary" title="Booking Finish">Booking Selesai</a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">User</td>
                                <td>
                                    <b><?php echo $kasir;?></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
        if($status_booking==1){
            ?>
            <div style="text-align: right;">
                <button 
                data-step         ="1" 
                data-intro        ="Digunakan untuk menambah data."  
                data-hint         ="Digunakan untuk menambah data." 
                data-hintPosition ="top-middle" 
                data-position     ="bottom-right-aligned"
                class="btn btn-primary btn-xs m-r-5" onclick="edit_booking('Data Booking','booking','edit_data_booking','<?php echo $kode_booking;?>')">
                    <i class="fa fa-pencil"></i> 
                    Edit Data Booking
                </button>&nbsp;
            </div>
            <?php
        }
        ?>
        
    </div>
</div>
</br>
<div class="row"> 
    <div class="col-md-12"> 
        <div class="panel panel-inverse"> 
            <div class="panel-heading"> 
                <div class="panel-heading-btn">
                    <?php 
                    if($status_booking==1){
                        ?>
                        <button 
                        data-step         ="1" 
                        data-intro        ="Digunakan untuk menambah data."  
                        data-hint         ="Digunakan untuk menambah data." 
                        data-hintPosition ="top-middle" 
                        data-position     ="bottom-right-aligned"
                        class="btn btn-primary btn-xs m-r-5" onclick="tambah_data()">
                            <i class="fa fa-plus-circle"></i> 
                            Tambah Data
                        </button>&nbsp;
                        <?php
                    }
                    ?>
                    <button 
                    data-step         ="3" 
                    data-intro        ="Digunakan untuk reload data pada database."  
                    data-hint         ="Digunakan untuk reload data pada database." 
                    data-hintPosition ="top-middle" 
                    data-position     ="bottom-right-aligned"
                    class="btn btn-warning btn-xs m-r-5" onclick="reload_table()">
                        <i class="fa fa-refresh"></i> 
                        Reload Data
                    </button> 
                </div> 
                <h4 class="panel-title">Detil Barang Yang di Booking</h4> 
            </div> 
            <div class="panel-body"> 
                <div class="table-responsive"> 
                    <table id="data-booking-detil" 
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
        <div style="text-align: center;">
            <a href="<?php echo base_url();?>sewa/cek/<?php echo $kode_booking;?>" class="btn btn-primary btn-block">Next</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datepicker({
            todayHighlight: !0
        });
        jQuery("#ket_disc_lama").hide('');
        jQuery("#b_poin").hide('');
        jQuery("#b_cash").hide('');
        jQuery("#warna").change(function(){
            var warna = jQuery("#warna").val();
            var kode  = jQuery("#kode_barang").val();
            if(warna!=""){
                jQuery.blockUI({
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: 0.5, 
                        color: '#fff' 
                    },
                    message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
                });
                setTimeout(function(){
                    jQuery.post($BASE_URL+"booking/getBarang/"+kode+"/"+warna,
                    function(data){
                        jQuery.unblockUI();
                        var dt = data.split("|");
                        jQuery("#stok_barang").val(dt[0]);
                        jQuery("#warna_barang").val(dt[1]);
                        jQuery("#foto_barang").val(dt[2]);
                        var foto         = jQuery("#foto_barang").val();
                        var warna_barang = jQuery("#warna_barang").val();
                        var stok         = jQuery("#stok_barang").val();
                        if(stok=='NotOk'){
                            $.gritter.add({title:"Informasi Barang !",text: "Data Tidak Ditemukan Untuk Saat Ini !"});
                            jQuery("#qty").val('');
                            return false;
                        }else if(stok <= 0){
                            $.gritter.add({title:"Informasi Barang !",text: "Stok Barang Tersebut Tidak Tersedia"});return false;
                        }else{
                            document.getElementById('qty').focus();
                            // jQuery("#qty").val('');
                            $.gritter.add({title:"Informasi Barang !",text: "Warna Barang : " + warna_barang + "<br/> Stok Barang : " + stok,image:'<?php echo base_url();?>assets/foto/barang/'+foto});
                            return false;
                        }
                    });
                },500);
                jQuery.unblockUI();
            }
        });
        jQuery("#warnaX").change(function(){
            var warna = jQuery("#warnaX").val();
            var kode  = jQuery("#kodeAdd").val();
            if(warna!=""){
                jQuery.blockUI({
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: 0.5, 
                        color: '#fff' 
                    },
                    message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
                });
                setTimeout(function(){
                    jQuery.post($BASE_URL+"booking/getBarang/"+kode+"/"+warna,
                    function(data){
                        jQuery.unblockUI();
                        var dt = data.split("|");
                        jQuery("#stok_barangAdd").val(dt[0]);
                        jQuery("#warna_barangAdd").val(dt[1]);
                        jQuery("#foto_barangAdd").val(dt[2]);
                        var foto         = jQuery("#foto_barangAdd").val();
                        var warna_barang = jQuery("#warna_barangAdd").val();
                        var stok         = jQuery("#stok_barangAdd").val();
                        if(stok=='NotOk'){
                            $.gritter.add({title:"Informasi Barang !",text: "Data Tidak Ditemukan Untuk Saat Ini !"});
                            jQuery("#qtyAdd").val('');
                            return false;
                        }else if(stok <= 0){
                            $.gritter.add({title:"Informasi Barang !",text: "Stok Barang Tersebut Tidak Tersedia"});return false;
                        }else{
                            document.getElementById('qtyAdd').focus();
                            // jQuery("#qty").val('');
                            $.gritter.add({title:"Informasi Barang !",text: "Warna Barang : " + warna_barang + "<br/> Stok Barang : " + stok,image:'<?php echo base_url();?>assets/foto/barang/'+foto});
                            return false;
                        }
                    });
                },500);
                jQuery.unblockUI();
            }
        });
        jQuery("#qty").change(function(){
            var stok  = jQuery("#stok_barang").val();
            var qty   = jQuery("#qty").val();
            var warna = jQuery("#warna_barang").val();
            if(warna!=""){
                if(qty!="" || parseInt(qty)  > 0){
                    if(parseInt(qty)  <= parseInt(stok)){
                        $.gritter.add({title:"Informasi Barang !",text: "Silahkan Klik Tombol Simpan untuk Menyimpan Data."});
                        return false;
                    }else{
                        $.gritter.add({title:"Informasi Barang !",text: "Jumlah Barang Melebihi Stok Barang !"});
                        jQuery("#qty").val('0');
                        document.getElementById('qty').focus();
                        return false;
                    }
                }else{
                    $.gritter.add({title:"Informasi Barang !",text: "Masukan Jumlah Barang yang akan di booking !"});
                    document.getElementById('qty').focus();
                    return false;
                }
            }else{
                $.gritter.add({title:"Informasi Barang !",text: "Masukan Jumlah Barang yang akan di booking !"});
                document.getElementById('warna').focus();
                return false;
            }
        });
        jQuery("#qtyAdd").change(function(){
            var stok  = jQuery("#stok_barangAdd").val();
            var qty   = jQuery("#qtyAdd").val();
            var warna = jQuery("#warna_barangAdd").val();
            if(warna!=""){
                if(qty!="" || parseInt(qty)  > 0){
                    if(parseInt(qty)  <= parseInt(stok)){
                        $.gritter.add({title:"Informasi Barang !",text: "Silahkan Klik Tombol Simpan untuk Menyimpan Data."});
                        return false;
                    }else{
                        $.gritter.add({title:"Informasi Barang !",text: "Jumlah Barang Melebihi Stok Barang !"});
                        jQuery("#qtyAdd").val('0');
                        document.getElementById('qtyAdd').focus();
                        return false;
                    }
                }else{
                    $.gritter.add({title:"Informasi Barang !",text: "Masukan Jumlah Barang yang akan di booking !"});
                    document.getElementById('qtyAdd').focus();
                    return false;
                }
            }else{
                $.gritter.add({title:"Informasi Barang !",text: "Masukan Jumlah Barang yang akan di booking !"});
                document.getElementById('warnaX').focus();
                return false;
            }
        });
        jQuery("#namaAdd").autocomplete({
            source: function(req,add){
                jQuery.ajax({
                    url:"<?php echo base_url() . 'booking/get_barang';?>",
                    dataType:'json',
                    type:'POST',
                    data:req,                                                   
                    success:function(data){
                        if(data.response=='true'){
                            add(data.message); 
                        }else{
                            $.gritter.add({title:"Informasi !",text: "Data yang anda cari tidak ditemukan"});
                            jQuery("#tombol").hide('');
                            jQuery("#informasi_barang_detil").hide('');
                            return false;
                        }
                    },
                    error:function(XMLHttpRequest){
                        alert(XMLHttpRequest.responseText);
                    }
                })
            },
            minLength:3,
            select: function(event,ui){
                jQuery('#kodeAdd').val(ui.item.kode);
                jQuery('#namaAdd').val(ui.item.nama);
                jQuery('#hrg_sewa').val(ui.item.harga);
                jQuery('#hrg_poin').val(ui.item.poin);
                document.getElementById('warnaX').focus();
                return false;
            }
        })
        jQuery("#tgl_selesai").change(function(){
            var mulai   = jQuery("#tgl_mulai").val();
            var selesai = jQuery("#tgl_selesai").val();
            if(mulai != "" && selesai != ""){
                jQuery.post($BASE_URL+"booking/cekLama/"+mulai+"/"+selesai,
                function(data){
                    var dt        = data.split("|");
                    jQuery("#lama_pinjam").val(dt[0]);
                    jQuery("#disc_lama_pinjam").val(dt[1]);
                    jQuery("#id_disc_lama").val(dt[2]);
                    var lama      = jQuery("#lama_pinjam").val();
                    jQuery("#lama").val(lama);
                    return false;
                });
            }else{
                $.gritter.add({title:"Informasi !",text: "Pastikan Tanggal Pinjam dan Tanggal Selesai Pinjam Sudah Terisi"});
            }
        });
    });
</script>
<div id="modal_form_add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Basic modal</h4>
            </div>
            <div class="modal-body">        
                <div class="alert alert-info alert-styled-left">
                    <small><span class="text-semibold">Pastikan Inputan Data Benar !</span></small>
                </div>      
                <form action="#" id="form_add" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <input name="kodeAdd" id="kodeAdd" type="hidden">
                            <input class="form-control" type="hidden" id="stok_barangAdd" name="stok_barangAdd" />
                            <input class="form-control" type="hidden" id="foto_barangAdd" name="foto_barangAdd" />
                            <input class="form-control" type="hidden" id="warna_barangAdd" name="warna_barangAdd" />
                            <label class="control-label col-md-3">Informasi Barang  </label>
                            <div class="col-md-8">
                                <input name="namaAdd" id="namaAdd" maxlength="150" placeholder="Masukan Informasi Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga Sewa </label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" style="text-align: right;" id="hrg_sewa" minlength="1" readonly="readonly" maxlength='20' name="hrg_sewa" data-type="text"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga Poin </label>
                            <div class="col-md-3">
                                <input class="form-control" type="text" style="text-align: right;" id="hrg_poin" minlength="1" readonly="readonly" maxlength='20' name="hrg_poin" data-type="text"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Warna Barang </label>
                            <div class="col-md-6">
                            <?php echo form_dropdown('warnaX',$option_warnaX,isset($default['warnaX']) ? $default['warnaX'] : '','class="default-select2 form-control" style="width:100%" id="warnaX" name="warnaX" data-live-search="true" data-style="btn-white"');?>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Qty </label>
                            <div class="col-md-2">
                                <input name="qtyAdd" id="qtyAdd" maxlength="30" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>                 
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveAdd" onclick="save_bookingx('booking')" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_form" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Basic modal</h4>
            </div>
            <div class="modal-body">        
                <div class="alert alert-info alert-styled-left">
                    <small><span class="text-semibold">Pastikan Inputan Data Benar !</span></small>
                </div>      
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="" name="kode_barang" id="kode_barang" /> 
                    <input class="form-control" type="hidden" id="stok_barang" name="stok_barang" />
                    <input class="form-control" type="hidden" id="stok_awal" name="stok_awal" />
                    <input class="form-control" type="hidden" id="warna_awal" name="warna_awal" />
                    <input class="form-control" type="hidden" id="foto_barang" name="foto_barang" />
                    <input class="form-control" type="hidden" id="warna_barang" name="warna_barang" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang  </label>
                            <div class="col-md-6">
                                <input name="nama" id="nama" maxlength="30" placeholder="Masukan Nama Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Warna Barang </label>
                            <div class="col-md-6">
                            <?php echo form_dropdown('warna',$option_warna,isset($default['warna']) ? $default['warna'] : '','class="default-select2 form-control" style="width:100%" id="warna" name="warna" data-live-search="true" data-style="btn-white"');?>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Qty </label>
                            <div class="col-md-2">
                                <input name="qty" id="qty" maxlength="30" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>                 
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_booking('booking')" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_form_edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Basic modal</h4>
            </div>
            <div class="modal-body">        
                <div class="alert alert-info alert-styled-left">
                    <small><span class="text-semibold">Pastikan Inputan Data Benar !</span></small>
                </div>      
                <form action="#" id="form_edit" class="form-horizontal">
                    <input class="form-control" type="hidden" id="lama_pinjam" name="lama_pinjam" />
                    <input class="form-control" type="hidden" id="jns_bayar" name="jns_bayar" />
                    <input class="form-control" type="hidden" id="subtotal_x" name="subtotal_x" />
                    <input class="form-control" type="hidden" style="text-align: right;" id="subpoin" minlength="1" readonly="readonly" maxlength='20' name="subpoin" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Booking  </label>
                            <div class="col-md-4">
                                <input name="kode_booking" id="kode_booking" maxlength="150" readonly="readonly" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Tanggal Mulai </label>
                        <div class="col-md-4">
                            <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" name="tgl_mulai" id="tgl_mulai" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Tanggal Selesai </label>
                        <div class="col-md-4">
                            <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" name="tgl_selesai" id="tgl_selesai" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Lama Pinjam  </label>
                            <div class="col-md-3">
                                <div class="input-group date" id="datepicker-default">
                                    <input name="lama" id="lama" style="text-align: right;" readonly="readonly" maxlength="150" class="form-control" type="text">
                                    <span class="input-group-addon"> hari</span>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="b_poin">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Subtotal Poin  </label>
                                <div class="col-md-4">
                                    <input name="subtotal_poin" id="subtotal_poin" style="text-align: right;" maxlength="150" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="b_cash">
                        <!-- <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3">Diskon Tetap</label>
                            <div class="col-md-3 col-sm-3">
                                <div class="input-group">
                                    <input class="form-control" type="text" style="text-align: right;" id="disc_lama_pinjam" minlength="1" readonly="readonly" maxlength='20' name="disc_lama_pinjam" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                        <div id="ket_disc_lama">
                            <div class="form-group">
                                <div class="col-md-8 col-sm-8">
                                    <span style="color:red;" id="ket_diskon_lama"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3">Diskon Khusus</label>
                            <div class="col-md-3 col-sm-3">
                                <div class="input-group">
                                    <input class="form-control" type="text" style="text-align: right;" id="disc" minlength="1" readonly="readonly" maxlength='20' name="disc" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                        <div id="ket_disc_lama">
                            <div class="form-group">
                                <div class="col-md-8 col-sm-8">
                                    <span style="color:red;" id="ket_diskon_lama"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Subtotal  </label>
                                <div class="col-md-4">
                                    <div class="input-group date" id="datepicker-default">
                                        <span class="input-group-addon">Rp.</span>
                                        <input name="subtotal" id="subtotal" style="text-align: right;" maxlength="150" readonly="readonly" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <?php
                        if($this->session->userdata('sett_')=='1'){
                            ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Potongan  </label>
                                    <div class="col-md-4">
                                        <div class="input-group date" id="datepicker-default">
                                            <span class="input-group-addon">Rp.</span>
                                            <input name="potongan" id="potongan" style="text-align: right;" maxlength="150" class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Dibayar  </label>
                                <div class="col-md-4">
                                    <div class="input-group date" id="datepicker-default">
                                        <span class="input-group-addon">Rp.</span>
                                        <input name="dibayar" id="dibayar" style="text-align: right;" maxlength="150" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Sisa Bayar  </label>
                                <div class="col-md-4">
                                    <div class="input-group date" id="datepicker-default">
                                        <span class="input-group-addon">Rp.</span>
                                        <input name="sisa" id="sisa" style="text-align: right;" maxlength="150" readonly="readonly" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>                 
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveAdd" onclick="save_bookingxx('booking')" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>