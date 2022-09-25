<?php 
	$controllerName = $this->router->fetch_class();
	$actionName = $this->router->fetch_method();

	$activeDashboard = ($controllerName == 'index') ? 'active' : '' ;
	$activeCategories = ($controllerName == 'categories') ? 'active' : '' ;
	$activeInfos = ($controllerName == 'infos') ? 'active' : '' ;
	$activeArticles = ($controllerName == 'articles') ? 'active' : '' ;
	$activeHistorique = ($controllerName == 'historique') ? 'active' : '' ;
	$activeCB = ($controllerName == 'codebarre') ? 'active' : '' ;
	$activeTaille = ($controllerName == 'taille') ? 'active' : '' ;
	$activeMedias = ($controllerName == 'medias') ? 'active' : '' ;
	$activeCaisse = ($controllerName == 'caisse') ? 'active' : '' ;
?>

<!-- sidebar -->
<aside class="fixed skin-6">
	<div class="sidebar-inner scrollable-sidebar">
		<div class="main-menu">
			<ul>
				<li class="<?php echo $activeDashboard ?>">
					<a href="<?php echo BASE_URL ?>">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Tableau de bord
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>

				<?php /* ?>
				<li class="openable <?php echo $activeMedias ?>">
					<a href="#">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Medias
						</span>
						<span class="menu-hover"></span>
					</a>
					<ul class="submenu">
						<li><a href="#"><span class="submenu-label">Liste</span></a></li>
						<li><a href="<?php echo BASE_URL ?>/medias/add"><span class="submenu-label">Ajouter</span></a></li>
					</ul>
				</li>
				<?php */ ?>

				<li class="<?php echo $activeArticles ?>">
					<a href="<?php echo BASE_URL ?>/articles">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Articles
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>
				
				<li class="<?php echo $activeCategories ?>">
					<a href="<?php echo BASE_URL ?>/categories">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Catégories
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>

				<li class="<?php echo $activeTaille ?>">
					<a href="<?php echo BASE_URL ?>/taille">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Taille
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>

				<li class="<?php echo $activeHistorique ?>">
					<a href="<?php echo BASE_URL ?>/historique-des-ventes">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Historique des ventes
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>

				<li class="<?php echo $activeCB ?>">
					<a href="<?php echo BASE_URL ?>/codebarre">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Code Barre
						</span>
						<span class="menu-hover"></span>
					</a>
				</li>

				<li class="openable <?php echo $activeCaisse ?>">
					<a href="#">
						<span class="menu-icon">
							<i class="fa fa-chevron-right fa-lg"></i> 
						</span>
						<span class="text">
							Caisse
						</span>
						<span class="menu-hover"></span>
					</a>
					<ul class="submenu">
						<li><a href="<?php echo BASE_URL ?>/caisse" target="_blank"><span class="submenu-label">Afficher caisse</span></a></li>
						<li><a href="<?php echo BASE_URL ?>/caisse/paiement"><span class="submenu-label">Mode de paiement</span></a></li>
						<li><a href="<?php echo BASE_URL ?>/caisse/ticket"><span class="submenu-label">Paramétrage ticket de caisse</span></a></li>
					</ul>
				</li>
				
			</ul>
		</div><!-- /main-menu -->
	</div><!-- /sidebar-inner -->
</aside>