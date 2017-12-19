var save_method;
var table;
$(function() {
    table = $('#data-barang-detil').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "barang/getDataDetil",
            "type": "POST",
            "data": function ( data ) {
                
            }
        },
        "columnDefs": [{ 
            "targets": [ 0,1 ],
            "orderable": false, 
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
function tambah_data(){
    save_method = 'add';
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Data Stok Barang');
}
function edit_barang_detil(page,link,action,id){ 
    save_method = 'update';
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $.ajax({
        url : $BASE_URL+link+"/"+action+"/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            jQuery('[name="warna"]').select2("val", data.id_warna);
            $('[name="stokna"]').val(data.stok);
            $('[name="id"]').val(data.id);
            $('#photo-preview').show();
            if(data.foto){
                $('#label-photo').text('Ganti Photo'); 
                $('#photo-preview div').html('<img src="'+$BASE_URL+'assets/foto/barang/'+data.foto+'" height="30%" width="50%" class="img-responsive">'); 
            }else{
                $('#label-photo').text('Upload Foto'); 
                $('#photo-preview div').text('(No Foto)');
            }
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Stok Barang');
            $('[name="kode"]').attr('disabled',false);
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}