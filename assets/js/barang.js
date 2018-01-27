var save_method;
var table;
$(function() {
    jQuery("#filter_pencarian").hide();
    table = $('#data-barang').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "barang/getData",
            "type": "POST",
            "data": function ( data ) {
                data.tipe  = $('#tipe').val();
                data.merk  = $('#merk').val();
            }
        },
        "columnDefs": [{ 
            "targets": [ 6,0 ],
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
    jQuery("#tipe").change(function(){
        table.ajax.reload(null,false); 
    });
    jQuery("#merk").change(function(){
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
function filter(){
    jQuery("#filter_pencarian").show("slow");
}
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
        jQuery('[name ="tipe"]').select2("val", "");
        jQuery('[name ="merk"]').select2("val", "");
        jQuery("#filter_pencarian").hide("slow");
        table.ajax.reload(null,false);
        jQuery.unblockUI();
    }, 100);
}
function edit_barang(page,link,action,id){ 
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
            $('[name="hrgpoin"]').val(data.poin);
            $('[name="hrgbeli"]').val(data.hrg_beli);
            $('[name="hrgsusut"]').val(data.biaya_penyusutan);
            $('[name="hrgsewa"]').val(data.hrg_sewa);
            var tgl_beli = new Date(data.tgl_beli); 
            $("#tgl_beli").datepicker({
                dateFormat: 'dd-mm-yy'
            }).datepicker('setDate', tgl_beli)
            jQuery('[name="tipeX"]').select2("val", data.id_tipe);
            jQuery('[name="merkX"]').select2("val", data.id_merk);
            $('[name="id"]').val(data.kode);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Barang');
            $('[name="kode"]').attr('disabled',false);
            jQuery('#hrgbeli').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            jQuery('#hrgsusut').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            jQuery('#hrgsewa').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });   
            jQuery('#hrgpoin').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });   
            jQuery('#stok').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });               
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function detil_barang(id,page,link){ 
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
                        window.location.href = $BASE_URL+link+'/detil_barang/'+id; 
                    }else{ 
                        $.gritter.add({title:"Informasi Data barang !",text: page+ " ini tidak ditemukan di database !"});
                        return false; 
                    } 
                } 
            }); 
        } 
    });
}