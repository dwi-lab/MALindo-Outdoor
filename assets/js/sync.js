var save_method;
var table;
$(function() {
    TableManageResponsive.init();
    table = $('#data-sync').DataTable({ 
        autoWidth: false,
        columnDefs: [{
            width: '5',
            targets: 0,
            className: "text-center",
        },{            
            width: '65%',           
            targets: 1
        },{
            width: '20%',
            targets: 2,
            className: "text-center"
        },{
            width: '10%',
            targets: 3,
            className: "text-center"
        },{
            width: '5%',
            targets: 4,
            orderable: false, 
            className: "text-center"
        },{
            width: '5%',
            targets: 5,
            orderable: false, 
            className: "text-center"
        }               
        ],
        "processing": true,
        "serverSide": true,
        "responsive": true, 
        
        "pageLength": 10,
        "ajax": {
            "url": $BASE_URL+ "sync/getData",
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
