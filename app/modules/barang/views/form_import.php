<script src="<?php echo base_url();?>assets/js/import_barang.js"></script>
<div class="row">
  <div class="col-12">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
      <div class="panel-heading">
        <div class="panel-heading-btn"> 
          <a 
            data-step         ="1" 
            data-intro        ="Digunakan untuk mendownload format pengisian Data Barang."  
            data-hint         ="Digunakan untuk mendownload format pengisian Data Barang." 
            data-hintPosition ="top-middle" 
            data-position     ="bottom-right-aligned"
            href="<?php echo base_url();?>barang/download_format" class="btn btn-warning btn-xs m-r-5">
            <i class="fa fa-download"></i>&nbsp;
            Download Format Pengisian Data Barang
          </a> 
          <a href="javascript:void(0);" class="btn btn-info btn-xs m-r-5" title="Bantuan" onclick="javascript:introJs().start();">
            <i class="fa fa-question"></i> 
          </a> 
        </div> 
        <h4 class="panel-title"><?php echo $halaman;?></h4>
      </div>
      <div class="panel-body">
        <div class="alert alert-warning fade in">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          Form ini digunakan untuk <strong><a href="#">import </a></strong>data Barang sesuai dengan format pengisian data Data Barang yang sudah disediakan.
        </div>
        <form class="form-inline" action="<?php echo base_url();?>barang/proses_import" enctype="multipart/form-data" method="POST">
          <div class="form-group m-r-10">
            <input 
            data-step         ="2" 
            data-intro        ="Upload File Data Barang, type file (*.xls | *.xlsx)"  
            data-hint         ="Upload File Data Barang, type file (*.xls | *.xlsx)." 
            data-hintPosition ="top-middle" 
            data-position     ="bottom-right-aligned"
            type="file" name="file" id="file" />
            <span style="color:red;"><small>Type File Import Data Barang (*.xls | *.xlsx)</small></span>
          </div>
          <button
            data-step         ="3" 
            data-intro        ="Tombol Proses Import Data Data Barang."  
            data-hint         ="Tombol Proses Import Data Data Barang." 
            data-hintPosition ="top-middle" 
            data-position     ="bottom-right-aligned"
            type="submit" class="btn btn-sm btn-primary m-r-5">Proses Import Data Barang</button>
        </form>
        <?php echo $this->session->flashdata('msg'); ?>
      </div>
    </div>
  </div>
  <!-- Stok Barang -->
  <div class="col-12">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
      <div class="panel-heading">
        <div class="panel-heading-btn"> 
          <a 
            data-step         ="1" 
            data-intro        ="Digunakan untuk mendownload format pengisian Stok Barang."  
            data-hint         ="Digunakan untuk mendownload format pengisian Stok Barang." 
            data-hintPosition ="top-middle" 
            data-position     ="bottom-right-aligned"
            href="javascript:void(0)" onclick="download_stok()" class="btn btn-warning btn-xs m-r-5">
            <i class="fa fa-download"></i>&nbsp;
            Download Format Pengisian Stok Barang
          </a> 
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
            <a href="javascript:void(0);" class="btn btn-info btn-xs m-r-5" title="Bantuan" onclick="javascript:introJs().start();">
                <i class="fa fa-question"></i> 
            </a> 
        </div> 
        <h4 class="panel-title">Import Stok Barang</h4>
        <div id="filter_pencarian">
            <br/>
            <?php echo form_dropdown('tipe',$option_tipe,isset($default['tipe']) ? $default['tipe'] : '','class="default-select2 form-control" style="width:15%" id="tipe" name="tipe" data-live-search="true" data-style="btn-white"');?>
            <?php echo form_dropdown('merk',$option_merk,isset($default['merk']) ? $default['merk'] : '','class="default-select2 form-control" style="width:15%" id="merk" name="merk" data-live-search="true" data-style="btn-white"');?>
        </div>
      </div>
      <div class="panel-body">
        <div class="alert alert-warning fade in">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          Form ini digunakan untuk <strong><a href="#">import </a></strong>Stok Barang sesuai dengan format pengisian data Stok Barang yang sudah disediakan.
        </div>
        <form class="form-inline" action="<?php echo base_url();?>barang/proses_import_stok" enctype="multipart/form-data" method="POST">
          <div class="form-group m-r-10">
            <input 
            data-step         ="2" 
            data-intro        ="Upload File Stok Barang, type file (*.xls | *.xlsx)"  
            data-hint         ="Upload File Stok Barang, type file (*.xls | *.xlsx)." 
            data-hintPosition ="top-middle" 
            data-position     ="bottom-right-aligned"
            type="file" name="file" id="file" />
            <span style="color:red;"><small>Type File Import Stok Barang (*.xls | *.xlsx)</small></span>
          </div>
          <button
            data-step         ="3" 
            data-intro        ="Tombol Proses Import Data Stok Barang."  
            data-hint         ="Tombol Proses Import Data Stok Barang." 
            data-hintPosition ="top-middle" 
            data-position     ="bottom-right-aligned"
            type="submit" class="btn btn-sm btn-primary m-r-5">Proses Import Stok Barang</button>
        </form>
        <?php echo $this->session->flashdata('msg'); ?>
      </div>
    </div>
  </div>
</div>
