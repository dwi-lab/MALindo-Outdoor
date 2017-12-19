<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>assets/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/highcharts/themes/skies.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/detil_barang.js"></script>
<div class="profile-container">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:void(0);" class="btn btn-info btn-xs m-r-5" title="Bantuan" onclick="javascript:introJs().start();">
                <i class="fa fa-question"></i>
            </a>
        </div>
    </div>
    <div
    data-step         ="1"
    data-intro        ="Informasi Data Barang."
    data-hintPosition ="top-middle"
    data-position     ="bottom-right-aligned"
    class="profile-section">
        <div class="profile-right">
            <div class="profile-info">
                <div class="table-responsive">
                    <table class="table table-profile">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h4><?php echo $nama;?> </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="highlight">
                                <td class="field">Kode Barang</td>
                                <td><?php echo $kode;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tipe Barang</td>
                                <td><?php echo $tipe;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Merk Barang</td>
                                <td><?php echo $merk;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tanggal Beli</td>
                                <td><?php echo date("d-m-Y",strtotime($tglbeli));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Harga Beli</td>
                                <td>Rp. <?php echo number_format($hrgbeli) ;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Biaya Penyusutan</td>
                                <td>Rp. <?php echo number_format($hrgsusut) ;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Harga Sewa</td>
                                <td>Rp. <?php echo number_format($hrgsewa) ;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Total Stok</td>
                                <td><?php echo number_format($stoktot) ;?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
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
                </div> 
                <h4 class="panel-title">Detil Stok Barang</h4> 
            </div> 
            <div class="panel-body"> 
                <div class="table-responsive"> 
                    <table id="data-barang-detil" 
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
                                <th style="text-align:center" width="70%">Warna Barang</th> 
                                <th style="text-align:center" width="10%">Stok</th> 
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
                <h4 class="panel-title">Grafik Peminjaman</h4>
            </div>
            <div class="panel-body p-0">
                <div
                data-step         ="3"
                data-intro        ="Grafik Peminjaman Barang."
                data-hint         ="Grafik Peminjaman Barang."
                data-hintPosition ="top-middle"
                data-position     ="bottom-right-aligned"
                class="vertical-box">
                    <div id="chart-pinjam" class="vertical-box-column p-20 calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">History Peminjaman</h4>
            </div>
            <div class="panel-body p-0">
                <div
                data-step         ="4"
                data-intro        ="History Peminjaman Barang."
                data-hint         ="History Peminjaman Barang."
                data-hintPosition ="top-middle"
                data-position     ="bottom-right-aligned"
                class="vertical-box">
                    <div id="calendar" class="vertical-box-column p-20 calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">History Pengembalian</h4>
            </div>
            <div class="panel-body p-0">
                <div
                data-step         ="5"
                data-intro        ="History Pengembalian Barang."
                data-hint         ="History Pengembalian Barang."
                data-hintPosition ="top-middle"
                data-position     ="bottom-right-aligned"
                class="vertical-box">
                    <div id="calendar" class="vertical-box-column p-20 calendar"></div>
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
                <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="text" value="" name="id"/> 
                    <div class="form-group" id="photo-preview">
                        <label class="control-label col-md-3">Foto</label>
                        <div class="col-md-9">
                            (No photo)
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Warna Barang * :</label>
                            <div class="col-md-6">
                            <?php echo form_dropdown('warna',$option_warna,isset($default['warna']) ? $default['warna'] : '','class="default-select2 form-control" style="width:100%" id="warna" name="warna" data-live-search="true" data-style="btn-white"');?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Stok Barang * :</label>
                            <div class="col-md-3">
                            <input class="form-control" maxlength="15" style="text-align:right" type="text" id="stokna" minlength="1" name="stokna" />
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label id="label-photo" class="control-label col-md-3">Foto Barang</label>
                            <div class="col-md-6">
                                <input name="foto" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>                 
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_detil('<?php echo $link;?>','barang','form')" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>