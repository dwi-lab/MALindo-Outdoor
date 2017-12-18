$(function() {
    jQuery("#filter_pencarian").hide();
    $('.select').select2({
        minimumResultsForSearch: Infinity,
        width: '350px'
    });
    $('#btn-reset').click(function(){
        $('#form-filter')[0].reset();
        table.ajax.reload(null,false); 
    });
});
function download_stok() {
    var tipe = jQuery("#tipe").val();
    var merk = jQuery("#merk").val();
    if(tipe !="" && merk !=""){
        $.ajax({ 
            url : $BASE_URL+link+'/cekdata/'+id, 
            dataType : 'json', 
            type : 'post', 
            success : function(json) { 
                $.unblockUI(); 
                if (json.say == "ok") { 
                    window.location.href = $BASE_URL+link+'/edit/'+id; 
                }else{ 
                    $.gritter.add({title:"Informasi Pengeditan !",text: page+ " ini tidak ditemukan di database !"});
                    return false; 
                } 
            } 
        }); 
    }else if(tipe !="" && merk == ""){

    }else{
        
    }

}
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
        jQuery.unblockUI();
    }, 100);
}