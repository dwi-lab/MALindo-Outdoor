var host = window.location.host;
$BASE_URL = 'http://'+host+'/';
var current_page    =   1;
$(document).ready(function(){
    $.ajax({
        url   : $BASE_URL+"login/getRight",
        'type':'post',
        success:function(data){
            var data    =   $.parseJSON(data);
            $(data.html).hide().appendTo('.right-content').fadeIn(50);
        }
    });
    $.ajax({
        url   : $BASE_URL+"login/getContent",
        'type':'post',
        success:function(data){
            var data    =   $.parseJSON(data);
            $(data.html).hide().appendTo('.news-feed').fadeIn(50);
        }
    });
});
function doLogin(){
    var uname = jQuery("#username").val();
    var password = jQuery("#password").val();
    if (uname == "") {
        jQuery("#username").effect('shake','1500').attr('placeholder','username tidak boleh kosong');
    } else if (password == "") {
        jQuery("#password").effect('shake','1500').attr('placeholder','password tidak boleh kosong');
    } else {
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
            message : 'sedang melakukan pengecekan <br/> silahkan tunggu ...'
        });
        jQuery.ajax({
            url : $BASE_URL+'login/do_login',
            data : {txtuser:uname,txtpass:password},
            type : 'POST',
            dataType: 'json',
            success:function(data){
                jQuery.unblockUI();
                if(data.response=='true'){
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
                        message : 'Login Berhasil !!! sedang memuat halaman'
                    });
                    window.location = $BASE_URL+'dashboard';
                    setTimeout(function(){
                        jQuery.unblockUI();
                    },50);
                } else {
                    notif({
                        type: "warning",
                        msg: "Ups Username dan Password Anda tidak dikenal Silahkan Login Kembali",
                        position: "center",
                        width: 500,
                        height: 60,
                        autohide: true
                    });
                    jQuery("#username").val('');
                    jQuery("#password").val('');
                }            
            }
        });
    }
}