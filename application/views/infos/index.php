<?php 
	$session = $this->session->userdata('logged_in');
	$pseudo = $session['username'] ;
	$password = $session['password'] ;
?>

<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="<?php echo BASE_URL ?>">&nbsp;Accueil</a></li>
			 <li class="active">Informations de connexion</li>	 
		</ul>
	</div>

	<div class="padding-md">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<form class="updateInfos" id="updateInfos" method="POST">
							<div class="text-center mb-30">
							    <img class="profile-img mb-10" src="http://dev.bazarkids.mg/assets/img/user.jpg" width="125" height="125" class="mb-10" style="border-radius:50%">
							    <div class="clear"></div>
							    <span class="cpointer btn-file" onclick="getfile('hiddenProfilePicture')">Modifier votre avatar</span>
							    <input type="file" name="" id="hiddenProfilePicture" class="cpointer hide">
							</div>

							<div class="form-group">
								<label for="pseudo">Pseudo</label>
								<input type="text" class="form-control input-sm" id="pseudo" name="pseudo" placeholder="Votre pseudo" value="<?php echo $pseudo ?>">
							</div><!-- /form-group -->
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control input-sm" id="password" name="password" placeholder="Votre mot de passe" value="">
							</div><!-- /form-group -->
							
							<button type="button" class="btn btn-success btn-sm" onclick="updateInfos()">Mettre à jour</button>
						</form>
					</div>
				</div><!-- /panel -->
			</div><!-- /.col -->
		</div>
	</div>
</div>

<script type="text/javascript">
	function getfile (type) {
	   document.getElementById(''+type+'').click();
	}
</script>