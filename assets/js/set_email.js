var save_method;
var table;
$(function() {
    TableManageResponsive.init();
    table = $('#data-email').DataTable({ 
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
            orderable: false, 
            className: "text-center"
        } ,{
            width: '5%',
            targets: 3,
            orderable: false, 
            className: "text-center"
        }    
        ],
        "processing": true,
        "serverSide": true,
        "responsive": true, 
        "pageLength": 10,
        "ajax": {
            "url": $BASE_URL+ "set_email/getData",
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
            $('[name="nama"]').val(data.email);
            $('[name="id"]').val(data.id);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Email');
            $('[name="kode"]').attr('disabled',false);
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}