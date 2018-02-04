<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pemeliharaan.js"></script>
<script type="text/javascript">
function kirim(mail){
    save_method = 'add';
    $('#form')[0].reset();
    jQuery("#email").val(mail)
    $('[name="email"]').attr('disabled',true);
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Form Pengiriman E-mail');
}
function kirim_email(link) {
    $('#btnKirim').text('Proses...');
    $('#btnKirim').attr('disabled', true);
    var url;
    if (save_method == 'add') {
        url = $BASE_URL + link + "/kirim_email";
    } else {
        url = $BASE_URL + link + "/proses_edit";
    }
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal_form').modal('hide');
            	$.gritter.add({title:"Informasi !",text: " Pengiriman E-mail Berhasil !"});
            	return false;
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name ="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                    $('[name ="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                    $('.select').select2({
                        minimumResultsForSearch: Infinity,
                        width: '250px'
                    });
                }
            }
            $('#btnKirim').text('Simpan');
            $('#btnKirim').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.gritter.add({
                title: "Informasi !",
                text: "Pengiriman E-mail Gagal, Pastikan Terkoneksi dengan Internet"
            });
            $('#btnKirim').text('Simpan');
            $('#btnKirim').attr('disabled', false);
            return false;
        }
    });
}
</script>
<div class="row"> 
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-red">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-thumbs-up fa-fw"></i></div>
			<div class="stats-title">Total Pemeliharaan Finish</div>
			<div class="stats-number"><?php echo number_format($this->db->get_where('tbl_pemeliharaan',array('status'=>'0'))->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total Pemeliharaan Finish Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-orange">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-cloud-upload fa-fw"></i></div>
			<div class="stats-title">Total Barang</div>
			<div class="stats-number"><?php echo number_format($this->db->get_where('view_pemeliharaan_detil',array('status'=>'1'))->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total Barang Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-blue">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-check-circle fa-fw"></i></div>
			<div class="stats-title">Total Pemeliharaan InProses</div>
			<div class="stats-number"><?php echo number_format($this->db->get_where('tbl_pemeliharaan',array('status'=>'1'))->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total InProses Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-green">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
			<div class="stats-title">Total Pemeliharaan</div>
			<div class="stats-number"><?php echo number_format($this->db->get('tbl_pemeliharaan')->num_rows());?></div>
			<div class="stats-progress progress">
				<div class="progress-bar" style="width: 100%;"></div>
			</div>
			<div class="stats-desc">Total Pemeliharaan Sampai Saat Ini</div>
		</div>
	</div>
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<div class="panel-heading-btn">
					<a href="<?php echo base_url();?>pemeliharaan/add" 
					data-step         ="1" 
					data-intro        ="Digunakan untuk menambah data."  
					data-hint         ="Digunakan untuk menambah data." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="btn btn-primary btn-xs m-r-5" >
						<i class="fa fa-plus-circle"></i> 
						Tambah Data Pemeliharaan
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
				<h4 class="panel-title">List Data Pemeliharaan</h4> 
				<div id="filter_pencarian">
					<br/>
					<select name="status" class="default-select2 form-control" style="width:20%" id="status" name="status" data-live-search="true" data-style="btn-white">
						<option value="">Pilih Status Pemeliharaan</option>
						<option value="1">InProses</option>
						<option value="0">Finish</option>
					</select>
				</div>
			</div> 
			<div class="panel-body"> 
				<div class="table-responsive"> 
					<table id="data-pemeliharaan" 
					data-step         ="4" 
					data-intro        ="List Data yang tersimpan pada database."  
					data-hint         ="List Data yang tersimpan pada database." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="table table-striped table-bordered nowrap" width="100%"> 
						<thead> 
							<tr> 
								<th style="text-align:center" width="1%">No.</th> 
								<th style="text-align:center" width="10%">Kode Transaksi</th> 
								<th style="text-align:center" width="30%">Tgl Pemeliharaan</th> 
								<th style="text-align:center" width="10%">Nama Mitra</th>  
								<th style="text-align:center" width="10%">Kontak</th> 
								<th style="text-align:center" width="15%">No Handphone</th> 
								<th style="text-align:center" width="10%">Email</th> 
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
