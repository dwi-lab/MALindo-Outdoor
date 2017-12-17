<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pegawai.js"></script>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<div class="panel-heading-btn">
					<a href="<?php echo base_url();?>pegawai/add" 
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
					<table id="data-pegawai" 
					data-step         ="4" 
					data-intro        ="List Data yang tersimpan pada database."  
					data-hint         ="List Data yang tersimpan pada database." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="table table-striped table-bordered nowrap" width="100%"> 
						<thead> 
							<tr> 
								<th style="text-align:center" width="1%">No.</th> 
								<th style="text-align:center" width="10%">Foto</th>  
								<th style="text-align:center" width="15%">Kode</th> 
								<th style="text-align:center" width="40%">Nama</th> 
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
