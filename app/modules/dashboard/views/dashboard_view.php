<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>MALindo Outdoor </title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Aplikasi Penyewaan Alat Gunung" />
    <meta content="" name="Hendy Andrianto,https://www.facebook.com/hackerlocalhost/?ref=br_rs" />
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>logo/icon.png"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/font-google/font-google-api.css" rel="stylesheet"> 
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/funcy/jquery.fancybox.css" media="screen" />
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.min.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style-responsive.min.css"> 
    <link href="<?php echo base_url();?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css"> 
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/intro-js/introjs.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.0.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-migrate-1.4.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/css/prettify/prettify.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootbox/bootbox.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/masked-input/masked-input.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/funcy/jquery.fancybox.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/intro-js/intro.js"></script>
    <script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/form-plugins.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            jQuery('.fancybox').fancybox({'type' : 'image'});
            App.init();
            FormPlugins.init();
        });
    </script>
</head>
<body>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <?php
        $this->load->view('dashboard/menu_atas');
        ?>
        <?php
        $this->load->view('dashboard/menu_samping');
        ?>
        <div id="content" class="content">
            <?php
            if($page=="booking"){
                ?>
                    <h1 class="page-header hidden-print"><?php echo $halaman;?> <small><?php echo $judul;?></small></h1>
                <?php
            }else{
                ?>
                    <h1 class="page-header"><?php echo $halaman;?> <small><?php echo $judul;?></small></h1>
                <?php
            }
            ?>
            <?php
            $this->load->view($content);
            ?>
        </div>
        <?php 
        if($page!="booking"){
            $this->load->view('dashboard/footer');
        }
        ?>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    </div>
</body>
</html>
