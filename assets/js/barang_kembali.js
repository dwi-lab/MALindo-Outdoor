var save_method;
var table;
$(function() {
    jQuery("#filter_pencarian").hide();
    table = $('#data-barangkembali').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "pengembalian/getPengembalianDetil",
            "type": "POST",
            "data": function ( data ) {
            }
        },
        "columnDefs": [{ 
            "targets": [ 0, 7 ],
            "orderable": false, 
            "className": "text-center",
        },{ 
            "targets": [ 4,6,5 ],
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
        table.ajax.reload(null,false);
        jQuery.unblockUI();
    }, 100);
}
function edit_data(page,link,action,id){ 
    save_method = 'update';
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $.ajax({
        url : $BASE_URL+link+"/"+action+"/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            $('[name="nama"]').val(data.nama_barang);
            $('[name="kode_barang"]').val(data.kode_barang);
            jQuery('[name="warna"]').select2("val", data.kode_warna);
            $('[name="qty"]').val(data.qty);
            $('[name="stok_awal"]').val(data.qty);
            $('[name="warna_awal"]').val(data.kode_warna);
            $('[name="id"]').val(data.id);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Booking Barang');
            $('[name="kode"]').attr('disabled',false);
            $('[name="kode_barang"]').attr('disabled',false);
            $('[name="nama"]').attr('disabled',true);        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
