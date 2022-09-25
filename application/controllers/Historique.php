<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historique extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'article_model' => 'Articles'
			,'historique_model' => 'Historique'
			,'global_model' => 'Global'
			,'caisse_model' => 'Caisse'
		)) ;
		
		if (!$this->Users->getData()) {
			redirect(BASE_URL."/login");
		}
		else{
			$role = $this->Users->getData()['role'] ;

			if($role != 'admin'){
				redirect(BASE_URL."/caisse");
			}
		}
	}

	public function index()
	{	
		// $data = array() ;
		// $data['js_to_load']= THEMES_URL."js/scripts/categories/index.js" ;
		
		$this->layout->set('title', 'Historique des ventes');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/historique/index.js"));
		$this->layout->load('default', 'contents' , 'historique/index');
	}

	public function getHistorique()
	{
		$aColumns = 
			array(
				'f.facture_numero'
				,'v.vente_date'
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
				SQL_CALC_FOUND_ROWS v.id_vente
				,f.facture_numero
				,f.id_facture
				,IF(v.vente_date='0000-00-00 00:00:00' OR v.vente_date IS NULL, '', DATE_FORMAT(v.vente_date,'%d %b %Y %Hh %imn')) AS vente_date
			FROM ventes v
			LEFT JOIN factures f ON (f.id_facture = v.facture_id)
			$sWhere
			GROUP BY f.id_facture
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
		 	 	$id = $item->id_facture ;

		 	 	// $row[] = $id ;
		 	 	$row[] = $item->facture_numero;
		 	 	$row[] = $item->vente_date;

		 	 	$actions = "<span class='cpointer' title='Visualiser facture' onclick='showModalFacture(this)' data-resource_type='historique' data-resource_id='".$id."'><i class='fa fa-eye fa-lg'></i></span>" ;
		 	 	$actions .= "<span class='ml-10 cpointer' title='Supprimer' onclick='deleteFacture(this)' data-resource_id='".$id."'><i class='fa fa-trash-o fa-lg'></i></span>" ;
		 	 	$actions .= "<span class='ml-10 cpointer' title='Afficher facture A4'><a href='".BASE_URL."/facture/factureA4?id=".$id."' target='_blank'><i class='fa fa-print'></i><a></span>" ;
                    
		 	 	$row[] = $actions;

		 	 	$output['aaData'][] = $row;
		 	} 
		}
		
		echo json_encode($output);
	}

	public function showmodal()
	{
		$res = array() ;

		$facture_id = (int)$this->input->post('resource_id') ;
		$resource_type = $this->input->post('resource_type') ;

		$facture = $this->Global->selectRow('factures','facture_numero','id_facture='.$facture_id) ;
		$getArticleByFactureId = $this->Historique->getArticleByFactureId($facture_id) ;

		$res['modal_title'] = "Détails facture #".$facture->facture_numero ;

		$htmlWrapper = "<div class='pl-25 pr-25'>" ;

		if(!empty($getArticleByFactureId)){
			foreach ($getArticleByFactureId as $item) {
				$htmlWrapper .= "<span class='pull-left'>".$item->nom_article."</span>" ;
				$htmlWrapper .= "<span class='pull-right'>".$item->vente_quantite."</span>" ;
				$htmlWrapper .= "<br>" ;
			}
		}

		$htmlWrapper .= "</div>" ;

		$res['htmlWrapper'] = $htmlWrapper ;

		echo json_encode($res) ;
	}

	public function delete()
	{
		$res = array() ;

		$facture_id = (int)$this->input->post('resource_id') ;
		$this->Global->delete("factures","id_facture=$facture_id") ;

		$res['msg'] = "Facture supprimée avec succès" ;
		echo json_encode($res);
	}

}
