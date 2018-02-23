<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dropzone.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/basic.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/dropzone.min.js') ?>"></script>
<style type="text/css">
.dropzone {
    margin-top: 0px;
    border: 2px dashed #0087F7;
}
</style>
<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/form-plugins.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<style>
.datepicker{z-index:1151 !important;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datepicker({
            todayHighlight: !0
        });
        $('#tglmulai').datepicker();
    	$('#tglselesai').datepicker();
        jQuery("#kode_barang").autocomplete({
            source: function(req,add){
                jQuery.ajax({
                    url:"<?php echo base_url() . 'booking/get_barang';?>",
                    dataType:'json',
                    type:'POST',
                    data:req,                                                   
                    success:function(data){
                        if(data.response=='true'){
                            add(data.message); 
						    jQuery("#tombol").show('');
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
                jQuery('#kode_barang').val(ui.item.kode);
                jQuery('#nama_barang').val(ui.item.nama);
                jQuery('#hrg_sewa').val(ui.item.harga);
                jQuery('#hrg_poin').val(ui.item.poin);
				jQuery("#informasi_barang_detil").show('slow');
            	document.getElementById('warna').focus();
                return false;
            }
        })
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
			                jQuery("#qty").val('');
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
						$.gritter.add({title:"Informasi Barang !",text: "Silahkan Klik Tombol Tambah untuk menambah Barang."});
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
    });
</script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse" data-sortable-id="form-dropzone-1">
            <div class="panel-heading">
                <h4 class="panel-title">Tambahkan Foto Bukti Kondisi Barang-Barang Sebelum Pemeliharaan ?</h4>
            </div>
            <div class="panel-body">
                <div id="dropzone">
                    <form action="" class="dropzone needsclick" id="demo-upload">
                        <div class="dz-message needsclick">
                            Drop atau Kik Foto Barang - Barang sesuai dengan Barang yang akan dilakukan proses Pemeliharaan.<br />
                            <span class="dz-note needsclick">
                                (File foto - foto berikut digunakan untuk melakukan perbandingan kondisi barang sebelum dan sesudah Pemeliharaan.)
                            </span>
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
        url: "<?php echo base_url('pemeliharaan/proses_upload') ?>",
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
            url:"<?php echo base_url('pemeliharaan/remove_foto') ?>",
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
<div class="row">
    <div class="col-md-12">
		<div class="panel panel-inverse" data-sortable-id="form-validation-2">
		    <div class="panel-heading">
		        <h4 class="panel-title"><?php echo $halaman;?></h4>
		    </div>
		    <div class="panel-body panel-form">
				<div id="status">
				</div>
		        <form class="form-horizontal form-bordered" action="<?php echo $action;?>" method="post" enctype="multipart/form-data" data-parsley-validate="true">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tanggal Pemeliharaan</label>
						<div class="col-md-2 col-sm-2">
							<div class="input-group date" id="tglmulai" data-date-format="dd-mm-yyyy">
	                            <input type="text" class="form-control" name="tglpemeliharaan" id="tglpemeliharaan" data-parsley-minlength="10" data-parsley-maxlength="10" minlength="10" maxlength="10" data-parsley-required="true"/>
	                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                        </div>
	                    </div>
					</div>
					<div class="form-group">
	                    <input class="form-control" type="hidden" id="status_warna" name="status_warna" />
	                    <input class="form-control" type="hidden" id="stok_barang" name="stok_barang" />
	                    <input class="form-control" type="hidden" id="foto_barang" name="foto_barang" />
	                    <input class="form-control" type="hidden" id="warna_barang" name="warna_barang" />
						<label class="control-label col-md-3 col-sm-3">Kode Transaksi</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="text" readonly="readonly" id="kode" minlength="1" maxlength='20' name="kode" value="<?php echo set_value('kode',isset($default['kode']) ? $default['kode'] : ''); ?>"  data-type="kode" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                            <span style="color:red;"><?php echo form_error('kode');?></span>
						</div>
					</div>
                	<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Pilih Mitra Pemeliharaan</label>
						<div class="col-md-15 col-sm-8">
							<select name="mitra" class="default-select2 form-control" id="mitra" data-size="20" data-live-search="true" data-style="btn-white">
							<?php
							$ckmitra = $this->db->get('tbl_pemeliharaan_mitra')->result();
							if(count($ckmitra)>0){
								foreach ($ckmitra as $key) {
									?>
									<option value="" selected="selected">Pilih Mitra Pemeliharaan</option>
									<option value="<?php echo $key->id;?>"><?php echo $key->nama_mitra . " | " . $key->kontak . " | " . $key->no_kontak;?></option>
									<?php
								}
							}else{
								?>
									<option value="" selected="selected">Mitra Pemeliharaan Belum Tersedia</option>
								<?php
							}
							?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Informasi Barang</label>
						<div class="col-md-8">
							<input class="form-control" type="text" id="kode_barang" minlength="1" placeholder="Masukan Informasi Barang (Kode Barang,Nama Barang)" maxlength='20' name="kode_barang" data-parsley-minlength="1" data-parsley-maxlength="50"/>
						</div>
					</div>
            		<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Barang</label>
						<div class="col-md-4 col-sm-4">
							<input class="form-control" type="text" id="nama_barang" minlength="1" readonly="readonly" maxlength='20' name="nama_barang" data-parsley-minlength="1" data-parsley-maxlength="20"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Sewa<br/>
						<small><font color="red">* permalam</font></small></label>
						<div class="col-md-2 col-sm-2">
							<div class="input-group">
                                <span class="input-group-addon">Rp.</span>
								<input class="form-control" type="text" style="text-align: right;" id="hrg_sewa" minlength="1" readonly="readonly" maxlength='20' name="hrg_sewa" data-type="text"/>
                            </div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Poin<br/>
						<small><font color="red">* permalam</font></small></label>
						<div class="col-md-1 col-sm-1">
							<div class="input-group">
								<input class="form-control" type="text" id="hrg_poin" style="text-align: right;" id="hrg_poin" minlength="1" readonly="readonly" maxlength='20' name="hrg_poin" data-type="text"/>
                            </div>
						</div>
					</div>
            		<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Warna Barang</label>
						<div class="col-md-15 col-sm-3">
							<?php echo form_dropdown('warna',$option_warna,isset($default['warna']) ? $default['warna'] : '','class="default-select2 form-control" id="warna" data-size="10" data-live-search="true" data-style="btn-white"');?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Jumlah Barang</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="number" id="qty" minlength="1" maxlength='20' name="qty" data-type="number"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3"></label>
						<div class="col-md-4 col-sm-4">
							<button type="button" id="tambahbooking" class="btn btn-primary btn-xs m-r-5" title="Tambah Pemeliharaan Barang"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-20 col-sm-20">
							<h4 class="widgettitle nomargin shadowed"><b>Detil Informasi Pemeliharaan Barang</b></h4>
							<div class="widgetcontent bordered shadowed nomargin">
								<div class ="table-responsive" style="text-align: center;" >
									<?php 
									echo "<table width=\"80%\" text-align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id='tbladdbarang'>\n"; 
									echo "  <tr>\n"; 
									echo "    <th>Nama Barang</th>\n"; 
									echo "    <th>Warna</th>\n";
									echo "    <th>Harga Sewa</th>\n";
									echo "    <th>Harga Poin</th>\n";
									echo "    <th>QTY</th>\n";
									echo "    <th>Total</th>\n";
									echo "    <th>Action</th>\n";
									echo "  </tr>\n"; 
									echo "</table>";
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
                        <label class="col-md-2 control-label">Tambahkan Catatan ?</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="note" placeholder="Masukan Catatan Penyewaan" rows="5"></textarea>
                        </div>
                    </div>
                    <div id="tombol">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3"></label>
							<div class="col-md-3 col-sm-3">
								<button type="submit" class="btn btn-success btn-sm"><?php echo $tombolsimpan;?></button>
	                      		<button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm"><?php echo $tombolbatal ; ?></button>
							</div>
						</div>
                    </div>
		        </form>
		    </div>
		</div>
	</div>
</div>
