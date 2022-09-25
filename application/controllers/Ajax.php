<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'article_model' => 'Articles'
			,'categorie_model' => 'Categorie'
			,'global_model' => 'Global'
			,'historique_model' => 'Historique'
			,'caisse_model' => 'Caisse'
			,'options_model' => 'Options'
			,'utils_model' => 'Utils'
		)) ;
	}

	public function showModalFacture()
	{
		$res = array() ;

		$facture_id = (int)$this->input->post('resource_id') ;
		$resource_type = $this->input->post('resource_type') ;

		$facture = $this->Global->selectRow('factures','facture_numero','id_facture='.$facture_id) ;
		$getArticleByFactureId = $this->Historique->getArticleByFactureId($facture_id) ;

		$res['modal_title'] = "Détails ticket #".$facture->facture_numero ;

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
		// $res['modalFooter'] = '<span class="btn btn-danger btn-sm" onclick="printFacture(this)" data-resource_type="'.$resource_type.'" data-resource_id="'.$facture_id.'">Imprimer ticket de caisse</span>' ;
		$res['modalFooter'] = '<a href="'.BASE_URL.'/facture/ticketcaisse/?id='.$facture_id.'&nom='.$resource_type.'" target="_blank"><span class="btn btn-danger btn-sm" data-resource_type="'.$resource_type.'" data-resource_id="'.$facture_id.'">Imprimer ticket de caisse</span></a>' ;


		echo json_encode($res) ;
	}

	public function Createpdf()
	{
		$numfact = (int)$this->input->post('resource_id');
		$resource_type = $this->input->post('resource_type');

		$pdfFilePath = FCPATH . "uploads/Ticket/Ticket-".$numfact."-".$resource_type.".pdf";
		$data['all'] = $this->Caisse->Get_All_Facture($numfact);
		$data['getAllOptions'] = $this->Options->getAllOptions() ;
		$html = $this->load->view('caisse/facture', $data, true);
        $this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);                
        $pdf->Output($pdfFilePath, 'F');

        /*AUTO PRINT*/
        // $header = 'Document header';
        // $html   = 'Your document content goes here';
        // $footer = 'Print date: ' . date('d.m.Y H:i:s') . '<br />Page {PAGENO} of {nb}';

        // $mpdf = new mPDF('utf-8', 'A4', 0, '', 12, 12, 25, 15, 12, 12);
        // $mpdf->SetHTMLHeader($header);
        // $mpdf->SetHTMLFooter($footer);
        // $mpdf->SetJS('this.print();');
        // $mpdf->WriteHTML($html);
        // $mpdf->Output();

        echo 1;    
	}

	public function generateCodeBarre()
	{
		$resource_type = $this->input->post('resource_type');

		switch ($resource_type) {
			case 'articles':
					$getAllOptions = $this->Options->getAllOptions() ;
					$code7 = $getAllOptions['codebarre'] ;
					$articleCode = $this->Utils->generate(5) ;

					$t = trim($code7.$articleCode) ;
					// $t = "313178193226" ;

					$getCleControleCodeBarre = $this->Utils->cleControleCodeBarre($t) ;
					$string = $getCleControleCodeBarre['full'] ;

					$res['string'] = $string ;
					$res['attribute'] = 'codebarre_article' ;
				break;

			case 'caisse':
					$string = $this->Utils->generate('7') ;

					if ($string[0] == 0) {
						$string = "1".$this->Utils->generate('6') ;
					}

					$res['string'] = $string ;
					$res['attribute'] = 'codebarre' ;
				break;
			
			default:
				# code...
				break;
		}
		

		echo json_encode($res) ;
	}

	public function getarticle()
	{
		$codebarre_article = $this->input->post('codebarre_article') ;

		$article = $this->Articles->getArticleByCodeBarre($codebarre_article) ;
		
		if (!empty($article)) {
			$classAlert = ($article->nbre_stock_article <= 5) ? "badge badge-danger" : "" ;

			$htmlContent = "<div class='row'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Nom</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'>".$article->nom_article."</div>" ;
			$htmlContent .= "</div>" ;
			$htmlContent .= "<div class='row mt-10'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Référence</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'>".$article->uniqid."</div>" ;
			$htmlContent .= "</div>" ;
			$htmlContent .= "<div class='row mt-10'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Code barre</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'>".$article->codebarre_article."</div>" ;
			$htmlContent .= "</div>" ;
			$htmlContent .= "<div class='row mt-10'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Prix d'achat</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'>Ar&nbsp;".$article->prix_achat."</div>" ;
			$htmlContent .= "</div>" ;
			$htmlContent .= "<div class='row mt-10'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Pourcentage</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'>".$article->pourcentage."&nbsp;%</div>" ;
			$htmlContent .= "</div>" ;
			$htmlContent .= "<div class='row mt-10'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Prix de vente</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'>Ar&nbsp;".number_format($article->prix_article,0,',','.')."</div>" ;
			$htmlContent .= "</div>" ;
			$htmlContent .= "<div class='row mt-10'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Quantité dans le stock</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'><span class='".$classAlert."'>".$article->nbre_stock_article."</span></div>" ;
			$htmlContent .= "</div>" ;
			$htmlContent .= "<div class='row mt-10'>" ;
			$htmlContent .= 	"<div class='col-md-4'><span style='font-weight:bold'>Déscription(s)</span></div>" ;
			$htmlContent .= 	"<div class='col-md-8'>".$article->article_commentaire."</div>" ;
			$htmlContent .= "</div>" ;

			$res['state'] = 'success' ;
			$res['content'] = $htmlContent ;
			$res['nom_article'] = $article->nom_article ;
			$res['uniqid'] = $article->uniqid ;
		}
		else{
			$res['state'] = 'empty' ;
			$res['content'] = "Pas d'article associée à ce code barre" ;
		}

		echo json_encode($res) ;
	}
}
