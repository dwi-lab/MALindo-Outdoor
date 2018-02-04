<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pengembalian.js"></script>
<script src="<?php echo base_url();?>assets/js/pengembalian_finish.js"></script>
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
	<div class="col-md-12"> 
		<div class="panel panel-inverse"> 
			<div class="panel-heading"> 
				<h4 class="panel-title">List Data Pengembalian</h4> 
			</div> 
			<div class="panel-body"> 
				<div class="table-responsive"> 
					<table id="data-kembali" 
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
								<th style="text-align:center" width="15%">Tgl Sewa</th> 
								<th style="text-align:center" width="10%">Tgl Selesai</th> 
								<th style="text-align:center" width="10%">Lama</th> 
								<th style="text-align:center" width="10%">Tgl Kembali</th> 
								<th style="text-align:center" width="10%">Denda</th>
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
<div id="modal_form" class="modal modal-message fade">
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
                            <label class="control-label col-md-2">E-mail</label>
                            <div class="col-md-6">
                                <input name="email" id="email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-2">Judul Pesan</label>
                            <div class="col-md-8">
                                <input name="judul" id="judul" placeholder="Masukan Judul Pesan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-2">Isi Pesan</label>
                            <div class="col-md-9">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Isi Pesan" rows="15"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>                 
            </div>
            <div class="modal-footer">
                <button type="button" id="btnKirim" onclick="kirim_email('dashboard')" class="btn btn-primary">Kirim</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>