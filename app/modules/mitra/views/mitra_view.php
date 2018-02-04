<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/mitra.js"></script>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<div class="panel-heading-btn">
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
					<a href="javascript:void(0);" class="btn btn-info btn-xs m-r-5" title="Bantuan" onclick="javascript:introJs().start();">
						<i class="fa fa-question"></i> 
					</a> 
				</div> 
				<h4 class="panel-title"><?php echo $halaman;?></h4> 
			</div> 
			<div class="panel-body"> 
				<div class="table-responsive"> 
					<table id="data-mitra" 
					data-step         ="4" 
					data-intro        ="List Data yang tersimpan pada database."  
					data-hint         ="List Data yang tersimpan pada database." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="table table-striped table-bordered nowrap" width="100%"> 
						<thead> 
							<tr> 
								<th style="text-align:center" width="1%">No.</th> 
								<th style="text-align:center" width="15%">Nama Mitra</th> 
								<th style="text-align:center" width="25%">Kontak</th> 
								<th style="text-align:center" width="10%">Alamat</th> 
								<th style="text-align:center" width="15%">E-mail</th> 
								<th style="text-align:center" width="10%">No Handphone</th> 
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
							<label class="control-label col-md-3">Nama Mitra</label>
							<div class="col-md-6">
								<input name="nama" id="nama" placeholder="Masukan Nama Mitra" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Alamat</label>
							<div class="col-md-8">
								<input name="alamat" id="alamat" placeholder="Masukan Alamat Mitra" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Nama Kontak</label>
							<div class="col-md-6">
								<input name="kontak" id="kontak" placeholder="Masukan Nama Kontak Mitra" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">E-mail</label>
							<div class="col-md-6">
								<input name="email" id="email" placeholder="Masukan E-mail Mitra" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">No Handphone</label>
							<div class="col-md-4">
								<input name="hp" id="hp" placeholder="Masukan No Handphone" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
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