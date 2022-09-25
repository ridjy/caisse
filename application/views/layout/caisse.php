<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$controllerName = $this->router->fetch_class();
	$actionName = $this->router->fetch_method();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo BASE_URL.'/assets/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="<?php echo BASE_URL.'/assets/css/font-awesome.min.css'; ?>" rel="stylesheet">

	<!-- Pace -->
	<link href="<?php echo BASE_URL.'/assets/css/pace.css' ; ?>" rel="stylesheet">	
	
	<!-- Endless -->
	<link href="<?php echo BASE_URL.'/assets/css/endless.min.css'; ?>" rel="stylesheet">
	<link href="<?php echo BASE_URL.'/assets/css/endless-skin.css'; ?>" rel="stylesheet">

	<!-- growl -->
	<link href="<?php echo PLUGINS_URL?>jquery.growl/css/jquery.growl.css" rel="stylesheet">

	<!-- headLink -->
	<?php 
		if ($headLink) {
			echo $headLink;
		}
	?>

</head>

<body class="overflow-hidden" onload="startTime()">
	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>

	<div id="wrapper" class="preload">
		<?php echo $this->layout->setStatics('header.php') ?>
		<?php echo $contents ?>
		<?php echo $this->layout->setStatics('modal_appel_prix.php') ?>
		<?php echo $this->layout->setStatics('modal_mode_paiement.php') ?>
	</div>

	<a href="#" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>
    
    <?php /* ?>
    <script src="<?php echo BASE_URL.'/assets/js/jquery-1.10.2.min.js'; ?>"></script>
    <?php */ ?>
    <script src="<?php echo BASE_URL.'/assets/js/jquery-2.1.0.min.js'; ?>"></script>

	<!-- Bootstrap -->
    <script src="<?php echo BASE_URL.'/assets/bootstrap/js/bootstrap.js'; ?>"></script>
   
	<!-- Flot -->
	<script src='<?php echo BASE_URL.'/assets/js/jquery.flot.min.js'; ?>'></script>
   
	<!-- Morris -->
	<script src='<?php echo BASE_URL.'/assets/js/rapheal.min.js'; ?>'></script>	
	<script src='<?php echo BASE_URL.'/assets/js/morris.min.js'; ?>'></script>	
	
	<!-- Colorbox -->
	<script src='<?php echo BASE_URL.'/assets/js/jquery.colorbox.min.js'; ?>'></script>	

	<!-- Sparkline -->
	<script src='<?php echo BASE_URL.'/assets/js/jquery.sparkline.min.js'; ?>'></script>
	
	<!-- Pace -->
	<script src='<?php echo BASE_URL.'/assets/js/uncompressed/pace.js'; ?>'></script>
	
	<!-- Popup Overlay -->
	<script src='<?php echo BASE_URL.'/assets/js/jquery.popupoverlay.min.js'; ?>'></script>
	
	<!-- Slimscroll -->
	<script src='<?php echo BASE_URL.'/assets/js/jquery.slimscroll.min.js'; ?>'></script>
	
	<!-- Modernizr -->
	<script src='<?php echo BASE_URL.'/assets/js/modernizr.min.js'; ?>'></script>
	
	<!-- Cookie -->
	<script src='<?php echo BASE_URL.'/assets/js/jquery.cookie.min.js'; ?>'></script>
	
	<!-- Endless -->
	<!--<script src="<?php echo BASE_URL.'/assets/js/endless/endless_dashboard.js'; ?>"></script>-->
	<script src="<?php echo BASE_URL.'/assets/js/endless/endless.js'; ?>"></script>

	<!-- growl -->
	<script src="<?php echo PLUGINS_URL ?>jquery.growl/js/jquery.growl.js"></script>

	<!-- BLOCK UI -->
	<script src="<?php echo PLUGINS_URL ?>blockui.min.js"></script>

	<!-- inputmask -->
	<script src="<?php echo THEMES_URL ?>js/jquery.mask.min.js"></script>
		
	<script src="<?php echo BASE_URL.'/assets/js/jquery.scannerdetection.compatibility.js'; ?>"></script>
	<script src="<?php echo BASE_URL.'/assets/js/jquery.scannerdetection.js'; ?>"></script>

	<script type="text/javascript">
		var root = "<?php echo BASE_URL ?>/" ;
	</script>

	<!-- headScript -->
	<?php 
		if ($headScript) {
			echo $headScript;
		}
	?>

</body>
</html>
