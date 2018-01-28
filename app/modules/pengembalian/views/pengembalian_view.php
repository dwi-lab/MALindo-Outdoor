<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pengembalian.js"></script>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<h4 class="panel-title">List Data Penyewaan</h4> 
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
