<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script>
$(document).ready(function() {
    TableManageResponsive.init();
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: '60px'
    });
});
function edit(id,page,link){ 
    bootbox.confirm("Yakin Akan Mengedit " +page+ " Berikut ?", function(result) { 
        if (result) { 
            $.blockUI({ 
                css: { 
                    border: 'none',
                    padding: '15px', 
                    backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', 
                    opacity: 2, color: '#fff' }, 
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
                        window.location.href = $BASE_URL+link+'/edit/'+id; 
                    }else{ 
                        $.gritter.add({title:"Informasi Pengeditan !",text: page+ " ini tidak ditemukan di database !"});
                        return false; 
                    } 
                } 
            }); 
        } 
    });
}
function hapus(id,page,link,action){ 
    bootbox.confirm("Yakin Akan Menghapus " +page+ " Berikut ?", 
        function(result) { 
            if (result) { 
                $.blockUI({ 
                    css: { 
                         border: 'none',
                         padding: '15px', 
                         backgroundColor: '#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', 
                         opacity: 2, 
                         color: '#fff' }, 
                         message : 'Sedang Melakukan Pengecekan Data <br/> Mohon menunggu ... ' 
                     }); 
                setTimeout(function(){ 
                    $.unblockUI(); 
                },1000); 
                $.ajax({ 
                    url : $BASE_URL+link+'/'+action+'/'+id, 
                    dataType : 'json', 
                    type : 'post', 
                    success : function(json) { 
                        $.unblockUI(); 
                        if(json.say == "ok") { 
                            window.location.href = $BASE_URL+link; 
                        }else{ 
                            $.gritter.add({title:"Informasi Penghapusan !",text: page+ " ini tidak bisa dihapus,terkait dengan database lain !"});
                            return false; 
                        } 
                    } 
                }); 
            } 
        });
}
</script>    
<div class="row">
    <div 
    data-step         ="5" 
    data-intro        ="Background Login Digunakan untuk mengganti Background pada halaman login aplikasi. Bisa berupa Background Perusahaan,kegiatan-kegiatan Perusahaan dll."  
    data-hint         ="Background Login Digunakan untuk mengganti Background pada halaman login aplikasi. Bisa berupa Background Perusahaan,kegiatan-kegiatan Perusahaan dll." 
    data-hintPosition ="top-middle" 
    data-position     ="bottom-right-aligned"
    class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="<?php echo base_url();?><?php echo $link;?>/add" title="Tambah <?php echo $halaman;?>" class="btn btn-primary btn-xs m-r-5">Tambah Data</a>
                    <a href="javascript:void(0);" class="btn btn-info btn-xs m-r-5" title="Bantuan" onclick="javascript:introJs().start();">
                        <i class="fa fa-question"></i> 
                    </a> 
                </div>
                <h4 class="panel-title"><?php echo $halaman;?></h4>
            </div>
            <div class="panel-body">
                <table 
                data-step         ="1" 
                data-intro        ="List Data Background Login."  
                data-hint         ="List Data Background Login." 
                data-hintPosition ="top-middle" 
                data-position     ="bottom-right-aligned"
                id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center" width="1%">No.</th>
                            <th style="text-align:center" width="10">Background</th>
                            <th style="text-align:center" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $ii= 0;
                    $guru = $this->db->get('tbl_bglogin')->result();
                    foreach ($guru as $key) {
                        $ii++;
                        $nip = $key->id;
                        ?>
                        <tr class="odd gradeX">
                            <td width="1%" style="text-align:center"><?php echo $ii . "." ;?></td>
                            <td width="90%" 
                            data-step         ="2" 
                            data-intro        ="Foto Background Login."  
                            data-hint         ="Foto Background Login." 
                            data-hintPosition ="top-middle" 
                            data-position     ="bottom-right-aligned"
                            style="text-align:center"><a class="fancybox" href="<?php echo base_url();?>assets/img/login-bg/<?php echo $key->logo;?>" style="width:80px;text-align:center;height:80px;"><img src="<?php echo base_url();?>assets/img/login-bg/<?php echo $key->logo;?>" style="width:71px;" alt="" /></a></td>
                            <td style="text-align:center" width="10%">
                                <a href="javascript:void(0)" 
                                data-step         ="3" 
                                data-intro        ="Digunakan untuk merubah data."  
                                data-hint         ="Digunakan untuk merubah data." 
                                data-hintPosition ="top-middle" 
                                data-position     ="bottom-right-aligned"
                                onclick="edit(<?php echo "'" .$nip . "'";?>,<?php echo "'" .$halaman . "'";?>,<?php echo "'" .$link . "'";?>,<?php echo "'" .$actionedit . "'";?>)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-warning" title='Edit Data'><i class="icon-pencil icon-white"></i></a>
                                <a href="javascript:void(0)" 
                                data-step         ="4" 
                                data-intro        ="Digunakan untuk menghapus data."  
                                data-hint         ="Digunakan untuk menghapus data." 
                                data-hintPosition ="top-middle" 
                                data-position     ="bottom-right-aligned"
                                onclick="hapus(<?php echo "'" .$nip . "'";?>,<?php echo "'" .$halaman . "'";?>,<?php echo "'" .$link . "'";?>,<?php echo "'" .$actionhapus . "'";?>)" data-toggle="tooltip" class="btn btn-xs m-r-5 btn-danger" title='Hapus Data'><i class="icon-remove icon-white"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>