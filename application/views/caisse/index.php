<div class="row" style="margin:50px 10px">
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading" >
				<h4 class="text-center">LISTE DES ARTICLES</h4>
			</div>
			<div class="panel-body" style="height: 500px">	
				<h4 class="alert alert-danger pull-left">TOTAL: <span id="total_caisse"></span> </h4>	
				<h4 class="pull-right"><?= date("d/m/Y"); ?> | <span id="heure_caisse"></span></h4>												
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
							<div class="col-sm-12"><button class="btn btn-success btn-xl btn_42" value="X"><i class="fa fa-times"></i></button></div>
							<div class="col-sm-12"><button class="btn btn-success btn-xl btn_8" id="retour_caisse" onclick="retour_caisse()"><i class="fa fa-arrow-left"></i></button></div>
							<div class="col-sm-12"><button class="btn btn-success btn-xl btn_114" id="reload_caisse" onclick="reload_caisse()"><i class="fa fa-refresh"></i></button></div>
							<div class="col-sm-12"><button class="btn btn-success btn-xl btn_105" id="print_caisse" onclick="print_caisse()"><i class="fa fa-print"></i></button></div>			
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_55" value="7">7</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_56" value="8">8</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_57" value="9">9</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_52" value="4">4</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_53" value="5">5</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_54" value="6">6</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_49" value="1">1</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_50" value="2">2</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_51" value="3">3</button></div>
							<div class="col-sm-4"><button class="btn btn-info btn-xl btn_48" value="0">0</button></div>
							<div class="col-sm-8"><button class="btn btn-info btn-xl btn-block btn_" value="00">00</button></div>
						</div>
					</div>
					<div class="col-sm-3" style="height:310px">
						<button class="btn btn-primary btn-block btn-ver btn_13" id="caisse_OK" onclick="caisse_OK()"><i class="fa fa-check fa-5x"></i></button>
					</div>
				</div>
			</div>
		</div>
		<?php /* ?>
		<label class="label-checkbox inline cpointer">
			<input type="checkbox" class="use_CB" checked="checked" name="use_CB">
			<span class="custom-checkbox"></span>
			Utiliser code barre
		</label>
		<?php */?>
		<span class="btn btn-success pull-right btn-lg" onclick="showModalAppelPrix()" id="appelPrix">Appel prix</span>	
	</div>
</div>	