<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Code Barre</li>	 
		</ul>
	</div>
	<div class="padding-md">
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading" >
					<h4 class="text-center">GENERER VOTRE CODE BARRE</h4>
				</div>
				<div class="panel-body" id="generateCB">
					<div class="text-center">
						<div id="Logo_CB">
							<img src="<?php echo BASE_URL.'/assets/img/code_barre.gif'; ?>" width="300px">
						</div>							
						<?php /* ?><h3>Entrer votre code barre</h2><?php */ ?>
						<div class="input-group mt-10">
							<input class="form-control" type="text" id="code_barre" style="font-size: 20pt;" placeholder="Entrer le code barre">
							<span class="input-group-addon cpointer" id="Generer_CB">Générer</span>
						</div>
						<div id="resultCB" class="hide mt-20">
							<button class="btn btn-success hide" id="Imprimer_CB" onclick="Imprimer_CB(this)" data-code_barre="" data-nom_article="" data-uniqid=""><i class="fa fa-print"></i>&nbsp;Imprimer</button>
	                        <button class="btn btn-danger" id="Annuler_CB"><i class="fa fa-times"></i>&nbsp;Annuler</button>
	                        <div id="Result_CB" class="mt-20">
	                        	<div id="img_result">
	                            	<img src="" id="Image_CB">
	                        	</div>
	                        </div>
						</div>
					</div>						
				</div>
			</div>				
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading" >
					<h4 class="text-center">ARTICLE ASSOCIEE</h4>
				</div>
				<div class="panel-body">
					<div class="text-center">
						<div id='html_append' >
						</div>
					</div>						
				</div>
			</div>				
		</div>
	</div><!-- /.padding-md -->
</div><!-- /main-container -->
