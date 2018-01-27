var save_method;
var table;
$(function() {
    TableManageResponsive.init();
    table = $('#data-poin').DataTable({ 
        autoWidth: false,
        columnDefs: [{
            width: '5',
            targets: 0,
            className: "text-center",
        },{            
            width: '75%',           
            targets: 1
        },{
            width: '15%',
            targets: 2,
            orderable: true, 
            className: "text-center"
        } ,{
            width: '5%',
            targets: 3,
            orderable: false, 
            className: "text-center"
        }   ,{
            width: '5%',
            targets: 4,
            orderable: false, 
            className: "text-center"
        }    
        ],
        "processing": true,
        "serverSide": true,
        "responsive": true, 
        "pageLength": 10,
        "ajax": {
            "url": $BASE_URL+ "poin/getData",
            "type": "POST"
        },
        
        dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
        displayLength: 4,               
    });
    $('.dataTables_filter input[type=search]').attr('placeholder','Filter Pencarian');
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: '60px'
    });
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
});
function tambah_data(){
    save_method = 'add';
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Data Poin');
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
            $('[name="nominal_a"]').val(data.nominal_a);
            $('[name="nominal_b"]').val(data.nominal_b);
            $('[name="poin"]').val(data.jml_poin);
            $('[name="id"]').val(data.id);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Poin');
            $('[name="kode"]').attr('disabled',false);
            jQuery('#nominal_a').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            jQuery('#nominal_b').priceFormat({
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