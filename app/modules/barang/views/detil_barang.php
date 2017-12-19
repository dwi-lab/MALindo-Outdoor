<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>assets/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/highcharts/themes/skies.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
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
    data-intro        ="Informasi Pribadi Member <?php echo $nama;?>"   
    data-hint         ="Informasi Pribadi Member <?php echo $nama;?>" 
    data-hintPosition ="top-middle" 
    data-position     ="bottom-right-aligned"
    class="profile-section">
        <div class="profile-left">
            <div class="profile-image">
               <!--  <?php
               if($foto==""){
                   $fotox = "no.jpg";
               }else{
                   $fotox = $foto;
               }
               ?>
               <img src="<?php echo base_url();?>assets/foto/member/<?php echo $fotox;?>" style="width:200px;text-align:center;height:180px;"> -->
                <i class="fa fa-user hide"></i>
            </div>
        </div>
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
