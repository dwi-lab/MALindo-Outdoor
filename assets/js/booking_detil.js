var save_method;
var table;
$(function() {
    jQuery("#filter_pencarian").hide();
    table = $('#data-booking-detil').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "booking/getDataDetil",
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
            $('[name="nama"]').val(data.merk);
            $('[name="id"]').val(data.id);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Booking Barang');
            $('[name="kode"]').attr('disabled',false);
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function tambah_data(){
    save_method = 'add';
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Booking Barang');
}