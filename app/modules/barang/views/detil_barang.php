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
