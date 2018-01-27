<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/sewa.js"></script>
<script src="<?php echo base_url();?>assets/js/sewa_proses.js"></script>
<div class="row"> 
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-red">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-thumbs-up fa-fw"></i></div>
			<div class="stats-title">Total Penyewaan Finish</div>
			<div class="stats-number"><?php echo number_format($this->db->get_where('tbl_trans',array('status_transaksi'=>'0'))->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total Penyewaan Finish Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-orange">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-cloud-upload fa-fw"></i></div>
			<div class="stats-title">Total OnBooking</div>
			<div class="stats-number"><?php echo number_format($this->db->get_where('tbl_booking',array('status_booking'=>'1'))->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total OnBooking Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-blue">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-check-circle fa-fw"></i></div>
			<div class="stats-title">Total Penyewaan InProses</div>
			<div class="stats-number"><?php echo number_format($this->db->get_where('tbl_trans',array('status_transaksi'=>'1'))->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total InProses Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-green">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
			<div class="stats-title">Total Penyewaan</div>
			<div class="stats-number"><?php echo number_format($this->db->get('tbl_trans')->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total Penyewaan Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<div class="panel-heading-btn">
					<a href="<?php echo base_url();?>booking/add" 
					data-step         ="1" 
					data-intro        ="Digunakan untuk menambah data."  
					data-hint         ="Digunakan untuk menambah data." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="btn btn-primary btn-xs m-r-5" >
						<i class="fa fa-plus-circle"></i> 
						Tambah Data Booking
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
				</div> 
				<h4 class="panel-title">List Data Booking</h4> 
				<div id="filter_pencarian">
					<br/>
					<select name="jns_bayar" class="default-select2 form-control" style="width:20%" id="jns_bayar" name="jns_bayar" data-live-search="true" data-style="btn-white">
						<option value="">Pilih Jenis Pembayaran</option>
						<option value="1">Cash</option>
						<option value="2">Poin</option>
					</select>
				</div>
			</div> 
			<div class="panel-body"> 
				<div class="table-responsive"> 
					<table id="data-booking" 
					data-step         ="4" 
					data-intro        ="List Data yang tersimpan pada database."  
					data-hint         ="List Data yang tersimpan pada database." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="table table-striped table-bordered nowrap" width="100%"> 
						<thead> 
							<tr> 
								<th style="text-align:center" width="1%">No.</th> 
								<th style="text-align:center" width="10%">Foto Member</th> 
								<th style="text-align:center" width="10%">Kode Booking</th>  
								<th style="text-align:center" width="30%">Nama Member</th> 
								<th style="text-align:center" width="10%">Tgl Booking</th> 
								<th style="text-align:center" width="15%">Tgl Sewa</th> 
								<th style="text-align:center" width="10%">Tgl Selesai</th> 
								<th style="text-align:center" width="10%">Lama</th> 
								<th style="text-align:center" width="10%">Status</th> 
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
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<div class="panel-heading-btn">
					<a href="<?php echo base_url();?>sewa/add" 
					data-step         ="1" 
					data-intro        ="Digunakan untuk menambah data."  
					data-hint         ="Digunakan untuk menambah data." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="btn btn-primary btn-xs m-r-5" >
						<i class="fa fa-plus-circle"></i> 
						Tambah Data Penyewaan
					</a>&nbsp;
					<button 
					data-step         ="2" 
					data-intro        ="Digunakan untuk melakukan filter pencarian."  
					data-hint         ="Digunakan untuk melakukan filter pencarian." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="btn btn-danger btn-xs m-r-5" onclick="filter_sewa()">
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
				</div> 
				<h4 class="panel-title">List Data Penyewaan</h4> 
				<div id="filter_pencarian_sewa">
					<br/>
					<select name="jns_bayar_sewa" class="default-select2 form-control" style="width:20%" id="jns_bayar_sewa" name="jns_bayar_sewa" data-live-search="true" data-style="btn-white">
						<option value="">Pilih Jenis Pembayaran</option>
						<option value="1">Cash</option>
						<option value="2">Poin</option>
					</select>
				</div>
			</div> 
			<div class="panel-body"> 
				<div class="table-responsive"> 
					<table id="data-sewa" 
					data-step         ="4" 
					data-intro        ="List Data yang tersimpan pada database."  
					data-hint         ="List Data yang tersimpan pada database." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="table table-striped table-bordered nowrap" width="100%"> 
						<thead> 
							<tr> 
								<th style="text-align:center" width="1%">No.</th> 
								<th style="text-align:center" width="10%">Foto Member</th> 
								<th style="text-align:center" width="10%">Kode Transaksi</th>  
								<th style="text-align:center" width="30%">Nama Member</th> 
								<th style="text-align:center" width="10%">Tgl Transaksi</th> 
								<th style="text-align:center" width="15%">Tgl Sewa</th> 
								<th style="text-align:center" width="10%">Tgl Selesai</th> 
								<th style="text-align:center" width="10%">Lama</th> 
								<th style="text-align:center" width="10%">Status</th> 
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
