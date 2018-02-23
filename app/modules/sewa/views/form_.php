<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/form-plugins.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<style>
.datepicker{z-index:1151 !important;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datepicker({
            todayHighlight: !0
        });
        jQuery('#subtotal_').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#bayar').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#sisa').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#b_cash').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#sisa_bayar_p').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#blain').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#b_sisa').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
	    jQuery('#potongan').priceFormat({
	        prefix: '',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
	    });
        $('#tglmulai').datepicker();
    	$('#tglselesai').datepicker();
        jQuery("#informasi").hide('');
        jQuery("#pelunasan").hide('');
    	jQuery("#ket_poin").hide('');
        jQuery("#bayar_cash").hide('');
        jQuery("#bayar_poin").hide('');
        jQuery("#tombol").hide('');
        jQuery("#ket_disc").hide('');
        jQuery("#ket_disc_lama").hide('');
        jQuery("#ket_ultah").hide('');
        jQuery("#informasi_barang").hide('');
        jQuery("#informasi_barang_detil").hide('');
        jQuery("#status").hide('');

        jQuery("#nama").autocomplete({
            source: function(req,add){
                jQuery.ajax({
                    url:"<?php echo base_url() . 'booking/get_member';?>",
                    dataType:'json',
                    type:'POST',
                    data:req,                                                   
                    success:function(data){
                        if(data.response=='true'){
                            add(data.message); 
                        }else{
                            $.gritter.add({title:"Informasi !",text: "Data yang anda cari tidak ditemukan"});
						    jQuery("#informasi").hide('');
        					jQuery("#status").hide('');
        					jQuery("#informasi_barang").hide('');
                            return false;
                        }
                    },
                    error:function(XMLHttpRequest){
                        alert(XMLHttpRequest.responseText);
                    }
                })
            },
            minLength:3,
            select: function(event,ui){
                jQuery('#nama').val(ui.item.nama+" | " + ui.item.kode);
                jQuery('#foto').val(ui.item.foto);
                jQuery('#alamat').val(ui.item.alamat);
                jQuery('#status_warna').val(ui.item.status_warna);
                jQuery('#no_handphone').val(ui.item.no_handphone);
                jQuery('#no_identitas').val(ui.item.no_identitas);
				var nama  = jQuery('#nama').val();
				var foto  = jQuery('#foto').val();
				if(ui.item.status_warna==9){
					jQuery("#informasi_barang").show('slow');
                	document.getElementById('kode_barang').focus();
					document.getElementById("status").innerHTML ="<div class=\"alert alert-success fade in\"><i class=\"fa fa-check fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>"
				}else if(ui.item.status_warna==2){
					jQuery("#informasi_barang").hide('slow');
					document.getElementById("status").innerHTML ="<div class=\"alert alert-warning fade in\"><i class=\"fa fa-remove fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>	"
				}else if(ui.item.status_warna==1){
					jQuery("#informasi_barang").show('slow');
                	document.getElementById('kode_barang').focus();
					document.getElementById("status").innerHTML ="<div class=\"alert alert-success fade in\"><i class=\"fa fa-check fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>"
				}else{
					jQuery("#informasi_barang").hide('slow');
					document.getElementById("status").innerHTML ="<div class=\"alert alert-danger fade in\"><i class=\"fa fa-remove fa-2x pull-left\"></i><p>"+ui.item.status_pinjam+"</p></div>	"
				}
                $.gritter.add({title:"Informasi Member !",text: "Nama Member : " + ui.item.nama + "<br/> No HP : " + ui.item.no_handphone + "<br/> No Identitas : " + ui.item.no_identitas,image:'<?php echo base_url();?>assets/foto/member/'+foto});
                // jQuery("#tombol").show("slow");
			    jQuery("#informasi").show('slow');
				jQuery("#status").show('slow');
				$("#status_pinjam").text(ui.item.status_pinjam);
				jQuery.post($BASE_URL+"booking/cekUltah/"+ui.item.kode,
	            function(data){
					if(data=='NotOk'){
				        jQuery("#ket_ultah").hide('slow');					
	                }else{
				        jQuery("#ket_ultah").show('slow');
	                    document.getElementById("ket_ulangtahun").innerHTML = "<b> Member Bersangkutan Ulang Tahun Hari Ini, Tanggal Lahir : "+ data +" </b>";
	                }
	            });
            }
        })
        jQuery("#kode_barang").autocomplete({
            source: function(req,add){
                jQuery.ajax({
                    url:"<?php echo base_url() . 'booking/get_barang';?>",
                    dataType:'json',
                    type:'POST',
                    data:req,                                                   
                    success:function(data){
                        if(data.response=='true'){
                            add(data.message); 
                        }else{
                            $.gritter.add({title:"Informasi !",text: "Data yang anda cari tidak ditemukan"});
						    jQuery("#tombol").hide('');
       						jQuery("#informasi_barang_detil").hide('');
                            return false;
                        }
                    },
                    error:function(XMLHttpRequest){
                        alert(XMLHttpRequest.responseText);
                    }
                })
            },
            minLength:3,
            select: function(event,ui){
                jQuery('#kode_barang').val(ui.item.kode);
                jQuery('#nama_barang').val(ui.item.nama);
                jQuery('#hrg_sewa').val(ui.item.harga);
                jQuery('#hrg_poin').val(ui.item.poin);
				jQuery("#informasi_barang_detil").show('slow');
            	document.getElementById('warna').focus();
                return false;
            }
        })
        jQuery("#warna").change(function(){
			var warna = jQuery("#warna").val();
			var kode  = jQuery("#kode_barang").val();
	        if(warna!=""){
	            jQuery.blockUI({
	                css: { 
	                    border: 'none', 
	                    padding: '15px', 
	                    backgroundColor: '#000', 
	                    '-webkit-border-radius': '10px', 
	                    '-moz-border-radius': '10px', 
	                    opacity: 0.5, 
	                    color: '#fff' 
	                },
	                message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
	            });
	            setTimeout(function(){
	            	jQuery.post($BASE_URL+"booking/getBarang/"+kode+"/"+warna,
		            function(data){
		                jQuery.unblockUI();
		                var dt = data.split("|");
		                jQuery("#stok_barang").val(dt[0]);
		                jQuery("#warna_barang").val(dt[1]);
		                jQuery("#foto_barang").val(dt[2]);
						var foto         = jQuery("#foto_barang").val();
						var warna_barang = jQuery("#warna_barang").val();
						var stok         = jQuery("#stok_barang").val();
						if(stok=='NotOk'){
				            $.gritter.add({title:"Informasi Barang !",text: "Data Tidak Ditemukan Untuk Saat Ini !"});
			                jQuery("#qty").val('');
				            return false;
		                }else if(stok <= 0){
				            $.gritter.add({title:"Informasi Barang !",text: "Stok Barang Tersebut Tidak Tersedia"});return false;
		                }else{
			                document.getElementById('qty').focus();
			                jQuery("#qty").val('');
				            $.gritter.add({title:"Informasi Barang !",text: "Warna Barang : " + warna_barang + "<br/> Stok Barang : " + stok,image:'<?php echo base_url();?>assets/foto/barang/'+foto});
				            return false;
		                }
		            });
	            },500);
                jQuery.unblockUI();
	        }
	    });
	    jQuery("#potongan").change(function(){
			var potongan  = jQuery("#potongan").unmask();
			var subtotal_ = jQuery("#subtotal_").unmask();
	        if(potongan!=""){
	            var tot_x = parseInt(subtotal_) - parseInt(potongan);
	            jQuery("#subtotal_").val(tot_x);
	            jQuery('#subtotal_').priceFormat({
			        prefix: '',
			        centsSeparator: ',',
			        thousandsSeparator: '.'
			    });
			    var s = jQuery("#subtotal_").val();
	            jQuery.post($BASE_URL+"booking/cekMinbayar/"+s,
	            function(data){
					var dt        = data.split("|");
					var min_bayar = dt[1];
					jQuery("#min_bayar").val(min_bayar);
	            	$.gritter.add({title:"Informasi !",text: "Minimal Pembayaran " + dt[0] + " %"});
					
                    return false;
	            });
	        }
	    });
	    jQuery("#blain").change(function(){
			var blain  = jQuery("#blain").unmask();
			var subtotal_ = jQuery("#subtotal_").unmask();
	        if(blain!=""){
	            var tot_x = parseInt(subtotal_) + parseInt(blain);
	            jQuery("#subtotal_").val(tot_x);
	            jQuery('#subtotal_').priceFormat({
			        prefix: '',
			        centsSeparator: ',',
			        thousandsSeparator: '.'
			    });
	        }
	    });
	    jQuery("#b_cash").change(function(){
			var total     = jQuery("#subtotal_").unmask();
			var bayar     = jQuery("#b_cash").unmask();
			var min_bayar = jQuery("#min_bayar").unmask();
			if(parseInt(bayar) < parseInt(min_bayar)){
				var s = jQuery("#subtotal_").val();
	            jQuery.post($BASE_URL+"booking/cekMinbayar/"+s,
	            function(data){
					var dt        = data.split("|");
	            	$.gritter.add({title:"Informasi !",text: "Minimal Pembayaran " + dt[0] + " % dari Total <br/> Sebesar : Rp. " + dt[1]});
                    return false;
	            });
	        	jQuery("#tombol").hide('');
				return false;
			}else{
				if(parseInt(bayar) > parseInt(total)){
					jQuery("#sisa_bayar").val(parseInt(bayar) - parseInt(total));
				}else{
					jQuery("#sisa_bayar").val(parseInt(total) - parseInt(bayar));
				}
				jQuery('#sisa_bayar').priceFormat({
			        prefix: '',
			        centsSeparator: ',',
			        thousandsSeparator: '.'
			    });
	        	jQuery("#tombol").show('');
				return false;
			}
	    });
	    jQuery("#jns_bayar").change(function(){
			var jns           = jQuery("#jns_bayar").val();
			var subtotal_poin = jQuery("#subtotal_poin").val();
			if(jns==2){
	            $.gritter.add({title:"Informasi Pembayaran !",text: "Jika Pembayaran dengan Poin untuk Diskon Tetap dan Diskon Khusus tidak Berlaku !"});
				var nama = jQuery('#nama').val();
				var pch  = nama.split(" | ");
				var kode = pch[1];
				jQuery.post($BASE_URL+"booking/cekPoint/"+kode,
	            function(data){
					var dt  = data;
					jQuery("#tot_poin").val(dt);
					var tot = jQuery("#tot_poin").val();
	                if(tot=='NotOk'){
	                	jQuery("#bayar_poin").hide('slow');
						jQuery("#bayar_cash").hide('slow');
	                    document.getElementById("ket_point").innerHTML = "<b>Member bersangkutan belum mempunyai Poin</b>";
	                }else{
        				jQuery("#pelunasan").show('');
	                	jQuery("#bayar_poin").show('slow');
						jQuery("#bayar_cash").hide('slow');
        				jQuery("#tombol").hide('');
        				if(parseInt(dt) >= parseInt(subtotal_poin)){
	        				document.getElementById("ket_point").innerHTML = "<b> Total Poin Member bersangkutan " + dt + "</b>";
			                document.getElementById('b_point').focus();	
        				}else{
        					var kurang = parseInt(subtotal_poin) - parseInt(dt);
	            			document.getElementById("ket_point").innerHTML = "<b>Pembayaran dengan Poin Kurang " + kurang + " Poin, Total Poin Member bersangkutan " + dt + "</b>";
			                document.getElementById('b_point').focus();	
        				}
	                }
	            	jQuery("#ket_poin").show('slow');
                    return false;
	            });
			}else if(jns==1){
				var s = jQuery("#subtotal_").val();
	            jQuery.post($BASE_URL+"booking/cekMinbayar/"+s,
	            function(data){
					var dt        = data.split("|");
					var min_bayar = dt[1];
					jQuery("#min_bayar").val(min_bayar);
	            	$.gritter.add({title:"Informasi !",text: "Minimal Pembayaran " + dt[0] + " %"});
					
                    return false;
	            });
				jQuery("#ket_poin").hide('slow');
				jQuery("#bayar_poin").hide('slow');
				jQuery("#bayar_cash").show('slow');
        		jQuery("#pelunasan").hide('');
                document.getElementById('b_cash').focus();
        		jQuery("#tombol").hide('');
			}else{
        		jQuery("#tombol").hide('');
        		jQuery("#pelunasan").hide('');
				jQuery("#bayar_poin").hide('slow');
				jQuery("#bayar_cash").hide('slow');
	            $.gritter.add({title:"Informasi Pembayaran !",text: "Silahkan Pilih Jenis Pembayaran"});
			}
	    });
	    jQuery("#b_point").change(function(){
			/*var tot_poin = jQuery("#tot_poin").val();
			var b        = jQuery("#b_point").val();
			if(parseInt(b) > parseInt(tot_poin)){
	            $.gritter.add({title:"Informasi Pembayaran !",text: "Pembayaran Poin Melebihi Total Poin Member"});
	            jQuery("#b_point").val('');
                document.getElementById('b_point').focus();
        		jQuery("#tombol").hide('');
			}else if(parseInt(b) <= parseInt(tot_poin)){
				var nama = jQuery('#nama').val();
				var pch  = nama.split(" | ");
				var kode = pch[1];
				jQuery.post($BASE_URL+"booking/bayarPoin/"+kode+"/"+b,
	            function(data){
					var dt        = data;
					jQuery("#tot_poin_b").val(dt);
					var tot_bayar = jQuery("#subtotal_").unmask();
					var tukar     = dt;
					if(parseInt(tot_bayar) > parseInt(tukar)){
	            		$.gritter.add({title:"Informasi Pembayaran !",text: "Pembayaran Dengan Poin Masih Kurang, Sisa Pembayaran Bisa Dengan Uang !"});
        				jQuery("#pelunasan").show('');
						jQuery("#sisa_bayar_p").val(parseInt(tot_bayar) - parseInt(tukar));
					}else if(tot_bayar <= tukar){
						$.gritter.add({title:"Informasi Pembayaran !",text: "Pembayaran Dengan Poin Melebihi Total Pembayaran, Poin Tidak Bisa Diuangkan !"});
        				jQuery("#pelunasan").hide('');
						jQuery("#sisa_bayar_p").val(parseInt(tukar) - parseInt(tot_bayar));
					}
        			jQuery("#tombol").show('');
	            });
			}
			jQuery('#sisa_bayar_p').priceFormat({
		        prefix: '',
		        centsSeparator: ',',
		        thousandsSeparator: '.'
		    });
            return false;*/
			var subtotal_poin = jQuery("#subtotal_poin").val();
			var b             = jQuery("#b_point").val();
			if(parseInt(b) >= parseInt(subtotal_poin)){
				$.gritter.add({title:"Informasi Pembayaran !",text: "Pembayaran Dengan Poin Melebihi Total Pembayaran, Poin Tidak Bisa Diuangkan !"});
				jQuery("#pelunasan").hide('');
    			jQuery("#tombol").show('');
				// jQuery("#sisa_bayar_p").val(parseInt(tukar) - parseInt(tot_bayar));
			}else{
				jQuery("#pelunasan").hide('');
				$.gritter.add({title:"Informasi Pembayaran !",text: "Pembayaran Dengan Poin Masih Kurang !"});
				// jQuery("#pelunasan").show('');
				// jQuery("#sisa_bayar_p").val(parseInt(tot_bayar) - parseInt(tukar));
			}
	    });
	    jQuery("#tglselesai").change(function(){
			var mulai   = jQuery("#tglsewa").val();
			var selesai = jQuery("#tglselesaisewa").val();
			if(mulai != "" && selesai != ""){
				jQuery.post($BASE_URL+"booking/cekLama/"+mulai+"/"+selesai,
	            function(data){
					var dt        = data.split("|");
					jQuery("#lama_pinjam").val(dt[0]);
					jQuery("#disc_lama_pinjam").val(dt[1]);
					jQuery("#id_disc_lama").val(dt[2]);
					var lama      = jQuery("#lama_pinjam").val();
					var subpoin   = jQuery("#subpoin").val();
					jQuery("#subtotal_poin").val(parseInt(lama) * parseInt(subpoin));
					var disc_lama = jQuery("#disc_lama_pinjam").val();
	                if(lama=='NotOk'){
						jQuery("#disc_lama_pinjam").val('');
	                    document.getElementById("ket_diskon_lama").innerHTML = "<b>Tidak Ada Diskon</b>";
	                }else{
	                    document.getElementById("ket_diskon_lama").innerHTML = "<b> Diskon Dengan Lama Pinjam " + lama + " Hari adalah "+ disc_lama +" % </b>";
	                }
			        jQuery("#ket_disc_lama").show('slow');
			        /*Hitung Subtotal*/
					var diskon_momen = jQuery("#disc").val();
					var diskon_lama  = jQuery("#disc_lama_pinjam").val();
					var total        = jQuery("#subtotal").unmask();
					var subtotal     = jQuery("#subtotal").unmask();
					var h_subtotal   = parseInt(subtotal) * parseInt(lama);
					if(diskon_momen!="" && diskon_lama==""){
						var h        = parseInt(h_subtotal) * parseInt(diskon_momen) / 100;
						var subtotal = parseInt(h_subtotal) - parseInt(h);
					}else if(diskon_lama!="" && diskon_momen==""){
						var h        = parseInt(diskon_lama) / 100 * parseInt(h_subtotal);
						var subtotal = parseInt(h_subtotal) - parseInt(h);
					}else if(diskon_lama!="" && diskon_momen!=""){
						var m              = parseInt(h_subtotal) * (parseInt(diskon_momen) / 100);
						var subtotal_momen = parseInt(h_subtotal) - parseInt(m);
						var l              = parseInt(h_subtotal) * (parseInt(diskon_lama) / 100);
						var subtotal_lama  = parseInt(h_subtotal) - parseInt(l);
						var subtotal       = parseInt(h_subtotal) - ((parseInt(subtotal_momen) + parseInt(subtotal_lama)));
					}else{
						var subtotal = parseInt(h_subtotal);
					}
					jQuery("#subtotal_x").val(parseInt(total) * parseInt(lama));
					jQuery("#subtotal_").val(subtotal);
					jQuery('#subtotal_').priceFormat({
				        prefix: '',
				        centsSeparator: ',',
				        thousandsSeparator: '.'
				    });
                    return false;
	            });
			}else{
	            $.gritter.add({title:"Informasi !",text: "Pastikan Tanggal Pinjam dan Tanggal Selesai Pinjam Sudah Terisi"});
			}
	    });
	    jQuery("#qty").change(function(){
			var stok  = jQuery("#stok_barang").val();
			var qty   = jQuery("#qty").val();
			var warna = jQuery("#warna_barang").val();
			if(warna!=""){
				if(qty!="" || parseInt(qty)  > 0){
					if(parseInt(qty)  <= parseInt(stok)){
						$.gritter.add({title:"Informasi Barang !",text: "Silahkan Klik Tombol Tambah untuk menambah Barang."});
			            return false;
					}else{
						$.gritter.add({title:"Informasi Barang !",text: "Jumlah Barang Melebihi Stok Barang !"});
						jQuery("#qty").val('0');
		                document.getElementById('qty').focus();
			            return false;
					}
				}else{
		            $.gritter.add({title:"Informasi Barang !",text: "Masukan Jumlah Barang yang akan di booking !"});
	                document.getElementById('qty').focus();
		            return false;
				}
			}else{
				$.gritter.add({title:"Informasi Barang !",text: "Masukan Jumlah Barang yang akan di booking !"});
                document.getElementById('warna').focus();
	            return false;
			}
	    });
    });
</script>
<div class="row">
    <div class="col-md-12">
		<div class="panel panel-inverse" data-sortable-id="form-validation-2">
		    <div class="panel-heading">
		        <h4 class="panel-title"><?php echo $halaman;?></h4>
		    </div>
		    <div class="panel-body panel-form">
				<div id="status">
				</div>
		        <form class="form-horizontal form-bordered" action="<?php echo $action;?>" method="post" enctype="multipart/form-data" data-parsley-validate="true">
					<?php
					if($cek=='edit'){
						?>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Foto Barang :</label>
							<div class="col-md-2 col-sm-2">
							<?php
								if($foto==""){
									$fotox = "no.jpg";
								}else{
									$fotox = $foto;
								}
							?>
								<img src="<?php echo base_url();?>assets/foto/barang/<?php echo $fotox;?>" style="width:150px;text-align:center;height:180px;">
							</div>
						</div>
						<?php
					}
					?>
					<div class="form-group">
	                    <input class="form-control" type="hidden" id="status_warna" name="status_warna" />
	                    <input class="form-control" type="hidden" id="subtotal_x" name="subtotal_x" />
	                    <input class="form-control" type="hidden" id="min_bayar" name="min_bayar" />
	                    <input class="form-control" type="hidden" id="tot_poin" name="tot_poin" />
	                    <input class="form-control" type="hidden" id="id_disc_lama" name="id_disc_lama" />
	                    <input class="form-control" type="hidden" id="id_disc_momen" name="id_disc_momen" />
	                    <input class="form-control" type="hidden" id="tot_poin_b" name="tot_poin_b" />
	                    <input class="form-control" type="hidden" id="nama_diskon" name="nama_diskon" />
	                    <input class="form-control" type="hidden" id="tot_diskon" name="tot_diskon" />
	                    <input class="form-control" type="hidden" id="foto" name="foto" />
	                    <input class="form-control" type="hidden" id="stok_barang" name="stok_barang" />
	                    <input class="form-control" type="hidden" id="foto_barang" name="foto_barang" />
	                    <input class="form-control" type="hidden" id="warna_barang" name="warna_barang" />
						<label class="control-label col-md-3 col-sm-3">Kode Booking</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" type="text" readonly="readonly" id="kode" minlength="1" maxlength='20' name="kode" value="<?php echo set_value('kode',isset($default['kode']) ? $default['kode'] : ''); ?>"  data-type="kode" data-parsley-required="true" data-parsley-minlength="1" data-parsley-maxlength="20"/>
                            <span style="color:red;"><?php echo form_error('kode');?></span>
						</div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Informasi Member</label>
                        <div class="col-md-8">
                            <input name="nama" id="nama" maxlength="50" placeholder="Masukan Kriteria Pencarian (Kode Member,Nama Member,No Identitas,No Hanphone)" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div id="ket_ultah">
						<div class="form-group">
							<div class="col-md-8 col-sm-8">
                        		<span style="color:red;" id="ket_ulangtahun"></span>
							</div>
						</div>
					</div>
                    <div id="informasi">
                    	<div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3">No Handphone</label>
	                        <div class="col-md-2">
	                            <input name="no_handphone" id="no_handphone" style="text-align: right;" readonly="readonly" maxlength="50" class="form-control" type="text">
	                            <span class="help-block"></span>
	                        </div>
	                    </div>
                    	<div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3">No Identitas</label>
	                        <div class="col-md-2">
	                            <input name="no_identitas" id="no_identitas" style="text-align: right;" readonly="readonly" maxlength="50" class="form-control" type="text">
	                            <span class="help-block"></span>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label col-md-3 col-sm-3">Alamat</label>
	                        <div class="col-md-6">
	                            <input name="alamat" id="alamat" readonly="readonly" maxlength="50" class="form-control" type="text">
	                            <span class="help-block"></span>
	                        </div>
	                    </div>
                    </div>
                    <div id="informasi_barang">
                    	<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Informasi Barang</label>
							<div class="col-md-8">
								<input class="form-control" type="text" id="kode_barang" minlength="1" placeholder="Masukan Informasi Barang (Kode Barang,Nama Barang)" maxlength='20' name="kode_barang" data-parsley-minlength="1" data-parsley-maxlength="50"/>
							</div>
						</div>
                    	<div id="informasi_barang_detil">
                    		<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Nama Barang</label>
								<div class="col-md-4 col-sm-4">
									<input class="form-control" type="text" id="nama_barang" minlength="1" readonly="readonly" maxlength='20' name="nama_barang" data-parsley-minlength="1" data-parsley-maxlength="20"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Harga Sewa<br/>
								<small><font color="red">* permalam</font></small></label>
								<div class="col-md-2 col-sm-2">
									<div class="input-group">
		                                <span class="input-group-addon">Rp.</span>
										<input class="form-control" type="text" style="text-align: right;" id="hrg_sewa" minlength="1" readonly="readonly" maxlength='20' name="hrg_sewa" data-type="text"/>
		                            </div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Harga Poin<br/>
								<small><font color="red">* permalam</font></small></label>
								<div class="col-md-1 col-sm-1">
									<div class="input-group">
										<input class="form-control" type="text" id="hrg_poin" style="text-align: right;" id="hrg_poin" minlength="1" readonly="readonly" maxlength='20' name="hrg_poin" data-type="text"/>
		                            </div>
								</div>
							</div>
                    		<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Warna Barang</label>
								<div class="col-md-15 col-sm-3">
									<?php echo form_dropdown('warna',$option_warna,isset($default['warna']) ? $default['warna'] : '','class="default-select2 form-control" id="warna" data-size="10" data-live-search="true" data-style="btn-white"');?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Jumlah Barang</label>
								<div class="col-md-2 col-sm-2">
									<input class="form-control" type="number" id="qty" minlength="1" maxlength='20' name="qty" data-type="number"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3"></label>
								<div class="col-md-4 col-sm-4">
									<button type="button" id="tambahbooking" class="btn btn-primary btn-xs m-r-5" title="Tambah Booking Barang"><i class="fa fa-plus"></i></button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-20 col-sm-20">
									<h4 class="widgettitle nomargin shadowed"><b>Detil Informasi Booking Barang</b></h4>
									<div class="widgetcontent bordered shadowed nomargin">
										<div class ="table-responsive" style="text-align: center;" >
											<?php 
											echo "<table width=\"80%\" text-align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id='tbladdbarang'>\n"; 
											echo "  <tr>\n"; 
											echo "    <th>Nama Barang</th>\n"; 
											echo "    <th>Warna</th>\n";
											echo "    <th>Harga Sewa</th>\n";
											echo "    <th>Harga Poin</th>\n";
											echo "    <th>QTY</th>\n";
											echo "    <th>Total</th>\n";
											echo "    <th>Action</th>\n";
											echo "  </tr>\n"; 
											echo "</table>";
											?>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Total</label>
								<div class="col-md-3 col-sm-3">
									<div class="input-group">
		                                <span class="input-group-addon">Rp.</span> -->
										<input class="form-control" type="hidden" style="text-align: right;" id="subtotal" minlength="1" readonly="readonly" maxlength='20' name="subtotal" data-parsley-minlength="1" data-parsley-maxlength="20"/>
										<input class="form-control" type="hidden" style="text-align: right;" id="subpoin" minlength="1" readonly="readonly" maxlength='20' name="subtotal" data-parsley-minlength="1" data-parsley-maxlength="20"/>
		                            <!-- </div>
								</div>
							</div> -->
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Tanggal Sewa</label>
								<div class="col-md-2 col-sm-2">
									<div class="input-group date" id="tglmulai" data-date-format="dd-mm-yyyy">
			                            <input type="text" class="form-control" name="tglsewa" id="tglsewa" data-parsley-minlength="10" data-parsley-maxlength="10" minlength="10" maxlength="10" data-parsley-required="true"/>
			                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                        </div>
			                    </div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Tanggal Selesai</label>
								<div class="col-md-2 col-sm-2">
									<div class="input-group date" id="tglselesai" data-date-format="dd-mm-yyyy">
			                            <input type="text" class="form-control" id="tglselesaisewa" name="tglselesai" data-parsley-minlength="10" data-parsley-maxlength="10" minlength="10" maxlength="10" data-parsley-required="true"/>
			                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			                        </div>
			                    </div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Lama Pinjam</label>
								<div class="col-md-2 col-sm-2">
									<div class="input-group">
		                                <input class="form-control" type="text" style="text-align: right;" id="lama_pinjam" minlength="1" readonly="readonly" maxlength='20' name="lama_pinjam" data-parsley-minlength="1" data-parsley-maxlength="20"/>
		                                <span class="input-group-addon">Hari</span>
		                            </div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Diskon Tetap</label>
								<div class="col-md-2 col-sm-2">
									<div class="input-group">
		                                <input class="form-control" type="text" style="text-align: right;" id="disc_lama_pinjam" minlength="1" readonly="readonly" maxlength='20' name="disc_lama_pinjam" data-parsley-minlength="1" data-parsley-maxlength="20"/>
		                                <span class="input-group-addon">%</span>
		                            </div>
								</div>
							</div>
							<div id="ket_disc_lama">
								<div class="form-group">
									<div class="col-md-8 col-sm-8">
	                            		<span style="color:red;" id="ket_diskon_lama"></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Diskon Khusus</label>
								<div class="col-md-2 col-sm-2">
									<div class="input-group">
		                                <input class="form-control" type="text" style="text-align: right;" id="disc" minlength="1" readonly="readonly" maxlength='20' name="disc" data-parsley-minlength="1" data-parsley-maxlength="20"/>
		                                <span class="input-group-addon">%</span>
		                            </div>
								</div>
							</div>
							<div id="ket_disc">
								<div class="form-group">
									<div class="col-md-8 col-sm-8">
	                            		<span style="color:red;" id="ket_diskon"></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Subtotal</label>
								<div class="col-md-3 col-sm-3"> 
									<div class="input-group">
		                                <span class="input-group-addon">Rp.</span>
										<input class="form-control" type="text" style="text-align: right;" id="subtotal_" minlength="1" readonly="readonly" maxlength='20' name="subtotal_" data-parsley-minlength="1" data-parsley-maxlength="20"/>
		                            </div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Subtotal Poin</label>
								<div class="col-md-1 col-sm-1"> 
									<div class="input-group">
										<input class="form-control" type="text" style="text-align: right;" id="subtotal_poin" minlength="1" readonly="readonly" maxlength='20' name="subtotal_poin" data-parsley-minlength="1" data-parsley-maxlength="20"/>
		                            </div>
								</div>
							</div>
							<?php
							if($this->session->userdata('sett_')=='1'){
								?>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3">Potongan Lainnnya</label>
									<div class="col-md-3 col-sm-3">
										<div class="input-group">
			                                <span class="input-group-addon">Rp.</span>
											<input class="form-control" type="text" style="text-align: right;" id="potongan" name="potongan"/>
			                            </div>
									</div>
								</div>
								<?php
							}
							?>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Biaya Lainnnya</label>
								<div class="col-md-3 col-sm-3">
									<div class="input-group">
		                                <span class="input-group-addon">Rp.</span>
										<input class="form-control" type="text" style="text-align: right;" id="blain" name="blain"/>
		                            </div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Keterangan Biaya Lainnya</label>
								<div class="col-md-8">
									<input class="form-control" type="text" id="kode_barang" minlength="1" name="blain_detil"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3">Jenis Bayar</label>
								<div class="col-md-15 col-sm-3">
									<select name="jns_bayar" class="default-select2 form-control" id="jns_bayar" data-size="10" data-live-search="true" data-style="btn-white">
									<option value="" selected="selected">Pilih Jenis Bayar</option>
									<option value="1">Cash</option>
									<option value="2">Poin</option>
									</select>
								</div>
							</div>
							<div id="bayar_cash">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3">Bayar Cash</label>
									<div class="col-md-3 col-sm-3">
										<div class="input-group">
			                                <span class="input-group-addon">Rp.</span>
											<input class="form-control" type="text" style="text-align: right;" id="b_cash" name="b_cash"/>
			                            </div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3">Sisa Pembayaran / Kembalian</label>
									<div class="col-md-3 col-sm-3">
										<div class="input-group">
			                                <span class="input-group-addon">Rp.</span>
											<input class="form-control" readonly="readonly" type="text" style="text-align: right;" id="sisa_bayar" name="sisa_bayar"/>
			                            </div>
									</div>
								</div>
							</div>
							<div id="bayar_poin">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3">Bayar Poin</label>
									<div class="col-md-2 col-sm-2">
										<div class="input-group">
											<input class="form-control" type="number" id="b_point" minlength="1" maxlength='20' name="b_point" data-type="number"/>
			                            </div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3">Sisa Pembayaran / Kembalian</label>
									<div class="col-md-3 col-sm-3">
										<div class="input-group">
			                                <span class="input-group-addon">Rp.</span>
											<input class="form-control" readonly="readonly" type="text" style="text-align: right;" id="sisa_bayar_p" name="sisa_bayar_p"/>
			                            </div>
									</div>
								</div>
							</div>
							<div id="pelunasan">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3">Bayar Sisa</label>
									<div class="col-md-3 col-sm-3">
										<div class="input-group">
			                                <span class="input-group-addon">Rp.</span>
											<input class="form-control" type="text" style="text-align: right;" id="b_sisa" name="b_sisa"/>
			                            </div>
									</div>
								</div>
							</div>
							<div id="ket_poin">
								<div class="form-group">
									<div class="col-md-8 col-sm-8">
	                            		<span style="color:red;" id="ket_point"></span>
									</div>
								</div>
							</div>
                    	</div>
                    </div>
                    <div id="tombol">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3"></label>
							<div class="col-md-3 col-sm-3">
								<button type="submit" class="btn btn-success btn-sm"><?php echo $tombolsimpan;?></button>
	                      		<button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm"><?php echo $tombolbatal ; ?></button>
							</div>
						</div>
                    </div>
		        </form>
		    </div>
		</div>
	</div>
</div>
