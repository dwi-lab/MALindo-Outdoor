var save_method;
var table;
$(function() {
    jQuery("#filter_pencarian").hide();
    table = $('#data-sewa-detil').DataTable({ 
        "processing": true, 
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $BASE_URL+ "pengembalian/getDataDetil",
            "type": "POST",
            "data": function ( data ) {
            }
        },
        "columnDefs": [{ 
            "targets": [ 7 ],
            "orderable": false, 
            "className": "text-center",
        },{ 
            "targets": [ 4,6,5 ],
            "orderable": true, 
            "className": "text-center",
        },{ 
           'targets': 0,
            'searchable': false,
            'orderable': false,
            'width':'1%',
            'className': 'text-center',
            'render': function (data, type, row){
                return '<input type="checkbox" name="kode_barang[]" value="' + row[2] + '|' + row[4] + '">';
            }
        },
        ],
    });
    $('#select-all').on('click', function(){
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
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
