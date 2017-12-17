var save_method;
var table;
$(function() {
    table = $('#data-pegawai').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "pegawai/getData",
            "type": "POST",
            "data": function ( data ) {
                
            }
        },
        "columnDefs": [{ 
            "targets": [ 1,6 ],
            "orderable": false, 
            "className": "text-center",
        },{ 
            "targets": [ 5 ],
            "orderable": true, 
            "className": "text-right",
        },
        ],
    });
    $('.dataTables_filter input[type=search]').attr('placeholder','Filter Pencarian');
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: '60px'
    });
    $('#btn-filter').click(function(){ 
        table.ajax.reload(null,false); 
    });
    $('.select').select2({
        minimumResultsForSearch: Infinity,
        width: '350px'
    });
    $('#btn-reset').click(function(){
        $('#form-filter')[0].reset();
        table.ajax.reload(null,false); 
    });
});
function reload_table(){
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
        message : 'Mohon menunggu ... '
    });
    setTimeout(function () {
        table.ajax.reload(null,false);
        jQuery.unblockUI();
    }, 100);
}
function edit_pegawai(id,page,link){ 
    bootbox.confirm("Yakin Akan Mengedit " +page+ " Berikut ?", 
    function(result) { 
        if (result) { 
            $.blockUI({ 
                css: { 
                    border: 'none', 
                    padding: '15px', 
                    backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', 
                    opacity: 2, 
                    color: '#fff' 
                }, 
                message : 'Sedang Melakukan Pengecekan Data <br/> Mohon menunggu ... ' 
            }); 
            setTimeout(function(){ 
                $.unblockUI(); 
            },1000); 
            $.ajax({ 
                url : $BASE_URL+link+'/cekdata/'+id, 
                dataType : 'json', 
                type : 'post', 
                success : function(json) { 
                    $.unblockUI(); 
                    if (json.say == "ok") { 
                        window.location.href = $BASE_URL+link+'/edit/'+id; 
                    }else{ 
                        $.gritter.add({title:"Informasi Pengeditan !",text: page+ " ini tidak ditemukan di database !"});
                        return false; 
                    } 
                } 
            }); 
        } 
    });
}
