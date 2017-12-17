var save_method;
var table;
$(function() {
    jQuery("#data-guru").hide();
    jQuery("#data-siswa").hide();
    $('select[name="list_data[]"]').DualListBox();
    $('.select').select2({
        minimumResultsForSearch: Infinity,
        width: '350px'
    });
    jQuery("#jrs_tujuan").change(function(){
        var jrs_tujuan = jQuery("#jrs_tujuan").val();
        if(jrs_tujuan!=""){
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
            setTimeout(function() {
                jQuery("#kls_tujuan").load ($BASE_URL+'siswa/get_kelas/'+jrs_tujuan);
                jQuery('[name ="kls_tujuan"]').select2("val","");
                jQuery.unblockUI();
            }, 500);
        }else{
            $.gritter.add({title:"Informasi !",text: " Data Jurusan Asal Tidak Boleh Kosong !"});return false;
        }
    });
    var id = jQuery("#id_mesin").val();
    setTimeout(function() {
        $.ajax({ 
            url : $BASE_URL+'sync/cekUser/'+id,
            dataType : 'json', 
            type : 'post', 
            success : function(json) { 
                if (json.say == "NotOk") { 
                    jQuery.unblockUI();
                    jQuery("#data_user").hide("slow");
                    jQuery("#jenis").hide("slow");
                    jQuery("#data-siswa").hide("slow");
                    jQuery("#kelulusan").hide("slow");
                    $.gritter.add({
                        title: "Informasi !",
                        text: " Maaf data user pada mesin tersebut tidak ditemukan."
                    });
                }else{ 
                    jQuery('[name="list_data[]"]').load ($BASE_URL+'sync/get_user/'+id);
                    jQuery("#data_user").show("slow");
                    jQuery("#jenis").show("slow");
                    $.gritter.add({
                        title: "Informasi !",
                        text: " Silahkan lakukan pengelompokan user."
                    });
                    jQuery.unblockUI();
                } 
            } 
        }); 
    }, 10);
    jQuery(".tipe").click(function (){
        var checked_value = jQuery(".tipe:checked").val();
        if(checked_value==0){
            jQuery("#data-siswa").show("slow");
            jQuery("#data-guru").hide("slow");
        }else{
            jQuery("#data-siswa").hide("slow");
            jQuery("#data-guru").show("slow");
        }
    });
    jQuery("#form").submit(function() {
        setTimeout(function() {
            var list_data = $('[name="list_data[]"]').val();
            if(list_data!=""){
                var checked_value = jQuery(".tipe:checked").val();
                if(checked_value==0){
                    var kls_tujuan = jQuery("#kls_tujuan").val();
                    jQuery.ajax({
                        url : $BASE_URL+'sync/simpan_usersiswa',
                        data : {list_data:list_data,kls_tujuan:kls_tujuan},
                        type : 'POST',
                        dataType: 'json',
                        success:function(data){
                            if(data.response=='true'){
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
                                    message: 'Sedang Melakukan Penyimpanan Data, Mohon menunggu ... '
                                });
                                setTimeout(function(){
                                    jQuery.unblockUI();
                                },1000);
                                setTimeout(function(){
                                    $.gritter.add({
                                        title: "Informasi !",
                                        text: " Penyimpanan Berhasil !"
                                    });
                                    // window.location.reload();
                                },1000);
                            } else {
                                $.gritter.add({
                                    title: "Informasi !",
                                    text: " Penyimpanan Gagal !"
                                });
                            }            
                        }
                    });
                }else if(checked_value==1){
                    jQuery.ajax({
                        url : $BASE_URL+'sync/simpan_userguru',
                        data : {list_data:list_data},
                        type : 'POST',
                        dataType: 'json',
                        success:function(data){
                            if(data.response=='true'){
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
                                    message: 'Sedang Melakukan Penyimpanan Data, Mohon menunggu ... '
                                });
                                setTimeout(function(){
                                    jQuery.unblockUI();
                                },1000);
                                setTimeout(function(){
                                    $.gritter.add({
                                        title: "Informasi !",
                                        text: " Penyimpanan Berhasil !"
                                    });
                                },1000);
                            } else {
                                $.gritter.add({
                                    title: "Informasi !",
                                    text: " Penyimpanan Gagal !"
                                });
                            }            
                        }
                    });
                }else{
                    $.gritter.add({
                        title: "Informasi !",
                        text: " Silahkan pilih data-siswa atau Kelulusan user."
                    });
                }
            }else{
                $.gritter.add({
                    title: "Informasi !",
                    text: " Silahkan pilih user terlebih dahulu."
                });
            }
        }, 5000);
    });
});
function simpan() {
    var list_data = $('[name="list_data[]"]').val();
    if(list_data!=""){
        var checked_value = jQuery(".tipe:checked").val();
        if(checked_value==0){
            var kls_tujuan = jQuery("#kls_tujuan").val();
            setTimeout(function(){
                jQuery.ajax({
                    url : $BASE_URL+'sync/simpan_usersiswa',
                    data : {list_data:list_data,kls_tujuan:kls_tujuan},
                    type : 'POST',
                    dataType: 'json',
                    success:function(data){
                        if(data.response=='true'){
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
                                message: 'Sedang Melakukan Penyimpanan Data, Mohon menunggu ... '
                            });
                            setTimeout(function(){
                                jQuery.unblockUI();
                            },1000);
                            setTimeout(function(){
                                $.gritter.add({
                                    title: "Informasi !",
                                    text: " Penyimpanan Berhasil !"
                                });
                            },1000);
                        } else {
                            $.gritter.add({
                                title: "Informasi !",
                                text: " Penyimpanan Gagal !"
                            });
                        }            
                    }
                });
            },500);
        }else if(checked_value==1){
            setTimeout(function(){
                jQuery.ajax({
                    url : $BASE_URL+'sync/simpan_userguru',
                    data : {list_data:list_data},
                    type : 'POST',
                    dataType: 'json',
                    success:function(data){
                        if(data.response=='true'){
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
                                message: 'Sedang Melakukan Penyimpanan Data, Mohon menunggu ... '
                            });
                            setTimeout(function(){
                                jQuery.unblockUI();
                            },1000);
                            setTimeout(function(){
                                $.gritter.add({
                                    title: "Informasi !",
                                    text: " Penyimpanan Berhasil !"
                                });
                            },1000);
                        } else {
                            $.gritter.add({
                                title: "Informasi !",
                                text: " Penyimpanan Gagal !"
                            });
                        }            
                    }
                });
            },500);
        }else{
            $.gritter.add({
                title: "Informasi !",
                text: " Silahkan pilih data-siswa atau Kelulusan user."
            });
        }
    }else{
        $.gritter.add({
            title: "Informasi !",
            text: " Silahkan pilih user terlebih dahulu."
        });
    }
}
