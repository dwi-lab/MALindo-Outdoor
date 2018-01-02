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
    <div class="profile-section">
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
                            <tr class="highlight">
                                <td class="field">Kode Booking</td>
                                <td><?php echo "<b>" . $kode_booking . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tgl Booking</td>
                                <td><?php echo date("d-m-Y",strtotime($tgl_booking));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tgl Sewa</td>
                                <td><?php echo date("d-m-Y",strtotime($tgl_mulai));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Tgl Selesai</td>
                                <td><?php echo date("d-m-Y",strtotime($tgl_selesai));?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Lama Sewa</td>
                                <td><?php echo "<b><font color='red'>" . number_format($lama) . " hari </font></b>" ;?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Poin Bayar</td>
                                <td><?php echo "<b>" . number_format($poin_bayar) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Harga Poin</td>
                                <td><?php echo "<b>Rp. " . number_format($harga_poin) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Subtotal</td>
                                <td><?php echo "<b>Rp. " . number_format($subtotal) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Diskon Tetap</td>
                                <td><?php echo "<b>" . number_format($diskon_pinjam) . " %" . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Diskon Khusus</td>
                                <td><?php echo "<b>" . number_format($diskon_momen) . " %" . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Dibayar</td>
                                <td><?php echo "<b>Rp. " . number_format($total_bayar) . "</b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Sisa</td>
                                <td><?php echo "<b><font color='red'>Rp. " . number_format($sisa_bayar) . "</font></b>";?></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Jenis Bayar</td>
                                <td>
                                    <b><font color="red"><?php echo $jns_bayar;?></font></b>
                                </td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Status Booking</td>
                                <td>
                                    <?php 
                                    if($status_booking==1){
// proses
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-info" title="Sedang Dalam Proses">InProses</a>
                                        <?php
                                    }else if($status_booking==0){
// cancel
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title="Booking Selesai">Booking Finish</a>
                                        <?php
                                    }else{
// Finish
                                        ?>
                                        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title="Booking Cancel">Booking Cancel</a>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/booking_detil.js"></script>
<div class="row"> 
    <div class="col-md-12"> 
        <div class="panel panel-inverse"> 
            <div class="panel-heading"> 
                <div class="panel-heading-btn">
                    <a href="<?php echo base_url();?>booking/add_booking/<?php echo $kode_booking;?>" class="btn btn-primary btn-xs m-r-5" >
                        <i class="fa fa-plus-circle"></i> 
                        Tambah Data Barang
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
                <h4 class="panel-title">Detil Barang Yang di Booking</h4> 
            </div> 
            <div class="panel-body"> 
                <div class="table-responsive"> 
                    <table id="data-booking-detil" 
                    data-step         ="4" 
                    data-intro        ="List Data yang tersimpan pada database."  
                    data-hint         ="List Data yang tersimpan pada database." 
                    data-hintPosition ="top-middle" 
                    data-position     ="bottom-right-aligned"
                    class="table table-striped table-bordered nowrap" width="100%"> 
                        <thead> 
                            <tr> 
                                <th style="text-align:center" width="1%">No.</th> 
                                <th style="text-align:center" width="10%">Foto Barang</th> 
                                <th style="text-align:center" width="10%">Kode Barang</th> 
                                <th style="text-align:center" width="40%">Nama Barang</th> 
                                <th style="text-align:center" width="10%">Warna Barang</th> 
                                <th style="text-align:center" width="10%">Harga Sewa</th> 
                                <th style="text-align:center" width="7%">Qty</th> 
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
<!-- 
<div class="row"> 
    <div class="col-md-12"> 
        <script type="text/javascript">
        function kirim_email($kode_booking) {
            jQuery.post($BASE_URL+"booking/kirim_email/"+$kode_booking,
            function(data){
                if(data.response!='true'){
                    $.gritter.add({title:"Informasi Invoice !",text: "Nota Pesanan Terkirim ke e-mail member !"});
                    return false;
                }else{
                    $.gritter.add({title:"Informasi Invoice !",text: "Nota Pesanan Gagal Terkirim ke e-mail member !"});
                    return false;
                }
            });
        }
        </script>
        <link href="<?php echo base_url();?>assets/css/invoice-print.min.css" rel="stylesheet" />
        <div class="invoice">
            <div class="invoice-company">
                <span class="pull-right hidden-print">
                <a href="javascript:;" onclick="window.print();kirim_email('<?php echo $kode_booking;?>');" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i> Print</a>
                </span>
                <b>MALindo Outdoor</b>
            </div>
            <div class="invoice-header">
                <div class="invoice-from">
                    <small>dari</small>
                    <address class="m-t-5 m-b-5">
                        <strong>MALindo Outdoor.</strong><br />
                        JL. DR. Moch. Hatta No. 168 Kel. Sukamanah <br />
                        Kec. Cipedes Kota Tasikmalaya<br />
                        Tlp : 0813-2014-7000<br />
                        e-mail : malindooutdoor@gmail.com
                    </address>
                </div>
                <div class="invoice-to">
                    <small>ke</small>
                    <address class="m-t-5 m-b-5">
                        <strong><?php echo $nama_member;?></strong><br />
                        <?php echo $alamat_member;?><br />
                        <?php echo $alamat_detil;?><br />
                        Tlp: <?php echo $tlp_member;?><br />
                        e-mail: <?php echo $email_member;?>
                    </address>
                </div>
                <div class="invoice-date">
                    <small>Nota Pesanan</small>
                    <div class="date m-t-5"><?php echo $tgl_booking;?></div>
                    <div class="invoice-detail">
                        #<?php echo $kode_booking;?><br />
                        <b>Pesanan</b><br/>
                        <small><font color="red"><?php echo $tgl_mulai;?> s/d <?php echo $tgl_selesai;?></font></small><br/>
                        <b>Jenis Bayar : <font color="red"><?php echo $jns_bayar;?></font></b>
                    </div>
                </div>
            </div>
            <div class="invoice-content">
                <div class="table-responsive">
                    <table class="table table-invoice">
                        <thead>
                            <tr>
                                <th>Rincian Pesanan</th>
                                <th>Harga Sewa</th>
                                <th>Lama Pinjam</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $detil = $this->db->query("SELECT * FROM tbl_booking a JOIN tbl_booking_detil b ON a.kode_booking = b.kode_booking JOIN view_barang_detil c ON b.kode_barang = c.kode WHERE a.kode_booking = '$kode_booking' GROUP BY b.kode_barang,b.kode_warna")->result();
                            if(count($detil)>0){
                                foreach ($detil as $row) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row->nama_barang;?><br />
                                            <small>Warna Barang : <?php echo $row->warna;?> </small>
                                            <small>Tipe Barang <?php echo $row->tipe;?> Merk Barang : <?php echo $row->merk;?> Warna Barang : <?php echo $row->warna;?> </small>
                                        </td>
                                        <td><?php echo number_format($row->hrg_sewa);?></td>
                                        <td><?php echo number_format($row->lama) . " hari";?></td>
                                        <td><?php echo number_format($row->hrg_sewa * $row->lama);?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="invoice-price">
                    <div class="invoice-price-left">
                        <div class="invoice-price-row">
                            <div class="sub-price">
                                <small>Subtotal</small>
                                <?php echo number_format($subtotal);?>
                            </div>
                            <div class="sub-price">
                                <i class="fa fa-minus"></i>
                            </div>
                            <div class="sub-price">
                                <small>Diskon Tetap (<?php echo number_format($diskon_pinjam);?> %)</small>
                                <?php echo number_format($tot_diskon_pinjam);?>
                                <small><font color="red"><?php echo $nama_diskon_pinjam;?></font></small>
                            </div>
                            <div class="sub-price">
                                <i class="fa fa-minus"></i>
                            </div>
                            <div class="sub-price">
                                <small>Diskon Khusus (<?php echo number_format($diskon_momen);?> %)</small>
                                <?php echo number_format($tot_diskon_momen);?>
                                <small><font color="red"><?php echo $nama_diskon_momen;?></font></small>
                            </div>
                            <div class="sub-price">
                                <i class="fa fa-minus"></i>
                            </div>
                            <div class="sub-price">
                                <small>Dibayar</small>
                                <?php echo number_format($total_bayar);?>
                                <small><font color="red"><?php echo $status;?></font></small>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-price-right">
                        <small>SISA PEMBAYARAN</small> <?php echo number_format($sisa_bayar);?>
                    </div>
                </div>
            </div>
            <div class="invoice-note">
                <?php
                $syarat = $this->db->get_where('tbl_syarat',array('status'=>'1'))->result();
                if(count($syarat)>0){
                    foreach ($syarat as $xx) {
                        echo " * " . $xx->ket;
                    }
                }
                ?>
            </div>
            <div class="invoice-footer text-muted">
                <p class="text-center m-b-5">
                    Terimakasih Atas Kepercayaan Yang Telah Diberikan
                </p>
                <p class="text-center">
                    <span class="m-r-10"><i class="fa fa-globe"></i> malindooutdoor.com</span>
                    <span class="m-r-10"><i class="fa fa-phone"></i> T:0813-2014-7000</span>
                    <span class="m-r-10"><i class="fa fa-envelope"></i> malindooutdoor@gmail.com</span>
                </p>
            </div>
        </div>
    </div>
</div>
 -->