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
	<link href="<?php echo BASE_URL.'/assets/css/pace.css' ; ?>" rel="stylesheet">	
	
	<!-- Endless -->
	<link href="<?php echo BASE_URL.'/assets/css/endless.min.css'; ?>" rel="stylesheet">
	<link href="<?php echo BASE_URL.'/assets/css/endless-skin.css'; ?>" rel="stylesheet">

	<!-- growl -->
	<link href="<?php echo PLUGINS_URL?>jquery.growl/css/jquery.growl.css" rel="stylesheet">

	<style>
		.btn-xl {
		    padding: 10px 30px;
		    font-size: 35px;
		    margin: 3px; 
		}
		.btn-ver{
			height: 100%;
		}
		input[type=text] {
			font-size: 30px;
		}
		.selected{
			background-color: #424f63 !important;
		}

		.cpointer{
			cursor: pointer;
		}

		.text-underline:hover{
			text-decoration : underline ;
			color: red ;
		}

		.appelPrix:hover{
			text-decoration: underline;
		}

	</style>
</head>

  <body class="overflow-hidden">
	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>
	
	<div id="wrapper" class="preload">
		<div id="top-nav" class="skin-6 fixed">
			<div class="brand">
				<span>Endless</span>
				<span class="text-toggle"> Admin</span>
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
					<div class="panel-body" style="height: 500px">	
						<h4 class="alert alert-danger pull-left">TOTAL: <span id="total_caisse"></span> </h4>	
						<h4 class="pull-right"><?= date("d/m/Y"); ?> | <?= date("H:m:s"); ?></h4>												
						<table class="table table-hover">
							<thead>
								<tr>
									<th class='hide'>id</th>
									<th>REF</th>
									<th>Désignation</th>
									<th>Quantité</th>
									<th>PU</th>
									<th>Sous-Total</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="content_table_caisse">
								
							</tbody>
						</table>
					</div>				
				</div>				
			</div>
			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h4 class="text-center">OPERATIONS</h4>
					</div>
					<div class="panel-body">
						<div class="col-lg-12" style="padding-bottom: 10px;">
							<input type="text" class="form-control input-lg" id="text_caisse">	
						</div>													
						<div class="row">
							<div class="col-sm-3">
								<div class="row">
									<div class="col-sm-12"><button class="btn btn-success btn-xl btn_106" value="X"><i class="fa fa-times"></i></button></div>
									<div class="col-sm-12"><button class="btn btn-success btn-xl btn_8" id="retour_caisse" onclick="retour_caisse()"><i class="fa fa-arrow-left"></i></button></div>
									<div class="col-sm-12"><button class="btn btn-success btn-xl btn_82" id="reload_caisse" onclick="reload_caisse()"><i class="fa fa-refresh"></i></button></div>
									<div class="col-sm-12"><button class="btn btn-success btn-xl btn_73" id="print_caisse" onclick="print_caisse()"><i class="fa fa-print"></i></button></div>			
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_103" value="7">7</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_104" value="8">8</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_105" value="9">9</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_100" value="4">4</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_101" value="5">5</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_102" value="6">6</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_97" value="1">1</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_98" value="2">2</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_99" value="3">3</button></div>
									<div class="col-sm-4"><button class="btn btn-info btn-xl btn_96" value="0">0</button></div>
									<div class="col-sm-8"><button class="btn btn-info btn-xl btn-block btn_" value="00">00</button></div>
								</div>
							</div>
							<div class="col-sm-3" style="height:310px">
								<button class="btn btn-primary btn-block btn-ver btn_13" id="caisse_OK" onclick="caisse_OK()"><i class="fa fa-check fa-5x"></i></button>
							</div>
						</div>
					</div>
				</div>
				<span class="btn btn-success pull-right btn-lg" onclick="showModalAppelPrix()" id="appelPrix">Appel prix</span>			
			</div>
		</div>		
		<!-- /main-container -->
	</div><!-- /wrapper -->

	<a href="#" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>

	<!-- MODAL APPEL PRIX -->
	<div class="modal fade" id="modalAppelPrix">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4>Appel de prix</h4>
	            </div> 
	            
	            <div class="modal-body">
	            	<div class="panel-group" id="accordion">

	            		<?php 
	            			$getArticleAndCategory = $Article->getArticleAndCategory() ;
	            			if (!empty($getArticleAndCategory)) {
	            				foreach ($getArticleAndCategory as $item) { ?>
	            					<div class="panel panel-default">
	            						<div class="panel-heading">
	            							<h4 class="panel-title">
	            								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $item['id_categorie']?>">
	            									<?php echo $item['nom_categorie'] ?>
	            								</a>
	            							</h4>
	            						</div>
	            						<div id="<?php echo $item['id_categorie']?>" class="panel-collapse collapse">
	            							<div class="panel-body">
	            								<?php 
	            									$articles = $item['article'] ;
	            									if (!empty($articles)) {
	            										foreach ($articles as $article) { ?>
	            											<span  class="cpointer appelPrix"  onclick="CBFormAppelPrix(this)" data-code_barre="<?php echo $article->codebarre_article ?>">
	            												<span><?php echo $article->nom_article?></span>
	            												<span class="pull-right" ><?php echo $article->codebarre_article?></span>
	            											</span>
	            											<br>
	            									<?php	}
	            									}
	            								?>
	            							</div>
	            						</div>
	            					</div><!-- /panel -->
	            		<?php		}
	            			}
	            		?>
						
					</div>
	            </div>
	            <div class="modal-footer">
	                <span class="btn btn-success btn-sm" data-dismiss="modal" aria-hidden="true">Fermer</span>
	            </div>

	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<script src="<?php echo BASE_URL.'/assets/js/jquery-1.10.2.min.js'; ?>"></script>

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

	<script>
		var root = '<?php echo BASE_URL.'/' ; ?>';
		var i = 0;

		function strstr(haystack, needle, bool) {
		    var pos = 0;

		    haystack += "";
		    pos = haystack.indexOf(needle); if (pos == -1) {
		        return false;
		    } else {
		        if (bool) {
		            return haystack.substr(0, pos);
		        } else {
		            return haystack.slice(pos);
		        }
		    }
		}

		function showModalAppelPrix()
		{
			var text_caisse = $('#text_caisse').val() ,
			test = strstr(text_caisse,"X") ;

			if ( text_caisse !== '' && test) {
				$('#modalAppelPrix').modal('show') ;
			}
			else{
				$.growl.error({ title:"", message: "Veuillez entrer la quantité"});
			}
		}

		function CBFormAppelPrix(item){
			var codeb = $(item).data('code_barre') ;
			$('input#text_caisse').val(function(){
				return this.value + codeb ;
			}) ;
			caisse_OK() ;
			$('#modalAppelPrix').modal('hide') ;
		}

		function addClassTo(v){
			$('.btn_'+v).addClass('selected') ;
		}

		function removeClassTo(v){
			$('.btn_'+v).removeClass('selected') ;
		}
		
		function clearDiv(id){
			$('#'+id).val('');
		}

		function retour_caisse(){
			var text = $('#text_caisse').val();
			var longueur = text.length;
			text = text.substring(0, longueur-1);
			$('#text_caisse').val(text);
		}

		function reload_caisse(){
			clearDiv('text_caisse') ;
		}

		var incr = 1 ;
		function caisse_OK(){
			if ($('#text_caisse').val()!=''){
				var text = $('#text_caisse').val();
				text = text.split('X');

				$.post(root+'/caisse/Getcontentproduct', 
			    {
			        "quantite":text[0]
			        ,"CDB":text[1]
			        ,"incr" : incr 
			    },
			    function(d){
			    	if (d.state == 'success') {
    		    		$('#content_table_caisse').append(d.table_content) ;
    		    		clearDiv('text_caisse') ;

    					if ($('#total_caisse').text()!=''){
    						var total = Number($('#total_caisse').text()) + d.sous_total_article;
    						$('#total_caisse').text(total);
    					}
    					else
    					{
    						$('#total_caisse').text(d.sous_total_article);
    					}
			    	}
			    	else{
		    			$.growl.error({ title:"", message: d.msg });
		    			clearDiv('text_caisse') ;
			    	}
			    }, 'json');
			}
			else
			{
				$.growl.warning({ title:"", message: "Champ obligatoire" });
			}

			incr++ ;
		}

		function print_caisse() {
			var tabArticle = [];

			$("#content_table_caisse tr").each(function() {
			    var arrayOfThisRow = [];
			    var tableData = $(this).find('td');
			    if (tableData.length > 0) {
			        tableData.each(function() { arrayOfThisRow.push($(this).text()); });
			        tabArticle.push(arrayOfThisRow);
			    }
			});

			$.ajax({
				url: root+'Caisse/Add',
				type: 'POST',					
				data: {TABARTICLE: tabArticle},
				dataType:"json" ,
				beforeSend: function(){
					$('body').block({ 
		                message: '<i class="fa fa-spinner fa fa-2x fa-spin" style="color:#000;"></i>',
		                overlayCSS: {
		                    backgroundColor: '#fff',
		                    opacity: 0.8,
		                    cursor: 'wait'
		                },
		                css: {
		                    border: 0,
		                    padding: 0,
		                    backgroundColor: 'transparent'
		                }
		              });
				},
				success : function(d){
					$('body').unblock() ;
					$('#content_table_caisse').empty();
					$('span#total_caisse').text('') ;
					clearDiv('text_caisse') ;

					if (d.state == 'error') {
						$.growl.warning({ title:"", message: d.msg });
					}
				}			
			});
		}

		function deleteLigne(item){
			var ligne = $(item).data('ligne') ,
			article_id = $('tr#ligne_'+ligne).data('article_id') ,
			quantite = $('tr#ligne_'+ligne).data('quantite') ;

			$.post(root+'/caisse/deleteLigne', 
		    {
		        "article_id":article_id
		        ,"quantite":quantite
		    },
		    function(d){
		    	$('tr#ligne_'+ligne).addClass('hide') ;

    			var total_c = $('#total_caisse').text();
    			var total_f = total_c - d.total ;
    			$('#total_caisse').text(total_f);
		    }, 'json');
		}

		$(document).ready(function() {
			$('body').keyup(function(e){
				var v = e.keyCode ;
				var n = {} ;

				switch(v){
					case 96 : 
						n['code'] = 96 ;
						n['value'] = 0 ;
					break ;
					case 97 : 
						n['code'] = 97 ;
						n['value'] = 1 ;
					break ;
					case 98 : 
						n['code'] = 98 ;
						n['value'] = 2 ;
					break ;
					case 99 : 
						n['code'] = 99 ;
						n['value'] = 3 ;
					break ;
					case 100 : 
						n['code'] = 100 ;
						n['value'] = 4 ;
					break ;
					case 101 : 
						n['code'] = 101 ;
						n['value'] = 5 ;
					break ;
					case 102 : 
						n['code'] = 102 ;
						n['value'] = 6 ;
					break ;
					case 103 : 
						n['code'] = 103 ;
						n['value'] = 7 ;
					break ;
					case 104 : 
						n['code'] = 104 ;
						n['value'] = 8 ;
					break ;
					case 105 : 
						n['code'] = 105 ;
						n['value'] = 9 ;
					break ;
					case 106 : 
						n['code'] = 106 ; 
						n['value'] = 'X' ;
					break ;
					case 8 : 
						n['code'] = 8 ; 
						n['value'] = '' ;
					break ;
					case 82 : 
						n['code'] = 82 ; 
						n['value'] = '' ;
					break ;
					case 73 : 
						n['code'] = 73 ; 
						n['value'] = '' ;
					break ;
					case 13 : 
						n['code'] = 13 ; 
						n['value'] = '' ;
					break ;
				}

				if ( (v == 96) || (v == 97) || (v == 98) || (v == 99) || (v == 100) || (v == 101) || (v == 102) || (v == 103) || (v == 104)  || (v == 105)  || (v == 106) || (v == 8) || (v == 82) || (v == 73) || (v == 13) ) {

					addClassTo(v) ;
					setTimeout(removeClassTo,150,v) ;

					if (!n.value && n.value !== 0) {
						switch (n.code) {
							case 8 :
								retour_caisse() ;
							break;
							case 82 :
								clearDiv('text_caisse') ;
								break ;
							case 73 :
								print_caisse();
								break ;
							case 13 :
								caisse_OK() ;
								break ;
						}
					}
					else{
						$('input#text_caisse').val(function(){
							return this.value + n.value ;
						}) ;
					}
				}
			}) ;

			$('#text_caisse').hover(function() {
				$('#text_caisse').attr('disabled','true');
			}, function() {
				$('#text_caisse').removeAttr('disabled');
			});

			$('.btn').click(function() {
				if($('#text_caisse').val()!=''){
					var a = $('#text_caisse').val();
					$('#text_caisse').val(a+$(this).val());					
				}
				else
				{
					$('#text_caisse').val($(this).val());
				}				
			});
		});		
	</script>
	
  </body>

</html>
