var save_method;
var table;
$(function() {
    jQuery("#filter_pencarian").hide();
    table = $('#data-sewa-detil').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "sewa/getDataDetil",
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
function edit_booking(page,link,action,id){ 
    save_method = 'update';
    $('#form_edit')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $.ajax({
        url : $BASE_URL+link+"/"+action+"/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
            $('[name="kode_booking"]').val(data.kode_booking);
            $('[name="sisa"]').val(data.sisa_bayar);
            $('[name="jns_bayar"]').val(data.jns_bayar);
            $('[name="dibayar"]').val(data.dibayar);
            $('[name="subtotal_x"]').val(data.subtotal_x);
            $('[name="subtotal"]').val(data.total_bayar);
            $('[name="potongan"]').val(data.potongan);
            $('[name="subpoin"]').val(data.subtotal_poin);
            $('[name="lama"]').val(data.lama);
            var tgl_mulai = new Date(data.tgl_perencanaan_sewa); 
            $("#tgl_mulai").datepicker({
                dateFormat: 'dd-mm-yy'
            }).datepicker('setDate', tgl_mulai)
            var tgl_selesai = new Date(data.tgl_selesai); 
            $("#tgl_selesai").datepicker({
                dateFormat: 'dd-mm-yy'
            }).datepicker('setDate', tgl_selesai)
            $('#modal_form_edit').modal('show');
            $('.modal-title').text('Edit Data Booking');
            $('[name="kode"]').attr('disabled',false);
            $('[name="kode_barang"]').attr('disabled',false);
            jQuery('#subtotal').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            jQuery('#potongan').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            jQuery('#dibayar').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            jQuery('#sisa').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            var jns = data.jns_bayar;
            if(jns=='1'){
                jQuery("#b_poin").hide('');
                jQuery("#b_cash").show('');
            }else{
                jQuery("#b_poin").show('');
                jQuery("#b_cash").hide('');
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function tambah_data(){
    save_method = 'add';
    $('#form_add')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form_add').modal('show');
    $('.modal-title').text('Tambah Booking Barang');
}