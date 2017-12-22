<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
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
        jQuery("#informasi").hide('');
        jQuery("#tombol").hide('');
        jQuery("#informasi_barang").hide('');
        jQuery("#informasi_barang_detil").hide('');
        jQuery("#status").hide('');
        jQuery("#nama").autocomplete({
            source: function(req,add){
                jQuery.ajax({
                    url:"<?php echo base_url() . 'booking/get_member';?>",
                    dataType:'json',
                    type:'POST',
                    data:req,                                                   
                    success:function(data){
                        if(data.response=='true'){
                            add(data.message); 
                        }else{
                            $.gritter.add({title:"Informasi !",text: "Data yang anda cari tidak ditemukan"});
						    jQuery("#tombol").hide('');
						    jQuery("#informasi").hide('');
        					jQuery("#status").hide('');
        					jQuery("#informasi_barang").hide('');
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
                jQuery('#nama').val(ui.item.nama+" | " + ui.item.kode);
                jQuery('#foto').val(ui.item.foto);
                jQuery('#alamat').val(ui.item.alamat);
                jQuery('#status_warna').val(ui.item.status_warna);
                jQuery('#no_handphone').val(ui.item.no_handphone);
                jQuery('#no_identitas').val(ui.item.no_identitas);
				var nama  = jQuery('#nama').val();
				var foto  = jQuery('#foto').val();
				if(ui.item.status_warna==9){
					jQuery("#informasi_barang").show('slow');
                	document.getElementById('kode_barang').focus();
					document.getElementById("status").innerHTML ="<div class=\"alert alert-success fade in\"><i class=\"fa fa-check fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>"
				}else if(ui.item.status_warna==2){
					jQuery("#informasi_barang").hide('slow');
					document.getElementById("status").innerHTML ="<div class=\"alert alert-warning fade in\"><i class=\"fa fa-remove fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>	"
				}else if(ui.item.status_warna==1){
					jQuery("#informasi_barang").show('slow');
                	document.getElementById('kode_barang').focus();
					document.getElementById("status").innerHTML ="<div class=\"alert alert-success fade in\"><i class=\"fa fa-check fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>"
				}else{
					jQuery("#informasi_barang").hide('slow');
					document.getElementById("status").innerHTML ="<div class=\"alert alert-danger fade in\"><i class=\"fa fa-remove fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>	"
				}
                $.gritter.add({title:"Informasi Member !",text: "Nama Member : " + ui.item.nama + "<br/> No HP : " + ui.item.no_handphone + "<br/> No Identitas : " + ui.item.no_identitas,image:'<?php echo base_url();?>assets/foto/member/'+foto});
                jQuery("#tombol").show("slow");
			    jQuery("#informasi").show('slow');
				jQuery("#status").show('slow');
				$("#status_pinjam").text(ui.item.status_pinjam);
                return false;
            }
        })
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
                jQuery('#kode_barang').val(ui.item.nama+" | " + ui.item.kode);
                jQuery('#nama_barang').val(ui.item.nama);
                jQuery('#hrg_sewa').val(ui.item.harga);
				jQuery("#informasi_barang_detil").show('slow');
            	document.getElementById('qty').focus();
                return false;
            }
        })
    });
</script>
<div class="row">
    <div class="col-md-12">
		<div class="panel panel-inverse" data-sortable-id="form-validation-2">
		    <div class="panel-heading">
		        <div class="panel-heading-btn">
		            <a href="javascript:void(0);" class="btn btn-info btn-xs m-r-5" title="Bantuan" onclick="javascript:introJs().start();">
						<i class="fa fa-question"></i>
					</a>
		        </div>
		        <h4 class="panel-title"><?php echo $halaman;?></h4>
		    </div>
		    <div class="panel-body panel-form">
				<div id="status">
				</div>
		        <form class="form-horizontal form-bordered" action="<?php echo $action;?>" method="post" enctype="multipart/form-data" data-parsley-validate="true">
					<?php
					if($cek=='edit'){
						?>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Foto Barang :</label>
							<div class="col-md-2 col-sm-2">
							<?php
								if($foto==""){
									$fotox = "no.jpg";
								}else{
									$fotox = $foto;
								}
							?>
								<img src="<?php echo base_url();?>assets/foto/barang/<?php echo $fotox;?>" style="width:150px;text-align:center;height:180px;">
							</div>
						</div>
						<?php
					}
					?>
					<div class="form-group">
	                    <input class="form-control" type="hidden" id="status_warna" name="status_warna" />
	                    <input class="form-control" type="hidden" id="foto" name="foto" />
						<label class="control-label col-md-3 col-sm-3">Kode Booking</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="text" readonly="readonly" id="kode" minlength="1" maxlength='20' name="kode" value="<?php echo set_value('kode',isset($default['kode']) ? $default['kode'] : ''); ?>"  data-type="kode" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                            <span style="color:red;"><?php echo form_error('kode');?></span>
						</div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Informasi Member</label>
                        <div class="col-md-8">
                            <input name="nama" id="nama" maxlength="50" placeholder="Masukan Kriteria Pencarian (Kode Member,Nama Member,No Identitas,No Hanphone)" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div id="informasi">
                    	<div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3">No Handphone</label>
	                        <div class="col-md-2">
	                            <input name="no_handphone" id="no_handphone" style="text-align: right;" readonly="readonly" maxlength="50" class="form-control" type="text">
	                            <span class="help-block"></span>
	                        </div>
	                    </div>
                    	<div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3">No Identitas</label>
	                        <div class="col-md-2">
	                            <input name="no_identitas" id="no_identitas" style="text-align: right;" readonly="readonly" maxlength="50" class="form-control" type="text">
	                            <span class="help-block"></span>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3">Alamat</label>
	                        <div class="col-md-6">
	                            <input name="alamat" id="alamat" readonly="readonly" maxlength="50" class="form-control" type="text">
	                            <span class="help-block"></span>
	                        </div>
	                    </div>
                    </div>
                    <div id="informasi_barang">
                    	<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Kode Barang</label>
							<div class="col-md-2 col-sm-2">
								<input class="form-control" type="text" id="kode_barang" minlength="1" maxlength='20' name="kode_barang" data-parsley-minlength="1" data-parsley-maxlength="20"/>
							</div>
						</div>
                    	<div id="informasi_barang_detil">
                    		<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Nama Barang</label>
								<div class="col-md-4 col-sm-4">
									<input class="form-control" type="text" id="nama_barang" minlength="1" readonly="readonly" maxlength='20' name="nama_barang" data-parsley-minlength="1" data-parsley-maxlength="20"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Harga Sewa</label>
								<div class="col-md-2 col-sm-2">
									<input class="form-control" type="text" id="hrg_sewa" minlength="1" readonly="readonly" maxlength='20' name="hrg_sewa" data-type="text" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
								</div>
							</div>
                    		<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Warna Barang</label>
								<div class="col-md-15 col-sm-3">
									<?php echo form_dropdown('warna',$option_warna,isset($default['warna']) ? $default['warna'] : '','class="default-select2 form-control" id="warna" data-size="10" data-live-search="true" data-parsley-group="wizard-step-2" data-parsley-required="true" data-style="btn-white"');?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Jumlah Barang</label>
								<div class="col-md-2 col-sm-2">
									<input class="form-control" type="number" id="qty" minlength="1" maxlength='20' name="qty" data-type="number" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3"></label>
								<div class="col-md-4 col-sm-4">
									<button type="button" id="tambahstok" class="btn btn-primary btn-xs m-r-5" title="Tambah Stok Barang"><i class="fa fa-plus"></i></button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-20 col-sm-20">
									<h4 class="widgettitle nomargin shadowed"><b>Detil Informasi Booking Barang</b></h4>
									<div class="widgetcontent bordered shadowed nomargin">
										<div class ="table-responsive" style="text-align: center;" >
											<?php 
											echo "<table width=\"50%\" text-align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id='tbladdstok'>\n"; 
											echo "  <tr>\n"; 
											echo "    <th>Nama Barang</th>\n"; 
											echo "    <th>Warna</th>\n";
											echo "    <th>QTY</th>\n";
											echo "    <th>Action</th>\n";
											echo "  </tr>\n"; 
											echo "</table>";
											?>
										</div>
									</div>
								</div>
							</div>
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
