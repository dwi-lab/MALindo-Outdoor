var save_method;
var table;
$(function() {
    jQuery("#filter_pencarian").hide();
    table = $('#data-kembali').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "pengembalian/getDataPengembalian",
            "type": "POST",
            "data": function ( data ) {
            }
        },
        "columnDefs": [{ 
            "targets": [ 0,1,9 ],
            "orderable": false, 
            "className": "text-center",
        },{ 
            "targets": [ 7 ],
            "orderable": true, 
            "className": "text-right",
        },{ 
            "targets": [ 4,4,6,7,8 ],
            "orderable": true, 
            "className": "text-center",
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
        jQuery("#filter_pencarian").hide("slow");
        table.ajax.reload(null,false);
        jQuery.unblockUI();
    }, 100);
}
function detil_kembali(id,page,link){ 
    bootbox.confirm("Yakin Akan Melihat Detil " +page+ " Berikut ?", 
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
                        window.location.href = $BASE_URL+link+'/detil_pengembalian/'+id; 
                    }else{ 
                        $.gritter.add({title:"Informasi Data booking !",text: page+ " ini tidak ditemukan di database !"});
                        return false; 
                    } 
                } 
            }); 
        } 
    });
}