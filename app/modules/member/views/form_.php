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
<script src="<?php echo base_url();?>assets/js/webcam.js"></script>
<script src="<?php echo base_url();?>assets/js/daftar.js"></script>
<style>
.datepicker{z-index:1151 !important;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datepicker({
            todayHighlight: !0
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
							<label class="control-label col-md-3 col-sm-3">Foto Profile :</label>
							<div class="col-md-2 col-sm-2">
							<?php
								if($foto==""){
									$fotox = "no.jpg";
								}else{
									$fotox = $foto;
								}
							?>
								<img src="<?php echo base_url();?>assets/foto/member/<?php echo $fotox;?>" style="width:150px;text-align:center;height:180px;">
							</div>
						</div>
						<?php
					}
					?>
					<div
					data-step         ="1"
					data-intro        ="Untuk Kode Member Sudah Otomatis"
					data-hint         ="Untuk Kode Member Sudah Otomatis"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Kode Member</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="text" readonly="readonly" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="kode" minlength="1" maxlength='20' name="kode" value="<?php echo set_value('kode',isset($default['kode']) ? $default['kode'] : ''); ?>" data-type="kode" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                            <span style="color:red;"><?php echo form_error('kode');?></span>
						</div>
					</div>
					<div
					data-step         ="2"
					data-intro        ="Masukan No Identitas KTP atau Identitas Lainnya , Maksimal dan Minimal 16 karakter"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">No Identitas</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="text" id="no_identitas" style="text-align:right" minlength="16" maxlength='16' name="no_identitas" value="<?php echo set_value('no_identitas',isset($default['no_identitas']) ? $default['no_identitas'] : ''); ?>" data-type="no_identitas" data-parsley-required="true" data-parsley-type="number" data-parsley-minlength="16" data-parsley-maxlength="16"/>
                            <span style="color:red;"><?php echo form_error('no_identitas');?></span>
						</div>
					</div>
					<?php
					if($cek=='edit'){
						?>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Foto Identitas :</label>
							<div class="col-md-2 col-sm-2">
							<?php
								if($foto_identitas==""){
									$fotoxx = "no.jpg";
								}else{
									$fotoxx = $foto_identitas;
								}
							?>
								<img src="<?php echo base_url();?>assets/foto/identitas/<?php echo $fotoxx;?>" style="width:150px;text-align:center;height:180px;">
							</div>
						</div>
						<?php
					}
					?>
					<div
					data-step         ="3"
					data-intro        ="Masukan Foto Identitas Member. Type File jpg max : 1 Mb"
					data-hint         ="Masukan Foto Identitas Member. Type File jpg max : 1 Mb"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Bukti Identitas :<br/><b><span class="small"><font color="red">* Type Format jpg | png <br/> Max File Size : 1 Mb<br/></font></span></b></label>
						<div class="col-md-3 col-sm-3">
                            <input name="MAX_FILE_SIZE" value="9999999999" type="hidden">
				            <input type="file" id="identitas" name="identitas" />
						</div>
					</div>
					<div
					data-step         ="4"
					data-intro        ="Masukan Nama Member."
					data-hint         ="Masukan Nama Member."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Member</label>
						<div class="col-md-4 col-sm-4">
							<input class="form-control" type="text" id="nama" minlength="1" maxlength='50' name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="50"/>
                            <span style="color:red;"><?php echo form_error('nama');?></span>
						</div>
					</div>
					<div
					data-step         ="5"
					data-intro        ="Masukan Tanggal Lahir. Format Tanggal dd-mm-yyyy."
					data-hint         ="Masukan Tanggal Lahir. Format Tanggal dd-mm-yyyy."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tanggal Lahir</label>
						<div class="col-md-2 col-sm-2">
							<div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
	                            <input type="text" class="form-control" name="tgllahir" value="<?php echo set_value('tgllahir',isset($default['tgllahir']) ? $default['tgllahir'] : ''); ?>" data-type="tgllahir" data-parsley-minlength="10" data-parsley-maxlength="10" minlength="10" maxlength="10" data-parsley-required="true"/>
	                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                            <span style="color:red;"><?php echo form_error('tgllahir');?></span>
	                        </div>
	                    </div>
					</div>
					<div 
					data-step         ="6"
					data-intro        ="Pilih Lokasi Provinsi."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Provinsi * :</label>
                        <div class="col-md-3 col-sm-3">
                            <?php echo form_dropdown('provinsi',$option_provinsi,isset($default['provinsi']) ? $default['provinsi'] : '','id="provinsi" data-size="10" data-parsley-group="wizard-step-1" data-parsley-required="true" data-live-search="true" data-style="btn-white" class="default-select2 form-control"');?>
                            <span style="color:red;"><?php echo form_error('provinsi');?></span>
                        </div>
                    </div>
                    <div 
					data-step         ="7"
					data-intro        ="Pilih Lokasi Kota / Kabupaten."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Kabupaten / Kota * :</label>
                        <div class="col-md-3 col-sm-3">
                            <?php echo form_dropdown('kota',$option_kota,isset($default['kota']) ? $default['kota'] : '','id="kota" data-size="10" data-parsley-group="wizard-step-1" data-parsley-required="true" data-live-search="true" data-style="btn-white" class="default-select2 form-control"');?>
                            <span style="color:red;"><?php echo form_error('kota');?></span>
                        </div>
                    </div>
                    <div 
					data-step         ="8"
					data-intro        ="Pilih Lokasi Kecamatan."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Kecamatan * :</label>
                        <div class="col-md-3 col-sm-3">
                            <?php echo form_dropdown('kecamatan',$option_kecamatan,isset($default['kecamatan']) ? $default['kecamatan'] : '','id="kecamatan" data-size="10" data-parsley-group="wizard-step-1" data-parsley-required="true" data-live-search="true" data-style="btn-white" class="default-select2 form-control"');?>
                            <span style="color:red;"><?php echo form_error('kecamatan');?></span>
                        </div>
                    </div>
                    <div 
					data-step         ="9"
					data-intro        ="Pilih Lokasi Kelurahan."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Kelurahan * :</label>
                        <div class="col-md-3 col-sm-3">
                            <?php echo form_dropdown('kelurahan',$option_kelurahan,isset($default['kelurahan']) ? $default['kelurahan'] : '','id="kelurahan" data-size="10" data-parsley-group="wizard-step-1" data-parsley-required="true" data-live-search="true" data-style="btn-white" class="default-select2 form-control"');?>
                            <span style="color:red;"><?php echo form_error('kelurahan');?></span>
                        </div>
                    </div>
					<div
					data-step         ="10"
					data-intro        ="Masukan Alamat Tempat Tinggal Member."
					data-hint         ="Masukan Alamat Tempat Tinggal Member."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Alamat</label>
						<div class="col-md-5 col-sm-5">
                            <textarea class="form-control" minlength="1" data-parsley-required="true" id="almt" name="almt" rows="3"><?php echo set_value('almt',isset($default['almt']) ? $default['almt'] : ''); ?></textarea>
	                            <span style="color:red;"><?php echo form_error('almt');?></span>
	                            <span style="color:red;">* Cara Penulisan Alamat : Jalan di ikuti No Rumah RT dan RW</span>
						</div>
					</div>
					<div
					data-step         ="11"
					data-intro        ="Pilih Jenis Kelamin."
					data-hint         ="Pilih Jenis Kelamin."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Jenis Kelamin</label>
						<div class="col-md-15 col-sm-5">
							<input type="radio"  data-parsley-required="true" name="jk" value="1" <?php if($jk=="1"){echo 'checked="checked"';}?>/> Laki - Laki &nbsp; &nbsp;
                            <input type="radio"  data-parsley-required="true" name="jk" value="2"  <?php if($jk=="2"){echo 'checked="checked"';}?> /> Perempuan &nbsp; &nbsp;
                            <span style="color:red;"><?php echo form_error('jk');?></span>
						</div>
					</div>
					<div
					data-step         ="12"
					data-intro        ="Pilih Pekerjaan."
					data-hint         ="Pilih Pekerjaan."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Pekerjaan</label>
						<div class="col-md-15 col-sm-5">
							<?php echo form_dropdown('kerja',$option_kerja,isset($default['kerja']) ? $default['kerja'] : '','class="default-select2 form-control" id="kerja" data-size="10" data-live-search="true" data-parsley-group="wizard-step-2" data-parsley-required="true" data-style="btn-white"');?>
                            <span style="color:red;"><?php echo form_error('kerja');?></span>
						</div>
					</div>
					<div
					data-step         ="13"
					data-intro        ="Masukan No Handphone. Data inputan hanya karakter angka. max : 16 karakter </br> ex : 08123455555"
					data-hint         ="Masukan No Handphone. Data inputan hanya karakter angka. max : 16 karakter </br> ex : 08123455555"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">No Handphone</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" maxlength="15" style="text-align:right" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="hp" minlength="1" name="hp" value="<?php echo set_value('hp',isset($default['hp']) ? $default['hp'] : ''); ?>" data-type="hp" data-parsley-required="true" data-parsley-type="number" data-parsley-minlength="1" data-parsley-minlength="15"/>
                            <span style="color:red;"><?php echo form_error('hp');?></span>
						</div>
					</div>
					<div
					data-step         ="14"
					data-intro        ="Masukan E-mail. </br> ex : member@gmail.com"
					data-hint         ="Masukan E-mail. </br> ex : member@gmail.com"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Email</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" id="mail" name="mail" value="<?php echo set_value('mail',isset($default['mail']) ? $default['mail'] : ''); ?>" data-type="mail" data-parsley-required="true" data-parsley-type="email"/>
	                            <span style="color:red;"><?php echo form_error('mail');?></span>
						</div>
					</div>
					<div
					data-step         ="15"
					data-intro        ="Silahkan Lakukan Pengambilan Foto Member"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Foto Member</label>
						<div class="col-md-3 col-sm-3">
							<script type="text/javascript">
								var kode = jQuery("#kode").val();
						  		webcam.set_api_url('<?php echo base_url();?>member/proses_foto/'+kode);
								webcam.set_swf_url('<?php echo base_url();?>assets/webcam.swf' );
								webcam.set_quality(100);
								webcam.set_shutter_sound(true,'<?php echo base_url();?>assets/shutter.mp3');
							</script>
							<script language="JavaScript">
								document.write( webcam.get_html(220, 300) );
							</script>
							<br/><br/>
							<button type="button" onClick="webcam.configure()" class="btn btn-primary btn-sm">Setting</button>
							<button type="button" class="btn btn-primary btn-sm" onClick="webcam.freeze()">Capture</button>
							<button type="button" class="btn btn-primary btn-sm" onClick="do_upload()">Upload</button>
							<script language="JavaScript">
							webcam.set_hook( 'onError', 'salah' );
							function salah(){
								alert("EROR");
							}
							function do_upload(){
								webcam.upload();
								webcam.reset();
							}
							</script>
							<div id="foto"></div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3"></label>
						<div class="col-md-3 col-sm-3">
							<button type="submit"
							data-step         ="16"
							data-intro        ="Jika data inputan sudah benar silahkan klik tombol simpan untuk menyimpan data member."
							data-hint         ="Jika data inputan sudah benar silahkan klik tombol simpan untuk menyimpan data member."
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
