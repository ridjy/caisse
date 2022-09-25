<?php 
	$session = $this->session->userdata('logged_in');
	$mois=array('','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre');
?>

<!-- MAIN CONTENT -->
<div id="main-container">
	<div id="breadcrumb">
		<ul class="breadcrumb">
			 <li><i class="fa fa-home"></i><a href="#"> Accueil</a></li>
			 <li class="active">Tableau de bord</li>	 
		</ul>
	</div><!-- /breadcrumb-->
	<div class="main-header clearfix">
		<div class="page-title">
			<h3 class="no-margin">Votre tableau de bord</h3>
			<?php
				$username = $session['username'];
				$text = "Hey ! Comment ça va #username# ?";
				$hey = str_replace("#username#", $username,$text);
			?>
			<span><?php echo $hey ?></span>
		</div><!-- /page-title -->
		
		<?php /* ?>
		<ul class="page-stats">
	    	<li>
	    		<div class="value">
	    			<span title="nombre d'utilisateurs enregistrés">Utilisateurs</span>
	    			<h4 id="currentVisitor"><?php echo $nbreuser ?></h4>
	    		</div>
				<span id="visits" class="sparkline"></span>
	    	</li>
	    	<li>
	    		<div class="value">
	    			<span>Total des ventes</span>
	    			<h4><strong id="currentBalance"><?php echo $nbrevente ?></strong></h4>
	    		</div>
	    		<span id="balances" class="sparkline"></span>
	    	</li>
	    </ul><!-- /page-stats -->
	    <?php */ ?>
	</div><!-- /main-header -->

	
	<div class="grey-container shortcut-wrapper">
		<a href="#" class="shortcut-link">
			<span class="shortcut-icon">
				<i class="fa fa-bar-chart-o"></i>
			</span>
			<span class="text">Tableau de bord</span>
		</a>
		<a href="<?php echo BASE_URL ?>/historique-des-ventes" class="shortcut-link">
			<span class="shortcut-icon">
				<i class="fa fa-shopping-cart"></i>
				<span class="shortcut-alert">
					<?php echo $nbrevente ?>
				</span>	
			</span>
			<span class="text">Ventes</span>
		</a>
		<?php
			$role = $session['role'] ;

			if ($role == 'admin') { ?>
				
				<a href="<?php echo BASE_URL ?>/users" class="shortcut-link">
					<span class="shortcut-icon">
						<i class="fa fa-user"></i>
					</span>
					<span class="text">Utilisateurs</span>
				</a>
				
		<?php	}
		?>
		<a href="<?php echo BASE_URL ?>/articles" class="shortcut-link">
			<span class="shortcut-icon">
				<i class="fa fa-list"></i>
				<!--<span class="shortcut-alert">
					<?php //echo $nbrearticle ?>
				</span>	 -->
			</span>
			<span class="text">Articles</span>
		</a>
		<a href="<?php echo BASE_URL ?>/categories" class="shortcut-link">
			<span class="shortcut-icon">
				<i class="fa fa-list"></i>
				<!--<span class="shortcut-alert">
					<?php //echo $nbrecategorie ?>
				</span>	 -->
			</span>
			<span class="text">Catégories</span>
		</a>
		<?php /* ?>
		<a href="#" class="shortcut-link">
			<span class="shortcut-icon">
				<i class="fa fa-cog"></i></span>
			<span class="text">Paramètres</span>
		</a>
		<?php */ ?>
	</div><!-- /grey-container -->


	
	<div class="padding-md">
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<div class="panel-stat3 bg-danger">
					<h2 class="m-top-none"><?php echo $nbrearticle ?></h2>
					<h5>Articles enregistrés</h5>
					<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs">Dernier enregistrement fait le <?php echo date('d-m-Y',strtotime($dernierarticle['date_article'])) ?> à <?php echo date('H:i',strtotime($dernierarticle['date_article'])) ?></span>
					<div class="stat-icon">
						<i class="fa fa-list fa-3x"></i>
					</div>
					<?php /* ?><div class="refresh-button">
						<i class="fa fa-refresh"></i>
					</div><?php */ ?>
					<div class="loading-overlay">
						<i class="loading-icon fa fa-refresh fa-spin fa-lg"></i>
					</div>
				</div>
			</div><!-- /.col -->


			<div class="col-sm-6 col-md-3">
				<div class="panel-stat3 bg-info">
					<h2 class="m-top-none"><span><?php echo $nbrecategorie ?></span></h2>
					<h5>Catégories</h5>
					<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs">parmi lesquelles les articles sont classés</span>
					<div class="stat-icon">
						<i class="fa fa-hdd-o fa-3x"></i>
					</div>
					<?php /* ?><div class="refresh-button">
						<i class="fa fa-refresh"></i>
					</div><?php */ ?>
					<div class="loading-overlay">
						<i class="loading-icon fa fa-refresh fa-spin fa-lg"></i>
					</div>
				</div>
			</div><!-- /.col -->


			<div class="col-sm-6 col-md-3">
				<div class="panel-stat3 bg-warning">
					<h2 class="m-top-none"><?php echo $ventemois ?></h2>
					<h5>Ventes pour ce mois de <?php echo $mois[date('n')]; ?></h5>
					<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs">3% de plus que le mois dernier</span>
					<div class="stat-icon">
						<i class="fa fa-shopping-cart fa-3x"></i>
					</div>
					<?php /* ?><div class="refresh-button">
						<i class="fa fa-refresh"></i>
					</div><?php */ ?>
					<div class="loading-overlay">
						<i class="loading-icon fa fa-refresh fa-spin fa-lg"></i>
					</div>
				</div>
			</div><!-- /.col -->
			<div class="col-sm-6 col-md-3">
				<div class="panel-stat3 bg-success">
					<h2 class="m-top-none"><?php echo $plusvendu['total']; ?></h2>
					<h5>Ventes total pour l'article le plus vendu</h5>
					<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs"><?php echo $articleplusvendu['nom_article']; ?> est celui qui se vend le mieux</span>
					<div class="stat-icon">
						<i class="fa fa-bar-chart-o fa-3x"></i>
					</div>
					<?php /* ?><div class="refresh-button">
						<i class="fa fa-refresh"></i>
					</div><?php */ ?>
					<div class="loading-overlay">
						<i class="loading-icon fa fa-refresh fa-spin fa-lg"></i>
					</div>
				</div>
			</div><!-- /.col -->
		</div>


		<div class="row">
			<div class="col-lg-8">			
				
				<div class="panel panel-default">
					<div class="panel-heading">
						Alerte de stock
						<span class="badge badge-info pull-right" title="5 articles ayant le stock le moins élevé">	
							<?php echo str_replace("#nbrearticle#", $nbrearticle , "sur #nbrearticle# articles") ; ?>
						</span>
					</div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Article</th>
								<th>Etat de stock</th>
								<th></th>
								<th>Nbre en stock</th>
								<th>Nbre de vente</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($rowrupture as $item) : ?>
							<tr>
								<td><?php echo $item->nom_article ;
								$nbrvendu=$this->Dashboard->getnbrarticlevendu($item->id_article);//get pourcentage du stock article 
								$cent=$nbrvendu+$item->nbre_stock_article;
								$pce=($item->nbre_stock_article*100)/$cent;
								?></td>
								<td>
									<div class="progress progress-striped active" style="height:8px; margin:5px 0 0 0;">
										<div class="progress-bar" style="width: <?php echo $pce.'%'; ?>">
											<span class="sr-only"><?php echo $pce; ?> restant</span>
										</div>
									</div>
								</td>
								<td><?php echo $pce.'%' ; ?></td>
								<td><span class="badge badge-danger"><?php echo $item->nbre_stock_article; ?></span></td>
								<td><span class="badge badge-info"><?php echo $nbrvendu; ?></span></td>
							</tr>
						<?php endforeach ?>
						</tbody>

					</table>
				</div><!-- /panel -->

				<div class="panel panel-default">
					<div class="panel-heading">
						Stock en abondance
						<span class="badge badge-info pull-right" title="5 articles ayant le stock le plus élevé">	
							<?php echo str_replace("#nbrearticle#", $nbrearticle , "sur #nbrearticle# articles") ; ?>
						</span>
					</div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Article</th>
								<th>Etat de stock</th>
								<th></th>
								<th>Nbre en stock</th>
								<th>Nbre de vente</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($rowmoinvendu as $item) : ?>
							<tr>
								<td><?php echo $item->nom_article ;
								$nbrvendu=$this->Dashboard->getnbrarticlevendu($item->id_article);//get pourcentage du stock article 
								$cent=$nbrvendu+$item->nbre_stock_article;
								$pce=($item->nbre_stock_article*100)/$cent;
								?></td>
								<td>
									<div class="progress progress-striped active" style="height:8px; margin:5px 0 0 0;">
										<div class="progress-bar" style="width: <?php echo $pce.'%'; ?>">
											<span class="sr-only"><?php echo $pce; ?> restant</span>
										</div>
									</div>
								</td>
								<td><?php echo $pce.'%' ; ?></td>
								<td><span class="badge badge-danger"><?php echo $item->nbre_stock_article; ?></span></td>
								<td><span class="badge badge-info"><?php echo $nbrvendu; ?></span></td>
							</tr>
						<?php endforeach ?>
						</tbody>

					</table>
				</div><!-- /panel -->

				<div class="row">
					<div class="col-lg-6">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<span class="pull-left">Moins vendu</span>
								<ul class="tool-bar">
									<?php /* ?><li><a href="#" class="refresh-widget" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Refresh"><i class="fa fa-refresh"></i></a></li><?php */ ?>
									<li><a href="#toDoListWidget" data-toggle="collapse"><i class="fa fa-arrows-v"></i></a></li>
								</ul>
							</div>
							<div class="panel-body no-padding collapse in" id="toDoListWidget">
								<ul class="list-group task-list no-margin collapse in">
									<?php foreach ($articlemoinsvendu as $item) : ?>
									<li class="list-group-item">
										<?php /* ?><label class="label-checkbox inline">
											 <input type="checkbox" class="task-finish">
											 <span class="custom-checkbox"></span>
										</label><?php */ ?>
										<?php echo $item->nom_article ; ?> <span class="label label-warning m-left-xs"></span>
										<?php /* ?><span class="pull-right">
											<a href="#" class="task-del"><i class="fa fa-trash-o fa-lg text-danger"></i></a>
										</span><?php */ ?>
										<span class="badge badge-success m-right-xs" title="nombre vendu"><?php echo $item->sum ?></span>
									</li>
									<?php endforeach ?>
								</ul><!-- /list-group -->
							</div>

							<div class="loading-overlay">
								<i class="loading-icon fa fa-refresh fa-spin fa-lg"></i>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->

					<div class="col-lg-6">
						<div class="panel panel-default">	
							<div class="panel-heading clearfix">
								<span class="pull-left">Plus vendu</span>
								<ul class="tool-bar">
									<?php /* ?><li><a href="#" class="refresh-widget" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Refresh"><i class="fa fa-refresh"></i></a></li><?php */ ?>
									<li><a href="#feedList" data-toggle="collapse"><i class="fa fa-arrows-v"></i></a></li>
								</ul>
							</div>		
							<ul class="list-group collapse in" id="feedList">
								<?php foreach ($plusvendu1 as $item) : ?>
								<li class="list-group-item clearfix">
									<div class="activity-icon bg-success small">
										<i class="fa fa-usd"></i>
									</div>
									<div class="pull-left m-left-sm">
										<span><?php echo $item->nom_article ; ?></span><br/>
										<small class="text-muted"><i class="fa fa-clock-o"></i><?php echo ' '.$item->sum ?> ventes</small>
									</div>	
								</li>
								<?php endforeach ?>
							</ul><!-- /list-group -->	
							<div class="loading-overlay">
								<i class="loading-icon fa fa-refresh fa-spin fa-lg"></i>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
				</div><!-- ./row -->

			</div><!-- /.col -->


			<div class="col-lg-4">
				<div class="panel bg-info fadeInDown animation-delay4">
					<div class="panel-body">
						<div id="lineChart" style="height: 150px;"></div>
						<div class="pull-right text-right">
							<strong class="font-14">Montant vente du mois <?php echo number_format($montantmois, 2, ',', ' ') ?> Ariary</strong><br/>
							<span><i class="fa fa-shopping-cart"></i> Total vendu <?php echo $ventemois ?></span>
							<div class="seperator"></div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-xs-4">
								Vente en <?php echo $mois[$moisprec2]; ?>
								<strong class="block"><?php echo number_format($montantmoisprec2, 0, ',', ' ') ?> Ariary</strong>
							</div><!-- /.col -->
							<div class="col-xs-4">
								Vente en <?php echo $mois[$moisprec]; ?>
								<strong class="block"><?php echo number_format($montantmoisprec, 0, ',', ' ') ;  ?> Ariary</strong>
							</div><!-- /.col -->
							<div class="col-xs-4">
								Vente ce <?php echo $mois[date('n')]; ?> 
								<strong class="block"><?php echo number_format($montantmois, 0, ',', ' ') ; ?> Ariary</strong>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
				</div><!-- /panel -->
						
						
				
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.padding-md -->
</div><!-- /main-container -->