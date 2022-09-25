<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>BazarKids</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo BASE_URL.'/assets/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="<?php echo BASE_URL.'/assets/css/font-awesome.min.css'; ?>" rel="stylesheet">

	<!-- Pace -->
	<link href="<?php echo BASE_URL.'/assets/css/pace.css'; ?>" rel="stylesheet">	
	
	<!-- Endless -->
	<link href="<?php echo BASE_URL.'/assets/css/endless.min.css'; ?>" rel="stylesheet">
	<link href="<?php echo BASE_URL.'/assets/css/endless-skin.css'; ?>" rel="stylesheet">	
	<link href="<?php echo BASE_URL.'/assets/css/jquery.dataTables_themeroller.css'; ?>" rel="stylesheet">	
</head>

  <body class="overflow-hidden">
	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>
	
	<div id="wrapper" class="preload">
		<div id="top-nav" class="skin-6 fixed">
			<div class="brand">
				<span>Bazar</span>
				<span class="text-toggle"> Kids</span>
			</div><!-- /brand -->
			<button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<button type="button" class="navbar-toggle pull-left hide-menu" id="menuToggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div><!-- /top-nav-->
		<div class="row" style="margin:50px 10px">
			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading" >
						<h4 class="text-center">LISTE DES ARTICLES</h4>
					</div>
					<div class="panel-body">	
						<table id="listeproduit" class="table table-hover table-vcenter" cellspacing="0" width="100%">
							<thead>
								<th>Code barre</th>
								<th>Désignation</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
									$i = 0;
									foreach ($liste as $data) {
								?>
									<tr>
										<td id="code_CB<?= $i; ?>"> <?= $data->codebarre_article; ?></td>
										<td> <?= $data->nom_article; ?> </td>
										<td><button class="btn btn-info" onclick="ShowCB(<?= $i; ?>)"><i class="fa fa-barcode"></i></button></td>
									</tr>
								<?php
									$i++;
									}
								?>
							</tbody>
						</table>	
					</div>				
				</div>				
			</div>
			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading" >
						<h4 class="text-center">GENERER VOTRE CODE BARRE</h4>
					</div>
					<div class="panel-body">
						<div class="text-center">
							<div id="Logo_CB">
								<img src="<?php echo BASE_URL.'/assets/img/code_barre.gif'; ?>" width="300px">
							</div>							
							<h3>Entrer votre code barre</h2>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
								<input class="form-control" type="text" id="code_barre" style="text-align: center;font-size: 20pt;" >
								<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
							</div>
							<br>
							<button class="btn btn-info" id="Generer_CB"><i class="fa fa-check"></i> Générer</button>
							<button class="btn btn-success" id="Imprimer_CB" style="display : none"><i class="fa fa-print"></i>   Imprimer</button>
                            <button class="btn btn-danger" id="Annuler_CB" style="display : none"><i class="fa fa-times"></i>   Annuler</button>
                            <br><br>
                            <div id="Result_CB">
                                <img src="" id="Image_CB">
                            </div>
						</div>						
					</div>
				</div>				
			</div>
		</div>		
		<!-- /main-container -->
	</div><!-- /wrapper -->

	<a href="#" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>

	<div class="modal fade" id="CB_Modal">
		<div class="modal-dialog" style="width:350px">
			<div class="modal-content">
  				<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>CODE BARRE</h4>
  				</div>
			    <div class="modal-body">
			    	<input type="hidden" id="CB_cache">
					<img id="img_CB_modal">
					<button class="btn btn-info" onclick="print_CB_modal()"><i class="fa fa-print"></i></button>
			    </div>
		  	</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

<script src="<?php echo BASE_URL.'/assets/js/jquery-1.10.2.min.js'; ?>"></script>

	<!-- Bootstrap -->
    <script src="<?php echo BASE_URL.'/assets/bootstrap/js/bootstrap.js'; ?>"></script>
	
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

	<script src='<?php echo BASE_URL.'/assets/js/jquery.dataTables.min.js'; ?>'></script>
	<script src='<?php echo BASE_URL.'/assets/js/JsBarcode.all.min.js'; ?>'></script>
	<script src="<?php echo BASE_URL.'/assets/js/jspdf.min.js'; ?>"></script>

	<!-- Endless -->
	<!--<script src="<?php echo BASE_URL.'/assets/js/endless/endless_dashboard.js'; ?>"></script>-->
	<script src="<?php echo BASE_URL.'/assets/js/endless/endless.js'; ?>"></script>


	<script>
		$(document).ready(function() {
			$('#listeproduit').dataTable({
				"responsive": true,
	            "order": [[ 0, "desc" ]],
	            "language": {
	                "search": '<i class="fa fa-search"></i>',
	                "paginate": {
	                  "previous": '<i class="demo-psi-arrow-left"></i>',
	                  "next": '<i class="demo-psi-arrow-right"></i>'
	                }
	            },
	            "pageLength": 6,
	            "info": false,
	            "bLengthChange" : false
			});

			$('#Generer_CB').click(function() {
	            var code = $('#code_barre').val();	            
	            JsBarcode("#Image_CB")
	              .options({font: "OCR-B"})
	              .EAN13(code, {fontSize: 20, textMargin: 1, height:75,  fontOptions: "bold"})    
	              .render();
	            $('#Image_CB').show();
	            $('#Logo_CB').toggle('slow');
	            $('#Generer_CB').hide();
	            $('#Imprimer_CB').show();
	            $('#Annuler_CB').show();
	            
        	});

	        $('#Imprimer_CB').click(function(event) {
	            var imgData = $('#Image_CB').attr('src');
	            var a = $('#code_barre').val();			
				var doc = new jsPDF("l","mm",[50,20]);	
				var code1 = a.slice(0,1);
				var code2 = a.slice(1,7);
				var code3 = a.slice(7,13);
				doc.addImage(imgData, 'PNG', 7, 3, 40, 15);	
				doc.setFontType("bold");
				doc.setFontSize(8);					
			    doc.output('dataurlnewwindow');
			});

	        $('#Annuler_CB').click(function(event) {
	            $('#Logo_CB').toggle('slow');
	            $('#Image_CB').hide();
	            $('#Generer_CB').show();
	            $('#Imprimer_CB').hide();
	            $('#Code_CB').val('');
	            $('#Annuler_CB').hide();
	        });
		});

		function ShowCB (i) {			
			var code = Number($('#code_CB'+i).text());	            
			$('#CB_cache').val(code);
	            JsBarcode("#img_CB_modal")
	              .options({font: "OCR-B"})
	              .EAN13(code, {fontSize: 20, textMargin: 1, height:75,  fontOptions: "bold"})    
	              .render();	            
			$('#CB_Modal').modal();
		}

		function print_CB_modal () {
			var imgData = $('#img_CB_modal').attr('src');
            var a = $('#CB_cache').val();			
			var doc = new jsPDF("l","mm",[50,20]);	
			var code1 = a.slice(0,1);
			var code2 = a.slice(1,7);
			var code3 = a.slice(7,13);
			doc.addImage(imgData, 'PNG', 7, 3, 40, 15);	
			doc.setFontType("bold");
			doc.setFontSize(8);					
		    doc.output('dataurlnewwindow');
		}
	</script>
	
  </body>

</html>
