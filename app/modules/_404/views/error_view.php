<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>MALindo Outdoor </title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="Aplikasi Penyewaan Alat Gunung" />
    <meta content="" name="Hendy Andrianto,https://www.facebook.com/hackerlocalhost/?ref=br_rs" />
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>logo/icon.png"/>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>logo/icon.png"/>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/funcy/jquery.fancybox.css" media="screen" />
	<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.min.css"> 
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style-responsive.min.css"> 
	<script src="<?php echo base_url();?>assets/plugins/pace/pace.min.js"></script>
</head>
<body class="pace-top">
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<div id="page-container" class="fade">
		<div class="error">
			<div class="error-code m-b-10">404 <i class="fa fa-warning"></i></div>
			<div class="error-content">
				<div class="error-message">Halaman Tidak Ditemukan</div>
				<br/>
				<div>
					<a href="<?php echo base_url();?>" class="btn btn-success">Halaman Utama</a>&nbsp;
					<button type="button" onclick="history.go(-1)" class="btn btn-success">Kembali </button>
				</div>
			</div>
		</div>
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	</div>
	<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
</html>
