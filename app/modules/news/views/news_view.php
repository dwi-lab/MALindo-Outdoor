<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/form-plugins.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/news.js"></script>
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
					data-step         ="2" 
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
					<table id="data-news" 
					data-step         ="3" 
					data-intro        ="List Data yang tersimpan pada database."  
					data-hint         ="List Data yang tersimpan pada database." 
					data-hintPosition ="top-middle" 
					data-position     ="bottom-right-aligned"
					class="table table-striped table-bordered nowrap" width="100%"> 
						<thead> 
							<tr> 
								<th style="text-align:center" width="1%">No.</th> 
								<th style="text-align:center" width="10%">Foto</th> 
								<th style="text-align:center" width="10%">Nama</th> 
								<th style="text-align:center" width="60%">Isi Berita</th>  
								<th style="text-align:center" width="15%">Tgl Dibuat</th>  
								<th style="text-align:center" width="15%">Tgl Selesai</th>  
								<th style="text-align:center" width="10%">Publish</th> 
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
                            <label class="control-label col-md-2">Deskripsi</label>
                            <div class="col-md-9">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Informasi Berita" rows="15"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">    
                        <label class="control-label col-md-2">Tgl Publish :</label>  
                        <div class="col-md-3 col-sm-3"> 
                            <div class="input-group input-daterange"> 
                                <input type="text" class="form-control" name="tgl_dibuat" id="tgl_dibuat" /> 
                                <span class="help-block"></span>
                            </div>   
                        </div> 
                    </div>
                    <div class="form-group">    
                        <label class="control-label col-md-2">Tgl Selesai :</label>  
                        <div class="col-md-3 col-sm-3"> 
                            <div class="input-group input-daterange"> 
                                <input type="text" class="form-control" name="tgl_selesai" id="tgl_selesai" /> 
                                <span class="help-block"></span>
                            </div>   
                        </div> 
                    </div>
                </form>                 
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_news('<?php echo $link;?>','news','form')" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>