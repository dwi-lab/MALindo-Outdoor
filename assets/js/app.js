var host = window.location.host;
$BASE_URL = 'http://' + host + '/';
jQuery(document).ready(function() {
    jQuery("#tambahstok").click(function() {
        var no    = jQuery("#tbladdstok tr").length;
        var stok  = jQuery("#stok").val();
        var kode  = jQuery("#kode").val();
        var warna = jQuery("#warna option:selected").text();
        if (warna != "" && stok != "") {
            jQuery('#tbladdstok > tbody:first').append("<tr id ='" + no + "''><td><input style='width:80px' class='form-control' type='text' readonly='readonly' value='" + kode + "' name='kodena[]' /><td><input style='width:180px' class='form-control' type='text' readonly='readonly' value='" + warna + "' name='warnana[]' /></td><td><input style='width:80px' readonly='readonly' class='form-control' type='text' value='" + stok + "' name='stokna[]'  /></td><td><input type='file' name='fotona[]' id='fotona' class='form-control' style='width:100px'/></td><td><button id='delRow' style=\"text-align:center\" class=\"btn btn-primary btn-xs m-r-5\" onclick=\"delrow('" + no + "');return false;\"><i class=\"fa fa-remove\"></i></button></td></tr>");
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
})
function delrow(id) {
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
