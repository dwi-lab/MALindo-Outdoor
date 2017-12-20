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
            <div class="profile-image" title="Foto Profile">
                <?php
                if($foto==""){
                    $fotox = "no.jpg";
                }else{
                    $fotox = $foto;
                }
                ?>
                <img src="<?php echo base_url();?>assets/foto/member/<?php echo $fotox;?>" style="width:200px;text-align:center;height:180px;">
                <i class="fa fa-user hide"></i>
            </div>
            <br/>
            <div class="profile-image" title="Foto Identitas">
                <?php
                if($foto_identitas==""){
                    $foto_identitas = "no.jpg";
                }else{
                    $foto_identitas = $foto_identitas;
                }
                ?>
                <img src="<?php echo base_url();?>assets/foto/identitas/<?php echo $foto_identitas;?>" style="width:200px;text-align:center;height:180px;">
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
                                    <h4><?php echo $nama;?> <small><?php echo $no_identitas;?></small></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="highlight">
                                <td class="field">Kode Member</td>
                                <td><?php echo $kode_member;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Jenis Kelamin</td>
                                <td><?php if($jk=='1'){echo 'Laki-Laki';}else{echo 'Perempuan';};?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tanggal Lahir</td>
                                <td><?php echo date("d-m-Y",strtotime($tgllahir));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Provinsi</td>
                                <td><?php echo $provinsi;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kota</td>
                                <td><?php echo $kota;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kecamatan</td>
                                <td><?php echo $kecamatan;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Kelurahan</td>
                                <td><?php echo $kelurahan;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Alamat</td>
                                <td><?php echo $almt;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Umur</td>
                                <td><?php echo $umur;?> Tahun</td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Pekerjaan</td>
                                <td><?php echo $kerja;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">No Handphone</td>
                                <td><?php echo $hp;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">E-mail</td>
                                <td><?php echo $mail;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tanggal Daftar</td>
                                <td><?php echo date("d-m-Y",strtotime($tgldaftar));?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="panel-heading-btn"> 
                        <br/> 
                        <a class="btn btn-xs m-r-5 btn-primary" href="<?php echo base_url();?>member/edit/<?php echo $kode_member;?>" title="Edit Data" 
                        data-step         ="2" 
                        data-intro        ="Digunakan untuk mengedit data."  
                        data-hint         ="Digunakan untuk mengedit data." 
                        data-hintPosition ="top-middle" 
                        data-position     ="bottom-right-aligned"><i class="icon-pencil"></i>&nbsp;Edit Data Member</a>
                    </div>  
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
    <div class="col-md-12"> 
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">List Barang</h4>
            </div>
            <div class="panel-body p-0">
                <div 
                data-step         ="6" 
                data-intro        ="List Barang Yang Pernah Di Pinjam."  
                data-hint         ="List Barang Yang Pernah Di Pinjam." 
                data-hintPosition ="top-middle" 
                data-position     ="bottom-right-aligned"
                class="vertical-box">
                    <div id="calendar" class="vertical-box-column p-20 calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
