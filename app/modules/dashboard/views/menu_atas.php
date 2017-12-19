<div id="header" class="header navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
        <a href="<?php echo base_url();?>dashboard" class="navbar-brand"><span class="navbar-logo"><i class="ion-ios-cloud"></i></span> <b>MAL</b>indo</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">Selamat Datang </span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <?php
                    $kode   = $this->session->userdata('kode');
                    $ckuser = $this->db->get_where('tbl_username',array('kode'=>$kode));
                    $row    = $ckuser->row();
                    $nama   = $row->nama;
                    $foto   = $row->foto;
                    ?>
                    <img src="<?php echo base_url();?>assets/foto/pegawai/<?php echo $foto;?>" style="width:18px;text-align:center;height:22px;" alt="<?php echo $nama;?>" /> 
                    <span class="hidden-xs"><?php echo $nama;?></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="<?php echo base_url();?>profile">Profile</a></li>
                    <li class="divider"></li>
                    <li><a onclick="logout('<?php echo str_replace("'", "", $nama) ;?>')" href='javascript:void(0)'>Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>