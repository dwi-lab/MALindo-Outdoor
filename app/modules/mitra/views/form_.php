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
								<img src="<?php echo base_url();?>assets/foto/pegawai/<?php echo $fotox;?>" style="width:150px;text-align:center;height:180px;">
							</div>
						</div>
						<?php
					}
					?>
					<div
					data-step         ="1"
					data-intro        ="Untuk Kode Pegawai Sudah Otomatis, Kode Pegawai ini digunakan untuk Username dan Password saat Login di Aplikasi."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Kode Pegawai</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="text" readonly="readonly" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="kode" minlength="1" maxlength='20' name="kode" value="<?php echo set_value('kode',isset($default['kode']) ? $default['kode'] : ''); ?>" data-type="kode" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                            <span style="color:red;"><?php echo form_error('kode');?></span>
						</div>
					</div>
					<div
					data-step         ="2"
					data-intro        ="Masukan Nama Pegawai."
					data-hint         ="Masukan Nama Pegawai."
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Pegawai</label>
						<div class="col-md-4 col-sm-4">
							<input class="form-control" type="text" id="nama" minlength="1" maxlength='50' name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="50"/>
                            <span style="color:red;"><?php echo form_error('nama');?></span>
						</div>
					</div>
					<div
					data-step         ="6"
					data-intro        ="Masukan No Handphone Pegawai. Data inputan hanya karakter angka. max : 16 karakter </br> ex : 08123455555"
					data-hint         ="Masukan No Handphone Pegawai. Data inputan hanya karakter angka. max : 16 karakter </br> ex : 08123455555"
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
					data-step         ="7"
					data-intro        ="Masukan E-mail Pegawai. </br> ex : Pegawai@gmail.com"
					data-hint         ="Masukan E-mail Pegawai. </br> ex : Pegawai@gmail.com"
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
					data-step         ="8" 
					data-intro        ="Masukan Foto Pegawai. Jika Ada. Type File jpg max : 1 Mb" 
					data-hint         ="Masukan Foto Pegawai. Jika Ada. Type File jpg max : 1 Mb" 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Foto Profile :<br/><b><span class="small"><font color="red">* Type Format jpg | png <br/> Max File Size : 1 Mb<br/></font></span></b></label>
						<div class="col-md-3 col-sm-3">
                            <input name="MAX_FILE_SIZE" value="9999999999" type="hidden">
				            <input type="file" id="foto" name="foto" />  
						</div>
					</div>
					<div 
					data-step         ="9" 
					data-intro        ="Setting Potongan Harga ?" 
					data-hint         ="Setting Potongan Harga ?" 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Sett Potongan Harga</label>
						<div class="col-md-2 col-sm-2">
							<input class="submenu" name="set_pot" id="set_pot" <?php if($set_pot=='1'){echo 'checked="checked"';}else{ echo ''; } ;?> data-parsley-multiple="submenu" type="checkbox">
						</div>
					</div>
					<div
					data-step         ="10"
					data-intro        ="Jika Tidak Memliki File Foto Pegawai Silahkan Lakukan Pengambilan Foto Pegawai"
					data-hintPosition ="top-middle"
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Foto Pegawai</label>
						<div class="col-md-3 col-sm-3">
							<script type="text/javascript">
								var kode = jQuery("#kode").val();
						  		webcam.set_api_url('<?php echo base_url();?>pegawai/proses_foto/'+kode);
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
					<div 
					data-step         ="11" 
					data-intro        ="Pilih Hak Akses Pegawai." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="form-group">
						<label class="control-label col-md-3 col-sm-3">Hak Akses :</label>
						<div class="col-md-3 col-sm-3">
							<span class="field">
                    <ul style="list-style-type:none;padding-top:5px">
                            <?php
                      if(!empty($menunya)){
                          $idmenu = explode("|", $menunya);
                          $idmenux = explode("|", $submenu);
                      }
                      $i=0;
                      $mutama = $this->db->query("SELECT * FROM tbl_menu WHERE status = '1' ORDER BY urutan")->result();
                      foreach ($mutama as $key ) {
                        $i++;
                        echo '<li><strong>' . "- " . $key->nama_menu . "</strong></li>". "\n";
                        $smenu = $this->db->get_where('tbl_submenu',array('parent'=>$key->menu_id,'level'=>'1','sstatus'=>'1'))->result();
                        echo '<ul style="list-style-type:none;padding-bottom:10px">' . "\n";
                        foreach ($smenu as $keys) {
                          echo '<li><input type="checkbox" class="submenu" name="submenu[]" id="submenu'. $i .'" value="'. $keys->smenu_id . '"';
                          if(!empty($menunya)){
                            for($i=0;$i<count($idmenu);$i++){
                              if($idmenu[$i]==$keys->smenu_id){
                                echo " checked";
                              }
                            }
                          }
                          echo '>&nbsp;&nbsp;' . $keys->nama_smenu . "</li>" . "\n";
                          $xx = 0;
                          $smenux = $this->db->query("SELECT * FROM tbl_submenux WHERE parentx = '$keys->smenu_id' AND levelx = '1' AND sstatusx = '1' ORDER BY urut")->result();
                          echo '<ul style="list-style-type:none;padding-bottom:10px">' . "\n";
                          foreach ($smenux as $keysz) {
                            $xx++;
                            echo '<li><input type="checkbox" class="submenux" name="submenux[]" id="submenux'. $xx .'" value="'. $keysz->smenu_id . '"';
                            if(!empty($menunya)){
                              for($xx=0;$xx<count($idmenux);$xx++){
                                if($idmenux[$xx]==$keysz->smenu_id){
                                  echo " checked";
                                }
                              }
                            }
                            echo '>&nbsp;&nbsp;' . $keysz->nama_smenux . "</li>" . "\n";
                          }
                          echo "</ul>" . "\n";
                        }
                        echo "</ul>" . "\n";
                      }
                      ?>
                  </ul>
              </span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3"></label>
						<div class="col-md-3 col-sm-3">
							<button type="submit"
							data-step         ="10"
							data-intro        ="Jika data inputan sudah benar silahkan klik tombol simpan untuk menyimpan data Pegawai."
							data-hint         ="Jika data inputan sudah benar silahkan klik tombol simpan untuk menyimpan data Pegawai."
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
