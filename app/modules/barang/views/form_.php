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
        jQuery('#hrgbeli').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#hrgsusut').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#hrgsewa').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#poin').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });         
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
					<div
					data-step         ="1"
					data-intro        ="Untuk Kode Barang Sudah Otomatis"
					data-hint         ="Untuk Kode Barang Sudah Otomatis"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Kode Barang</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="text" readonly="readonly" id="kode" minlength="1" maxlength='20' name="kode" value="<?php echo set_value('kode',isset($default['kode']) ? $default['kode'] : ''); ?>" data-type="kode" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                            <span style="color:red;"><?php echo form_error('kode');?></span>
						</div>
					</div>
					<div
					data-step         ="2"
					data-intro        ="Masukan Nama Barang."
					data-hint         ="Masukan Nama Barang."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Barang</label>
						<div class="col-md-4 col-sm-4">
							<input class="form-control" type="text" id="nama" minlength="1" maxlength='50' name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="50"/>
                            <span style="color:red;"><?php echo form_error('nama');?></span>
						</div>
					</div>
					<div
					data-step         ="7"
					data-intro        ="Masukan Tanggal Beli Barang. Format Tanggal dd-mm-yyyy."
					data-hint         ="Masukan Tanggal Beli Barang. Format Tanggal dd-mm-yyyy."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tanggal Beli</label>
						<div class="col-md-2 col-sm-2">
							<div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
	                            <input type="text" class="form-control" name="tglbeli" value="<?php echo set_value('tglbeli',isset($default['tglbeli']) ? $default['tglbeli'] : ''); ?>" data-type="tglbeli" data-parsley-minlength="10" data-parsley-maxlength="10" minlength="10" maxlength="10" data-parsley-required="true"/>
	                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                            <span style="color:red;"><?php echo form_error('tglbeli');?></span>
	                        </div>
	                    </div>
					</div>
					<div
					data-step         ="8"
					data-intro        ="Masukan Harga Beli Barang. "
					data-hint         ="Masukan Harga Beli Barang. "
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Beli</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" maxlength="15" style="text-align:right" type="text" id="hrgbeli" minlength="1" name="hrgbeli" value="<?php echo set_value('hrgbeli',isset($default['hrgbeli']) ? $default['hrgbeli'] : ''); ?>" data-type="hrgbeli" data-parsley-required="true" data-parsley-minlength="1" data-parsley-minlength="15"/>
                            <span style="color:red;"><?php echo form_error('hrgbeli');?></span>
						</div>
					</div>
					<div
					data-step         ="9"
					data-intro        ="Masukan Biaya Penyusutan Barang. "
					data-hint         ="Masukan Biaya Penyusutan Barang. "
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Biaya Penyusutan</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" maxlength="15" style="text-align:right" type="text" id="hrgsusut" minlength="1" name="hrgsusut" value="<?php echo set_value('hrgsusut',isset($default['hrgsusut']) ? $default['hrgsusut'] : ''); ?>" data-type="hrgsusut" data-parsley-required="true" data-parsley-minlength="1" data-parsley-minlength="15"/>
                            <span style="color:red;"><?php echo form_error('hrgsusut');?></span>
						</div>
					</div>
					<div
					data-step         ="10"
					data-intro        ="Masukan Harga Sewa Barang. "
					data-hint         ="Masukan Harga Sewa Barang. "
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Sewa</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" maxlength="15" style="text-align:right" type="text" id="hrgsewa" minlength="1" name="hrgsewa" value="<?php echo set_value('hrgsewa',isset($default['hrgsewa']) ? $default['hrgsewa'] : ''); ?>" data-type="hrgsewa" data-parsley-required="true" data-parsley-minlength="1" data-parsley-minlength="15"/>
                            <span style="color:red;"><?php echo form_error('hrgsewa');?></span>
						</div>
					</div>
					<div
					data-step         ="10"
					data-intro        ="Masukan Poin Harga Sewa permalam. "
					data-hint         ="Masukan Poin Harga Sewa permalam. "
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Poin</label>
						<div class="col-md-1 col-sm-1">
							<input class="form-control" maxlength="3" style="text-align:right" type="text" id="poin" minlength="1" name="poin" value="<?php echo set_value('poin',isset($default['poin']) ? $default['poin'] : ''); ?>" data-type="poin" data-parsley-required="true" data-parsley-minlength="1" data-parsley-minlength="3"/>
                            <span style="color:red;"><?php echo form_error('poin');?></span>
						</div>
					</div>
					<div
					data-step         ="3"
					data-intro        ="Pilih Tipe Barang."
					data-hint         ="Pilih Tipe Barang."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tipe Barang</label>
						<div class="col-md-15 col-sm-3">
							<?php echo form_dropdown('tipe',$option_tipe,isset($default['tipe']) ? $default['tipe'] : '','class="default-select2 form-control" id="tipe" data-size="10" data-live-search="true" data-parsley-group="wizard-step-2" data-parsley-required="true" data-style="btn-white"');?>
                            <span style="color:red;"><?php echo form_error('tipe');?></span>
						</div>
					</div>
					<div
					data-step         ="4"
					data-intro        ="Pilih Merk Barang."
					data-hint         ="Pilih Merk Barang."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Merk Barang</label>
						<div class="col-md-15 col-sm-3">
							<?php echo form_dropdown('merk',$option_merk,isset($default['merk']) ? $default['merk'] : '','class="default-select2 form-control" id="merk" data-size="10" data-live-search="true" data-parsley-group="wizard-step-2" data-parsley-required="true" data-style="btn-white"');?>
                            <span style="color:red;"><?php echo form_error('merk');?></span>
						</div>
					</div>
					<div
					data-step         ="5"
					data-intro        ="Pilih Warna Barang."
					data-hint         ="Pilih Warna Barang."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Warna Barang</label>
						<div class="col-md-15 col-sm-3">
							<?php echo form_dropdown('warna',$option_warna,isset($default['warna']) ? $default['warna'] : '','class="default-select2 form-control" id="warna" data-size="10" data-live-search="true" data-parsley-group="wizard-step-2" data-parsley-required="true" data-style="btn-white"');?>
                            <span style="color:red;"><?php echo form_error('warna');?></span>
						</div>
					</div>
					<div
					data-step         ="6"
					data-intro        ="Masukan Stok Barang dengan spesifikasi warna. "
					data-hint         ="Masukan Stok Barang dengan spesifikasi warna. "
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Stok Barang</label>
						<div class="col-md-1 col-sm-1">
							<input class="form-control" maxlength="15" style="text-align:right" type="text" id="stok" minlength="1" name="stok" value="<?php echo set_value('stok',isset($default['stok']) ? $default['stok'] : ''); ?>" data-type="stok" data-parsley-minlength="1" data-parsley-minlength="15"/>
                            <span style="color:red;"><?php echo form_error('stok');?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3"></label>
						<div class="col-md-4 col-sm-4">
							<button type="button" id="tambahstok" 
							data-step         ="10" 
							data-intro        ="Digunakan untuk menyimpan data Stok Barang sementara, jika barang tersebut memiliki jenis warna lebih dari satu silahkan lakukan pengisian Stok Barang kembali kemudian klik tombol ini, tetapi apabila Barang memiliki hanya satu jenis warna silahkan klik tombol simpan maka Stok Barang akan tersimpan dalam database."  
							data-hintPosition ="top-middle" 
							data-position     ="bottom-right-aligned"
					class="btn btn-primary btn-xs m-r-5" title="Tambah Stok Barang"><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div 
					data-step         ="11" 
					data-intro        ="List Penyimpanan Stok Barang Sementara."  
					data-hint         ="List Penyimpanan Stok Barang Sementara." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="form-group">
						<div class="col-md-20 col-sm-20">
							<h4 class="widgettitle nomargin shadowed"><b>Detil Stok Barang</b></h4>
							<div class="widgetcontent bordered shadowed nomargin">
								<div class ="table-responsive" style="text-align: center;" >
									<?php 
									echo "<table width=\"50%\" text-align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id='tbladdstok'>\n"; 
									echo "  <tr>\n"; 
									echo "    <th>Kode Barang</th>\n"; 
									echo "    <th>Warna</th>\n";
									echo "    <th>Stok Barang</th>\n";
									echo "    <th>File Foto</th>\n";
									echo "    <th>Action</th>\n";
									echo "  </tr>\n"; 
									echo "</table>";
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3"></label>
						<div class="col-md-3 col-sm-3">
							<button type="submit"
							data-step         ="12"
							data-intro        ="Jika data inputan sudah benar silahkan klik tombol simpan untuk menyimpan data Barang."
							data-hint         ="Jika data inputan sudah benar silahkan klik tombol simpan untuk menyimpan data Barang."
							data-hintPosition ="top-middle"
							data-position     ="bottom-right-aligned"
							class="btn btn-success btn-sm"><?php echo $tombolsimpan;?></button>
                      		<button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm"><?php echo $tombolbatal ; ?></button>
						</div>
					</div>
		        </form>
		    </div>
		</div>
	</div>
</div>
