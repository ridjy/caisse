<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Configuration du site</li>	 
		</ul>
	</div>
	<div class="padding-md">
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="siteConfiguration" class="form-horizontal no-margin form-border"  method="POST">
					<div class="form-group">
						<label class="col-lg-2 control-label">En tete du ticket de caisse</label>
						<div class="col-lg-10">
							<textarea class="form-control" name="Options[header_caisse]"><?php echo $getAllOptions['header_caisse'] ?></textarea>
							<span class="help-block">Veuillez effectuer un saut de ligne après chaque parragraphe.</span>
						</div><!-- /.col -->
					</div><!-- /form-group -->

					<div class="form-group">
						<label class="col-lg-2 control-label">En bas du ticket de caisse</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="Options[footer_caisse]" value="<?php echo $getAllOptions['footer_caisse'] ?>">
							<span class="help-block">Ceci apparaitra en-dessous de votre ticket de caisse.</span>
						</div><!-- /.col -->
					</div><!-- /form-group -->

					<?php /* ?>
					<div class="form-group ">
						<label class="col-lg-2 control-label">Version</label>
						<div class="col-lg-10">
							<select class="form-control" name="Options[version]">
								<?php
									for ($i=1; $i <=2 ; $i++) { 
										$selectedVersion = ($getAllOptions['version'] == $i ) ? "selected" : "" ;
										?>
										<option value="<?php echo $i?>" <?php echo $selectedVersion ?>><?php echo $i ?></option>
								<?php	}
								?>
							</select>
						</div><!-- /.col -->
					</div><!-- /form-group -->
					<?php  */ ?>
					
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
