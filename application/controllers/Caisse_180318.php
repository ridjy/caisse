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
		)) ;
		
	}
	public function index()
	{
		$data['Article'] = $this->Article ; 
		$this->load->view('caisse/index',$data);
	}

	public function Getcontentproduct()
	{
		$qte = (int)$this->input->post('quantite');
		$quantite = ($qte == 0) ? 1 : $qte ;
		$codebar = $this->input->post('CDB');
		$lineNumber = (int)$this->input->post('incr');
		
		$article = $this->Global->selectRow('articles','*','codebarre_article='.$codebar) ;

		if (!empty($article)) {
			$tab = "" ;

			$nbre_stock_article = $article->nbre_stock_article ;
			$prix_article = $article->prix_article ;
			$sous_total_article = $quantite * $prix_article ;

			if ($nbre_stock_article >= $quantite) {
				$tab = "<tr id='ligne_".$lineNumber."' data-article_id='".$article->id_article."' data-quantite='".$quantite."'>" ;
				$tab .= 	"<td class='hide' id='id_article'>".$article->id_article."</td>" ;
				$tab .= 	"<td id='uniqid'>".$article->uniqid."</td>" ;
				$tab .= 	"<td id='nom_article'>".$article->nom_article."</td>" ;
				$tab .= 	"<td id='quantite_article'>".$quantite."</td>" ;
				$tab .= 	"<td id='prix_article'>".$article->prix_article."</td>" ;
				$tab .= 	"<td id='sous_total_article'>".$sous_total_article."</td>" ;
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
		else{
			$res['state'] = 'error_CB' ;
			$res['msg'] = 'Code barre non reconnu OU quantité invalide' ;
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

		if (!empty($articles)) {
			/*insert into facture*/
			$dataFacture['facture_numero'] = $numFacture ;
			$dataFacture['facture_date'] = date('Y-m-d H:m:s');
			$dataFacture['facture_details'] = 'Essai';
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
		$pdfFilePath = FCPATH . "uploads/Fact".$numfact.".pdf";
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
}
