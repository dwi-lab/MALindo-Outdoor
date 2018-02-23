var host = window.location.host;
$BASE_URL = 'http://' + host + '/';
jQuery(document).ready(function() {
    jQuery("#tombollaporan").hide();
    jQuery("#lapperbulan").hide();
    jQuery("#lappertanggal").hide();
    jQuery("#tambahstok").click(function() {
        var no    = jQuery("#tbladdstok tr").length;
        var stok  = jQuery("#stok").val();
        var kode  = jQuery("#kode").val();
        var warna = jQuery("#warna option:selected").text();
        if (warna != "" && stok != "") {
            jQuery('#tbladdstok > tbody:first').append("<tr id ='" + no + "''><td><input style='width:80px' class='form-control' type='text' readonly='readonly' value='" + kode + "' name='kodena[]' /><td><input style='width:180px' class='form-control' type='text' readonly='readonly' value='" + warna + "' name='warnana[]' /></td><td><input style='width:80px' readonly='readonly' class='form-control' type='text' value='" + stok + "' name='stokna[]'  /></td><td><input type='file' name='fotona[]' id='fotona' class='form-control' style='width:100px'/></td><td><button id='delRow' style=\"text-align:center\" class=\"btn btn-primary btn-xs m-r-5\" onclick=\"delrow('" + no + "');return false;\"><i class=\"fa fa-remove\"></i></button></td></tr><br/>");
            jQuery("#tombol").show("slow");
            jQuery("#stok").val('');
            $.gritter.add({title:"Informasi !",text: " Silahkan Tambahkan Foto Barang !<br/> maxsize : 1mb <br/> Type File : jpg"});return false;
        } else {
            $.gritter.add({
                title: "Informasi !",
                text: " Data Tidak Boleh Kosong !"
            });
            return false;
        }
    });
    jQuery(".lap").click(function (){
        var checked_value = jQuery(".lap:checked").val();
        if(checked_value==1){
            jQuery("#tombollaporan").show("slow");
            jQuery("#lapperbulan").show("slow");
            jQuery("#lappertanggal").hide("slow");
        }else{
            jQuery("#tombollaporan").show("slow");
            jQuery("#lapperbulan").hide();
            jQuery("#lappertanggal").show("slow");
        }
    });
    jQuery("#tambahbooking").click(function() {
        var no          = jQuery("#tbladdbarang tr").length;
        var nama_barang = jQuery("#nama_barang").val();
        var qty         = jQuery("#qty").val();
        var harga       = jQuery("#hrg_sewa").val();
        var harga_poin  = jQuery("#hrg_poin").val();
        var harga_mask  = jQuery("#hrg_sewa").unmask();
        var warna       = jQuery("#warna option:selected").text();
        if (warna       != "Pilih Warna Barang" && qty != "") {
            var total    = parseInt(harga_mask) * parseInt(qty);
            var tot_poin = parseInt(harga_poin) * parseInt(qty);
            jQuery('#tbladdbarang > tbody:first').append("<tr id ='" + no + "''><td><input style='width:200px' class='form-control' type='text' readonly='readonly' value='" + nama_barang + "' name='nama_barangna[]' /><td><input style='width:160px' class='form-control' type='text' readonly='readonly' value='" + warna + "' name='warnana[]' /></td><td><input style='width:100px' class='form-control' type='text' readonly='readonly' value='" + harga + "' name='hargana[]' /></td><td><input style='width:50px' class='form-control' type='text' readonly='readonly' value='" + harga_poin + "' name='harga_poina[]' /></td><td><input style='width:80px' readonly='readonly' class='form-control' type='text' value='" + qty + "' name='qtyna[]'  /></td><td><input style='width:80px' class='form-control' type='text' readonly='readonly' id='totalna' value='" + total + "' name='totalna[]' /><td><td><button id='delRowBooking' style=\"text-align:left\" class=\"btn btn-primary btn-xs m-r-5\" onclick=\"delrowb('" + no + "','" + total + "');return false;\"><i class=\"fa fa-remove\"></i></button></td></tr>");
            jQuery("#qty").val('');
            jQuery("#kode_barang").val('');
            jQuery("#nama_barang").val('');
            jQuery("#hrg_sewa").val('');
            jQuery("#warna").select2("val","");
            document.getElementById('kode_barang').focus();
            var jumlah  = 0;
            var jumlahP = 0;
            var sub     = jQuery('#subtotal').unmask();
            var t_poin  = jQuery('#subpoin').unmask();
            for(i=0; i < no; i++){
                jumlah  = parseInt(total);
                jumlahP = parseInt(tot_poin);
            }
            if(sub!=""){
                jQuery('#subtotal').val(parseInt(jumlah)+parseInt(sub));
                jQuery('#subpoin').val(parseInt(jumlahP)+parseInt(t_poin));
            }else{
                jQuery('#subtotal').val(parseInt(jumlah));
                jQuery('#subpoin').val(parseInt(jumlahP));
            }
            jQuery('#subtotal').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            if(subtotal!=""){
                jQuery.post($BASE_URL+"booking/cekDiskon",
                    function(data){
                        var dt = data.split("|");
                        jQuery("#disc").val(dt[0]);
                        jQuery("#nama_diskon").val(dt[1]);
                        jQuery("#id_disc_momen").val(dt[2]);
                        var nama_diskon = jQuery("#nama_diskon").val();
                        var tot_diskon  = jQuery("#disc").val();
                        if(tot_diskon=='NotOk'){
                            jQuery("#disc").val('');
                            document.getElementById("ket_diskon").innerHTML = "<b>Tidak Ada Diskon Khusus</b>";
                        }else{
                            document.getElementById("ket_diskon").innerHTML = "<b>" + nama_diskon + "</b>";
                        }
                        jQuery("#ket_disc").show('slow');
                        return false;
                    });
            }
        } else {
            $.gritter.add({
                title: "Informasi !",
                text: " Data Tidak Boleh Kosong !"
            });
            return false;
        }
    });
})
function delrowx(id) {
    jQuery("#" + id).remove();
}
function tampilkan(link) {
    if(jQuery('#pertgl').is(':checked')) { 
        var tgl_a = jQuery("#mulaip").val();
        var tgl_b = jQuery("#selesaip").val();
        if(tgl_a!='' && tgl_b!=""){
            $.ajax({ 
                url : $BASE_URL+link+'/cekdata/'+tgl_a+'/'+tgl_b, 
                dataType : 'json', 
                type : 'post', 
                success : function(json) { 
                    $.unblockUI(); 
                    if(json.say == "1") { 
                        $.gritter.add({title:"Informasi Laporan!",text: " Tidak Ada Transaksi Penyewaan Pada Tanggal " + tgl});
                        return false; 
                    }else if(json.say=="0"){ 
                        window.location.href = $BASE_URL+link+'/pertanggal/'+tgl_a+'/'+tgl_b
                    }
                } 
            }); 
        }else{
            $.gritter.add({
                title: "Informasi !",
                text: "Tanggal Laporan Tidak Boleh Kosong !"
            });
        }
    }else if (jQuery('#perbulan').is(':checked')) { 
        var bln = jQuery('#lapbln').val();
        var thn = jQuery("#lapthnbln").val();
        if(bln!="" && thn!=""){
            $.ajax({ 
                url : $BASE_URL+link+'/cekdataBln/'+bln+'/'+thn, 
                dataType : 'json', 
                type : 'post', 
                success : function(json) { 
                    $.unblockUI(); 
                    if(json.say == "1") { 
                        $.gritter.add({title:"Informasi Laporan!",text: " Tidak Ada Transaksi Penyewaan Pada Tanggal " + tgl});
                        return false; 
                    }else if(json.say=="0"){ 
                        window.location.href = $BASE_URL+link+'/perbulan/'+bln+'/'+thn
                    }
                } 
            });
        }else{
            $.gritter.add({
                title: "Informasi !",
                text: "Bulan dan Tahun Pada Laporan Tidak Boleh Kosong !"
            });
        }
    }
}
function tampilkan_member(link) {
    var prov      = jQuery("#provinsi").val();
    var kota      = jQuery("#kota").val();
    var kecamatan = jQuery("#kecamatan").val();
    var kelurahan = jQuery("#kelurahan").val();
    if(prov != "" && kota == "" && kecamatan == "" && kelurahan == ""){
        /*provinsi*/
        $.ajax({ 
            url : $BASE_URL+link+'/cekdata', 
            dataType : 'json', 
            type : 'post', 
            success : function(json) { 
                $.unblockUI(); 
                if(json.say == "1") { 
                    $.gritter.add({title:"Informasi Laporan!",text: " Tidak Ada Transaksi Penyewaan Pada Tanggal "});
                    return false; 
                }else if(json.say=="0"){ 
                    window.location.href = $BASE_URL+link+'/perProvinsi/'+prov
                }
            } 
        });
    }else if(prov!="" && kota!="" && kecamatan == "" && kelurahan == ""){
        /*Kota*/
        $.ajax({ 
            url : $BASE_URL+link+'/cekdata', 
            dataType : 'json', 
            type : 'post', 
            success : function(json) { 
                $.unblockUI(); 
                if(json.say == "1") { 
                    $.gritter.add({title:"Informasi Laporan!",text: " Tidak Ada Transaksi Penyewaan Pada Tanggal "});
                    return false; 
                }else if(json.say=="0"){ 
                    window.location.href = $BASE_URL+link+'/perKota/'+prov+'/'+kota
                }
            } 
        });
    }else if(prov!="" && kota!="" && kecamatan != "" && kelurahan == ""){
        /*Kecamatan*/
        $.ajax({ 
            url : $BASE_URL+link+'/cekdata', 
            dataType : 'json', 
            type : 'post', 
            success : function(json) { 
                $.unblockUI(); 
                if(json.say == "1") { 
                    $.gritter.add({title:"Informasi Laporan!",text: " Tidak Ada Transaksi Penyewaan Pada Tanggal "});
                    return false; 
                }else if(json.say=="0"){ 
                    window.location.href = $BASE_URL+link+'/perKecamatan/'+prov+'/'+kota+'/'+kecamatan
                }
            } 
        });
    }else if(prov!="" && kota!="" && kecamatan != "" && kelurahan != ""){
        $.ajax({ 
            url : $BASE_URL+link+'/cekdata', 
            dataType : 'json', 
            type : 'post', 
            success : function(json) { 
                $.unblockUI(); 
                if(json.say == "1") { 
                    $.gritter.add({title:"Informasi Laporan!",text: " Tidak Ada Transaksi Penyewaan Pada Tanggal "});
                    return false; 
                }else if(json.say=="0"){ 
                    window.location.href = $BASE_URL+link+'/perKelurahan/'+prov+'/'+kota+'/'+kecamatan+'/'+kelurahan
                }
            } 
        });
    }else{
        $.gritter.add({
            title: "Informasi !",
            text: "Lokasi Member Tidak Boleh Kosong !"
        });
    }
}
function delrowb(id,total) {
    var sub = jQuery('#subtotal').unmask();
    jQuery('#subtotal').val(parseInt(sub)-parseInt(total));
    jQuery('#subtotal').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    jQuery("#" + id).remove();
}
function save(link) {
    $('#btnSave').text('Proses...');
    $('#btnSave').attr('disabled', true);
    var url;
    if (save_method == 'add') {
        url = $BASE_URL + link + "/proses_add";
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
                reload_table();
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
            $('#btnSave').text('Simpan');
            $('#btnSave').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.gritter.add({
                title: "Informasi !",
                text: "Error adding / update data."
            });
            $('#btnSave').text('Simpan');
            $('#btnSave').attr('disabled', false);
            return false;
        }
    });
}
function save_booking(link) {
    $('#btnSave').text('Proses...');
    $('#btnSave').attr('disabled', true);
    var url;
    if (save_method == 'add') {
        url = $BASE_URL + link + "/proses_add_barang";
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
                window.location.reload();
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
            $('#btnSave').text('Simpan');
            $('#btnSave').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.gritter.add({
                title: "Informasi !",
                text: "Error adding / update data."
            });
            $('#btnSave').text('Simpan');
            $('#btnSave').attr('disabled', false);
            return false;
        }
    });
}
function save_bookingx(link) {
    $('#btnSaveAdd').text('Proses...');
    $('#btnSaveAdd').attr('disabled', true);
    var url;
    if (save_method == 'add') {
        url = $BASE_URL + link + "/proses_add_barang";
    } else {
        url = $BASE_URL + link + "/proses_edit_booking";
    }
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form_add').serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                window.location.reload();
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
            $('#btnSaveAdd').text('Simpan');
            $('#btnSaveAdd').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.gritter.add({
                title: "Informasi !",
                text: "Error adding / update data."
            });
            $('#btnSaveAdd').text('Simpan');
            $('#btnSaveAdd').attr('disabled', false);
            return false;
        }
    });
}
function save_bookingxx(link) {
    $('#btnSaveAdd').text('Proses...');
    $('#btnSaveAdd').attr('disabled', true);
    var url;
    if (save_method == 'add') {
        url = $BASE_URL + link + "/proses_add_barang";
    } else {
        url = $BASE_URL + link + "/proses_edit_booking";
    }
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form_edit').serialize(),
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                window.location.reload();
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
            $('#btnSaveAdd').text('Simpan');
            $('#btnSaveAdd').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.gritter.add({
                title: "Informasi !",
                text: "Error adding / update data."
            });
            $('#btnSaveAdd').text('Simpan');
            $('#btnSaveAdd').attr('disabled', false);
            return false;
        }
    });
}
function save_detil(page,link,formid){
    $('#btnSave').text('proses menyimpan data...'); 
    $('#btnSave').attr('disabled',true);
    var url;
    if(save_method == 'add') {
        url = $BASE_URL+ page+"/proses_add_stok"; 
    } else {
        url = $BASE_URL+ page+"/proses_edit_stok"; 
    }
    var formData = new FormData($(formid)[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data){
            if(data.status ==  true ) {
                $('#modal_form').modal('hide');
                reload_table();
            }else if(data.status == false ){
                for (var i = 0; i < data.inputerror.length; i++){
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                }
            }else if(data.status == 'NoAktived'){
                $.gritter.add({title:"Informasi !",text: " Data Tidak Boleh Kosong !"});return false;
            }else{
                alert('tidak bisa di update data sudah tersedia');              
            }
            $('#btnSave').text('Simpan'); 
            $('#btnSave').attr('disabled',false); 
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error adding / update data');
            $('#btnSave').text('Simpan'); 
            $('#btnSave').attr('disabled',false); 
        }
    });
}
function validAngka(a) {
    if (!/^[0-9.]+$/.test(a.value)) {
        a.value = a.value.substring(0, a.value.length - 1000);
    }
}
function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function hapus_data(page, link, action, id) {
    bootbox.confirm("Yakin Akan Menghapus " + page + " Berikut ?", function(result) {
        if (result) {
            setTimeout(function() {
                jQuery.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: 2,
                        color: '#fff'
                    },
                    message: 'Mohon menunggu ... '
                });
                $.ajax({
                    url: $BASE_URL + link + "/" + action + "/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        $('#modal_form').modal('hide');
                        reload_table();
                        jQuery.unblockUI();
                        $.gritter.add({
                            title: "Informasi !",
                            text: " Data berhasil di hapus."
                        });
                        return false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $.gritter.add({
                            title: "Informasi !",
                            text: " Error deleting data."
                        });
                        jQuery.unblockUI();
                        return false;
                    }
                });
            }, 100);
        }
    });
}
function hapus_data_barang(page, link, action, id) {
    bootbox.confirm("Yakin Akan Menghapus " + page + " Berikut ?", function(result) {
        if (result) {
            setTimeout(function() {
                jQuery.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: 2,
                        color: '#fff'
                    },
                    message: 'Mohon menunggu ... '
                });
                $.ajax({
                    url: $BASE_URL + link + "/" + action + "/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        $('#modal_form').modal('hide');
                        jQuery.unblockUI();
                        $.gritter.add({
                            title: "Informasi !",
                            text: " Data berhasil di hapus."
                        });
                        window.location.reload();
                        return false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $.gritter.add({
                            title: "Informasi !",
                            text: " Error deleting data."
                        });
                        jQuery.unblockUI();
                        return false;
                    }
                });
            }, 100);
        }
    });
}
function rbstatus(jns, page, link, id) {
    if (jns == "aktif") {
        bootbox.confirm("Non Aktifkan " + page + " Berikut ?", function(result) {
            if (result) {
                setTimeout(function() {
                    jQuery.blockUI({
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: 2,
                            color: '#fff'
                        },
                        message: 'Mohon menunggu ... '
                    });
                    jQuery.post($BASE_URL + link + "/ubah_status/" + jns + "/" + id, jQuery("#form1").serialize(), function(data) {
                        $.unblockUI();
                        reload_table();
                    });
                }, 500);
            }
        });
    } else {
        bootbox.confirm("Aktifkan " + page + " Berikut ?", function(result) {
            if (result) {
                setTimeout(function() {
                    jQuery.blockUI({
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: 2,
                            color: '#fff'
                        },
                        message: 'Mohon menunggu ... '
                    });
                    jQuery.post($BASE_URL + link + "/ubah_status/" + jns + "/" + id, jQuery("#form1").serialize(), function(data) {
                        $.unblockUI();
                        reload_table();
                    });
                }, 500);
            }
        });
    }
}
function logout(nama) {
    bootbox.confirm(nama + " apakah yakin akan keluar ?", function(result) {
        if (result) {
            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: 2,
                    color: '#fff'
                },
                message: 'Sedang Melakukan Proses Log Out, Mohon menunggu ... '
            });
            setTimeout(function() {
                $.unblockUI();
            }, 1000);
            $.ajax({
                url: $BASE_URL + 'dashboard/log_out',
                complete: function(response) {
                    $.unblockUI();
                    window.location.href = $BASE_URL;
                }
            });
        }
    });
}
function date_time(id) {
    date   = new Date;
    year   = date.getFullYear();
    month  = date.getMonth();
    months = new Array('Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    d      = date.getDate();
    day    = date.getDay();
    days   = new Array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
    h      = date.getHours();
    if (h < 10) {
        h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10) {
        m = "0" + m;
    }
    s = date.getSeconds();
    if (s < 10) {
        s = "0" + s;
    }
    result = '' + days[day] + ', ' + d + '-' + months[month] + '-' + year + ' ' + h + ':' + m + ':' + s;
    document.getElementById(id).innerHTML = result;
    setTimeout('date_time("' + id + '");', '1000');
    return true;
}
function waktos(id) {
    date   = new Date;
    year   = date.getFullYear();
    month  = date.getMonth();
    months = new Array('Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    d      = date.getDate();
    day    = date.getDay();
    days   = new Array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
    h      = date.getHours();
    if (h < 10) {
        h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10) {
        m = "0" + m;
    }
    s = date.getSeconds();
    if (s < 10) {
        s = "0" + s;
    }
    result = ' ' + h + ':' + m + ':' + s;
    document.getElementById(id).innerHTML = result;
    setTimeout('waktos("' + id + '");', '1000');
    return true;
}
function kaping(id) {
    date   = new Date;
    year   = date.getFullYear();
    month  = date.getMonth();
    months = new Array('Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    d      = date.getDate();
    day    = date.getDay();
    days   = new Array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
    h      = date.getHours();
    if (h < 10) {
        h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10) {
        m = "0" + m;
    }
    s = date.getSeconds();
    if (s < 10) {
        s = "0" + s;
    }
    result = '' + days[day] + ', ' + d + '-' + months[month] + '-' + year + '';
    document.getElementById(id).innerHTML = result;
    setTimeout('kaping("' + id + '");', '1000');
    return true;
}
