<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/booking_now.js"></script>
<script src="<?= base_url('assets/highcharts/highcharts.js') ?>"></script>
<script src="<?= base_url('assets/highcharts/data.js') ?>"></script>
<script src="<?= base_url('assets/highcharts/drilldown.js') ?>"></script>
<script type="text/javascript">
$(function () {
    Highcharts.chart('booking-bulan', {
    title: {
    text: 'Order Perbulan',
            x: - 20
    },
            subtitle: {
            text: 'Grafik Booking Pertiap Bulan',
                    x: - 20
            },
            xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
            title: {
            text: 'Booking'
            },
                    plotLines: [{
                    value: 0,
                            width: 1,
                            color: '#808080'
                    }]
            },
            tooltip: {
            valueSuffix: ' Booking'
            },
            legend: {
            layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
            },
            series: [
<?php foreach ($orderBulan['years'] as $year) { ?>
                {
                name: '<?= $year ?>',
                        data: [<?= implode(',', $orderBulan['orders'][$year]) ?>]
                },
<?php } ?>
            ]
    });

    Highcharts.chart('sewa-bulan', {
    title: {
    text: 'Penyewaan Perbulan',
            x: - 20
    },
            subtitle: {
            text: 'Grafik Penyewaan Pertiap Bulan',
                    x: - 20
            },
            xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
            title: {
            text: 'Penyewaan'
            },
                    plotLines: [{
                    value: 0,
                            width: 1,
                            color: '#808080'
                    }]
            },
            tooltip: {
            valueSuffix: ' Penyewaan'
            },
            legend: {
            layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
            },
            series: [
<?php foreach ($sewaBulan['years'] as $year) { ?>
                {
                name: '<?= $year ?>',
                        data: [<?= implode(',', $sewaBulan['orders'][$year]) ?>]
                },
<?php } ?>
            ]
    });
    Highcharts.chart('balik-bulan', {
    title: {
    text: 'Pengembalian Perbulan',
            x: - 20
    },
            subtitle: {
            text: 'Grafik Pengembalian Pertiap Bulan',
                    x: - 20
            },
            xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
            title: {
            text: 'Pengembalian'
            },
                    plotLines: [{
                    value: 0,
                            width: 1,
                            color: '#808080'
                    }]
            },
            tooltip: {
            valueSuffix: ' Pengembalian'
            },
            legend: {
            layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
            },
            series: [
<?php foreach ($balikBulan['years'] as $year) { ?>
                {
                name: '<?= $year ?>',
                        data: [<?= implode(',', $balikBulan['orders'][$year]) ?>]
                },
<?php } ?>
            ]
    });
    Highcharts.chart('pemeliharaan-bulan', {
    title: {
    text: 'Pemeliharaan Perbulan',
            x: - 20
    },
            subtitle: {
            text: 'Grafik Pemeliharaan Pertiap Bulan',
                    x: - 20
            },
            xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
            title: {
            text: 'Pemeliharaan'
            },
                    plotLines: [{
                    value: 0,
                            width: 1,
                            color: '#808080'
                    }]
            },
            tooltip: {
            valueSuffix: ' Pemeliharaan'
            },
            legend: {
            layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
            },
            series: [
<?php foreach ($pemeliharaanBulan['years'] as $year) { ?>
                {
                name: '<?= $year ?>',
                        data: [<?= implode(',', $pemeliharaanBulan['orders'][$year]) ?>]
                },
<?php } ?>
            ]
    });
    Highcharts.chart('daftar-bulan', {
    title: {
    text: 'Pendaftaran Perbulan',
            x: - 20
    },
            subtitle: {
            text: 'Grafik Pendaftaran Member Pertiap Bulan',
                    x: - 20
            },
            xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
            },
            yAxis: {
            title: {
            text: 'Banyak Orang'
            },
                    plotLines: [{
                    value: 0,
                            width: 1,
                            color: '#808080'
                    }]
            },
            tooltip: {
            valueSuffix: ' Orang'
            },
            legend: {
            layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
            },
            series: [
<?php foreach ($pendaftaranBulan['years'] as $year) { ?>
                {
                name: '<?= $year ?>',
                        data: [<?= implode(',', $pendaftaranBulan['orders'][$year]) ?>]
                },
<?php } ?>
            ]
    });
});
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
function kirim_all(){
    save_method = 'add';
    $('#formAll')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_formAll').modal('show');
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
function kirimx_all(link) {
    $('#btnKirimAll').text('Proses...');
    $('#btnKirimAll').attr('disabled', true);
    var url;
    if (save_method == 'add') {
        url = $BASE_URL + link + "/kirim_email_all";
    } else {
        url = $BASE_URL + link + "/proses_edit";
    }
    $.ajax({
        url: url,
        type: "POST",
        data: $('#formAll').serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal_formAll').modal('hide');
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
            $('#btnKirimAll').text('Simpan');
            $('#btnKirimAll').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.gritter.add({
                title: "Informasi !",
                text: "Pengiriman E-mail Gagal, Pastikan Terkoneksi dengan Internet"
            });
            $('#btnKirimAll').text('Simpan');
            $('#btnKirimAll').attr('disabled', false);
            return false;
        }
    });
}
</script>
<div class="row">
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-green">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-calendar fa-fw"></i></div>
			<div class="stats-title">Total Booking</div>
			<div class="stats-number"><?php echo number_format($this->db->get('tbl_booking')->num_rows());?></div>
			<div class="stats-link">
				<a href="<?php echo base_url();?>booking">Lihat Detil <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-purple">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-check-square fa-fw"></i></div>
			<div class="stats-title">Total Penyewaan</div>
			<div class="stats-number"><?php echo number_format($this->db->get('tbl_trans')->num_rows());?></div>
			<div class="stats-link">
				<a href="<?php echo base_url();?>sewa">Lihat Detil <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-blue">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-group fa-fw"></i></div>
			<div class="stats-title">Total Member</div>
			<div class="stats-number"><?php echo number_format($this->db->get('tbl_member')->num_rows());?></div>
			<div class="stats-link">
				<a href="<?php echo base_url();?>member">Lihat Detil <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-black">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-clock-o fa-fw"></i></div>
			<div class="stats-title">Waktu</div>
			<div class="stats-number"><span id="waktos"><script type="text/javascript">window.onload = waktos('waktos');</script></span></div>
			<div class="stats-link">
				<a href="href;;"><span id="kaping"><script type="text/javascript">window.onload = kaping('kaping');</script></span></a>
			</div>
		</div>
	</div>
    <?php
    if($aya!=""){
        ?>
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="ui-general-1">
                <div class="panel-body">
                    <div class="alert alert-danger fade in m-b-15">
                        <strong>Informasi !</strong><br/>
                        <?php echo $this->session->flashdata('info'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
	<div class="col-md-8 col-sm-12">
		<div class="panel panel-inverse" data-sortable-id="index-5">
			<div class="panel-heading">
				<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
				<h4 class="panel-title"><i class="fa fa-bullhorn fa-fw"></i> Papan Informasi</h4>
			</div>
			<div class="panel-body">
				<div class="height-sm" data-scrollbar="true">
					<ul class="media-list media-list-with-divider media-messaging">
						<?php
    					date_default_timezone_set('Asia/Jakarta');
						$now    = date("Y-m-d");
						$cknews = $this->db->query("SELECT * FROM tbl_news a JOIN tbl_username b ON a.oleh = b.kode WHERE a.publish = '1' AND a.tgl_selesai >= '$now' ORDER BY a.tgl_selesai DESC")->result();
						if(count($cknews)>0){
							foreach ($cknews as $key) {
								$foto        = $key->foto;
								$nama        = $key->nama;
								$berita      = $key->berita;
								$tgl_dibuat  = date("d-m-Y",strtotime($key->tgl_dibuat));
								$tgl_selesai = date("d-m-Y",strtotime($key->tgl_selesai));
								?>
								<li class="media media-sm">
									<a href="javascript:;" class="pull-left">
										<img src="<?php echo base_url();?>assets/foto/pegawai/<?php echo $foto;?>" alt="" class="media-object" />
									</a>
									<div class="media-body">
										<h5 class="media-heading"><?php echo $nama;?></h5>
										<p><?php echo $berita;?></p><br/>
										<small><font color="red">Tanggal dibuat : <?php echo $tgl_dibuat;?><br/> Tanggal Selesai : <?php echo $tgl_selesai;?></font></small>
									</div>
								</li>
								<?php
							}
						}else{
							?>
							<div class="alert alert-info fade in m-b-15">
								<strong>Tidak ada informasi untuk saat ini</strong>
							</div>		
							<?php
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php
	date_default_timezone_set('Asia/Jakarta');
    $bln    = date("m");
    $cekbln = $this->db->query("SELECT bulan FROM tbl_bulan WHERE kode = '$bln'");
    if(count($cekbln->result())>0){
        $ju = $cekbln->row();
        $blnx = $ju->bulan;
    }else{
        $blnx = "";
    }
    ?>
	<div class="col-md-4">
        <div class="panel panel-inverse" data-sortable-id="index-5">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                	<?php
                        date_default_timezone_set('Asia/Jakarta');
                        $akhir = date("Y-m-d");
                        $bln   = date("m");
                        $ultah = $this->db->query("SELECT * FROM view_member WHERE MONTH(tgl_lahir) = '$bln' ORDER BY tgl_lahir ASC")->result();
                        if(count($ultah)>0){
                        	?>
                        	<a href="javascript:;" class="btn btn-primary btn-xs m-r-5" title="Kirim Pesan ke Semua Member" onclick="kirim_all()"><i class="fa fa-envelope"></i></a> 
                        	<?php
                   	 	}
                    ?>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title"><i class="fa fa-users fa-fw"></i> Member yang Berulang Tahun <?php echo number_format($this->db->query("SELECT * FROM view_member WHERE MONTH(tgl_lahir) = '$bln' ORDER BY tgl_lahir ASC")->num_rows());?> Orang</h4>
            </div>
            <div class="panel-body">
                <div class="height-sm" data-scrollbar="true">
                    <ul class="media-list media-list-with-divider media-messaging">
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $akhir = date("Y-m-d");
                        $bln   = date("m");
                        $ultah = $this->db->query("SELECT * FROM view_member WHERE MONTH(tgl_lahir) = '$bln' ORDER BY tgl_lahir ASC")->result();
                        if(count($ultah)>0){
                            foreach ($ultah as $key) {
								$kode_member = $key->kode_member;
								$nama        = $key->nama;
								$tgl_lahir   = $key->tgl_lahir;
								$foto        = $key->foto;
								$mail        = $key->email;
								$no_hp       = $key->no_handphone;
								$diff        = abs(strtotime($akhir) - strtotime($tgl_lahir));
								$years       = floor($diff / (365*60*60*24));
                                if(empty($foto)){
                                    $fotox = "no.jpg";
                                }else{
                                    $fotox = $foto;
                                }
                                ?>
                                <li class="media media-sm">
									<a href="javascript:;" class="pull-left">
										<img src="<?php echo base_url();?>assets/foto/member/<?php echo $fotox;?>" alt="" class="media-object" />
									</a>
									<div class="media-body">
										<h5 class="media-heading"><?php echo $nama;?></h5>
										<div title="Tanggal Lahir"><?php echo date("d-m-Y",strtotime($tgl_lahir));?></div>
                                        <div title="No Handphone"><?php echo $no_hp;?></div>
                                        <div title="E-mail"><?php echo $mail;?></div>
										<span class="date-time" title="Usia"><?php echo $years;?> Tahun</span>
									</div>
									<div style="text-align: center;">
						                <a href="javascript:;" onclick="kirim('<?php echo $mail;?>');" class="btn btn-primary btn-block btn-xs m-r-5"><i class="fa fa-envelope m-r-5"></i> Kirim E-mail</a>
						            </div>
								</li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12"> 
        <div class="panel panel-inverse"> 
            <div class="panel-heading"> 
                <div class="panel-heading-btn">
                    <a href="<?php echo base_url();?>booking/add" 
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
                <h4 class="panel-title"><i class="fa fa-download fa-fw"></i> List Perencanaan Penyewaan untuk hari ini tanggal : <b><?php echo date("d-m-Y");?></b></h4> 
                <div id="filter_pencarian">
                    <br/>
                    <select name="jns_bayar" class="default-select2 form-control" style="width:20%" id="jns_bayar" name="jns_bayar" data-live-search="true" data-style="btn-white">
                        <option value="">Pilih Jenis Pembayaran</option>
                        <option value="1">Cash</option>
                        <option value="2">Poin</option>
                    </select>
                    <select name="status" class="default-select2 form-control" style="width:20%" id="status" name="status" data-live-search="true" data-style="btn-white">
                        <option value="">Pilih Status Booking</option>
                        <option value="1">OnBooking</option>
                        <option value="2">InProses</option>
                        <option value="3">Cancel Booking</option>
                        <option value="0">Booking Finish</option>
                    </select>
                </div>
            </div> 
            <div class="panel-body"> 
                <div class="table-responsive"> 
                    <table id="data-booking" 
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
                                <th style="text-align:center" width="10%">Kode Booking</th>  
                                <th style="text-align:center" width="30%">Nama Member</th> 
                                <th style="text-align:center" width="10%">Tgl Booking</th> 
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
    <div class="col-lg-12">
        <div class="panel panel-inverse" data-sortable-id="index-5">
            <div class="panel-heading">
            	<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Grafik Pendaftaran Member - Perbulan</h3>
            </div>
            <div class="panel-body">
                <div id="daftar-bulan" style="min-width: 310px; height: 400px; margin: 0 auto;">

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-inverse" data-sortable-id="index-5">
            <div class="panel-heading">
            	<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Grafik Booking - Perbulan</h3>
            </div>
            <div class="panel-body">
                <div id="booking-bulan" style="min-width: 310px; height: 400px; margin: 0 auto;">

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-inverse" data-sortable-id="index-5">
            <div class="panel-heading">
            	<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Grafik Penyewaan - Perbulan</h3>
            </div>
            <div class="panel-body">
                <div id="sewa-bulan" style="min-width: 310px; height: 400px; margin: 0 auto;">

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-inverse" data-sortable-id="index-5">
            <div class="panel-heading">
            	<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Grafik Pengembalian - Perbulan</h3>
            </div>
            <div class="panel-body">
                <div id="balik-bulan" style="min-width: 310px; height: 400px; margin: 0 auto;">

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-inverse" data-sortable-id="index-5">
            <div class="panel-heading">
            	<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Grafik Pemeliharaan - Perbulan</h3>
            </div>
            <div class="panel-body">
                <div id="pemeliharaan-bulan" style="min-width: 310px; height: 400px; margin: 0 auto;">

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
<div id="modal_formAll" class="modal modal-message fade">
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
                <form action="#" id="formAll" class="form-horizontal">
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
                <button type="button" id="btnKirim" onclick="kirimx_all('dashboard')" class="btn btn-primary">Kirim</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>