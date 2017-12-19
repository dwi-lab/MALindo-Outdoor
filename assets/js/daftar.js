$(function() {
    jQuery("#provinsi").change(function(){
        var provinsi = jQuery("#provinsi").val();
        if(provinsi!=""){
            setTimeout(function(){
                jQuery("#kota").load ($BASE_URL+'member/getKabkot/'+provinsi);
                $("#kota").trigger("liszt:updated");
                jQuery.unblockUI();
            },500);
        }else{
            jQuery("#kota").select2("val","");
            return false;
        }
    });
    jQuery("#kota").change(function(){
        var kabupaten = jQuery("#kota").val();
        if(kabupaten!=""){
            setTimeout(function(){
                jQuery("#kecamatan").load ($BASE_URL+'member/getKec/'+kabupaten);
                $("#kecamatan").trigger("liszt:updated");
                jQuery.unblockUI();
            },500);
        }else{
            jQuery("#kecamatan").select2("val","");
            return false;
        }
    });
    jQuery("#kecamatan").change(function(){
        var kecamatan = jQuery("#kecamatan").val();
        if(kecamatan!=""){
            setTimeout(function(){
                jQuery("#kelurahan").load ($BASE_URL+'member/getKel/'+kecamatan);
                $("#kelurahan").trigger("liszt:updated");
                jQuery.unblockUI();
            },500);
        }else{
            jQuery("#kelurahan").select2("val","");
            return false;
        }
    });
});
