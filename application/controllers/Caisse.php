<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caisse extends CI_Controller {
	public function __construct()
	{		
		parent::__construct();

		$this->load->model(array(
			'caisse_model' => 'Caisse'
			,'global_model' => 'Global'
			,'options_model' => 'Options'
			,'article_model' => 'Article'
			,'user_model' => 'Users'
		)) ;
		
		if (!$this->Users->getData()) {
			redirect(BASE_URL."/login");
		}
	}
	public function index()
	{
		// $data['Article'] = $this->Article ;
		// $data['Mode_Paiement'] = $this->Caisse->List_MP();
		// $this->load->view('caisse/index',$data);

		$data['Article'] = $this->Article ;
		$data['Mode_Paiement'] = $this->Caisse->List_MP();

		$tabHeadLink[] = THEMES_URL."css/caisse.css" ;

		$tabHeadScript[] = THEMES_URL."js/scripts/caisse/index.js" ;
		
		$this->layout->set('title', 'Caisse');
		$this->layout->set('headLink',$tabHeadLink);
		$this->layout->set('headScript',$tabHeadScript);
		$this->layout->load('caisse', 'contents' , 'caisse/index',$data);
	}

	public function Getcontentproduct()
	{
		$res = array() ;

		$qte = (int)$this->input->post('quantite');
		$quantite = ($qte == 0) ? 1 : $qte ;
		$codebar = $this->input->post('CDB');
		$lineNumber = (int)$this->input->post('incr');
		$scanner = $this->input->post('scanner');
		$tabArticle = $this->input->post('tabArticle');

		$article = $this->Global->selectRow('articles','*','codebarre_article='.$codebar) ;

		if (!empty($article)) {
			$continue = true ;
			$nbre_stock_article = $article->nbre_stock_article ;

			if(!empty($tabArticle)){
				$tArticle = array() ;

				/*Put all id_article into array*/
				foreach ($tabArticle as $item) {
					array_push($tArticle, $item[0]) ;
				}

				if(is_array($tArticle)){
					/*if the new id_article is in the array of id_article*/
					if(in_array($article->id_article, $tArticle)){
						/*Get line having the id_article like the new id_article*/
						foreach ($tabArticle as $key => $item) {
							if($item[0] == $article->id_article){
								$t[] = $tabArticle[$key] ;
							}
						}

						$existedQuantity = 0 ;

						foreach ($t as $item) {
							$existedQuantity += $item[3] ;
						}

						$q2 = $existedQuantity+$quantite ;
						if($q2 >= $nbre_stock_article){
							$res['state'] = "stock_not_enough" ; 
							$res['msg'] = "La quantité dans le stock est insuffisante pour votre demande" ; 

							$continue = false ;
						}
						else{
							$continue = true ;
						}
					}
					else{
						$continue = true ;
					}
				}
			}

			if($continue){
				$tab = "" ;
				
				$prix_article = $article->prix_article ;
				$sous_total_article = $quantite * $prix_article ;

				if ($nbre_stock_article > $quantite) {
					$tab .= "<tr id='ligne_".$lineNumber."' data-article_id='".$article->id_article."' data-quantite='".$quantite."'>" ;
					$tab .= 	"<td class='hide' id='id_article'>".$article->id_article."</td>" ;
					$tab .= 	"<td id='uniqid'>".$article->uniqid."</td>" ;
					$tab .= 	"<td id='nom_article'>".$article->nom_article."</td>" ;
					$tab .= 	"<td id='quantite_article'>".$quantite."</td>" ;
					$tab .= 	"<td id='prix_article'>".number_format($article->prix_article,0,',','.')."</td>" ;
					$tab .= 	"<td id='sous_total_article'>".number_format($sous_total_article,0,',','.')."</td>" ;
					$tab .= 	"<td class='cpointer text-underline' onclick='deleteLigne(this)' data-ligne='".$lineNumber."'>Supprimer</td>" ;
					$tab .= "<tr>" ;

					$res['state'] = 'success' ;
					$res['table_content'] = $tab ;
					$res['sous_total_article'] = $sous_total_article ;
				}
				else{
					$res['state'] = 'stock_insuffisant' ;
					$res['msg'] = 'La quantité dans le stock est insuffisante pour cette demande' ;
				}
			}
		}
		else{
			$res['state'] = 'error_CB' ;
			$res['msg'] = 'Code barre non reconnu' ;
		}

		echo json_encode($res) ;
	}

	public function Getnumfacture()
	{
		$res = $this->Caisse->GetLastFacture();
		if($res){
			return $res->facture_numero+1;			
		}
		else
		{
			return 1;
		}		
	}
	
	public function Add()
	{
		$numFacture = self::Getnumfacture() ;
		$articles = $this->input->post('TABARTICLE');
		$modepaiement = $this->input->post('MODEPAIEMENT');
		$montant = $this->input->post('MONTANT');
		$montant_recu = $this->input->post('MONTANT_RECU'); /*montant reçu*/
		$rr = $this->input->post('RR'); /*reste ou reference*/

		if (!empty($articles)) {
			$continue = true ;

			switch ($modepaiement) {
				case 1:
						if($montant > $montant_recu){
							$res['state'] = "paiement_not_enough" ;
							$res['msg'] = "Montant reçu vide" ;
							$continue = false ;
						}
						else{
							$continue = true ;
						}
					break;
				case 2:
				case 3:
				case 4:
					if(empty($rr)){
						$res['state'] = "no_phone_number" ;
						$res['msg'] = "Pas de numéro de téléphone pour la transaction" ;
						$continue = false ;
					}
					else{
						$continue = true ;
					}
					break;
				case 5:
					/*NY HALAVANY LE CHEQUE*/
					if(empty($rr)){
						$res['state'] = "cheque_invalide" ;
						$res['msg'] = "Chèque invalide" ;
						$continue = false ;
					}
					else{
						$continue = true ;
					}
					break;
				default:
					break;
			}

			if($continue){
				/*insert into facture*/
				$dataFacture['facture_numero'] = $numFacture ;
				$dataFacture['facture_date'] = date('Y-m-d H:m:s');
				$dataFacture['facture_details'] = 'Essai';
				$dataFacture['facture_montant'] = $montant;
				$dataFacture['mode_paiement'] = $modepaiement;
				$dataFacture['montant_recu'] = $montant_recu;
				$dataFacture['rr'] = ($rr) ? $rr : 0 ;
				$this->Caisse->Add_Facture($dataFacture);

				/*insert into ventes*/
				foreach ($articles as $article) {
					$dataArticle['article_id'] = $article[0] ;
					$dataArticle['vente_quantite'] = $article[3] ;
					$dataArticle['facture_id'] = $numFacture ;
					$dataArticle['vente_date'] = date('Y-m-d H:m:s');
					$this->Caisse->Add_vente($dataArticle);	
					$this->Updatearticle($dataArticle['article_id'],$dataArticle['vente_quantite'],$numFacture);
				}

				/*create pdf*/
				$this->Createpdf($numFacture);

				$res['state'] = 'success';
				$res['msg'] = 'ok';
				$res['fact'] = $numFacture ;
			}
		}
		else{
			$res['state'] = 'error' ;
			$res['msg'] = 'Votre panier est encore vide' ;
		}

		echo json_encode($res) ;
	}

	public function Updatearticle($id=null,$qte=null,$numFacture)
	{
		$res = $this->Caisse->Get_article($id);
		if($res){
			if($res->nbre_stock_article>$qte){
				$data['nbre_stock_article'] = $res->nbre_stock_article - $qte;
				$this->Caisse->Update_article($data,$id);

				/*insert into historique*/
				$data_historique = array(
				    "article_id" => $id
				    ,"quantite" => $qte
				    ,"facture_id" => $numFacture
				    ,"type" => 'vente'
				) ;

				$this->Global->insert('historique',$data_historique) ;

			}
		}
	}

	public function Createpdf($numfact=null)
	{
		$pdfFilePath = FCPATH . "uploads/Ticket/Ticket-".$numfact.".pdf";
		$data['all'] = $this->Caisse->Get_All_Facture($numfact);
		$data['getAllOptions'] = $this->Options->getAllOptions() ;
		$html = $this->load->view('caisse/facture', $data, true);
        $this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);                
        $pdf->Output($pdfFilePath, 'F');        
	}

	public function deleteLigne()
	{
		$article_id = (int)$this->input->post('article_id') ;
		$quantite = (int)$this->input->post('quantite') ;

		$getPix = $this->Global->selectRow('articles','prix_article','id_article='.$article_id) ;

		$total = $quantite * $getPix->prix_article ;

		$res['total'] = $total ;
	
		echo json_encode($res);		
	}


	/*ADMIN*/
	public function paiement()
	{	
		$role = $this->Users->getData()['role'] ;

		if($role != 'admin'){
			redirect(BASE_URL."/caisse");
		}
		else{
			$this->layout->set('title', 'Mode de paiement');
			$this->layout->set('headLink', '');
			$this->layout->set('headScript', array(THEMES_URL."js/scripts/caisse/paiement.js"));
			$this->layout->load('default', 'contents' , 'caisse/paiement');
		}
	}

	public function getAllPaiement()
	{
		$aColumns = 
			array(
				'mp.id_mp'
				,'mp.type'
				,'mp.prefixe'
			);
		   		   		
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ". intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ". ($_GET['sSortDir_0']==='asc' ? 'ASC' : 'DESC') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
			}
		}

		$sQuery = "
			SELECT 
				SQL_CALC_FOUND_ROWS mp.id_mp
				,mp.type
				,mp.prefixe
			FROM mode_paiement mp
			$sWhere
			$sOrder
			$sLimit
		";

		$rResult        = $this->Global->query($sQuery);
		$total          = $this->Global->query("SELECT FOUND_ROWS() as FOUND_ROWS");
		$iFilteredTotal = $total[0]->FOUND_ROWS;
		$iTotal         = $total[0]->FOUND_ROWS;

		$output = array(
			"sEcho"                => intval($_GET['sEcho']),
			"iTotalRecords"        => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData"               => array()
		);

		if(!empty($rResult)){ 
		 	foreach ($rResult as $item) {
		 	 	$row = array();
		 	 	$id = $item->id_mp ;

		 	 	$row[] = $id ;
		 	 	$row[] = $item->type;
		 	 	$row[] = $item->prefixe;
		 	 	
		 	 	$actions = "<span class='cpointer' title='Modifier' onclick='showModal(this)' data-resource_type='editModePaiement' data-resource_id='".$id."'><i class='fa fa-pencil fa-lg'></i></span>" ;
		 	 	$actions .= "<span class='ml-10 cpointer' title='Supprimer' onclick='deleteModePaiement(this)' data-resource_id='".$id."'><i class='fa fa-trash-o fa-lg'></i></span>" ;
		 	 	              
		 	 	$row[] = $actions;

		 	 	$output['aaData'][] = $row;
		 	} 
		}
		
		echo json_encode($output);
	}

	public function showmodal()
	{
		$res = array() ;

		$resource_id = (int)$this->input->post('resource_id') ;
		$resource_type = $this->input->post('resource_type') ;

		$type = $prefixe = "" ;

		if($resource_type == 'editModePaiement'){
			$paiement = $this->Global->selectRow('mode_paiement','type,prefixe','id_mp='.$resource_id) ;
			$type = $paiement->type ;
			$prefixe = $paiement->prefixe ;
		}

		$modal_title = ($resource_type == 'editModePaiement') ? "Mode de paiement : ".$paiement->type : "Nouveau mode de paiement" ;

		$action = ($resource_type == 'editModePaiement') ? "edit" : "add" ;

		$res['modal_title'] = $modal_title ;

		$htmlWrapper = "" ;

		$htmlWrapper .= "<input type='hidden' name='id_mp' value='".$resource_id."'>" ;
		$htmlWrapper .= "<input type='hidden' name='action' value='".$action."'>" ;

		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='type'>Type</label>" ;
		$htmlWrapper .= 	"<input type='text' name='type' id='type' class='form-control' placeholder='Type' value='".$type."'>" ;
		$htmlWrapper .= "</div>" ;

		$htmlWrapper .= "<div class='form-group'>" ;
		$htmlWrapper .= 	"<label for='prefixe'>Préfixe</label>" ;
		$htmlWrapper .= 	"<input type='text' name='prefixe' id='prefixe' class='form-control' placeholder='Préfixe' value='".$prefixe."'>" ;
		$htmlWrapper .= "</div>" ;


        $res['htmlWrapper'] = $htmlWrapper ;

		echo json_encode($res) ;
	}

	public function modifyModePaiement()
	{
		$res = array() ;

		$action = $this->input->post('action') ;
		$id_mp = (int)$this->input->post('id_mp') ;
		$type = $this->input->post('type') ;
		$prefixe = $this->input->post('prefixe') ;

		if(empty($type)){
			$res['state'] = 'empty_type' ;
			$res['msg'] = "Nome du mode de paiement" ;
		}
		else{
			$data = array(
				'type' => $type
				,'prefixe' => $prefixe
			);

			if($action == 'add'){
				$this->Global->insert('mode_paiement',$data) ;
			}
			else{
				$this->Global->update('mode_paiement',$data,"id_mp=".$id_mp) ;
			}

			$res['state'] = 'success' ;
			$res['msg'] = 'Mise à jour avec succès' ;
		}

		echo json_encode($res) ;
	}

	public function deleteModePaiement()
	{
		$res = array() ;

		$id_mp = (int)$this->input->post('resource_id') ;
		$this->Global->delete('mode_paiement','id_mp='.$id_mp) ;

		$res['msg'] = "Mode de paiement supprimé avec succès" ;
		echo json_encode($res);
	}

	/*TICKET DE CAISSE*/
	public function ticket()
	{	
		$role = $this->Users->getData()['role'] ;

		if($role != 'admin'){
			redirect(BASE_URL."/caisse");
		}
		else{
			$getAllOptions = $this->Options->getAllOptions() ;

			$this->layout->set('title', 'Méthode de paiement');
			$this->layout->set('headLink', '');
			$this->layout->set('headScript', array(THEMES_URL."js/scripts/caisse/ticket.js"));
			$this->layout->load('default', 'contents' , 'caisse/ticket',array("getAllOptions"=>$getAllOptions));
		}
	}

	public function updateTicket()
	{
		if (empty($_POST['Options']['codebarre'])) {
			$res['state'] = 'empty_codebarre' ;
			$res['msg'] = 'Veuillez entrer les 07 chiffres qui composeront votre code barre' ;
		}
		else{
			if (strlen($_POST['Options']['codebarre']) < 7) {
				$res['state'] = 'codebarre_to_short' ;
				$res['msg'] = '07 chiffres maximum' ;
			}
			else{
				// update options
				if(!empty($_POST['Options'])){
					foreach ($_POST['Options'] as $meta_key => $meta_value) {
						$this->Options->updateOptions($meta_key,$meta_value) ;
					}
				}

				$res['state'] = 'success' ;
				$res['msg'] = 'Mise à jour effectuée' ;
			}
		}
		
		echo json_encode($res);
	}
}
