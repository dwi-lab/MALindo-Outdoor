var save_method;
var table;
$(function() {
    TableManageResponsive.init();
    table = $('#data-news').DataTable({ 
        autoWidth: false,
        columnDefs: [{
            width: '5',
            targets: 0,
            className: "text-center",
        },{
            width: '10%',
            targets: 1,
            orderable: false
        },{
            width: '30%',
            targets: 2,
            orderable: true
        },{
            width: '50%',
            targets: 3,
            orderable: false
        },{
            width: '5%',
            targets: 4,
            orderable: true, 
            className: "text-center"
        },{
            width: '5%',
            targets: 5,
            orderable: true, 
            className: "text-center"
        },{
            width: '5%',
            targets: 6,
            orderable: true, 
            className: "text-center"
        },{
            width: '5%',
            targets: 7,
            orderable: false, 
            className: "text-center"
        }          
        ],
        "processing": true,
        "serverSide": true,
        "responsive": true, 
        "pageLength": 10,
        "ajax": {
            "url": $BASE_URL+ "news/getData",
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
    $('.select').select2({
        mikodeumResultsForSearch: Infinity,
        width: '250px'
    });
});
function tambah_data(){
    save_method = 'add';
    jQuery("#filter_pencarian").hide("slow");
    $('#form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('#label-photo').text('Upload Photo');
    $('.modal-title').text('Tambah Papan Informasi');
    $('#photo-preview').hide();
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
            $('[name="deskripsi"]').val(data.berita);
            $('[name="judul"]').val(data.judul);
            var dibuat = new Date(data.tgl_dibuat);
            $("#tgl_dibuat").datepicker({
                dateFormat : 'dd-mm-yy'
            }).datepicker('setDate',dibuat)
            var selesai = new Date(data.tgl_selesai);
            $("#tgl_selesai").datepicker({
                dateFormat : 'dd-mm-yy'
            }).datepicker('setDate',selesai)
            $('[name="id"]').val(data.id);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Papan Informasi');
            $('[name="kode"]').attr('disabled',false);
            $('#photo-preview').show();
            if(data.foto){
                $('#label-photo').text('Ganti Photo'); 
                $('#photo-preview div').html('<img src="'+$BASE_URL+'assets/foto/news/'+data.foto+'" class="img-responsive">'); 
            }else{
                $('#label-photo').text('Upload Foto'); 
                $('#photo-preview div').text('(No Foto)');
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function save_news(page,link,formid){
    $('#btnSave').text('proses menyimpan data...'); 
    $('#btnSave').attr('disabled',true);
    var url;
    if(save_method == 'add') {
        url = $BASE_URL+ page+"/proses_add"; 
    } else {
        url = $BASE_URL+ page+"/proses_edit"; 
    }
    var formData = new FormData($(formid)[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data){
            if(data.status ==  true ) {
                $('#modal_form').modal('hide');
                reload_table();
            }else if(data.status == false ){
                for (var i = 0; i < data.inputerror.length; i++){
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                }
            }else if(data.status == 'NoAktived'){
                $.gritter.add({title:"Informasi !",text: " Data Tidak Boleh Kosong !"});return false;
            }else{
                alert('tidak bisa di update data sudah tersedia');              
            }
            $('#btnSave').text('Simpan'); 
            $('#btnSave').attr('disabled',false); 
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error adding / update data');
            $('#btnSave').text('Simpan'); 
            $('#btnSave').attr('disabled',false); 
        }
    });
}