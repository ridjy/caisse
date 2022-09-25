<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Caisse</li>
			 <li class="active">Paramétrage ticket de caisse</li>
		</ul>
	</div>
	<div class="padding-md">
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="caisse_ticket" class="form-horizontal no-margin form-border"  method="POST">
					<div class="form-group ">
						<label class="col-lg-2 control-label">7 premier chiffre du code barre</label>
						<div class="col-lg-10">
							<div class='input-group'>
								<input type="text" class="form-control" id="codebarre" name="Options[codebarre]" value="<?php echo $getAllOptions['codebarre'] ?>">
								<span class='input-group-btn'>
									<button class='btn btn-default' type='button' onclick='generateCodeBarre(this)' data-resource_type='caisse'>Générer</button>
								</span>
							</div>
							<span class="help-block">Ces chiffres composeront les 7 premiers chiffre de votre code barre.</span>
						</div><!-- /.col -->
					</div><!-- /form-group -->

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<input type="submit" class="btn btn-success btn-sm pull-right" value="Mettre à jour">
						</div><!-- /.col -->
					</div>

				</form>
			</div>
		</div>
	</div><!-- /.padding-md -->
</div><!-- /main-container -->
