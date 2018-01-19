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
	    jQuery('#hrgpoin').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });   
	    jQuery('#stok').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });               
    });
</script>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<div class="panel-heading-btn">
					<a href="<?php echo base_url();?>barang/add" 
					data-step         ="1" 
					data-intro        ="Digunakan untuk menambah data."  
					data-hint         ="Digunakan untuk menambah data." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="btn btn-primary btn-xs m-r-5" >
						<i class="fa fa-plus-circle"></i> 
						Tambah Data
					</a>&nbsp;
					<button 
					data-step         ="2" 
					data-intro        ="Digunakan untuk melakukan filter pencarian."  
					data-hint         ="Digunakan untuk melakukan filter pencarian." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="btn btn-danger btn-xs m-r-5" onclick="filter()">
						<i class="fa fa-search"></i> Filter Pencarian
					</button>
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
					<a data-step      ="4" 
					data-intro        ="Digunakan untuk melakukan import Data Barang."  
					data-hint         ="Digunakan untuk melakukan import Data Barang." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					href              ="<?php echo base_url();?>barang/import" class="btn btn-warning btn-xs m-r-5"><i class="fa fa-download"></i>&nbsp;Import Data Barang</a> 
					<a href="javascript:void(0);" class="btn btn-info btn-xs m-r-5" title="Bantuan" onclick="javascript:introJs().start();">
						<i class="fa fa-question"></i> 
					</a> 
				</div> 
				<h4 class="panel-title"><?php echo $halaman;?></h4> 
				<div id="filter_pencarian">
					<br/>
					<?php echo form_dropdown('tipe',$option_tipe,isset($default['tipe']) ? $default['tipe'] : '','class="default-select2 form-control" style="width:15%" id="tipe" name="tipe" data-live-search="true" data-style="btn-white"');?>
					<?php echo form_dropdown('merk',$option_merk,isset($default['merk']) ? $default['merk'] : '','class="default-select2 form-control" style="width:15%" id="merk" name="merk" data-live-search="true" data-style="btn-white"');?>
					<?php echo form_dropdown('warna',$option_warna,isset($default['warna']) ? $default['warna'] : '','class="default-select2 form-control" style="width:15%" id="warna" name="warna" data-live-search="true" data-style="btn-white"');?>
				</div>
			</div> 
			<div class="panel-body"> 
				<div class="table-responsive"> 
					<table id="data-barang" 
					data-step         ="5" 
					data-intro        ="List Data yang tersimpan pada database."  
					data-hint         ="List Data yang tersimpan pada database." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="table table-striped table-bordered nowrap" width="100%"> 
						<thead> 
							<tr> 
								<th style="text-align:center" width="1%">No.</th> 
								<th style="text-align:center" width="10%">Kode Barang</th> 
								<th style="text-align:center" width="30%">Nama Barang</th> 
								<th style="text-align:center" width="10%">Tipe Barang</th> 
								<th style="text-align:center" width="10%">Merk Barang</th> 
								<th style="text-align:center" width="10%">Total Stok</th> 
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
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Nama Barang</label>
							<div class="col-md-6">
								<input name="nama" id="nama" maxlength="30" placeholder="Masukan Nama Tipe" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tipe Barang * :</label>
                            <div class="col-md-6">
                            <?php echo form_dropdown('tipeX',$option_tipeX,isset($default['tipeX']) ? $default['tipeX'] : '','class="default-select2 form-control" style="width:100%" id="tipeX" name="tipeX" data-live-search="true" data-style="btn-white"');?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Merk Barang * :</label>
                            <div class="col-md-6">
                            <?php echo form_dropdown('merkX',$option_merkX,isset($default['merkX']) ? $default['merkX'] : '','class="default-select2 form-control" style="width:100%" id="merkX" name="merkX" data-live-search="true" data-style="btn-white"');?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tanggal Beli * :</label>
						<div class="col-md-4">
                            <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
	                            <input type="text" class="form-control" name="tgl_beli" id="tgl_beli" />
	                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                        </div>
	                    </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Beli * :</label>
                            <div class="col-md-3">
                            <input class="form-control" maxlength="15" style="text-align:right" type="text" id="hrgbeli" minlength="1" name="hrgbeli" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Biaya Penyusutan * :</label>
                            <div class="col-md-3">
                            <input class="form-control" maxlength="15" style="text-align:right" type="text" id="hrgsusut" minlength="1" name="hrgsusut" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Sewa * :</label>
                            <div class="col-md-3">
                            <input class="form-control" maxlength="15" style="text-align:right" type="text" id="hrgsewa" minlength="1" name="hrgsewa" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Poin * :</label>
                            <div class="col-md-3">
                            <input class="form-control" maxlength="15" style="text-align:right" type="text" id="hrgpoin" minlength="1" name="hrgpoin" />
						</div>
					</div>
				</form>					
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave" onclick="save('<?php echo $link;?>')" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>