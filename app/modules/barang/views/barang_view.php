<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/barang.js"></script>
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
								<!-- <th style="text-align:center" width="10%">Foto</th> -->  
								<th style="text-align:center" width="10%">Kode Barang</th> 
								<th style="text-align:center" width="30%">Nama Barang</th> 
								<th style="text-align:center" width="10%">Tipe Barang</th> 
								<th style="text-align:center" width="10%">Merk Barang</th> 
								<!-- <th style="text-align:center" width="10%">Warna Barang</th>  -->
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
