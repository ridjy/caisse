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